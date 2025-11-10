<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Hospital Requests Model - AUTO-ASSIGN VERSION (NO PAYMENT)
 * 
 * Flow:
 * 1. Consultant creates request (pending)
 * 2. Receptionist approves request (approved) - NO assignment
 * 3. Any technician can see all approved requests
 * 4. Technician clicks "Start" - AUTO-ASSIGNS to that technician (in_progress)
 * 5. Technician completes (completed)
 */
class Hospital_requests_model extends App_Model
{
    private $requests_table;
    private $request_items_table;
    private $categories_table;
    private $items_table;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->requests_table = db_prefix() . 'hospital_visit_requests';
        $this->request_items_table = db_prefix() . 'hospital_visit_request_items';
        $this->categories_table = db_prefix() . 'hospital_request_categories';
        $this->items_table = db_prefix() . 'hospital_request_items';
    }
    
    // ==========================================
    // RECEPTIONIST METHODS
    // ==========================================
    
    /**
     * Get all pending requests (awaiting approval)
     */
    public function get_pending_requests()
    {
        $this->db->select(
            'r.*, ' .
            'c.category_name, ' .
            'v.visit_number, ' .
            'v.visit_date, ' .
            'p.name as patient_name, ' .
            'p.patient_number, ' .
            'p.mobile_number as patient_mobile, ' .
            'p.age as patient_age, ' .
            'p.gender as patient_gender, ' .
            's.firstname as doctor_firstname, ' .
            's.lastname as doctor_lastname, ' .
            'COUNT(ri.id) as items_count'
        );
        $this->db->from($this->requests_table . ' r');
        $this->db->join($this->categories_table . ' c', 'c.id = r.category_id', 'left');
        $this->db->join(db_prefix() . 'hospital_visits v', 'v.id = r.visit_id', 'left');
        $this->db->join(db_prefix() . 'hospital_appointments a', 'a.id = v.appointment_id', 'left');
        $this->db->join(db_prefix() . 'hospital_patients p', 'p.id = a.patient_id', 'left');
        $this->db->join(db_prefix() . 'staff s', 's.staffid = r.requested_by', 'left');
        $this->db->join($this->request_items_table . ' ri', 'ri.request_id = r.id', 'left');
        
        $this->db->where('r.status', 'pending');
        $this->db->where_in('r.category_id', [1, 2]); // Lab + Procedure Diagnostics
        
        $this->db->group_by('r.id');
        $this->db->order_by('FIELD(r.priority, "emergency", "urgent", "normal")', '', FALSE);
        $this->db->order_by('r.created_at', 'DESC');
        
        return $this->db->get()->result_array();
    }
    
    /**
     * Get single request with items for modal
     */
    public function get_request_with_items($request_id)
    {
        // Get request header
        $this->db->select(
            'r.*, ' .
            'c.category_name, ' .
            'v.visit_number, ' .
            'v.visit_date, ' .
            'p.name as patient_name, ' .
            'p.patient_number, ' .
            'p.mobile_number as patient_mobile, ' .
            'p.age as patient_age, ' .
            'p.gender as patient_gender, ' .
            's.firstname as doctor_firstname, ' .
            's.lastname as doctor_lastname, ' .
            'tech.firstname as technician_firstname, ' .
            'tech.lastname as technician_lastname'
        );
        $this->db->from($this->requests_table . ' r');
        $this->db->join($this->categories_table . ' c', 'c.id = r.category_id', 'left');
        $this->db->join(db_prefix() . 'hospital_visits v', 'v.id = r.visit_id', 'left');
        $this->db->join(db_prefix() . 'hospital_appointments a', 'a.id = v.appointment_id', 'left');
        $this->db->join(db_prefix() . 'hospital_patients p', 'p.id = a.patient_id', 'left');
        $this->db->join(db_prefix() . 'staff s', 's.staffid = r.requested_by', 'left');
        $this->db->join(db_prefix() . 'staff tech', 'tech.staffid = r.assigned_technician_id', 'left');
        $this->db->where('r.id', $request_id);
        
        $request = $this->db->get()->row_array();
        
        if (!$request) {
            return null;
        }
        
        // Get items
        $this->db->select('ri.*, i.item_name, i.item_code, i.subcategory_name');
        $this->db->from($this->request_items_table . ' ri');
        $this->db->join($this->items_table . ' i', 'i.id = ri.item_id', 'left');
        $this->db->where('ri.request_id', $request_id);
        $request['items'] = $this->db->get()->result_array();
        
        return $request;
    }
    
    /**
     * Approve request (no technician assignment)
     */
    public function approve_request($request_id)
    {
        $update_data = [
            'status' => 'approved',
            'approved_at' => date('Y-m-d H:i:s'),
            'approved_by' => get_staff_user_id(),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id', $request_id);
        $this->db->where('status', 'pending');
        $updated = $this->db->update($this->requests_table, $update_data);
        
        if ($updated && $this->db->affected_rows() > 0) {
            log_activity('Request #' . $request_id . ' approved by receptionist');
            return ['success' => true, 'message' => 'Request approved successfully'];
        }
        
        return ['success' => false, 'message' => 'Failed to approve request'];
    }
    
    /**
     * Cancel request
     */
    public function cancel_request($request_id, $reason = null)
    {
        $update_data = [
            'status' => 'cancelled',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        if (!empty($reason)) {
            $update_data['lab_notes'] = 'CANCELLED: ' . $reason;
        }
        
        $this->db->where('id', $request_id);
        $this->db->where('status', 'pending');
        $updated = $this->db->update($this->requests_table, $update_data);
        
        if ($updated && $this->db->affected_rows() > 0) {
            log_activity('Request #' . $request_id . ' cancelled. Reason: ' . $reason);
            return ['success' => true, 'message' => 'Request cancelled successfully'];
        }
        
        return ['success' => false, 'message' => 'Cannot cancel this request'];
    }
    
    /**
     * Get receptionist statistics
     */
    public function get_receptionist_statistics()
    {
        $stats = [];
        
        // Pending approval
        $this->db->where('status', 'pending');
        $this->db->where_in('category_id', [1, 2]);
        $stats['pending'] = $this->db->count_all_results($this->requests_table);
        
        // Approved (waiting for technician)
        $this->db->where('status', 'approved');
        $this->db->where_in('category_id', [1, 2]);
        $stats['approved'] = $this->db->count_all_results($this->requests_table);
        
        // In progress
        $this->db->where('status', 'in_progress');
        $this->db->where_in('category_id', [1, 2]);
        $stats['in_progress'] = $this->db->count_all_results($this->requests_table);
        
        // Completed
        $this->db->where('status', 'completed');
        $this->db->where_in('category_id', [1, 2]);
        $stats['completed'] = $this->db->count_all_results($this->requests_table);
        
        // Today's total
        $this->db->where('DATE(created_at)', date('Y-m-d'));
        $this->db->where_in('category_id', [1, 2]);
        $stats['today'] = $this->db->count_all_results($this->requests_table);
        
        return $stats;
    }
    
    /**
     * Get all lab records (for receptionist view)
     */
    public function get_lab_records()
    {
        $this->db->select(
            'r.*, ' .
            'c.category_name, ' .
            'v.visit_number, ' .
            'v.visit_date, ' .
            'p.name as patient_name, ' .
            'p.patient_number, ' .
            'p.mobile_number as patient_mobile, ' .
            's.firstname as doctor_firstname, ' .
            's.lastname as doctor_lastname, ' .
            'tech.firstname as technician_firstname, ' .
            'tech.lastname as technician_lastname, ' .
            'COUNT(ri.id) as items_count'
        );
        $this->db->from($this->requests_table . ' r');
        $this->db->join($this->categories_table . ' c', 'c.id = r.category_id', 'left');
        $this->db->join(db_prefix() . 'hospital_visits v', 'v.id = r.visit_id', 'left');
        $this->db->join(db_prefix() . 'hospital_appointments a', 'a.id = v.appointment_id', 'left');
        $this->db->join(db_prefix() . 'hospital_patients p', 'p.id = a.patient_id', 'left');
        $this->db->join(db_prefix() . 'staff s', 's.staffid = r.requested_by', 'left');
        $this->db->join(db_prefix() . 'staff tech', 'tech.staffid = r.assigned_technician_id', 'left');
        $this->db->join($this->request_items_table . ' ri', 'ri.request_id = r.id', 'left');
        
        $this->db->where_in('r.category_id', [1, 2]);
        $this->db->where_in('r.status', ['approved', 'in_progress', 'completed']);
        
        $this->db->group_by('r.id');
        $this->db->order_by('r.created_at', 'DESC');
        
        return $this->db->get()->result_array();
    }
    
    // ==========================================
    // TECHNICIAN METHODS
    // ==========================================
    
    /**
     * Get ALL available requests for ANY technician
     * Shows: approved (not started) + their own in_progress
     */
    public function get_available_requests_for_technicians($technician_id)
    {
        $this->db->select(
            'r.*, ' .
            'c.category_name, ' .
            'v.visit_number, ' .
            'v.visit_date, ' .
            'p.name as patient_name, ' .
            'p.patient_number, ' .
            'p.mobile_number as patient_mobile, ' .
            's.firstname as doctor_firstname, ' .
            's.lastname as doctor_lastname, ' .
            'tech.firstname as technician_firstname, ' .
            'tech.lastname as technician_lastname, ' .
            'COUNT(ri.id) as items_count'
        );
        $this->db->from($this->requests_table . ' r');
        $this->db->join($this->categories_table . ' c', 'c.id = r.category_id', 'left');
        $this->db->join(db_prefix() . 'hospital_visits v', 'v.id = r.visit_id', 'left');
        $this->db->join(db_prefix() . 'hospital_appointments a', 'a.id = v.appointment_id', 'left');
        $this->db->join(db_prefix() . 'hospital_patients p', 'p.id = a.patient_id', 'left');
        $this->db->join(db_prefix() . 'staff s', 's.staffid = r.requested_by', 'left');
        $this->db->join(db_prefix() . 'staff tech', 'tech.staffid = r.assigned_technician_id', 'left');
        $this->db->join($this->request_items_table . ' ri', 'ri.request_id = r.id', 'left');
        
        $this->db->where_in('r.category_id', [1, 2]);
        
        // Show: ALL approved (available for anyone) OR my in_progress
        $this->db->group_start();
            $this->db->where('r.status', 'approved');
        $this->db->or_group_start();
            $this->db->where('r.status', 'in_progress');
            $this->db->where('r.assigned_technician_id', $technician_id);
        $this->db->group_end();
        $this->db->group_end();
        
        $this->db->group_by('r.id');
        $this->db->order_by('FIELD(r.priority, "emergency", "urgent", "normal")', '', FALSE);
        $this->db->order_by('r.created_at', 'DESC');
        
        return $this->db->get()->result_array();
    }
    
    /**
     * Start processing request - AUTO-ASSIGNS to the technician who starts it
     */
    public function start_processing($request_id, $technician_id)
    {
        // First check if request is available
        $request = $this->db->get_where($this->requests_table, ['id' => $request_id])->row();
        
        if (!$request) {
            return ['success' => false, 'message' => 'Request not found'];
        }
        
        if ($request->status !== 'approved') {
            return ['success' => false, 'message' => 'Request is not available (already taken or not approved)'];
        }
        
        // AUTO-ASSIGN and start
        $update_data = [
            'assigned_technician_id' => $technician_id,
            'status' => 'in_progress',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id', $request_id);
        $this->db->where('status', 'approved');
        $updated = $this->db->update($this->requests_table, $update_data);
        
        if ($updated && $this->db->affected_rows() > 0) {
            log_activity('Technician ID: ' . $technician_id . ' started processing request #' . $request_id);
            return ['success' => true, 'message' => 'Request started successfully'];
        }
        
        return ['success' => false, 'message' => 'Request was taken by another technician'];
    }
    
    /**
     * Complete request + Add amount to visit's additional_fee
     */
    public function complete_request($request_id, $technician_id, $notes = null)
    {
        // Start transaction
        $this->db->trans_start();
        
        // Get request details
        $request = $this->db->get_where($this->requests_table, ['id' => $request_id])->row();
        
        if (!$request) {
            $this->db->trans_rollback();
            return ['success' => false, 'message' => 'Request not found'];
        }
        
        // Update request status
        $update_data = [
            'status' => 'completed',
            'lab_notes' => $notes,
            'completed_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id', $request_id);
        $this->db->where('assigned_technician_id', $technician_id);
        $this->db->where('status', 'in_progress');
        $this->db->update($this->requests_table, $update_data);
        
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            return ['success' => false, 'message' => 'Cannot complete this request'];
        }
        
        // Add lab amount to visit's additional_fee
        $this->db->set('additional_fee', 'additional_fee + ' . $request->final_amount, FALSE);
        $this->db->set('total_fee', 'fee_amount + additional_fee', FALSE);
        $this->db->where('visit_id', $request->visit_id);
        $this->db->update(db_prefix() . 'hospital_visit_details');
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            return ['success' => false, 'message' => 'Failed to complete request'];
        }
        
        log_activity('Technician completed request #' . $request_id . ' - Amount ₹' . $request->final_amount . ' added to visit');
        return ['success' => true, 'message' => 'Request completed. Amount added to visit bill.'];
    }
    
    /**
     * Get technician statistics
     */
    public function get_technician_statistics($technician_id)
    {
        $stats = [];
        
        // Available for pickup
        $this->db->where('status', 'approved');
        $this->db->where_in('category_id', [1, 2]);
        $stats['available'] = $this->db->count_all_results($this->requests_table);
        
        // My in progress
        $this->db->where('assigned_technician_id', $technician_id);
        $this->db->where('status', 'in_progress');
        $this->db->where_in('category_id', [1, 2]);
        $stats['in_progress'] = $this->db->count_all_results($this->requests_table);
        
        // My completed
        $this->db->where('assigned_technician_id', $technician_id);
        $this->db->where('status', 'completed');
        $this->db->where_in('category_id', [1, 2]);
        $stats['completed'] = $this->db->count_all_results($this->requests_table);
        
        // My today's completed
        $this->db->where('assigned_technician_id', $technician_id);
        $this->db->where('status', 'completed');
        $this->db->where('DATE(completed_at)', date('Y-m-d'));
        $this->db->where_in('category_id', [1, 2]);
        $stats['today_completed'] = $this->db->count_all_results($this->requests_table);
        
        // Urgent available
        $this->db->where('status', 'approved');
        $this->db->where_in('priority', ['emergency', 'urgent']);
        $this->db->where_in('category_id', [1, 2]);
        $stats['urgent'] = $this->db->count_all_results($this->requests_table);
        
        return $stats;
    }
}