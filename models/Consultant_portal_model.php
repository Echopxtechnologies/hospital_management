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
        };
        
        // Total appointments
        $this->db->from($this->appointments_table);
        $apply_filter();
        $stats['total'] = $this->db->count_all_results();
        
        // Pending appointments
        $this->db->from($this->appointments_table);
        $this->db->where('status', 'pending');
        $apply_filter();
        $stats['pending'] = $this->db->count_all_results();
        
        // Confirmed appointments
        $this->db->from($this->appointments_table);
        $this->db->where('status', 'confirmed');
        $apply_filter();
        $stats['confirmed'] = $this->db->count_all_results();
        
        // Today's appointments
        $this->db->from($this->appointments_table);
        $this->db->where('appointment_date', date('Y-m-d'));
        $apply_filter();
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
}