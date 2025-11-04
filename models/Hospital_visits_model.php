<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hospital_visits_model extends App_Model
{
    private $table;
    private $details_table;
    
    public function __construct()
    {
        parent::__construct();
        $this->table = db_prefix() . 'hospital_visits';
        $this->details_table = db_prefix() . 'hospital_visit_details';
    }
    
    /**
     * Generate unique visit number
     */
    private function generate_visit_number()
    {
        $prefix = 'VIS';
        $year = date('Y');
        
        $this->db->select('visit_number');
        $this->db->like('visit_number', $prefix . $year, 'after');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $last = $this->db->get($this->table)->row();
        
        if ($last) {
            $last_number = (int) substr($last->visit_number, -4);
            $new_number = $last_number + 1;
        } else {
            $new_number = 1;
        }
        
        return $prefix . $year . str_pad($new_number, 4, '0', STR_PAD_LEFT);
    }
    
    /**
     * Save visit with details
     */
    public function save($visit_data, $visit_details_data = [])
    {
        $id = isset($visit_data['id']) && !empty($visit_data['id']) ? $visit_data['id'] : null;
        
        // Prepare main visit data
        $save_data = [
            'patient_id'      => $visit_data['patient_id'],
            'appointment_id'  => isset($visit_data['appointment_id']) ? $visit_data['appointment_id'] : null,
            'consultant_id'   => $visit_data['consultant_id'],
            'visit_date'      => $visit_data['visit_date'],
            'visit_time'      => $visit_data['visit_time'],
            'visit_type'      => $visit_data['visit_type'],
            'reason'          => $visit_data['reason'],
            'status'          => isset($visit_data['status']) ? $visit_data['status'] : 'ongoing',
            'chief_complaint' => isset($visit_data['chief_complaint']) ? $visit_data['chief_complaint'] : null,
            'diagnosis'       => isset($visit_data['diagnosis']) ? $visit_data['diagnosis'] : null,
            'treatment_given' => isset($visit_data['treatment_given']) ? $visit_data['treatment_given'] : null,
            'prescription'    => isset($visit_data['prescription']) ? $visit_data['prescription'] : null,
            'notes'           => isset($visit_data['notes']) ? $visit_data['notes'] : null,
        ];
        
        if ($id) {
            // UPDATE VISIT
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            $this->db->where('id', $id);
            $this->db->update($this->table, $save_data);
            
            // Update visit details if provided
            if (!empty($visit_details_data)) {
                $this->db->where('visit_id', $id);
                $existing_details = $this->db->get($this->details_table)->row();
                
                if ($existing_details) {
                    $visit_details_data['updated_at'] = date('Y-m-d H:i:s');
                    $this->db->where('visit_id', $id);
                    $this->db->update($this->details_table, $visit_details_data);
                } else {
                    $visit_details_data['visit_id'] = $id;
                    $this->db->insert($this->details_table, $visit_details_data);
                }
            }
            
            log_activity('Hospital Visit Updated [ID: ' . $id . ']');
            return ['success' => true, 'message' => 'Visit updated successfully', 'id' => $id];
            
        } else {
            // CREATE NEW VISIT
            $save_data['visit_number'] = $this->generate_visit_number();
            $save_data['created_by'] = get_staff_user_id();
            $save_data['created_at'] = date('Y-m-d H:i:s');
            
            $this->db->insert($this->table, $save_data);
            $visit_id = $this->db->insert_id();
            
            if (!$visit_id) {
                log_activity('Failed to insert visit: ' . json_encode($this->db->error()));
                return ['success' => false, 'message' => 'Failed to create visit'];
            }
            
            // Create visit details if provided
            if (!empty($visit_details_data)) {
                $visit_details_data['visit_id'] = $visit_id;
                $visit_details_data['created_at'] = date('Y-m-d H:i:s');
                
                $this->db->insert($this->details_table, $visit_details_data);
                
                if (!$this->db->insert_id()) {
                    log_activity('Failed to insert visit details: ' . json_encode($this->db->error()));
                    // Don't fail the whole operation, just log it
                }
            }
            
            log_activity('Hospital Visit Created [Number: ' . $save_data['visit_number'] . ']');
            return ['success' => true, 'message' => 'Visit created successfully', 'id' => $visit_id];
        }
    }
    
    /**
     * Get visit by ID with details
     */
    public function get($id)
    {
        $this->db->select($this->table . '.*, ' . $this->details_table . '.*');
        $this->db->from($this->table);
        $this->db->join($this->details_table, $this->details_table . '.visit_id = ' . $this->table . '.id', 'left');
        $this->db->where($this->table . '.id', $id);
        return $this->db->get()->row();
    }
    
    /**
     * Get all visits
     */
    public function get_all()
    {
        $this->db->select(
            $this->table . '.*, ' . 
            db_prefix() . 'hospital_patients.name as patient_name, ' .
            db_prefix() . 'hospital_patients.patient_number as patient_number, ' .
            db_prefix() . 'staff.firstname as consultant_firstname, ' .
            db_prefix() . 'staff.lastname as consultant_lastname'
        );
        
        $this->db->from($this->table);
        
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
        
        $this->db->order_by($this->table . '.visit_date', 'DESC');
        $this->db->order_by($this->table . '.visit_time', 'DESC');
        
        return $this->db->get()->result();
    }
    
    /**
     * Get visits by patient ID
     */
    public function get_by_patient($patient_id)
    {
        $this->db->select($this->table . '.*');
        $this->db->where('patient_id', $patient_id);
        $this->db->order_by('visit_date', 'DESC');
        $this->db->order_by('visit_time', 'DESC');
        return $this->db->get($this->table)->result();
    }
    
    /**
     * Complete visit
     */
    public function complete($id)
    {
        $update_data = [
            'status' => 'completed',
            'completed_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id', $id);
        $this->db->update($this->table, $update_data);
        
        log_activity('Hospital Visit Completed [ID: ' . $id . ']');
        return ['success' => true, 'message' => 'Visit marked as completed'];
    }
    
    /**
     * Cancel visit
     */
    public function cancel($id)
    {
        $update_data = [
            'status' => 'cancelled',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id', $id);
        $this->db->update($this->table, $update_data);
        
        log_activity('Hospital Visit Cancelled [ID: ' . $id . ']');
        return ['success' => true, 'message' => 'Visit cancelled'];
    }
    
    /**
     * Delete visit
     */
    public function delete($id)
    {
        // Delete visit details first (due to FK constraint)
        $this->db->where('visit_id', $id);
        $this->db->delete($this->details_table);
        
        // Delete visit
        $this->db->where('id', $id);
        $this->db->delete($this->table);
        
        log_activity('Hospital Visit Deleted [ID: ' . $id . ']');
        return ['success' => true, 'message' => 'Visit deleted successfully'];
    }
}