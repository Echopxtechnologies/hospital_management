<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Hospital_appointments_model extends App_Model
{
    private $table;
    
    public function __construct()
    {
        parent::__construct();
        $this->table = db_prefix() . 'hospital_appointments';
    }
    
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
     * Get consultants - ONLY users with Consultant role
     */
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
    $this->db->join(db_prefix() . 'staff s', 's.staffid = hu.staff_id', 'inner');
    
    $this->db->order_by('hu.first_name', 'ASC');
    
    $consultants = $this->db->get()->result_array();
    
    foreach ($consultants as &$c) {
        $c['full_name'] = $c['first_name'] . ' ' . $c['last_name'];
    }
    
    return $consultants;
}
    
    /**
     * Get appointment by ID
     */
    public function get($id)
    {
        $this->db->select($this->table . '.*, ' . 
                         db_prefix() . 'hospital_patients.name as patient_name, ' .
                         db_prefix() . 'hospital_patients.mobile_number as patient_mobile, ' .
                         db_prefix() . 'hospital_patients.patient_number as patient_number, ' .
                         db_prefix() . 'staff.firstname as consultant_firstname, ' .
                         db_prefix() . 'staff.lastname as consultant_lastname');
        $this->db->join(db_prefix() . 'hospital_patients', db_prefix() . 'hospital_patients.id = ' . $this->table . '.patient_id', 'left');
        $this->db->join(db_prefix() . 'staff', db_prefix() . 'staff.staffid = ' . $this->table . '.consultant_id', 'left');
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
            db_prefix() . 'hospital_patients.name as patient_name, ' .
            db_prefix() . 'hospital_patients.mobile_number as patient_mobile, ' .
            db_prefix() . 'hospital_patients.patient_number as patient_number, ' .
            'COALESCE(' . db_prefix() . 'staff.firstname, "Not Assigned") as consultant_firstname, ' .
            'COALESCE(' . db_prefix() . 'staff.lastname, "") as consultant_lastname'
        );
        
        $this->db->join(
            db_prefix() . 'hospital_patients', 
            db_prefix() . 'hospital_patients.id = ' . $this->table . '.patient_id', 
            'left'
        );
        
        $this->db->join(
            db_prefix() . 'staff', 
            db_prefix() . 'staff.staffid = ' . $this->table . '.consultant_id', 
            'left'
        );
        
        $this->db->order_by($this->table . '.appointment_date', 'DESC');
        $this->db->order_by($this->table . '.appointment_time', 'DESC');
        
        return $this->db->get($this->table)->result();
    }
    
 /**
 * Save appointment with patient data (handles all scenarios)
 * Scenarios:
 * 1. Existing patient appointment
 * 2. Existing patient walk-in
 * 3. New patient appointment
 * 4. New patient walk-in
 */
public function save($data, $patient_data = [], $files = [])
{
    // DEBUG LOG - Remove after testing
    log_activity('=== APPOINTMENT SAVE DEBUG ===');
    log_activity('Patient Mode: ' . (isset($data['patient_mode']) ? $data['patient_mode'] : 'NOT SET'));
    log_activity('Is New Patient: ' . (isset($data['is_new_patient']) ? $data['is_new_patient'] : 'NOT SET'));
    log_activity('Reason: ' . (isset($data['reason_for_appointment']) ? $data['reason_for_appointment'] : 'NOT SET'));
    log_activity('Patient Data Keys: ' . (!empty($patient_data) ? implode(', ', array_keys($patient_data)) : 'EMPTY'));
    log_activity('Data Keys: ' . implode(', ', array_keys($data)));
    log_activity('=== END DEBUG ===');
    
    $id = isset($data['id']) && !empty($data['id']) ? $data['id'] : null;
    
    // ========== STEP 1: VALIDATE ONLY REQUIRED FIELDS ==========
    $errors = [];
    
    // Check if this is a new patient scenario or existing patient scenario
    $is_new_patient = empty($data['patient_id']) || (isset($data['is_new_patient']) && $data['is_new_patient'] == 1);

    if ($is_new_patient && !empty($patient_data)) {
        // NEW PATIENT - Validate patient details
        if (empty($patient_data['name'])) {
            $errors[] = 'Patient name is required';
        }
        if (empty($patient_data['mobile_number'])) {
            $errors[] = 'Mobile number is required';
        }
        if (empty($patient_data['gender'])) {
            $errors[] = 'Gender is required';
        }
        if (empty($patient_data['patient_type'])) {
            $errors[] = 'Patient type is required';
        }
    } elseif (!$is_new_patient && empty($data['patient_id'])) {
        // EXISTING PATIENT - Just check patient_id
        $errors[] = 'Patient is required';
    }
    
    // Appointment required fields
    if (empty($data['appointment_date'])) {
        $errors[] = 'Appointment date is required';
    }
    if (empty($data['appointment_time'])) {
        $errors[] = 'Appointment time is required';
    }
    
    if (empty($data['reason_for_appointment']) || trim($data['reason_for_appointment']) === '') {
        $errors[] = 'Reason for appointment is required';
    }
        
    if (empty($data['consultant_id'])) {
        $errors[] = 'Consultant is required';
    }
    
    if (!empty($errors)) {
        log_activity('Validation Errors: ' . implode(', ', $errors));
        return ['success' => false, 'message' => implode('<br>', $errors)];
    }
    
    // ========== STEP 2: CREATE OR UPDATE PATIENT ==========
    $patient_id = $data['patient_id'];
    $patient_type_for_visit = null; // Initialize to prevent undefined variable error
    
    if (!empty($patient_data)) {
        // New patient or updating existing patient
        if (empty($patient_id)) {
            // CREATE NEW PATIENT
            $this->load->model('hospital_patients_model');
            $patient_type_for_visit = isset($patient_data['patient_type']) ? $patient_data['patient_type'] : 'Regular';
            log_activity('Creating new patient with type: ' . $patient_type_for_visit);
            
            $patient_result = $this->hospital_patients_model->save($patient_data, $files);
            
            if (!$patient_result['success']) {
                log_activity('Patient creation failed: ' . $patient_result['message']);
                return $patient_result;
            }
            
            $patient_id = $patient_result['id'];
            log_activity('Patient created successfully with ID: ' . $patient_id);
        } else {
            // UPDATE EXISTING PATIENT
            $this->load->model('hospital_patients_model');
            $patient_type_for_visit = isset($patient_data['patient_type']) ? $patient_data['patient_type'] : 'Regular';
            $patient_result = $this->hospital_patients_model->update_patient_info($patient_id, $patient_data, $files);
            
            if (!$patient_result['success']) {
                return ['success' => false, 'message' => 'Failed to update patient: ' . $patient_result['message']];
            }
        }
    } else {
        // EXISTING PATIENT - Fetch patient_type from database
        $this->db->select('patient_type');
        $this->db->where('id', $patient_id);
        $existing_patient = $this->db->get(db_prefix() . 'hospital_patients')->row();
        
        if ($existing_patient) {
            $patient_type_for_visit = $existing_patient->patient_type;
        } else {
            $patient_type_for_visit = 'Regular'; // Fallback
        }
    }
    
    // ========== STEP 3: CREATE OR UPDATE APPOINTMENT ==========
    $save_data = [
        'patient_id'             => $patient_id,
        'patient_mode'           => isset($data['patient_mode']) ? $data['patient_mode'] : 'appointment',
        'is_new_patient'         => isset($data['is_new_patient']) ? (int)$data['is_new_patient'] : 0,
        'appointment_date'       => $data['appointment_date'],
        'appointment_time'       => $data['appointment_time'],
        'reason_for_appointment' => $data['reason_for_appointment'], // Now guaranteed to have a value
        'consultant_id'          => $data['consultant_id'],
        'status'                 => isset($data['status']) ? $data['status'] : 'pending',
        'notes'                  => !empty($data['notes']) ? trim($data['notes']) : null,
    ];
    
    if ($id) {
        // UPDATE APPOINTMENT
        $save_data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $this->db->update($this->table, $save_data);
        
        log_activity('Hospital Appointment Updated [ID: ' . $id . ']');
        return ['success' => true, 'message' => 'Appointment updated successfully', 'id' => $id];
    } else {
        // CREATE NEW APPOINTMENT
        $save_data['appointment_number'] = $this->generate_appointment_number();
        $save_data['created_by'] = get_staff_user_id();
        $save_data['created_at'] = date('Y-m-d H:i:s');
        
        log_activity('Inserting appointment: ' . json_encode($save_data));
        
        $this->db->insert($this->table, $save_data);
        $insert_id = $this->db->insert_id();
        
        if (!$insert_id) {
            log_activity('Failed to insert appointment: ' . $this->db->error());
            return ['success' => false, 'message' => 'Failed to create appointment'];
        }

        log_activity('Appointment created with ID: ' . $insert_id);

        // AUTO-CREATE VISIT RECORD
        $this->load->model('hospital_visits_model');
        $visit_data = [
            'patient_id' => $patient_id,
            'appointment_id' => $insert_id,
            'consultant_id' => $data['consultant_id'],
            'visit_date' => $data['appointment_date'],
            'visit_time' => $data['appointment_time'],
            'visit_type' => $data['patient_mode'] === 'walk_in' ? 'walk_in' : 'appointment',
            'reason' => $data['reason_for_appointment'],
            'status' => 'ongoing'
        ];

   // Visit details data
$visit_details_data = [
    'patient_type_for_visit' => $patient_type_for_visit,
    
    // NEW: Fee payment radio (from form)
    'fee_payment'            => !empty($data['fee_payment']) ? $data['fee_payment'] : 'not_applicable',
    
    // Visit-specific referral
    'visit_referred_by'      => !empty($data['visit_referred_by']) ? $data['visit_referred_by'] : null,
    
    // Vitals & Medical Data
    'symptoms'               => !empty($data['symptoms']) ? $data['symptoms'] : null,
    'temperature'            => !empty($data['temperature']) ? $data['temperature'] : null,
    'blood_pressure'         => !empty($data['blood_pressure']) ? $data['blood_pressure'] : null,
    'pulse_rate'             => !empty($data['pulse_rate']) ? $data['pulse_rate'] : null,
    'weight'                 => !empty($data['weight']) ? $data['weight'] : null,
    
    // Fee Details
    'fee_payment_status'     => !empty($data['fee_payment_status']) ? $data['fee_payment_status'] : 'pending',
    'fee_amount'             => !empty($data['fee_amount']) ? $data['fee_amount'] : null,
    'payment_method'         => !empty($data['payment_method']) ? $data['payment_method'] : null,
    
    // Follow-up
    'follow_up_required'     => !empty($data['follow_up_required']) ? 1 : 0,
    'follow_up_date'         => !empty($data['follow_up_date']) ? $data['follow_up_date'] : null,
];

        // Save visit WITH details
        log_activity('Creating visit for appointment: ' . $insert_id);
        $visit_result = $this->hospital_visits_model->save($visit_data, $visit_details_data);

        log_activity('Hospital Appointment Created [Number: ' . $save_data['appointment_number'] . '] + Visit Auto-Created [ID: ' . $visit_result['id'] . ']');
        
        return [
            'success' => true, 
            'message' => 'Appointment and visit created successfully', 
            'id' => $insert_id,
            'visit_id' => $visit_result['id'],
            'appointment_number' => $save_data['appointment_number']
        ];
    }
}
    /**
     * Confirm appointment
     */
    public function confirm($id)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, ['status' => 'confirmed', 'updated_at' => date('Y-m-d H:i:s')]);
        
        log_activity('Hospital Appointment Confirmed [ID: ' . $id . ']');
        return ['success' => true, 'message' => 'Appointment confirmed successfully'];
    }
    
    /**
     * Cancel appointment
     */
    public function cancel($id, $reason = null)
    {
        $update_data = [
            'status' => 'cancelled',
            'cancellation_reason' => $reason,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id', $id);
        $this->db->update($this->table, $update_data);
        
        log_activity('Hospital Appointment Cancelled [ID: ' . $id . ']');
        return ['success' => true, 'message' => 'Appointment cancelled successfully'];
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
    
    /**
     * Get statistics
     */
    public function get_statistics()
    {
        $stats = [];
        
        $stats['total'] = $this->db->count_all_results($this->table);
        
        $this->db->where('status', 'pending');
        $stats['pending'] = $this->db->count_all_results($this->table);
        
        $this->db->where('status', 'confirmed');
        $stats['confirmed'] = $this->db->count_all_results($this->table);
        
        $this->db->where('appointment_date', date('Y-m-d'));
        $stats['today'] = $this->db->count_all_results($this->table);
        
        return $stats;
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
        return $this->db->get(db_prefix() . 'hospital_patients')->result_array();
    }
}