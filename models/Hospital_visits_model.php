<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Hospital_visits_model extends App_Model
{
    private $visits_table;
    private $details_table;
    
    public function __construct()
    {
        parent::__construct();
        $this->visits_table = db_prefix() . 'hospital_visits';
        $this->details_table = db_prefix() . 'hospital_visit_details';
    }
    
    private function generate_visit_number()
    {
        $prefix = 'VIS';
        $year = date('Y');
        
        $this->db->select('visit_number');
        $this->db->like('visit_number', $prefix . $year, 'after');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $last = $this->db->get($this->visits_table)->row();
        
        if ($last) {
            $last_number = (int) substr($last->visit_number, -4);
            $new_number = $last_number + 1;
        } else {
            $new_number = 1;
        }
        
        return $prefix . $year . str_pad($new_number, 4, '0', STR_PAD_LEFT);
    }
    
    public function get($id)
    {
        $this->db->select(
            $this->visits_table . '.*, ' .
            db_prefix() . 'hospital_patients.name as patient_name, ' .
            db_prefix() . 'hospital_patients.patient_number, ' .
            db_prefix() . 'hospital_patients.mobile_number as patient_mobile, ' .
            db_prefix() . 'staff.firstname as consultant_firstname, ' .
            db_prefix() . 'staff.lastname as consultant_lastname'
        );
        
        $this->db->from($this->visits_table);
        $this->db->join(db_prefix() . 'hospital_patients', db_prefix() . 'hospital_patients.id = ' . $this->visits_table . '.patient_id', 'left');
        $this->db->join(db_prefix() . 'staff', db_prefix() . 'staff.staffid = ' . $this->visits_table . '.consultant_id', 'left');
        $this->db->where($this->visits_table . '.id', $id);
        
        return $this->db->get()->row();
    }
    
    public function get_visit_details($visit_id)
    {
        $this->db->where('visit_id', $visit_id);
        return $this->db->get($this->details_table)->row();
    }
    
    public function get_all($filters = [])
    {
        $this->db->select(
            $this->visits_table . '.*, ' .
            db_prefix() . 'hospital_patients.name as patient_name, ' .
            db_prefix() . 'hospital_patients.patient_number, ' .
            db_prefix() . 'staff.firstname as consultant_firstname, ' .
            db_prefix() . 'staff.lastname as consultant_lastname'
        );
        
        $this->db->from($this->visits_table);
        $this->db->join(db_prefix() . 'hospital_patients', db_prefix() . 'hospital_patients.id = ' . $this->visits_table . '.patient_id', 'left');
        $this->db->join(db_prefix() . 'staff', db_prefix() . 'staff.staffid = ' . $this->visits_table . '.consultant_id', 'left');
        
        if (!empty($filters['consultant_id'])) {
            $this->db->where($this->visits_table . '.consultant_id', $filters['consultant_id']);
        }
        if (!empty($filters['status'])) {
            $this->db->where($this->visits_table . '.status', $filters['status']);
        }
        
        $this->db->order_by($this->visits_table . '.visit_date', 'DESC');
        $this->db->order_by($this->visits_table . '.visit_time', 'DESC');
        
        return $this->db->get()->result();
    }
    
    public function save($data, $details_data = [])
    {
        $id = isset($data['id']) ? $data['id'] : null;
        
        $save_data = [
            'patient_id' => $data['patient_id'],
            'appointment_id' => !empty($data['appointment_id']) ? $data['appointment_id'] : null,
            'consultant_id' => $data['consultant_id'],
            'visit_date' => $data['visit_date'],
            'visit_time' => $data['visit_time'],
            'visit_type' => $data['visit_type'],
            'reason' => $data['reason'],
            'chief_complaint' => !empty($data['chief_complaint']) ? $data['chief_complaint'] : null,
            'diagnosis' => !empty($data['diagnosis']) ? $data['diagnosis'] : null,
            'treatment_given' => !empty($data['treatment_given']) ? $data['treatment_given'] : null,
            'prescription' => !empty($data['prescription']) ? $data['prescription'] : null,
            'notes' => !empty($data['notes']) ? $data['notes'] : null,
            'status' => isset($data['status']) ? $data['status'] : 'ongoing',
        ];
        
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update($this->visits_table, $save_data);
            
            if (!empty($details_data)) {
                $this->save_details($id, $details_data);
            }
            
            return ['success' => true, 'message' => 'Visit updated successfully', 'id' => $id];
        } else {
            $save_data['visit_number'] = $this->generate_visit_number();
            $save_data['created_by'] = get_staff_user_id();
            
            $this->db->insert($this->visits_table, $save_data);
            $insert_id = $this->db->insert_id();
            
            if (!empty($details_data)) {
                $this->save_details($insert_id, $details_data);
            }
            
            return ['success' => true, 'message' => 'Visit created successfully', 'id' => $insert_id];
        }
    }
    
    public function save_details($visit_id, $data)
    {
        $this->db->where('visit_id', $visit_id);
        $existing = $this->db->get($this->details_table)->row();
        
        $details_data = [
            'visit_id' => $visit_id,
            'patient_type_for_visit' => !empty($data['patient_type_for_visit']) ? $data['patient_type_for_visit'] : null,
            'fee_payment_status' => !empty($data['fee_payment_status']) ? $data['fee_payment_status'] : 'pending',
            'fee_amount' => !empty($data['fee_amount']) ? $data['fee_amount'] : null,
            'payment_method' => !empty($data['payment_method']) ? $data['payment_method'] : null,
            'referred_by' => !empty($data['referred_by']) ? $data['referred_by'] : null,
            'symptoms' => !empty($data['symptoms']) ? $data['symptoms'] : null,
            'temperature' => !empty($data['temperature']) ? $data['temperature'] : null,
            'blood_pressure' => !empty($data['blood_pressure']) ? $data['blood_pressure'] : null,
            'pulse_rate' => !empty($data['pulse_rate']) ? $data['pulse_rate'] : null,
            'weight' => !empty($data['weight']) ? $data['weight'] : null,
            'follow_up_required' => !empty($data['follow_up_required']) ? 1 : 0,
            'follow_up_date' => !empty($data['follow_up_date']) ? $data['follow_up_date'] : null,
        ];
        
        if ($existing) {
            $this->db->where('visit_id', $visit_id);
            $this->db->update($this->details_table, $details_data);
        } else {
            $this->db->insert($this->details_table, $details_data);
        }
        
        return true;
    }
    
    public function complete_visit($id)
    {
        $this->db->where('id', $id);
        $this->db->update($this->visits_table, [
            'status' => 'completed',
            'completed_at' => date('Y-m-d H:i:s')
        ]);
        
        return ['success' => true, 'message' => 'Visit marked as completed'];
    }
}