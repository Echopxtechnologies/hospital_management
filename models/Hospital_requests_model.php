<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Hospital Requests Model - SIMPLE VERSION
 * 
 * Flow:
 * 1. Consultant creates request (pending)
 * 2. Receptionist assigns to technician (approved)
 * 3. Technician starts work (in_progress)
 * 4. Technician completes (completed)
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
     * Get all pending requests (awaiting assignment)
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
     * Get all active technicians
     */
    public function get_technicians()
    {
        // Get Technician role ID
        $role = $this->db->get_where(db_prefix() . 'roles', ['name' => 'Technician'])->row();
        
        if (!$role) {
            return [];
        }
        
        $this->db->select('staffid, firstname, lastname, email');
        $this->db->where('role', $role->roleid);
        $this->db->where('active', 1);
        $this->db->order_by('firstname', 'ASC');
        
        return $this->db->get(db_prefix() . 'staff')->result_array();
    }
    
    /**
     * Assign request to technician
     */
    public function assign_to_technician($request_id, $technician_id)
    {
        $update_data = [
            'assigned_technician_id' => $technician_id,
            'assigned_at' => date('Y-m-d H:i:s'),
            'assigned_by' => get_staff_user_id(),
            'status' => 'approved', // Changes to approved after assignment
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id', $request_id);
        $this->db->where('status', 'pending'); // Can only assign pending
        $updated = $this->db->update($this->requests_table, $update_data);
        
        if ($updated && $this->db->affected_rows() > 0) {
            log_activity('Request #' . $request_id . ' assigned to technician ID: ' . $technician_id);
            return ['success' => true, 'message' => 'Request assigned successfully'];
        }
        
        return ['success' => false, 'message' => 'Failed to assign request'];
    }
    
    /**
     * Cancel request
     */
    public function cancel_request($request_id, $reason = null)
    {
        $update_data = [
            'status' => 'cancelled',
            'cancellation_reason' => $reason,
            'cancelled_by' => get_staff_user_id(),
            'cancelled_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id', $request_id);
        $this->db->where('status', 'pending'); // Can only cancel pending
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
        
        // Pending assignment
        $this->db->where('status', 'pending');
        $this->db->where_in('category_id', [1, 2]);
        $stats['pending'] = $this->db->count_all_results($this->requests_table);
        
        // Assigned (approved)
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
    
    // ==========================================
    // TECHNICIAN METHODS
    // ==========================================
    
    /**
     * Get requests assigned to specific technician
     */
    public function get_technician_requests($technician_id)
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
            'COUNT(ri.id) as items_count'
        );
        $this->db->from($this->requests_table . ' r');
        $this->db->join($this->categories_table . ' c', 'c.id = r.category_id', 'left');
        $this->db->join(db_prefix() . 'hospital_visits v', 'v.id = r.visit_id', 'left');
        $this->db->join(db_prefix() . 'hospital_appointments a', 'a.id = v.appointment_id', 'left');
        $this->db->join(db_prefix() . 'hospital_patients p', 'p.id = a.patient_id', 'left');
        $this->db->join(db_prefix() . 'staff s', 's.staffid = r.requested_by', 'left');
        $this->db->join($this->request_items_table . ' ri', 'ri.request_id = r.id', 'left');
        
        $this->db->where('r.assigned_technician_id', $technician_id);
        $this->db->where_in('r.status', ['approved', 'in_progress']);
        $this->db->where_in('r.category_id', [1, 2]);
        
        $this->db->group_by('r.id');
        $this->db->order_by('FIELD(r.priority, "emergency", "urgent", "normal")', '', FALSE);
        $this->db->order_by('r.created_at', 'DESC');
        
        return $this->db->get()->result_array();
    }
    
    /**
     * Start processing request
     */
    public function start_processing($request_id, $technician_id)
    {
        $update_data = [
            'status' => 'in_progress',
            'processing_started_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id', $request_id);
        $this->db->where('assigned_technician_id', $technician_id); // Must be assigned to this tech
        $this->db->where('status', 'approved');
        $updated = $this->db->update($this->requests_table, $update_data);
        
        if ($updated && $this->db->affected_rows() > 0) {
            log_activity('Technician started processing request #' . $request_id);
            return ['success' => true, 'message' => 'Processing started'];
        }
        
        return ['success' => false, 'message' => 'Cannot start this request'];
    }
    
    /**
     * Complete request
     */
    public function complete_request($request_id, $technician_id, $notes = null)
    {
        $update_data = [
            'status' => 'completed',
            'technician_notes' => $notes,
            'completed_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id', $request_id);
        $this->db->where('assigned_technician_id', $technician_id);
        $this->db->where('status', 'in_progress'); // Must be in progress
        $updated = $this->db->update($this->requests_table, $update_data);
        
        if ($updated && $this->db->affected_rows() > 0) {
            log_activity('Technician completed request #' . $request_id);
            return ['success' => true, 'message' => 'Request completed successfully'];
        }
        
        return ['success' => false, 'message' => 'Cannot complete this request'];
    }
    
    /**
     * Get technician statistics
     */
    public function get_technician_statistics($technician_id)
    {
        $stats = [];
        
        // Assigned (not started)
        $this->db->where('assigned_technician_id', $technician_id);
        $this->db->where('status', 'approved');
        $this->db->where_in('category_id', [1, 2]);
        $stats['assigned'] = $this->db->count_all_results($this->requests_table);
        
        // In progress
        $this->db->where('assigned_technician_id', $technician_id);
        $this->db->where('status', 'in_progress');
        $this->db->where_in('category_id', [1, 2]);
        $stats['in_progress'] = $this->db->count_all_results($this->requests_table);
        
        // Completed
        $this->db->where('assigned_technician_id', $technician_id);
        $this->db->where('status', 'completed');
        $this->db->where_in('category_id', [1, 2]);
        $stats['completed'] = $this->db->count_all_results($this->requests_table);
        
        // Today's completed
        $this->db->where('assigned_technician_id', $technician_id);
        $this->db->where('status', 'completed');
        $this->db->where('DATE(completed_at)', date('Y-m-d'));
        $this->db->where_in('category_id', [1, 2]);
        $stats['today_completed'] = $this->db->count_all_results($this->requests_table);
        
        // Urgent
        $this->db->where('assigned_technician_id', $technician_id);
        $this->db->where_in('status', ['approved', 'in_progress']);
        $this->db->where_in('priority', ['emergency', 'urgent']);
        $this->db->where_in('category_id', [1, 2]);
        $stats['urgent'] = $this->db->count_all_results($this->requests_table);
        
        return $stats;
    }
}