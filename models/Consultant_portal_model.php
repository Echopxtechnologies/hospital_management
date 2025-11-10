<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Consultant Portal Model
 * 
 * Handles consultant-specific operations including:
 * - Consultant appointments retrieval
 * - Access control verification
 * - Consultant statistics
 * - Visit records for consultants
 * 
 * @package Hospital_Management
 * @version 2.1
 */
class Consultant_portal_model extends App_Model
{
    private $appointments_table;
    private $patients_table;
    private $staff_table;
    private $visits_table;
    private $visit_details_table;
    
    public function __construct()
    {
        parent::__construct();
        $this->appointments_table = db_prefix() . 'hospital_appointments';
        $this->patients_table = db_prefix() . 'hospital_patients';
        $this->staff_table = db_prefix() . 'staff';
        $this->visits_table = db_prefix() . 'hospital_visits';
        $this->visit_details_table = db_prefix() . 'hospital_visit_details';
    }
    
    // ==========================================
    // APPOINTMENTS
    // ==========================================
    
   /**
 * Get appointments for consultant with date filtering
 * 
 * @param int $staff_id Staff ID
 * @param bool $is_jc Is Junior Consultant (sees all)
 * @param string|null $from_date From date (Y-m-d format)
 * @param string|null $to_date To date (Y-m-d format)
 * @return array Appointments list
 */
public function get_appointments($staff_id, $is_jc = false, $from_date = null, $to_date = null)
{
    $this->db->select(
        $this->appointments_table . '.*,' .
        $this->patients_table . '.name as patient_name,' .
        $this->patients_table . '.mobile_number as patient_mobile,' .
        $this->patients_table . '.patient_number,' .
        $this->patients_table . '.email as patient_email,' .
        $this->patients_table . '.age as patient_age,' .
        $this->patients_table . '.gender as patient_gender,' .
        $this->staff_table . '.firstname as consultant_firstname,' .
        $this->staff_table . '.lastname as consultant_lastname,' .
        // Get reason and visit_type from visits table
        $this->visits_table . '.reason as reason_for_appointment,' .
        $this->visits_table . '.visit_type as patient_mode,' .
        $this->visits_table . '.id as visit_id,' .
        $this->visits_table . '.visit_number,' .
        $this->visits_table . '.status as visit_status'
    );
    
    $this->db->from($this->appointments_table);
    $this->db->join($this->patients_table, $this->patients_table . '.id = ' . $this->appointments_table . '.patient_id', 'left');
    $this->db->join($this->staff_table, $this->staff_table . '.staffid = ' . $this->appointments_table . '.consultant_id', 'left');
    $this->db->join($this->visits_table, $this->visits_table . '.appointment_id = ' . $this->appointments_table . '.id', 'left');
    
  // Regular consultants only see their own appointments
    if (!$is_jc) {
        $this->db->where($this->appointments_table . '.consultant_id', $staff_id);
    }
    
    // Apply date filters if provided
    if ($from_date !== null && $to_date !== null) {
        $this->db->where($this->appointments_table . '.appointment_date >=', $from_date);
        $this->db->where($this->appointments_table . '.appointment_date <=', $to_date);
    }
    
    // FILTER: Show only CONFIRMED appointments (exclude PENDING)
    $this->db->where($this->appointments_table . '.status', 'confirmed');
    
    $this->db->order_by($this->appointments_table . '.appointment_date', 'DESC');
    $this->db->order_by($this->appointments_table . '.appointment_time', 'DESC');
    
    return $this->db->get()->result_array();
}
    /**
     * Get single appointment with full details including visit info
     * 
     * @param int $appointment_id Appointment ID
     * @return array|null Appointment details
     */
    public function get($appointment_id)
    {
        $this->db->select(
            $this->appointments_table . '.*,' .
            $this->patients_table . '.name as patient_name,' .
            $this->patients_table . '.mobile_number as patient_mobile,' .
            $this->patients_table . '.patient_number,' .
            $this->patients_table . '.email as patient_email,' .
            $this->patients_table . '.age as patient_age,' .
            $this->patients_table . '.gender as patient_gender,' .
            $this->patients_table . '.address,' .
            $this->patients_table . '.city,' .
            $this->patients_table . '.state,' .
            $this->staff_table . '.firstname as consultant_firstname,' .
            $this->staff_table . '.lastname as consultant_lastname,' .
            $this->staff_table . '.email as consultant_email,' .
            // FIXED: Get visit details
            $this->visits_table . '.reason as reason_for_appointment,' .
            $this->visits_table . '.visit_type as patient_mode,' .
            $this->visits_table . '.visit_number,' .
            $this->visits_table . '.visit_date,' .
            $this->visits_table . '.visit_time,' .
            $this->visits_table . '.chief_complaint,' .
            $this->visits_table . '.diagnosis,' .
            $this->visits_table . '.treatment_given,' .
            $this->visits_table . '.prescription,' .
            $this->visits_table . '.notes as visit_notes,' .
            $this->visits_table . '.status as visit_status'
        );
        
        $this->db->from($this->appointments_table);
        $this->db->join($this->patients_table, $this->patients_table . '.id = ' . $this->appointments_table . '.patient_id', 'left');
        $this->db->join($this->staff_table, $this->staff_table . '.staffid = ' . $this->appointments_table . '.consultant_id', 'left');
        $this->db->join($this->visits_table, $this->visits_table . '.appointment_id = ' . $this->appointments_table . '.id', 'left');
        $this->db->where($this->appointments_table . '.id', $appointment_id);
        
        return $this->db->get()->row_array();
    }
    
    // ==========================================
    // ACCESS CONTROL
    // ==========================================
    
    /**
     * Check if consultant can access appointment (basic check)
     * 
     * @param int $appointment_id Appointment ID
     * @param int $staff_id Staff ID
     * @return bool True if can access
     */
    public function can_access($appointment_id, $staff_id)
    {
        $this->db->select($this->appointments_table . '.id');
        $this->db->from($this->appointments_table);
        $this->db->where($this->appointments_table . '.id', $appointment_id);
        $this->db->where($this->appointments_table . '.consultant_id', $staff_id);
        
        return $this->db->count_all_results() > 0;
    }
    
    /**
     * Verify consultant has access to appointment (IMPROVED - NEW METHOD)
     * Returns comprehensive access check with message
     * 
     * @param int $appointment_id Appointment ID
     * @param int $staff_id Staff ID
     * @return array ['has_access' => bool, 'message' => string]
     */
    public function verify_access($appointment_id, $staff_id)
    {
        // JC and Admins can access all appointments
        if (is_junior_consultant() || has_permission('consultant_portal', '', 'view')) {
            return ['has_access' => true];
        }
        
        // Regular consultants can only access their own appointments
        if (is_consultant()) {
            if ($this->can_access($appointment_id, $staff_id)) {
                return ['has_access' => true];
            }
            return [
                'has_access' => false,
                'message' => 'You do not have access to this appointment'
            ];
        }
        
        // Not a consultant at all
        return [
            'has_access' => false,
            'message' => 'Access denied'
        ];
    }
    
    // ==========================================
    // STATISTICS
    // ==========================================
    
    /**
     * Get statistics for consultant
     * 
     * @param int $staff_id Staff ID
     * @param bool $is_jc Is Junior Consultant (sees all stats)
     * @return array Statistics array
     */
    public function get_statistics($staff_id, $is_jc = false)
    {
        $stats = [];
        
        // Helper closure to apply filter
        $apply_filter = function() use ($is_jc, $staff_id) {
            if (!$is_jc) {
                $this->db->where('consultant_id', $staff_id);
            }
            // FILTER: Only count CONFIRMED and COMPLETED appointments (exclude PENDING and CANCELLED)
            $this->db->where_in('status', ['confirmed', 'completed']);
        };
    
        // Total appointments (only confirmed + completed)
        $this->db->from($this->appointments_table);
        $apply_filter();
        $stats['total'] = $this->db->count_all_results();
        
        // Pending appointments - SET TO 0 (we're excluding them)
        $stats['pending'] = 0;
        
        // Confirmed appointments (completed ones)
        $this->db->from($this->appointments_table);
        $this->db->where('status', 'completed');
        if (!$is_jc) {
            $this->db->where('consultant_id', $staff_id);
        }
        $stats['confirmed'] = $this->db->count_all_results();
        
        // Today's appointments (only confirmed + completed)
        $this->db->from($this->appointments_table);
        $this->db->where('appointment_date', date('Y-m-d'));
        if (!$is_jc) {
            $this->db->where('consultant_id', $staff_id);
        }
        $this->db->where_in('status', ['confirmed', 'completed']);
        $stats['today'] = $this->db->count_all_results();
            
        return $stats;
    }
    
    // ==========================================
    // VISIT RECORDS
    // ==========================================
    
    /**
     * Get visit record for an appointment
     * 
     * @param int $appointment_id Appointment ID
     * @return array|null Visit with details
     */
    public function get_visit_by_appointment($appointment_id)
    {
        $this->db->select($this->visits_table . '.*, ' . $this->visit_details_table . '.*');
        $this->db->from($this->visits_table);
        $this->db->join($this->visit_details_table, $this->visit_details_table . '.visit_id = ' . $this->visits_table . '.id', 'left');
        $this->db->where($this->visits_table . '.appointment_id', $appointment_id);
        
        return $this->db->get()->row_array();
    }


    // ==========================================
// REQUEST SYSTEM METHODS
// ==========================================

/**
 * Get all active categories
 */
public function get_request_categories()
{
    return $this->db->where('is_active', 1)
                    ->order_by('display_order', 'ASC')
                    ->get(db_prefix() . 'hospital_request_categories')
                    ->result_array();
}

/**
 * Get items by category with subcategory grouping
 */
public function get_request_items_by_category($category_id)
{
    $items = $this->db->where('category_id', $category_id)
                      ->where('is_active', 1)
                      ->order_by('subcategory_name, display_order', 'ASC')
                      ->get(db_prefix() . 'hospital_request_items')
                      ->result_array();
    
    // Group by subcategory
    $grouped = [];
    foreach ($items as $item) {
        $subcategory = $item['subcategory_name'] ?? 'Other';
        if (!isset($grouped[$subcategory])) {
            $grouped[$subcategory] = [];
        }
        $grouped[$subcategory][] = $item;
    }
    
    return $grouped;
}

/**
 * Save visit request
 */
public function save_visit_request($data)
{
    $this->db->trans_start();
    
    // Generate request number
    $request_number = $this->generate_request_number();
    
    // Prepare request header
    $request_data = [
        'visit_id' => $data['visit_id'],
        'request_number' => $request_number,
        'category_id' => $data['category_id'],
        'total_amount' => $data['total_amount'] ?? 0,
        'final_amount' => $data['final_amount'] ?? 0,
        'status' => 'pending',
        'priority' => $data['priority'] ?? 'normal',
        'doctor_notes' => $data['doctor_notes'] ?? null,
        'requested_by' => get_staff_user_id()
    ];
    
    // Insert request header
    $this->db->insert(db_prefix() . 'hospital_visit_requests', $request_data);
    $request_id = $this->db->insert_id();
    
    // Insert selected items
    if (!empty($data['selected_items'])) {
        $items_batch = [];
        foreach ($data['selected_items'] as $item) {
            $items_batch[] = [
                'request_id' => $request_id,
                'item_id' => $item['item_id'],
                'quantity' => $item['quantity'] ?? 1,
                'unit_price' => $item['unit_price'],
                'total_price' => ($item['quantity'] ?? 1) * $item['unit_price']
            ];
        }
        
        if (!empty($items_batch)) {
            $this->db->insert_batch(db_prefix() . 'hospital_visit_request_items', $items_batch);
        }
    }
    
    $this->db->trans_complete();
    
    if ($this->db->trans_status() === FALSE) {
        return ['success' => false, 'message' => 'Failed to save request'];
    }
    
    return [
        'success' => true,
        'message' => 'Request saved successfully',
        'request_id' => $request_id,
        'request_number' => $request_number
    ];
}

/**
 * Generate unique request number
 */
private function generate_request_number()
{
    $prefix = 'REQ-';
    $date = date('Ymd');
    
    // Get last request number for today
    $last = $this->db->select('request_number')
                     ->like('request_number', $prefix . $date, 'after')
                     ->order_by('id', 'DESC')
                     ->limit(1)
                     ->get(db_prefix() . 'hospital_visit_requests')
                     ->row();
    
    if ($last) {
        $last_number = intval(substr($last->request_number, -4));
        $new_number = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT);
    } else {
        $new_number = '0001';
    }
    
    return $prefix . $date . '-' . $new_number;
}

/**
 * Get visit requests
 */
public function get_visit_requests($visit_id)
{
    return $this->db->select('r.*, c.category_name, s.firstname, s.lastname')
                    ->from(db_prefix() . 'hospital_visit_requests r')
                    ->join(db_prefix() . 'hospital_request_categories c', 'c.id = r.category_id', 'left')
                    ->join(db_prefix() . 'staff s', 's.staffid = r.requested_by', 'left')
                    ->where('r.visit_id', $visit_id)
                    ->order_by('r.created_at', 'DESC')
                    ->get()
                    ->result_array();
}
/**
 * Get visit requests by appointment ID (NEW - CLEAN METHOD)
 * 
 * @param int $appointment_id Appointment ID
 * @return array Requests with items
 */
public function get_requests_by_appointment($appointment_id)
{
    // First, get the visit_id from appointment
    $this->db->select('id as visit_id');
    $this->db->where('appointment_id', $appointment_id);
    $visit = $this->db->get(db_prefix() . 'hospital_visits')->row();
    
    if (!$visit) {
        return []; // No visit = no requests
    }
    
    $visit_id = $visit->visit_id;
    
    // Get all requests for this visit
    $requests = $this->db->select('r.*, c.category_name')
                         ->from(db_prefix() . 'hospital_visit_requests r')
                         ->join(db_prefix() . 'hospital_request_categories c', 'c.id = r.category_id', 'left')
                         ->where('r.visit_id', $visit_id)
                         ->order_by('r.created_at', 'DESC')
                         ->get()
                         ->result_array();
    
    // For each request, get the items
    foreach ($requests as &$request) {
        $items = $this->db->select('ri.*, i.item_name, i.subcategory_name')
                          ->from(db_prefix() . 'hospital_visit_request_items ri')
                          ->join(db_prefix() . 'hospital_request_items i', 'i.id = ri.item_id', 'left')
                          ->where('ri.request_id', $request['id'])
                          ->get()
                          ->result_array();
        
        $request['items'] = $items;
        $request['items_count'] = count($items);
    }
    
    return $requests;
}
/**
 * Get request details with items
 */
public function get_request_details($request_id)
{
    $request = $this->db->select('r.*, c.category_name')
                        ->from(db_prefix() . 'hospital_visit_requests r')
                        ->join(db_prefix() . 'hospital_request_categories c', 'c.id = r.category_id', 'left')
                        ->where('r.id', $request_id)
                        ->get()
                        ->row_array();
    
    if ($request) {
        // Get items
        $request['items'] = $this->db->select('ri.*, i.item_name, i.item_code, i.subcategory_name')
                                     ->from(db_prefix() . 'hospital_visit_request_items ri')
                                     ->join(db_prefix() . 'hospital_request_items i', 'i.id = ri.item_id', 'left')
                                     ->where('ri.request_id', $request_id)
                                     ->get()
                                     ->result_array();
    }
    
    return $request;
}

// ==========================================
// SURGERY REQUESTS
// ==========================================

/**
 * Get surgery requests by appointment ID
 * Follows same pattern as get_requests_by_appointment()
 * 
 * @param int $appointment_id Appointment ID
 * @return array Surgery requests
 */
public function get_surgery_requests_by_appointment($appointment_id)
{
    // Get visit_id from appointment first
    $this->db->select('id');
    $this->db->where('appointment_id', $appointment_id);
    $visit = $this->db->get(db_prefix() . 'hospital_visits')->row();
    
    $this->db->select(
        'sr.*, ' .
        'st.surgery_name as surgery_type_name, ' .
        'st.category as surgery_category, ' .
        'staff.firstname as consultant_firstname, ' .
        'staff.lastname as consultant_lastname'
    );
    $this->db->from(db_prefix() . 'hospital_surgery_requests sr');
    $this->db->join(db_prefix() . 'hospital_surgery_types st', 'st.id = sr.surgery_type_id', 'left');
    $this->db->join(db_prefix() . 'staff staff', 'staff.staffid = sr.requested_by', 'left');
     $visit_id = $visit->visit_id;
    if ($visit) {
        $this->db->where('sr.visit_id', $visit->id);
    } else {
        // If no visit yet, return empty array
        return [];
    }
    
    $this->db->order_by('sr.requested_at', 'DESC');
    
    return $this->db->get()->result_array();
}
}