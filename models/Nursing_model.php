<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Nursing Model
 * Handles ward management, admissions, and patient care
 */
class Nursing_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    // ==========================================
    // GET PATIENTS FOR NURSING PORTAL
    // ==========================================
    
    /**
     * Get all paid surgery requests (ready for admission)
     * Status: payment_status = 'paid' AND counseling_status = 'accepted'
     */
    public function get_paid_surgery_requests()
    {
        $this->db->select('
            sr.id as surgery_request_id,
            sr.surgery_date,
            sr.room_type as requested_room_type,
            sr.payment_status,
            sr.status as surgery_status,
            sr.op_number,
            sr.quoted_amount,
            p.id as patient_id,
            p.patient_number,
            p.name as patient_name,
            p.mobile_number as patient_mobile,
            p.age as patient_age,
            p.gender as patient_gender,
            v.visit_number,
            st.surgery_name,
            consultant.firstname as consultant_firstname,
            consultant.lastname as consultant_lastname,
            a.id as admission_id,
            a.admission_date,
            a.admission_status,
            w.ward_name,
            w.room_number
        ');
        
        $this->db->from(db_prefix() . 'hospital_surgery_requests sr');
        $this->db->join(db_prefix() . 'hospital_patients p', 'p.id = sr.patient_id', 'left');
        $this->db->join(db_prefix() . 'hospital_visits v', 'v.id = sr.visit_id', 'left');
        $this->db->join(db_prefix() . 'hospital_surgery_types st', 'st.id = sr.surgery_type_id', 'left');
        $this->db->join(db_prefix() . 'staff consultant', 'consultant.staffid = sr.assigned_consultant_id', 'left');
        $this->db->join(db_prefix() . 'hospital_surgery_admissions a', 'a.surgery_request_id = sr.id', 'left');
        $this->db->join(db_prefix() . 'hospital_wards w', 'w.id = a.ward_id', 'left');
        
        // Only show paid surgeries that are accepted by counselor
        $this->db->where('sr.payment_status', 'paid');
        $this->db->where('sr.counseling_status', 'accepted');
        
        $this->db->order_by('sr.surgery_date', 'ASC');
        $this->db->order_by('sr.requested_at', 'DESC');
        
        return $this->db->get()->result_array();
    }
    
    /**
     * Get non-admitted patients (paid but not yet admitted)
     */
    public function get_non_admitted_patients()
    {
        $patients = $this->get_paid_surgery_requests();
        
        // Filter only non-admitted
        return array_filter($patients, function($patient) {
            return empty($patient['admission_id']) || $patient['admission_status'] === 'scheduled';
        });
    }
    
    /**
     * Get admitted patients (currently admitted)
     */
    public function get_admitted_patients()
    {
        $patients = $this->get_paid_surgery_requests();
        
        // Filter only admitted
        return array_filter($patients, function($patient) {
            return !empty($patient['admission_id']) && $patient['admission_status'] === 'admitted';
        });
    }
    
    // ==========================================
    // WARD MANAGEMENT
    // ==========================================
    
    /**
     * Get all active wards
     */
    public function get_all_wards()
    {
        $this->db->where('is_active', 1);
        $this->db->order_by('ward_type', 'ASC');
        $this->db->order_by('room_number', 'ASC');
        return $this->db->get(db_prefix() . 'hospital_wards')->result_array();
    }
    
    /**
     * Get available wards (with beds available)
     */
    public function get_available_wards()
    {
        $this->db->where('is_active', 1);
        $this->db->where('available_beds >', 0);
        $this->db->order_by('ward_type', 'ASC');
        return $this->db->get(db_prefix() . 'hospital_wards')->result_array();
    }
    
    // ==========================================
    // ADMISSION MANAGEMENT
    // ==========================================
    
    /**
     * Get admission details by surgery request ID
     */
    public function get_admission($surgery_request_id)
    {
        $this->db->select('
            a.*,
            sr.patient_id,
            sr.surgery_date,
            sr.op_number,
            sr.room_type as requested_room_type,
            p.patient_number,
            p.name as patient_name,
            p.mobile_number,
            p.age,
            p.gender,
            st.surgery_name,
            consultant.firstname as consultant_firstname,
            consultant.lastname as consultant_lastname,
            w.ward_name,
            w.ward_type,
            w.room_number,
            w.floor_number
        ');
        
        $this->db->from(db_prefix() . 'hospital_surgery_admissions a');
        $this->db->join(db_prefix() . 'hospital_surgery_requests sr', 'sr.id = a.surgery_request_id', 'left');
        $this->db->join(db_prefix() . 'hospital_patients p', 'p.id = sr.patient_id', 'left');
        $this->db->join(db_prefix() . 'hospital_surgery_types st', 'st.id = sr.surgery_type_id', 'left');
        $this->db->join(db_prefix() . 'staff consultant', 'consultant.staffid = sr.assigned_consultant_id', 'left');
        $this->db->join(db_prefix() . 'hospital_wards w', 'w.id = a.ward_id', 'left');
        $this->db->where('a.surgery_request_id', $surgery_request_id);
        
        return $this->db->get()->row_array();
    }
    
    /**
     * Create or update admission
     */
    public function save_admission($surgery_request_id, $data)
    {
        // Check if admission exists
        $this->db->select('id');
        $this->db->where('surgery_request_id', $surgery_request_id);
        $existing = $this->db->get(db_prefix() . 'hospital_surgery_admissions')->row();
        
        // Get patient_id from surgery request
        $this->db->select('patient_id');
        $this->db->where('id', $surgery_request_id);
        $surgery = $this->db->get(db_prefix() . 'hospital_surgery_requests')->row();
        
        if (!$surgery) {
            return ['success' => false, 'message' => 'Surgery request not found'];
        }
        
        $admission_data = [
            'surgery_request_id' => $surgery_request_id,
            'patient_id' => $surgery->patient_id,
            'ward_id' => $data['ward_id'],
            'admission_date' => $data['admission_date'],
            'admission_time' => $data['admission_time'] ?? date('H:i:s'),
            'admission_status' => 'admitted',
            'admission_notes' => $data['admission_notes'] ?? null,
            'admitted_by' => get_staff_user_id(),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        if ($existing) {
            // Update existing admission
            $this->db->where('id', $existing->id);
            $this->db->update(db_prefix() . 'hospital_surgery_admissions', $admission_data);
            $admission_id = $existing->id;
            $message = 'Admission updated successfully';
        } else {
            // Create new admission
            $admission_data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert(db_prefix() . 'hospital_surgery_admissions', $admission_data);
            $admission_id = $this->db->insert_id();
            $message = 'Patient admitted successfully';
        }
        
        // Update bed availability
        $this->update_bed_availability($data['ward_id'], 'decrease');
        
        log_activity('Patient admitted - Surgery Request #' . $surgery_request_id);
        
        return [
            'success' => true,
            'message' => $message,
            'admission_id' => $admission_id
        ];
    }
    
    /**
     * Discharge patient
     */
    public function discharge_patient($surgery_request_id, $data)
    {
        $this->db->select('id, ward_id, admission_status');
        $this->db->where('surgery_request_id', $surgery_request_id);
        $admission = $this->db->get(db_prefix() . 'hospital_surgery_admissions')->row();
        
        if (!$admission) {
            return ['success' => false, 'message' => 'Admission record not found'];
        }
        
        if ($admission->admission_status === 'discharged') {
            return ['success' => false, 'message' => 'Patient already discharged'];
        }
        
        $discharge_data = [
            'actual_discharge_date' => $data['discharge_date'],
            'discharge_time' => $data['discharge_time'] ?? date('H:i:s'),
            'admission_status' => 'discharged',
            'admission_notes' => $data['discharge_notes'] ?? null,
            'discharged_by' => get_staff_user_id(),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Calculate total days
        $this->db->select('admission_date');
        $this->db->where('id', $admission->id);
        $admission_record = $this->db->get(db_prefix() . 'hospital_surgery_admissions')->row();
        
        if ($admission_record) {
            $admission_date = new DateTime($admission_record->admission_date);
            $discharge_date = new DateTime($data['discharge_date']);
            $days = $discharge_date->diff($admission_date)->days;
            $discharge_data['total_days'] = $days > 0 ? $days : 1;
        }
        
        $this->db->where('id', $admission->id);
        $this->db->update(db_prefix() . 'hospital_surgery_admissions', $discharge_data);
        
        // Update bed availability
        $this->update_bed_availability($admission->ward_id, 'increase');
        
        log_activity('Patient discharged - Surgery Request #' . $surgery_request_id);
        
        return ['success' => true, 'message' => 'Patient discharged successfully'];
    }
    
    /**
     * Update bed availability
     */
    private function update_bed_availability($ward_id, $action = 'decrease')
    {
        if ($action === 'decrease') {
            $this->db->set('available_beds', 'available_beds - 1', FALSE);
        } else {
            $this->db->set('available_beds', 'available_beds + 1', FALSE);
        }
        
        $this->db->where('id', $ward_id);
        $this->db->update(db_prefix() . 'hospital_wards');
    }
}