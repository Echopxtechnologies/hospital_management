<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Hospital Visits Model
 * Handles all visit-related operations
 * 
 * @package Hospital_Management
 * @version 2.0
 */
class Hospital_visits_model extends App_Model
{
    private $visits_table;
    private $visit_details_table;
    private $patients_table;
    private $staff_table;
    private $appointments_table;
    private $medicines_table;
    
    public function __construct()
    {
        parent::__construct();
        
        // Initialize table names
        $this->visits_table = db_prefix() . 'hospital_visits';
        $this->visit_details_table = db_prefix() . 'hospital_visit_details';
        $this->patients_table = db_prefix() . 'hospital_patients';
        $this->staff_table = db_prefix() . 'staff';
        $this->appointments_table = db_prefix() . 'hospital_appointments';
        $this->medicines_table = db_prefix() . 'hospital_medicines';
    }
    
    // ==========================================
    // VISIT CREATION & RETRIEVAL
    // ==========================================
    
    /**
     * Get or create visit for appointment
     * This is the MAIN function that ensures visit exists
     * 
     * @param int $appointment_id Appointment ID
     * @param array $appointment Appointment data
     * @return int|false Visit ID or false on failure
     */
    public function get_or_create_visit($appointment_id, $appointment)
    {
        // STEP 1: Check if visit already exists for this appointment
        $this->db->where('appointment_id', $appointment_id);
        $existing_visit = $this->db->get($this->visits_table)->row_array();
        
        if ($existing_visit) {
            log_activity('Hospital Visit - Found existing visit ID: ' . $existing_visit['id'] . ' for appointment: ' . $appointment_id);
            return (int)$existing_visit['id'];
        }
        
        // STEP 2: No visit exists, create new one
        log_activity('Hospital Visit - Creating new visit for appointment: ' . $appointment_id);
        
        $visit_number = $this->generate_visit_number();
        
        $visit_data = [
            'visit_number'   => $visit_number,
            'patient_id'     => (int)$appointment['patient_id'],
            'appointment_id' => (int)$appointment_id,
            'consultant_id'  => (int)$appointment['consultant_id'],
            'visit_date'     => date('Y-m-d'),
            'visit_time'     => date('H:i:s'),
            'visit_type'     => 'appointment',
            'reason'         => !empty($appointment['reason_for_appointment']) ? $appointment['reason_for_appointment'] : 'consultation',
            'status'         => 'ongoing',
            'created_by'     => get_staff_user_id(),
            'created_at'     => date('Y-m-d H:i:s')
        ];
        
        // Insert into hospital_visits table
        $this->db->insert($this->visits_table, $visit_data);
        $visit_id = $this->db->insert_id();
        
        if (!$visit_id) {
            log_activity('Hospital Visit - ERROR: Failed to insert visit. DB Error: ' . $this->db->error()['message']);
            return false;
        }
        
        log_activity('Hospital Visit - Successfully created visit ID: ' . $visit_id . ' (Number: ' . $visit_number . ')');
        
        // STEP 3: Create corresponding visit_details record (empty initially)
        $visit_details_data = [
            'visit_id'   => (int)$visit_id,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert($this->visit_details_table, $visit_details_data);
        $details_insert_id = $this->db->insert_id();
        
        if (!$details_insert_id) {
            log_activity('Hospital Visit Details - WARNING: Failed to create initial visit_details for visit: ' . $visit_id . '. DB Error: ' . $this->db->error()['message']);
            // Don't return false here - the visit was created successfully, details can be created on first save
        } else {
            log_activity('Hospital Visit Details - Created empty visit_details record (ID: ' . $details_insert_id . ') for visit: ' . $visit_id);
        }
        
        return (int)$visit_id;
    }
    
    /**
 * Get visit with details by visit ID
 * 
 * @param int $visit_id Visit ID
 * @return array|null Visit data with details
 */
public function get_visit_with_details($visit_id)
{
    // CRITICAL: Select visit.id explicitly and alias visit_details.id
    $this->db->select(
        $this->visits_table . '.id as visit_id, ' .  // ← THE FIX: Explicit alias
        $this->visits_table . '.id, ' .  // ← Also keep regular id
        $this->visits_table . '.visit_number, ' .
        $this->visits_table . '.patient_id, ' .
        $this->visits_table . '.appointment_id, ' .
        $this->visits_table . '.consultant_id, ' .
        $this->visits_table . '.visit_date, ' .
        $this->visits_table . '.visit_time, ' .
        $this->visits_table . '.visit_type, ' .
        $this->visits_table . '.reason, ' .
        $this->visits_table . '.status, ' .
        $this->visits_table . '.completed_at, ' .
        $this->visits_table . '.created_by, ' .
        $this->visits_table . '.created_at as visit_created_at, ' .
        $this->visit_details_table . '.id as details_id, ' .  // ← Alias the details id
        $this->visit_details_table . '.allergies, ' .
        $this->visit_details_table . '.systemic_history, ' .
        $this->visit_details_table . '.family_history, ' .
        $this->visit_details_table . '.ocular_diseases, ' .
        $this->visit_details_table . '.surgical_history, ' .
        $this->visit_details_table . '.medication, ' .
        $this->visit_details_table . '.present_complaint, ' .
        $this->visit_details_table . '.dilating_drops, ' .
        $this->visit_details_table . '.examination_data, ' .
        $this->visit_details_table . '.retinoscopy_data, ' .
        $this->visit_details_table . '.opinion_plan_of_care, ' .
        $this->visit_details_table . '.icd_codes, ' .
        $this->visit_details_table . '.review_required, ' .
        $this->visit_details_table . '.review_period, ' .
        $this->visit_details_table . '.systematic_exam_ordered, ' .
        $this->visit_details_table . '.medicine_prescription_details, ' .
        $this->visit_details_table . '.fee_amount, ' .
        $this->visit_details_table . '.total_fee, ' .
        $this->visit_details_table . '.spectacle_right_sph, ' .
        $this->visit_details_table . '.spectacle_right_cyl, ' .
        $this->visit_details_table . '.spectacle_right_axis, ' .
        $this->visit_details_table . '.spectacle_right_near_vision, ' .
        $this->visit_details_table . '.spectacle_right_distance_vision, ' .
        $this->visit_details_table . '.spectacle_left_sph, ' .
        $this->visit_details_table . '.spectacle_left_cyl, ' .
        $this->visit_details_table . '.spectacle_left_axis, ' .
        $this->visit_details_table . '.spectacle_left_near_vision, ' .
        $this->visit_details_table . '.spectacle_left_distance_vision, ' .
        $this->visit_details_table . '.bifocals, ' .
        $this->visit_details_table . '.back_vertex, ' .
        $this->visit_details_table . '.interpupillary, ' .
        $this->visit_details_table . '.spectacle_remarks, ' .
        $this->visit_details_table . '.lens_type, ' .
        $this->visit_details_table . '.pediatric_notes, ' .
        $this->visit_details_table . '.is_completed, ' .
        $this->visit_details_table . '.completed_by, ' .
        $this->visit_details_table . '.created_at as details_created_at, ' .
        $this->visit_details_table . '.updated_at as details_updated_at'
    );
    
    $this->db->from($this->visits_table);
    $this->db->join(
        $this->visit_details_table, 
        $this->visit_details_table . '.visit_id = ' . $this->visits_table . '.id', 
        'left'
    );
    $this->db->where($this->visits_table . '.id', $visit_id);
    
    $result = $this->db->get()->row_array();
    
    if (!$result) {
        log_activity('Hospital Visit - ERROR: Visit ID ' . $visit_id . ' not found');
        return null;
    }
    
    // Ensure both id and visit_id point to the actual visit ID
    if (!isset($result['visit_id'])) {
        $result['visit_id'] = $result['id'];
    }
    
    return $result;
}
    /**
     * Get visit by appointment ID
     * 
     * @param int $appointment_id Appointment ID
     * @return array|null Visit data
     */
    public function get_visit_by_appointment($appointment_id)
    {
        $this->db->select(
            $this->visits_table . '.id, ' .
            $this->visits_table . '.visit_number, ' .
            $this->visits_table . '.patient_id, ' .
            $this->visits_table . '.appointment_id, ' .
            $this->visits_table . '.consultant_id, ' .
            $this->visits_table . '.visit_date, ' .
            $this->visits_table . '.visit_time, ' .
            $this->visits_table . '.status, ' .
            $this->visit_details_table . '.*'
        );
        
        $this->db->from($this->visits_table);
        $this->db->join(
            $this->visit_details_table, 
            $this->visit_details_table . '.visit_id = ' . $this->visits_table . '.id', 
            'left'
        );
        $this->db->where($this->visits_table . '.appointment_id', $appointment_id);
        
        $result = $this->db->get()->row_array();
        
        if ($result) {
            $result['visit_id'] = $result['id'];
        }
        
        return $result;
    }
    
    // ==========================================
    // VISIT DETAILS UPDATE
    // ==========================================
    
    /**
     * Update visit details
     * This handles both INSERT and UPDATE
     * 
     * @param int $visit_id Visit ID
     * @param array $data Data to save
     * @return bool Success
     */
    public function update_visit_details($visit_id, $data)
    {
        // STEP 1: Verify visit exists
        $this->db->where('id', $visit_id);
        $visit_exists = $this->db->get($this->visits_table)->row();
        
        if (!$visit_exists) {
            log_activity('Hospital Visit Details - ERROR: Cannot update details. Visit ID ' . $visit_id . ' does not exist in ' . $this->visits_table);
            return false;
        }
        
        // STEP 2: Check if visit_details record exists
        $this->db->where('visit_id', $visit_id);
        $existing_details = $this->db->get($this->visit_details_table)->row();
        
        if ($existing_details) {
            // UPDATE existing record
            $data['updated_at'] = date('Y-m-d H:i:s');
            
            $this->db->where('visit_id', $visit_id);
            $result = $this->db->update($this->visit_details_table, $data);
            
            if ($result) {
                log_activity('Hospital Visit Details - Updated details for visit ID: ' . $visit_id);
            } else {
                log_activity('Hospital Visit Details - ERROR: Failed to update details for visit: ' . $visit_id . '. DB Error: ' . $this->db->error()['message']);
            }
            
            return $result;
            
        } else {
            // INSERT new record
            $data['visit_id'] = (int)$visit_id;
            $data['created_at'] = date('Y-m-d H:i:s');
            
            $result = $this->db->insert($this->visit_details_table, $data);
            
            if ($result) {
                log_activity('Hospital Visit Details - Created new details record for visit ID: ' . $visit_id);
            } else {
                log_activity('Hospital Visit Details - ERROR: Failed to insert details for visit: ' . $visit_id . '. DB Error: ' . $this->db->error()['message']);
            }
            
            return $result;
        }
    }
    
    // ==========================================
    // PATIENT VISIT HISTORY
    // ==========================================
    
    /**
     * Get all visits for a patient (for history)
     * 
     * @param int $patient_id Patient ID
     * @return array List of visits
     */
    public function get_patient_visits($patient_id)
    {
        $this->db->select(
            $this->visits_table . '.*, ' . 
            $this->staff_table . '.firstname, ' . 
            $this->staff_table . '.lastname'
        );
        
        $this->db->from($this->visits_table);
        $this->db->join(
            $this->staff_table, 
            $this->staff_table . '.staffid = ' . $this->visits_table . '.consultant_id', 
            'left'
        );
        $this->db->where($this->visits_table . '.patient_id', $patient_id);
        $this->db->order_by($this->visits_table . '.visit_date', 'DESC');
        $this->db->order_by($this->visits_table . '.visit_time', 'DESC');
        
        return $this->db->get()->result_array();
    }
    
    // ==========================================
    // VISIT COMPLETION
    // ==========================================
    
    /**
     * Complete visit
     * 
     * @param int $visit_id Visit ID
     * @param int $staff_id Staff ID who completed
     * @return bool Success
     */
    public function complete_visit($visit_id, $staff_id)
    {
        // Update main visit status
        $this->db->where('id', $visit_id);
        $this->db->update($this->visits_table, [
            'status' => 'completed',
            'completed_at' => date('Y-m-d H:i:s')
        ]);
        
        // Update visit details
        $this->db->where('visit_id', $visit_id);
        $result = $this->db->update($this->visit_details_table, [
            'is_completed' => 1,
            'completed_by' => $staff_id
        ]);
        
        if ($result) {
            log_activity('Hospital Visit - Completed visit ID: ' . $visit_id . ' by staff: ' . $staff_id);
        }
        
        return $result;
    }
    
    // ==========================================
    // MEDICINES
    // ==========================================
    
    /**
     * Get medicines by category
     * 
     * @param string|null $category Category filter
     * @return array Medicines list
     */
    public function get_medicines($category = null)
    {
        $this->db->select('id, medicine_name, generic_name, category, strength, unit, price');
        $this->db->from($this->medicines_table);
        $this->db->where('is_active', 1);
        
        if ($category) {
            $this->db->where('category', $category);
        }
        
        $this->db->order_by('display_order', 'ASC');
        $this->db->order_by('medicine_name', 'ASC');
        
        return $this->db->get()->result_array();
    }
    
    /**
     * Get single medicine
     * 
     * @param int $medicine_id Medicine ID
     * @return array|null Medicine data
     */
    public function get_medicine($medicine_id)
    {
        $this->db->where('id', $medicine_id);
        return $this->db->get($this->medicines_table)->row_array();
    }
    
    /**
     * Calculate total medicine fee
     * 
     * @param array $medicines Array of medicine data
     * @return float Total amount
     */
    public function calculate_medicine_fee($medicines)
    {
        $total = 0.00;
        
        if (!empty($medicines)) {
            foreach ($medicines as $med) {
                if (isset($med['price'])) {
                    $total += (float)$med['price'];
                }
            }
        }
        
        return $total;
    }
    
    // ==========================================
    // HELPER FUNCTIONS
    // ==========================================
    
    /**
     * Generate unique visit number
     * Format: VST-YYYYMMDD-####
     * 
     * @return string Visit number
     */
    private function generate_visit_number()
    {
        $prefix = 'VST';
        $date = date('Ymd'); // 20251105
        
        // Get last visit number for today
        $this->db->select('visit_number');
        $this->db->from($this->visits_table);
        $this->db->like('visit_number', $prefix . $date, 'after');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        
        $last = $this->db->get()->row();
        
        if ($last) {
            // Extract sequence number and increment
            // Format: VST20251105-0001
            $last_number = (int)substr($last->visit_number, -4);
            $sequence = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $sequence = '0001';
        }
        
        return $prefix . $date . '-' . $sequence;
    }
    
    /**
     * Get visit statistics
     * 
     * @param int $consultant_id Consultant staff ID
     * @return array Statistics
     */
    public function get_visit_statistics($consultant_id = null)
    {
        $stats = [];
        
        // Total visits
        $this->db->from($this->visits_table);
        if ($consultant_id) {
            $this->db->where('consultant_id', $consultant_id);
        }
        $stats['total'] = $this->db->count_all_results();
        
        // Ongoing visits
        $this->db->from($this->visits_table);
        $this->db->where('status', 'ongoing');
        if ($consultant_id) {
            $this->db->where('consultant_id', $consultant_id);
        }
        $stats['ongoing'] = $this->db->count_all_results();
        
        // Completed visits
        $this->db->from($this->visits_table);
        $this->db->where('status', 'completed');
        if ($consultant_id) {
            $this->db->where('consultant_id', $consultant_id);
        }
        $stats['completed'] = $this->db->count_all_results();
        
        // Today's visits
        $this->db->from($this->visits_table);
        $this->db->where('visit_date', date('Y-m-d'));
        if ($consultant_id) {
            $this->db->where('consultant_id', $consultant_id);
        }
        $stats['today'] = $this->db->count_all_results();
        
        return $stats;
    }
    
    /**
     * Delete visit (with cascade)
     * 
     * @param int $visit_id Visit ID
     * @return bool Success
     */
    public function delete_visit($visit_id)
    {
        // Delete visit details first (if FK doesn't cascade)
        $this->db->where('visit_id', $visit_id);
        $this->db->delete($this->visit_details_table);
        
        // Delete visit
        $this->db->where('id', $visit_id);
        $result = $this->db->delete($this->visits_table);
        
        if ($result) {
            log_activity('Hospital Visit - Deleted visit ID: ' . $visit_id);
        }
        
        return $result;
    }
}