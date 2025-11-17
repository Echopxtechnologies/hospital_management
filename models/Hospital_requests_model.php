<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Hospital Requests Model - FIXED VERSION
 * 
 * WORKFLOW:
 * 1. Consultant creates request → status='pending'
 * 2. Receptionist processes payment → payment record created
 * 3. If fully paid → auto-approve OR receptionist manually approves → status='approved'
 * 4. ALL approved requests show in technician portal (no pre-assignment)
 * 5. Technician clicks "Start" → auto-assigns to them → status='in_progress'
 * 6. Technician completes → status='completed'
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
     * Get all pending requests (awaiting approval/payment)
     * Used by: Receptionist in lab_records.php "Pending Approval" section
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
            'p.patient_type,' .
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
        
        $this->db->where_in('r.status', ['pending', 'cancelled']);
        $this->db->where_in('r.category_id', [1, 2, 3]); // Lab + Procedure + Diagnostics
        
        $this->db->group_by('r.id');
        $this->db->order_by('FIELD(r.priority, "emergency", "urgent", "normal")', '', FALSE);
        $this->db->order_by('r.created_at', 'DESC');
        
        return $this->db->get()->result_array();
    }
    
    /**
     * Get single request with items for modal/detail view
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
     * Approve request manually (receptionist clicks Approve button)
     * This is used when payment is completed but needs manual approval
     */
    public function approve_request($request_id)
    {
        // First check if payment exists and is paid
        $payment = $this->check_request_payment($request_id);
        
        if (!$payment || $payment->payment_status !== 'paid') {
            return ['success' => false, 'message' => 'Payment must be completed before approval'];
        }
        
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
            log_activity('Lab Request #' . $request_id . ' approved by receptionist (manual approval after payment)');
            return ['success' => true, 'message' => 'Request approved successfully. Now available for technicians.'];
        }
        
        return ['success' => false, 'message' => 'Failed to approve request or already approved'];
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
            log_activity('Lab Request #' . $request_id . ' cancelled. Reason: ' . $reason);
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
        
        // Pending approval (pending status)
        $this->db->where('status', 'pending');
        $this->db->where_in('category_id', [1, 2, 3]);
        $stats['pending'] = $this->db->count_all_results($this->requests_table);
        
        // Approved (waiting for technician to pick up)
        $this->db->where('status', 'approved');
        $this->db->where_in('category_id', [1, 2, 3]);
        $stats['approved'] = $this->db->count_all_results($this->requests_table);
        
        // In progress (technician working on it)
        $this->db->where('status', 'in_progress');
        $this->db->where_in('category_id', [1, 2, 3]);
        $stats['in_progress'] = $this->db->count_all_results($this->requests_table);
        
        // Completed
        $this->db->where('status', 'completed');
        $this->db->where_in('category_id', [1, 2, 3]);
        $stats['completed'] = $this->db->count_all_results($this->requests_table);
        
        // Today's total requests
        $this->db->where('DATE(created_at)', date('Y-m-d'));
        $this->db->where_in('category_id', [1, 2, 3]);
        $stats['today'] = $this->db->count_all_results($this->requests_table);
        
        // Unpaid requests (pending with no payment or unpaid payment)
        $this->db->select('r.id');
        $this->db->from($this->requests_table . ' r');
        $this->db->join(db_prefix() . 'hospital_payments p', 'p.visit_request_id = r.id AND p.payment_status = "paid"', 'left');
        $this->db->where('r.status', 'pending');
        $this->db->where('p.id IS NULL');
        $this->db->where_in('r.category_id', [1, 2, 3]);
        $stats['unpaid'] = $this->db->count_all_results();
        
        return $stats;
    }
    
    /**
     * Get all lab records for receptionist (all statuses for tracking)
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
        
        $this->db->where_in('r.category_id', [1, 2, 3]);
        $this->db->where_in('r.status', ['approved', 'in_progress', 'completed']);
        
        $this->db->group_by('r.id');
        $this->db->order_by('r.created_at', 'DESC');
        
        return $this->db->get()->result_array();
    }
    
    // ==========================================
    // TECHNICIAN METHODS - CRITICAL FIX
    // ==========================================
    
    /**
     * Get ALL approved requests for technician portal
     * CRITICAL: This shows ALL approved & paid requests, not just assigned ones
     * 
     * Used by: Technician portal lab_requests.php
     * 
     * Returns:
     * - status='approved' requests (not yet started by anyone)
     * - status='in_progress' requests (currently being worked on by this or other technicians)
     * 
     * Note: Once a technician clicks "Start", it auto-assigns to them and changes to in_progress
     */
    public function get_technician_requests($technician_id = null)
    {
        $this->db->select(
            'r.*, ' .
            'c.category_name, ' .
            'v.visit_number, ' .
            'v.visit_date, ' .
            'p.name as patient_name, ' .
            'p.patient_number, ' .
            'p.patient_type,' .
            'p.mobile_number as patient_mobile, ' .
            'p.age as patient_age, ' .
            'p.gender as patient_gender, ' .
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
        
        // CRITICAL: Show ALL approved requests + my in_progress requests
        if ($technician_id) {
            // Show: approved (available to all) OR in_progress assigned to me
            $this->db->group_start();
                $this->db->where('r.status', 'approved'); // Available for anyone to pick up
                $this->db->or_where('(r.status = "in_progress" AND r.assigned_technician_id = ' . (int)$technician_id . ')');
            $this->db->group_end();
        } else {
            // If no technician_id, show all approved and in_progress
            $this->db->where_in('r.status', ['approved', 'in_progress']);
        }
        
        $this->db->where_in('r.category_id', [1, 2, 3]); // Lab + Procedure + Diagnostics
        
        $this->db->group_by('r.id');
        $this->db->order_by('FIELD(r.priority, "emergency", "urgent", "normal")', '', FALSE);
        $this->db->order_by('r.created_at', 'DESC');
        
        $results = $this->db->get()->result_array();
        
        // Debug logging
        log_activity('Technician Portal Query: Found ' . count($results) . ' requests for technician_id=' . $technician_id);
        
        return $results;
    }
    
    /**
     * Start processing a request (technician clicks "Start")
     * This AUTO-ASSIGNS the request to the technician
     */
    public function start_processing($request_id, $technician_id)
    {
        // Verify request is approved and not already being processed
        $this->db->where('id', $request_id);
        $this->db->where('status', 'approved');
        $request = $this->db->get($this->requests_table)->row();
        
        if (!$request) {
            return ['success' => false, 'message' => 'Request not found or already being processed'];
        }
        
        // Update status to in_progress and assign technician
        $update_data = [
            'status' => 'in_progress',
            'assigned_technician_id' => $technician_id,
            'started_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id', $request_id);
        $this->db->where('status', 'approved'); // Double-check status
        $updated = $this->db->update($this->requests_table, $update_data);
        
        if ($updated && $this->db->affected_rows() > 0) {
            log_activity('Lab Request #' . $request_id . ' started by technician #' . $technician_id);
            return ['success' => true, 'message' => 'Request assigned to you and started'];
        }
        
        return ['success' => false, 'message' => 'Failed to start request. It may have been picked up by another technician.'];
    }
    
    /**
     * Complete a request (technician clicks "Complete")
     */
    public function complete_request($request_id, $technician_id, $notes = null)
    {
        // Verify request is in_progress and assigned to this technician
        $this->db->where('id', $request_id);
        $this->db->where('status', 'in_progress');
        $this->db->where('assigned_technician_id', $technician_id);
        $request = $this->db->get($this->requests_table)->row();


        
        if (!$request) {
            return ['success' => false, 'message' => 'Request not found or not assigned to you'];
        }
                // echo "hello";
        
        // Start transaction
        $this->db->trans_start();

        // Update request status
        $update_data = [
            'status' => 'completed',
            'completed_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
      
        // if (!empty($notes)) {
        //     $update_data['technician_notes'] = $notes;
        // }
        
        $this->db->where('id', $request_id);
        $this->db->update($this->requests_table, $update_data);

        
        // Add amount to visit bill
        $this->db->set('additional_fee', 'additional_fee + ' . (float)$request->final_amount, FALSE);
        $this->db->where('visit_id', $request->visit_id);
        $result1 = $this->db->update(db_prefix() . 'hospital_visit_details');

        
        $this->db->trans_complete();
                // echo "trans_complete";
        
        if ($this->db->trans_status() === FALSE) {
            return ['success' => false, 'message' => 'Failed to complete request'];
        }
        log_activity('Lab Request #' . $request_id . ' completed by technician #' . $technician_id);
        return ['success' => true, 'message' => 'Request completed successfully'];
    }
    
    /**
     * Get technician statistics
     */
    public function get_technician_statistics($technician_id)
{
    $stats = [];
    
    // Available for pickup (approved requests - not assigned to anyone yet)
    $this->db->where('status', 'approved');
    $this->db->where_in('category_id', [1, 2, 3]);
    $stats['available'] = $this->db->count_all_results($this->requests_table);
    
    // Assigned to me (in progress and assigned to this technician)
    $this->db->where('assigned_technician_id', $technician_id);
    $this->db->where('status', 'in_progress');
    $this->db->where_in('category_id', [1, 2, 3]);
    $stats['assigned'] = $this->db->count_all_results($this->requests_table);
    
    // My in progress (same as assigned)
    $stats['in_progress'] = $stats['assigned'];
    
    // My completed (all time)
    $this->db->where('assigned_technician_id', $technician_id);
    $this->db->where('status', 'completed');
    $this->db->where_in('category_id', [1, 2, 3]);
    $stats['completed'] = $this->db->count_all_results($this->requests_table);
    
    // My today's completed
    $this->db->where('assigned_technician_id', $technician_id);
    $this->db->where('status', 'completed');
    $this->db->where('DATE(completed_at)', date('Y-m-d'));
    $this->db->where_in('category_id', [1, 2, 3]);
    $stats['today_completed'] = $this->db->count_all_results($this->requests_table);
    
    // Urgent available (approved requests with urgent/emergency priority)
    $this->db->where('status', 'approved');
    $this->db->where_in('priority', ['emergency', 'urgent']);
    $this->db->where_in('category_id', [1, 2, 3]);
    $stats['urgent'] = $this->db->count_all_results($this->requests_table);
    
    return $stats;
}

    // ==========================================
    // PAYMENT METHODS
    // ==========================================
    
    /**
     * Get payment calculation for visit request
     */
    public function get_request_payment_details($request_id)
    {
        // Get request with patient info
        $this->db->select('vr.*, vr.total_amount as subtotal, vr.discount_amount, vr.final_amount,
                           p.patient_type, p.name as patient_name, p.patient_number,
                           rc.category_name,
                           v.visit_number,
                           v.patient_id');
        $this->db->from(db_prefix() . 'hospital_visit_requests vr');
        $this->db->join(db_prefix() . 'hospital_visits v', 'v.id = vr.visit_id');
        $this->db->join(db_prefix() . 'hospital_patients p', 'p.id = v.patient_id');
        $this->db->join(db_prefix() . 'hospital_request_categories rc', 'rc.id = vr.category_id');
        $this->db->where('vr.id', $request_id);
        $request = $this->db->get()->row();
        
        if (!$request) {
            return null;
        }
        
        // Get all items for this request
        $this->db->select('vri.*, ri.item_name, ri.item_code');
        $this->db->from(db_prefix() . 'hospital_visit_request_items vri');
        $this->db->join(db_prefix() . 'hospital_request_items ri', 'ri.id = vri.item_id');
        $this->db->where('vri.request_id', $request_id);
        $items = $this->db->get()->result_array();
        
        // Calculate discount based on patient type
        $discount_percentage = $this->get_patient_type_discount($request->patient_type);
        $subtotal = floatval($request->subtotal);
        $discount_amount = ($subtotal * $discount_percentage) / 100;
        $final_amount = $subtotal - $discount_amount;
        
        return [
            'request_id' => $request_id,
            'request_number' => $request->request_number,
            'patient_id' => $request->patient_id ?? 0,
            'visit_id' => $request->visit_id,
            'patient_name' => $request->patient_name,
            'patient_number' => $request->patient_number,
            'patient_type' => $request->patient_type,
            'category_name' => $request->category_name,
            'visit_number' => $request->visit_number,
            'items' => $items,
            'subtotal' => $subtotal,
            'discount_percentage' => $discount_percentage,
            'discount_amount' => number_format($discount_amount, 2, '.', ''),
            'final_amount' => number_format($final_amount, 2, '.', ''),
            'current_status' => $request->status
        ];
    }
    
    /**
     * Get discount percentage based on patient type
     */
    private function get_patient_type_discount($patient_type)
    {
        // Define discount rules
        $discount_rules = [
            'VIP' => 10,
            'Concession Cases' => 50,
            'HELPAGE' => 100,
            'IGICH' => 100,
            'IGICH-UVEA' => 100,
            'Emergency' => 0,
            'Regular' => 0,
            'Staff' => 20,
            'VIIO Staff' => 20,
            'VCA' => 25, 'VCB' => 25, 'VCJ' => 25, 'VCK' => 25,
            'VCM' => 25, 'VCN' => 25, 'VCP' => 25, 'VCR' => 25,
            'VCT' => 25, 'VCKP' => 25,
            'SSVCB' => 30, 'SSVCJ' => 30, 'SSVCK' => 30,
            'SSVCM' => 30, 'SSVCN' => 30, 'SSVCP' => 30, 'SSVCT' => 30,
        ];
        
        return isset($discount_rules[$patient_type]) ? $discount_rules[$patient_type] : 0;
    }
    
    /**
     * Check if request has payment
     */
    public function check_request_payment($request_id)
    {
        $this->db->where('visit_request_id', $request_id);
        $this->db->where('payment_status !=', 'cancelled');
        return $this->db->get(db_prefix() . 'hospital_payments')->row();
    }
    
    /**
     * Get all lab records (approved, in_progress, completed) for receptionist
     */
    public function get_all_lab_records()
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
        
        $this->db->where_in('r.category_id', [1, 2, 3]);
        $this->db->where_in('r.status', ['approved', 'in_progress', 'completed']);
        
        $this->db->group_by('r.id');
        $this->db->order_by('r.created_at', 'DESC');
        
        return $this->db->get()->result_array();
    }
    
    /**
     * Get all technicians
     */
    public function get_technicians()
    {
        $this->db->select('staffid, firstname, lastname, email, active');
        $this->db->from(db_prefix() . 'staff');
        $this->db->where('active', 1);
        $this->db->order_by('firstname', 'ASC');
        
        return $this->db->get()->result_array();
    }

    /**
 * Save lab report data
 */
public function save_lab_report($data)
{
    // Check if report exists
    $this->db->where('request_id', $data['request_id']);
    $existing = $this->db->get(db_prefix() . 'hospital_lab_reports')->row();
    
    if ($existing) {
        // Update
        $this->db->where('id', $existing->id);
        $updated = $this->db->update(db_prefix() . 'hospital_lab_reports', $data);
        return ['success' => $updated, 'message' => $updated ? 'Lab report updated' : 'Update failed'];
    } else {
        // Insert
        $inserted = $this->db->insert(db_prefix() . 'hospital_lab_reports', $data);
        return ['success' => $inserted, 'message' => $inserted ? 'Lab report saved' : 'Insert failed'];
    }
}

/**
 * Get lab report by request ID
 */
public function get_lab_report($request_id)
{
    $this->db->where('request_id', $request_id);
    return $this->db->get(db_prefix() . 'hospital_lab_reports')->row();
}

// ==========================================
// COUNSELOR METHODS
// ==========================================

/**
 * Get all surgery requests for counselors
 * Shows all surgery requests regardless of status
 */
/**
 * Get all surgery requests for counselors
 * Shows all surgery requests regardless of status
 */
public function get_all_surgery_requests()
{
    $this->db->select(
        'sr.*, ' .
        'st.surgery_name, ' .
        'st.surgery_code, ' .
        'st.category as surgery_category, ' .
        'p.id as patient_id, ' .
        'p.patient_number, ' .
        'p.name as patient_name, ' .
        'p.mobile_number as patient_mobile, ' .
        'p.age as patient_age, ' .
        'p.gender as patient_gender, ' .
        'p.patient_type, ' .
        'v.visit_number, ' .
        'v.visit_date, ' .
        's.firstname as doctor_firstname, ' .
        's.lastname as doctor_lastname'
    );
    $this->db->from(db_prefix() . 'hospital_surgery_requests sr');
    $this->db->join(db_prefix() . 'hospital_surgery_types st', 'st.id = sr.surgery_type_id', 'left');
    $this->db->join(db_prefix() . 'hospital_visits v', 'v.id = sr.visit_id', 'left');
    $this->db->join(db_prefix() . 'hospital_patients p', 'p.id = sr.patient_id', 'left');
    $this->db->join(db_prefix() . 'staff s', 's.staffid = sr.requested_by', 'left');
    
    // Order by most recent first
    $this->db->order_by('sr.requested_at', 'DESC');
    
    return $this->db->get()->result_array();
}

/**
 * Get counselor statistics
 */
public function get_counselor_statistics()
{
    $stats = [];
    
    // Total surgery requests
    $stats['total_requests'] = $this->db->count_all_results(db_prefix() . 'hospital_surgery_requests');
    
    // Pending requests
    $this->db->where('status', 'pending');
    $stats['pending'] = $this->db->count_all_results(db_prefix() . 'hospital_surgery_requests');
    
    // Approved requests
    $this->db->where('status', 'approved');
    $stats['approved'] = $this->db->count_all_results(db_prefix() . 'hospital_surgery_requests');
    
    // Today's requests - FIXED: Use requested_at instead of created_at
    $this->db->where('DATE(requested_at)', date('Y-m-d'));
    $stats['today_requests'] = $this->db->count_all_results(db_prefix() . 'hospital_surgery_requests');
    
    // Completed requests
    $this->db->where('status', 'completed');
    $stats['completed'] = $this->db->count_all_results(db_prefix() . 'hospital_surgery_requests');
    
    return $stats;
}
}