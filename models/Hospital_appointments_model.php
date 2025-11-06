<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Hospital Appointments Model
 * 
 * Handles all appointment-related operations including:
 * - Appointment CRUD
 * - Consultant management
 * - Patient appointment linking
 * - Auto-create visit records
 * - Statistics and reporting
 * 
 * @package Hospital_Management
 * @version 2.0
 */
class Hospital_appointments_model extends App_Model
{
    private $table;
    private $patients_table;
    private $staff_table;
    
    public function __construct()
    {
        parent::__construct();
        $this->table = db_prefix() . 'hospital_appointments';
        $this->patients_table = db_prefix() . 'hospital_patients';
        $this->staff_table = db_prefix() . 'staff';
    }
    
    // ==========================================
    // CRUD OPERATIONS
    // ==========================================
    
    /**
     * Get appointment by ID
     */
    public function get($id)
    {
        $this->db->select(
            $this->table . '.*, ' . 
            $this->patients_table . '.name as patient_name, ' .
            $this->patients_table . '.mobile_number as patient_mobile, ' .
            $this->patients_table . '.patient_number as patient_number, ' .
            $this->staff_table . '.firstname as consultant_firstname, ' .
            $this->staff_table . '.lastname as consultant_lastname'
        );
        
        $this->db->join($this->patients_table, $this->patients_table . '.id = ' . $this->table . '.patient_id', 'left');
        $this->db->join($this->staff_table, $this->staff_table . '.staffid = ' . $this->table . '.consultant_id', 'left');
        $this->db->where($this->table . '.id', $id);
        
        return $this->db->get($this->table)->row();
    }
    
    /**
     * Get all appointments with LEFT JOIN to handle missing consultants
     */
    public function get_all()
    {
        $this->db->select(
            $this->table . '.*, ' . 
            $this->patients_table . '.name as patient_name, ' .
            $this->patients_table . '.mobile_number as patient_mobile, ' .
            $this->patients_table . '.patient_number as patient_number, ' .
            'COALESCE(' . $this->staff_table . '.firstname, "Not Assigned") as consultant_firstname, ' .
            'COALESCE(' . $this->staff_table . '.lastname, "") as consultant_lastname,'.
            db_prefix() . 'hospital_visits.reason as visit_reason, ' .
            db_prefix() . 'hospital_visits.visit_type as visit_type'
        );
        
        $this->db->join($this->patients_table, $this->patients_table . '.id = ' . $this->table . '.patient_id', 'left');
        $this->db->join($this->staff_table, $this->staff_table . '.staffid = ' . $this->table . '.consultant_id', 'left');
         $this->db->join(db_prefix() . 'hospital_visits', db_prefix() . 'hospital_visits.appointment_id = ' . $this->table . '.id', 'left');
        $this->db->order_by($this->table . '.appointment_date', 'DESC');
        $this->db->order_by($this->table . '.appointment_time', 'DESC');
        
        return $this->db->get($this->table)->result();
    }
    
    /**
     * Save appointment with patient data (handles all scenarios)
     * 
     * Scenarios:
     * 1. Existing patient appointment
     * 2. Existing patient walk-in
     * 3. New patient appointment
     * 4. New patient walk-in
     * 
     * @param array $data Appointment data
     * @param array $patient_data Patient data (for new/update)
     * @param array $files File uploads
     * @return array ['success' => bool, 'message' => string, 'id' => int]
     */
    public function save($data, $patient_data = [], $files = [])
    {
        $id = isset($data['id']) && !empty($data['id']) ? $data['id'] : null;
        
        // Step 1: Validate required fields
        $validation_result = $this->validate_appointment_data($data, $patient_data);
        if (!$validation_result['success']) {
            return $validation_result;
        }
        
        // Step 2: Create or update patient
        $patient_id = $this->handle_patient_data($data, $patient_data, $files);
        if (is_array($patient_id) && !$patient_id['success']) {
            return $patient_id; // Return error
        }
        
        // Get patient type for visit record
        $patient_type_for_visit = $this->get_patient_type($patient_id, $patient_data);
        
        // Step 3: Create or update appointment
        $save_data = $this->prepare_appointment_data($data, $patient_id);
        
        if ($id) {
            // UPDATE APPOINTMENT
            return $this->update_appointment($id, $save_data);
        } else {
            // CREATE NEW APPOINTMENT + AUTO-CREATE VISIT
            return $this->create_appointment($save_data, $data, $patient_id, $patient_type_for_visit);
        }
    }
    
    /**
     * Update appointment
     * 
     * @param int $id Appointment ID
     * @param array $data Update data
     * @return array Result
     */
    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        
        log_activity('Hospital Appointment Updated [ID: ' . $id . ']');
        return ['success' => true, 'message' => 'Appointment updated successfully'];
    }
    
    /**
     * Confirm appointment
     */
   public function confirm($id)
    {
        return $this->update($id, [
            'status' => 'confirmed',
            'time_reported' => date('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * Cancel appointment
     */
    public function cancel($id, $reason = null)
    {
        $update_data = [
            'status' => 'cancelled',
            'cancellation_reason' => $reason
        ];
        
        return $this->update($id, $update_data);
    }
    
    /**
     * Delete appointment
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
        
        log_activity('Hospital Appointment Deleted [ID: ' . $id . ']');
        return ['success' => true, 'message' => 'Appointment deleted successfully'];
    }
    
    // ==========================================
    // STATISTICS & REPORTING
    // ==========================================
    
    /**
     * Get statistics
     */
    public function get_statistics()
    {
        return [
            'total' => $this->get_count(),
            'pending' => $this->get_count_by_status('pending'),
            'confirmed' => $this->get_count_by_status('confirmed'),
            'today' => $this->get_today_count()
        ];
    }
    
    /**
     * Get count by status
     */
    private function get_count_by_status($status)
    {
        $this->db->where('status', $status);
        return $this->db->count_all_results($this->table);
    }
    
    /**
     * Get total count
     */
    private function get_count()
    {
        return $this->db->count_all_results($this->table);
    }
    
    /**
     * Get today's appointments count
     */
    private function get_today_count()
    {
        $this->db->where('appointment_date', date('Y-m-d'));
        return $this->db->count_all_results($this->table);
    }
    
    // ==========================================
    // CONSULTANT & PATIENT HELPERS
    // ==========================================
    
    /**
     * Get consultants - Return staff_id as the value for FK constraint
     */
    public function get_consultants()
    {
        $this->db->select('
            hu.staff_id as id,
            hu.staff_id as consultant_id,
            hu.staff_id,
            hu.first_name,
            hu.last_name,
            hu.email,
            hu.phone_number,
            r.name as role_name
        ');
        
        $this->db->from(db_prefix() . 'hospital_users hu');
        $this->db->join(db_prefix() . 'roles r', 'r.roleid = hu.role_id', 'left');
        $this->db->where('hu.active', 1);
        
        // Filter by Consultant role name
        $this->db->where('r.name', 'Consultant');
        
        // CRITICAL: Ensure staff_id exists in tblstaff
        $this->db->join($this->staff_table, $this->staff_table . '.staffid = hu.staff_id', 'inner');
        
        $this->db->order_by('hu.first_name', 'ASC');
        
        $consultants = $this->db->get()->result_array();
        
        foreach ($consultants as &$c) {
            $c['full_name'] = $c['first_name'] . ' ' . $c['last_name'];
        }
        
        return $consultants;
    }
    
    /**
     * Get patients for dropdown (with search optimization)
     */
    public function get_patients_for_dropdown($search = '')
    {
        $this->db->select('id, patient_number, name, mobile_number, email');
        
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('patient_number', $search);
            $this->db->or_like('name', $search);
            $this->db->or_like('mobile_number', $search);
            $this->db->group_end();
            $this->db->limit(50);
        } else {
            $this->db->limit(100);
        }
        
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get($this->patients_table)->result_array();
    }
    
    // ==========================================
    // HELPER METHODS (PRIVATE)
    // ==========================================
    
    /**
     * Generate unique appointment number
     */
    private function generate_appointment_number()
    {
        $prefix = 'APT';
        $year = date('Y');
        
        $this->db->select('appointment_number');
        $this->db->like('appointment_number', $prefix . $year, 'after');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $last = $this->db->get($this->table)->row();
        
        if ($last) {
            $last_number = (int) substr($last->appointment_number, -4);
            $new_number = $last_number + 1;
        } else {
            $new_number = 1;
        }
        
        return $prefix . $year . str_pad($new_number, 4, '0', STR_PAD_LEFT);
    }
    
    /**
     * Validate appointment data
     */
    private function validate_appointment_data($data, $patient_data)
    {
        $errors = [];
        
        // Check if this is a new patient scenario
        $is_new_patient = empty($data['patient_id']) || (isset($data['is_new_patient']) && $data['is_new_patient'] == 1);
        
        if ($is_new_patient && !empty($patient_data)) {
            // NEW PATIENT - Validate patient details
            if (empty($patient_data['name'])) $errors[] = 'Patient name is required';
            if (empty($patient_data['mobile_number'])) $errors[] = 'Mobile number is required';
            if (empty($patient_data['gender'])) $errors[] = 'Gender is required';
            if (empty($patient_data['patient_type'])) $errors[] = 'Patient type is required';
        } elseif (!$is_new_patient && empty($data['patient_id'])) {
            $errors[] = 'Patient is required';
        }
        
        // Appointment required fields
        if (empty($data['appointment_date'])) $errors[] = 'Appointment date is required';
        if (empty($data['appointment_time'])) $errors[] = 'Appointment time is required';
        if (empty($data['reason_for_appointment'])) $errors[] = 'Reason for appointment is required';
        if (empty($data['consultant_id'])) $errors[] = 'Consultant is required';
        
        if (!empty($errors)) {
            return ['success' => false, 'message' => implode('<br>', $errors)];
        }
        
        return ['success' => true];
    }
    
    /**
     * Handle patient data (create or update)
     */
    private function handle_patient_data($data, $patient_data, $files)
    {
        $patient_id = $data['patient_id'];
        
        if (!empty($patient_data)) {
            $this->load->model('hospital_patients_model');
            
            if (empty($patient_id)) {
                // CREATE NEW PATIENT
                $patient_result = $this->hospital_patients_model->save($patient_data, $files);
                
                if (!$patient_result['success']) {
                    return $patient_result; // Return error
                }
                
                return $patient_result['id'];
            } else {
                // UPDATE EXISTING PATIENT
                $patient_result = $this->hospital_patients_model->update_patient_info($patient_id, $patient_data, $files);
                
                if (!$patient_result['success']) {
                    return ['success' => false, 'message' => 'Failed to update patient: ' . $patient_result['message']];
                }
            }
        }
        
        return $patient_id;
    }
    
    /**
     * Get patient type
     */
    private function get_patient_type($patient_id, $patient_data)
    {
        if (isset($patient_data['patient_type'])) {
            return $patient_data['patient_type'];
        }
        
        // Fetch from database
        $this->db->select('patient_type');
        $this->db->where('id', $patient_id);
        $existing_patient = $this->db->get($this->patients_table)->row();
        
        return $existing_patient ? $existing_patient->patient_type : 'Regular';
    }
    
    /**
     * Prepare appointment data array
     */
    private function prepare_appointment_data($data, $patient_id)
    {
        return [
        'patient_id'       => $patient_id,
        'appointment_date' => $data['appointment_date'],
        'appointment_time' => $data['appointment_time'],
        'consultant_id'    => $data['consultant_id'],
        'status'           => isset($data['status']) ? $data['status'] : 'pending',
        'notes'            => !empty($data['notes']) ? trim($data['notes']) : null,
    ];
    }
    
    /**
     * Update appointment record
     */
    private function update_appointment($id, $save_data)
    {
        $save_data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $this->db->update($this->table, $save_data);
        
        log_activity('Hospital Appointment Updated [ID: ' . $id . ']');
        return ['success' => true, 'message' => 'Appointment updated successfully', 'id' => $id];
    }
    
    /**
     * Create new appointment and auto-create visit record
     */
    private function create_appointment($save_data, $data, $patient_id, $patient_type_for_visit)
    {
        // Add appointment metadata
        $save_data['appointment_number'] = $this->generate_appointment_number();
        $save_data['created_by'] = get_staff_user_id();
        $save_data['created_at'] = date('Y-m-d H:i:s');
        
        // Insert appointment
        $this->db->insert($this->table, $save_data);
        $insert_id = $this->db->insert_id();
        
        if (!$insert_id) {
            log_activity('Failed to insert appointment: ' . json_encode($this->db->error()));
            return ['success' => false, 'message' => 'Failed to create appointment'];
        }
        
        // AUTO-CREATE VISIT RECORD
        $visit_result = $this->create_visit_record($insert_id, $patient_id, $data, $patient_type_for_visit);
         // ✅ CHECK IF VISIT CREATION SUCCEEDED
        if (!$visit_result['success']) {
            log_activity('Hospital Appointment Created [Number: ' . $save_data['appointment_number'] . '] BUT Visit Creation Failed: ' . $visit_result['message']);
            
            // Return success for appointment but include warning about visit
            return [
                'success' => true,
                'message' => 'Appointment created successfully, but visit creation failed: ' . $visit_result['message'],
                'id' => $insert_id,
                'appointment_number' => $save_data['appointment_number'],
                'visit_error' => $visit_result['message']
            ];
        }
        log_activity('Hospital Appointment Created [Number: ' . $save_data['appointment_number'] . '] + Visit Auto-Created');
        
        return [
            'success' => true,
            'message' => 'Appointment and visit created successfully',
            'id' => $insert_id,
            'visit_id' => $visit_result['id'],
            'appointment_number' => $save_data['appointment_number']
        ];
    }
    
    /**
     * Create visit record for appointment
     */
    private function create_visit_record($appointment_id, $patient_id, $data, $patient_type_for_visit)
    {
        $this->load->model('hospital_visits_model');
        
        // Visit data
        $visit_data = [
            'patient_id' => $patient_id,
            'appointment_id' => $appointment_id,
            'consultant_id' => $data['consultant_id'],
            'visit_date' => $data['appointment_date'],
            'visit_time' => $data['appointment_time'],
            'visit_type' => $data['patient_mode'] === 'walk_in' ? 'walk_in' : 'appointment',
            'reason' => $data['reason_for_appointment'],
            'status' => 'ongoing'
        ];
        
        // Visit details data - ONLY fields that exist in your table
    $visit_details_data = [
        'patient_type_for_visit' => $patient_type_for_visit,
        'fee_payment'            => !empty($data['fee_payment']) ? $data['fee_payment'] : 'not_applicable',
        'fee_payment_status'     => !empty($data['fee_payment_status']) ? $data['fee_payment_status'] : 'pending',
        'fee_amount'             => !empty($data['fee_amount']) ? $data['fee_amount'] : null,
        'payment_method'         => !empty($data['payment_method']) ? $data['payment_method'] : null,
        'visit_referred_by'      => !empty($data['visit_referred_by']) ? $data['visit_referred_by'] : null,
        'follow_up_required'     => !empty($data['follow_up_required']) ? 1 : 0,
        'follow_up_date'         => !empty($data['follow_up_date']) ? $data['follow_up_date'] : null,
    ];
        
        return $this->hospital_visits_model->save($visit_data, $visit_details_data);
    }
}