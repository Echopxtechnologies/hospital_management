<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Hospital Management Controller
 * 
 * Handles all hospital management operations including:
 * - User & Role Management
 * - Patient Records
 * - Appointments
 * - Consultant Portal
 * - Visit Records
 * 
 * @package Hospital_Management
 * @version 2.0
 */
class Hospital_management extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        
        // Load required models
        $this->load->model([
            'hospital_users_model',
            'hospital_patients_model',
            'hospital_appointments_model',
            'hospital_visits_model',
            'consultant_portal_model'
        ]);
    }

    // ==========================================
    // DASHBOARD & MAIN VIEWS
    // ==========================================

    /**
     * Main Dashboard
     */
    public function index()
    {
        redirect(admin_url('hospital_management/users'));
    }

 

    // ==========================================
    // USER MANAGEMENT
    // ==========================================

    /**
     * List all users
     */
    public function users()
    {
        $this->check_permission('hospital_users', 'view');
        
        $data['title'] = 'Hospital Users Management';
        $data['users'] = $this->hospital_users_model->get_all_users();
        
        $this->load->view('users', $data);
    }

    /**
     * Create or Edit user form
     */
    public function manage_user($id = null)
    {
        // Permission check
        if ($id) {
            $this->check_permission('hospital_users', 'edit');
            $data['user'] = $this->hospital_users_model->get($id);
            if (!$data['user']) {
                show_404();
            }
            $data['title'] = 'Edit User';
        } else {
            $this->check_permission('hospital_users', 'create');
            $data['title'] = 'Create New User';
        }
        
        $data['roles'] = $this->hospital_users_model->get_allowed_roles();
        $this->load->view('manage_user', $data);
    }

    /**
     * View user details
     */
    public function view($id)
    {
        $this->check_permission('hospital_users', 'view');
        
        $data['user'] = $this->hospital_users_model->get($id);
        if (!$data['user']) {
            show_404();
        }
        
        $data['title'] = 'User Details';
        $this->load->view('view_user', $data);
    }

    /**
     * Save user (AJAX)
     */
    public function save()
    {
        $this->ajax_only();
        
        $id = $this->input->post('id');
        $this->check_permission('hospital_users', $id ? 'edit' : 'create');
        
        // Prevent Admin role manipulation
        $role_id = $this->input->post('role_id');
        if ($role_id == 6) {
            return $this->json_response(false, 'Cannot create or modify Admin role users');
        }
        
        $result = $this->hospital_users_model->save($this->input->post());
        return $this->json_response($result['success'], $result['message']);
    }

    /**
     * Delete user (AJAX)
     */
    public function delete($id)
    {
        $this->ajax_only();
        $this->check_permission('hospital_users', 'delete');
        
        // Prevent Admin role deletion
        $user = $this->hospital_users_model->get($id);
        if ($user && $user->role_id == 6) {
            return $this->json_response(false, 'Cannot delete Admin role users');
        }
        
        $result = $this->hospital_users_model->delete($id);
        return $this->json_response($result['success'], $result['message']);
    }

    /**
     * Check email availability (AJAX)
     */
    public function check_email()
    {
        $this->ajax_only();
        
        $email = $this->input->post('email');
        $user_id = $this->input->post('user_id');
        
        $exists = $this->hospital_users_model->email_exists($email, $user_id);
        return $this->json_response(true, '', ['available' => !$exists]);
    }

    // ==========================================
    // ROLE MANAGEMENT
    // ==========================================

    /**
     * List all roles
     */
    public function roles()
    {
        $this->check_permission('hospital_users', 'view');
        
        $this->load->model('roles_model');
        $all_roles = $this->roles_model->get();
        
        // Add user count to each role
        $roles_with_count = [];
        foreach ($all_roles as $role) {
            $this->db->where('role_id', $role['roleid']);
            $this->db->where('active', 1);
            $role['total_users'] = $this->db->count_all_results(db_prefix() . 'hospital_users');
            
            // Get assigned users for this role
            $this->db->select('id, first_name, last_name');
            $this->db->where('role_id', $role['roleid']);
            $this->db->where('active', 1);
            $role['users'] = $this->db->get(db_prefix() . 'hospital_users')->result_array();
            
            $roles_with_count[] = $role;
        }
        
        $data['title'] = 'Role Management';
        $data['roles'] = $roles_with_count;
        $this->load->view('roles', $data);
    }

    /**
     * Create new role (AJAX)
     */
    public function create_role()
    {
        $this->ajax_only();
        $this->check_permission('hospital_users', 'create');
        
        $role_name = trim($this->input->post('role_name'));
        
        if (strtolower($role_name) === 'admin') {
            return $this->json_response(false, 'Cannot create Admin role');
        }
        
        if (empty($role_name)) {
            return $this->json_response(false, 'Role name is required');
        }
        
        $result = $this->hospital_users_model->create_role($role_name);
        return $this->json_response($result['success'], $result['message']);
    }

    /**
     * Delete role (AJAX)
     */
    public function delete_role($role_id)
    {
        $this->ajax_only();
        $this->check_permission('hospital_users', 'delete');
        
        // Prevent Admin role deletion
        if ($role_id == 1) {
            return $this->json_response(false, 'Cannot delete Admin role');
        }
        
        // Check if role has users
        $this->db->where('role_id', $role_id);
        $this->db->where('active', 1);
        $user_count = $this->db->count_all_results(db_prefix() . 'hospital_users');
        
        if ($user_count > 0) {
            return $this->json_response(false, 'Cannot delete role with assigned users. Please reassign users first.');
        }
        
        // Delete role
        $this->load->model('roles_model');
        $deleted = $this->roles_model->delete($role_id);
        
        if ($deleted) {
            log_activity('Hospital Role Deleted [ID: ' . $role_id . ']');
            return $this->json_response(true, 'Role deleted successfully');
        }
        
        return $this->json_response(false, 'Failed to delete role');
    }

    /**
     * Get roles (AJAX)
     */
    public function get_roles()
    {
        $this->ajax_only();
        $this->check_permission('hospital_users', 'view');
        
        $roles = $this->hospital_users_model->get_roles_with_count();
        return $this->json_response(true, '', $roles);
    }

    /**
     * Get role permissions (AJAX)
     */
    public function get_role_permissions($role_id)
    {
        $this->ajax_only();
        $this->check_permission('hospital_users', 'view');
        
        $permissions = $this->hospital_users_model->get_role_permissions($role_id);
        return $this->json_response(true, '', ['permissions' => $permissions]);
    }

    /**
     * Update role permissions (AJAX)
     */
    public function update_role_permissions()
    {
        $this->ajax_only();
        $this->check_permission('hospital_users', 'edit');
        
        $role_id = $this->input->post('role_id');
        $permissions = $this->input->post('permissions');
        
        // Prevent Admin role modification
        if ($role_id == 6) {
            return $this->json_response(false, 'Cannot modify Admin role permissions');
        }
        
        $result = $this->hospital_users_model->update_role_permissions($role_id, $permissions);
        return $this->json_response($result['success'], $result['message']);
    }

    // ==========================================
    // PATIENT MANAGEMENT
    // ==========================================

    /**
     * List all patients
     */
    public function patient_records()
    {
        $this->check_receptionist_access('reception_management', 'view');
        
        $data['patients'] = $this->hospital_patients_model->get_all();
        $data['statistics'] = [
            'total_patients' => $this->hospital_patients_model->get_total_count(),
            'active_patients' => $this->hospital_patients_model->get_active_count(),
            'today_registrations' => $this->hospital_patients_model->get_today_registrations_count()
        ];
        
        $data['title'] = 'Patient Records';
        $this->load->view('patient_records', $data);
    }

    /**
     * Manage patient form (Edit)
     */
    public function manage_patient($id = null)
    {
        if (!$id) {
            redirect(admin_url('hospital_management/patient_records'));
        }
        
        $this->check_receptionist_access('reception_management', 'view');
        
        $data['patient'] = $this->hospital_patients_model->get($id);
        if (!$data['patient']) {
            show_404();
        }
        
        $data['patient_types'] = $this->hospital_patients_model->get_patient_types();
        $data['title'] = 'Update Patient Information';
        
        $this->load->view('manage_patient', $data);
    }

    /**
     * View patient details
     */
    public function view_patient($id)
    {
        $this->check_receptionist_access('reception_management', 'view');
        
        $data['patient'] = $this->hospital_patients_model->get($id);
        if (!$data['patient']) {
            show_404();
        }
        
        $data['title'] = 'Patient Details - ' . $data['patient']->name;
        $this->load->view('view_patient', $data);
    }

    /**
     * Save patient (POST)
     */
    public function save_patient()
    {
        $this->check_permission('hospital_management', 'create');
        
        // Collect all form fields
        $patient_data = [
            'id' => $this->input->post('id'),
            
            // Basic Info
            'name' => $this->input->post('name'),
            'gender' => $this->input->post('gender'),
            'dob' => $this->input->post('dob'),
            'age' => $this->input->post('age'),
            'blood_group' => $this->input->post('blood_group'),
            'patient_type' => $this->input->post('patient_type'),
            
            // Contact Info
            'mobile_number' => $this->input->post('mobile_number'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            
            // Address Info
            'address' => $this->input->post('address'),
            'address_landmark' => $this->input->post('address_landmark'),
            'city' => $this->input->post('city'),
            'state' => $this->input->post('state'),
            'pincode' => $this->input->post('pincode'),
            
            // Other Hospital
            'registered_other_hospital' => $this->input->post('registered_other_hospital') ? 1 : 0,
            'other_hospital_patient_id' => $this->input->post('other_hospital_patient_id'),
            
            // Fee Payment
            'fee_payment' => $this->input->post('fee_payment'),
            
            // Recommendation
            'recommended_to_hospital' => $this->input->post('recommended_to_hospital') ? 1 : 0,
            'recommended_by' => $this->input->post('recommended_by'),
            
            // Membership
            'membership_id' => $this->input->post('membership_id') ?: null,
        ];
        
        // Handle file upload
        $files = [];
        if (!empty($_FILES['document_file']['name'])) {
            $files['document'] = [
                'file' => $_FILES['document_file'],
                'type' => $this->input->post('document_type')
            ];
        }
        
        // Save patient
        $result = $this->hospital_patients_model->save($patient_data, $files);
        
        if ($result['success']) {
            set_alert('success', $result['message']);
            redirect(admin_url('hospital_management/view_patient/' . $result['id']));
        } else {
            set_alert('danger', $result['message']);
            redirect(admin_url('hospital_management/manage_patient' . (isset($patient_data['id']) ? '/' . $patient_data['id'] : '')));
        }
    }

    /**
     * Delete patient (AJAX POST)
     */
    public function delete_patient($id)
    {
        $this->ajax_only();
        $this->check_permission('hospital_patients', 'delete');
        
        $result = $this->hospital_patients_model->delete($id);
        return $this->json_response($result['success'], $result['message']);
    }

    /**
     * Get patient details (AJAX)
     */
    public function get_patient_details($patient_id)
    {
        $this->ajax_only();
        $this->check_receptionist_access('reception_management', 'view');
        
        $patient = $this->hospital_patients_model->get($patient_id);
        $documents = $this->hospital_patients_model->get_patient_documents($patient_id);
        
        if ($patient) {
            return $this->json_response(true, '', [
                'patient' => $patient,
                'documents' => $documents
            ]);
        }
        
        return $this->json_response(false, 'Patient not found');
    }

    /**
     * Download patient document
     */
    public function download_document($document_id = null)
    {
        $document_id = intval($document_id);
        
        if ($document_id <= 0) {
            show_404();
        }
        
        $document = $this->hospital_patients_model->get_document_file($document_id);
        
        if (!$document) {
            show_404();
        }
        
        $this->load->helper('download');
        force_download($document->original_filename, $document->file_data);
    }

    /**
     * Delete patient document (AJAX)
     */
    public function delete_document($document_id)
    {
        $this->ajax_only();
        $this->check_receptionist_access('reception_management', 'delete');
        
        $result = $this->hospital_patients_model->delete_document($document_id);
        return $this->json_response($result['success'], $result['message']);
    }

    // ==========================================
    // APPOINTMENTS MANAGEMENT
    // ==========================================

    /**
     * List all appointments
     */
    public function appointments()
    {
        $this->check_receptionist_access('reception_management', 'view');
        
        $data['title'] = 'Appointments Management';
        $data['appointments'] = $this->hospital_appointments_model->get_all();
        $data['statistics'] = $this->hospital_appointments_model->get_statistics();
        $data['consultants'] = $this->hospital_appointments_model->get_consultants();
        $data['patient_types'] = $this->hospital_patients_model->get_patient_types();
        $data['patients'] = $this->hospital_appointments_model->get_patients_for_dropdown();
        
        $this->load->view('appointments', $data);
    }

    /**
     * Save appointment (AJAX)
     */
    public function save_appointment()
    {
        $this->ajax_only();
        
        try {
            $post = $this->input->post();
            
            // Build appointment data array
            $appointment_data = [
                'patient_id'             => $post['patient_id'] ?? '',
                'is_new_patient'         => $post['is_new_patient'] ?? 0,
                'patient_mode'           => $post['patient_mode'] ?? 'appointment',
                'appointment_date'       => $post['appointment_date'] ?? '',
                'appointment_time'       => $post['appointment_time'] ?? '',
                'reason_for_appointment' => !empty($post['reason_for_appointment']) ? $post['reason_for_appointment'] : '',
                'consultant_id'          => $post['consultant_id'] ?? '',
                'notes'                  => $post['notes'] ?? '',
                'status'                 => $post['status'] ?? 'pending',
                
                // Visit details
                'symptoms'               => $post['symptoms'] ?? null,
                'visit_referred_by'      => $post['visit_referred_by'] ?? null,
                'temperature'            => $post['temperature'] ?? null,
                'blood_pressure'         => $post['blood_pressure'] ?? null,
                'pulse_rate'             => $post['pulse_rate'] ?? null,
                'weight'                 => $post['weight'] ?? null,
                
                // Fee payment
                'fee_payment'            => $post['fee_payment'] ?? 'not_applicable',
                'fee_payment_status'     => $post['fee_payment_status'] ?? 'pending',
                'fee_amount'             => $post['fee_amount'] ?? null,
                'payment_method'         => $post['payment_method'] ?? null,
                'follow_up_required'     => isset($post['follow_up_required']) ? 1 : 0,
                'follow_up_date'         => $post['follow_up_date'] ?? null,
            ];

            // Build patient data (only for new patients)
            $patient_data = [];
            
            if (isset($post['is_new_patient']) && $post['is_new_patient'] == 1) {
                if (!empty($post['name']) || !empty($post['mobile_number'])) {
                    $patient_data = [
                        // Basic Info
                        'name'                      => $post['name'] ?? '',
                        'gender'                    => $post['gender'] ?? '',
                        'age'                       => $post['age'] ?? null,
                        'dob'                       => $post['dob'] ?? null,
                        'patient_type'              => $post['patient_type'] ?? 'Regular',
                        
                        // Contact
                        'mobile_number'             => $post['mobile_number'] ?? '',
                        'phone'                     => $post['phone'] ?? null,
                        'email'                     => $post['email'] ?? null,
                        
                        // Address
                        'address'                   => $post['address'] ?? null,
                        'address_landmark'          => $post['address_landmark'] ?? null,
                        'city'                      => $post['city'] ?? null,
                        'state'                     => $post['state'] ?? null,
                        'pincode'                   => $post['pincode'] ?? null,
                        
                        // Other Hospital Registration
                        'registered_other_hospital' => $post['registered_other_hospital'] ?? 0,
                        'other_hospital_patient_id' => $post['other_hospital_patient_id'] ?? null,
                        
                        // Membership
                       'membership_id' => !empty($post['membership_id']) ? trim($post['membership_id']) : null,
                        
                        // Recommendation
                        'recommended_to_hospital'   => $post['recommended_to_hospital'] ?? 0,
                        'recommended_by'            => $post['recommended_by'] ?? null,
                    ];
                }
            }

            // Handle file uploads
            $files = [];
            if (!empty($_FILES['recommendation_file']['name'][0])) {
                $files['recommendation_file'] = $_FILES['recommendation_file'];
            }

            // Call model
            $result = $this->hospital_appointments_model->save($appointment_data, $patient_data, $files);

            // Return JSON response
            return $this->json_response(
                $result['success'],
                $result['message'],
                [
                    'id' => $result['id'] ?? null,
                    'appointment_number' => $result['appointment_number'] ?? null,
                ],
                true // Include CSRF tokens
            );
            
        } catch (Exception $e) {
            log_activity('Appointment Save Error: ' . $e->getMessage());
            return $this->json_response(false, 'Error: ' . $e->getMessage(), [], true);
        }
    }

/**
     * Get patients for dropdown (AJAX)
     */
    public function get_patients_dropdown()
    {
        // REMOVED strict permission check - allow all logged in users
        
        $search = $this->input->get('search', true);
        $patients = $this->hospital_appointments_model->get_patients_for_dropdown($search);
        
        // Return simple JSON without helper
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'patients' => $patients
        ]);
    }

    /**
     * Confirm appointment (AJAX)
     */
    public function confirm_appointment($id)
    {
        $this->ajax_only();
        
        $result = $this->hospital_appointments_model->confirm($id);
        return $this->json_response($result['success'], $result['message']);
    }

    /**
     * Cancel appointment (AJAX)
     */
    public function cancel_appointment()
    {
        $this->ajax_only();
        
        $id = $this->input->post('id');
        $reason = $this->input->post('reason');
        
        $result = $this->hospital_appointments_model->cancel($id, $reason);
        return $this->json_response($result['success'], $result['message']);
    }

    /**
     * Delete appointment (AJAX)
     */
    public function delete_appointment($id)
    {
        $this->ajax_only();
        
        $result = $this->hospital_appointments_model->delete($id);
        return $this->json_response($result['success'], $result['message']);
    }

    // ==========================================
    // CONSULTANT PORTAL
    // ==========================================

    /**
     * Consultant appointments list
     */
    public function consultant_appointments()
    {
        $this->check_consultant_access('consultant_portal', 'view');
        
        $staff_id = get_staff_user_id();
        $is_jc = $this->is_jc_or_admin();
        
        $data['appointments'] = $this->consultant_portal_model->get_appointments($staff_id, $is_jc);
        $data['statistics'] = $this->consultant_portal_model->get_statistics($staff_id, $is_jc);
        $data['title'] = 'My Appointments';
        $data['is_jc'] = $is_jc;
        
        $this->load->view('consultant_appointments', $data);
    }

    /**
     * Get consultant appointments (AJAX)
     */
    public function get_consultant_appointments()
    {
        $this->ajax_only();
        $this->check_consultant_access('consultant_portal', 'view');
        
        $staff_id = get_staff_user_id();
        $is_jc = $this->is_jc_or_admin();
        
        $appointments = $this->consultant_portal_model->get_appointments($staff_id, $is_jc);
        return $this->json_response(true, '', ['data' => $appointments]);
    }

    /**
     * Get appointment details (AJAX)
     */
    public function get_appointment_details($id)
    {
        $this->ajax_only();
        $this->check_consultant_access('consultant_portal', 'view');
        
        $appointment = $this->consultant_portal_model->get($id);
        
        if (!$appointment) {
            return $this->json_response(false, 'Appointment not found');
        }
        
        // Check access for regular consultants
        if (is_consultant() && !is_junior_consultant() && !has_permission('consultant_portal', '', 'view')) {
            if (!$this->consultant_portal_model->can_access($id, get_staff_user_id())) {
                return $this->json_response(false, 'Access denied to this appointment');
            }
        }
        
        return $this->json_response(true, '', ['data' => $appointment]);
    }

    /**
     * Confirm consultant appointment (AJAX)
     */
    public function confirm_consultant_appointment($id)
    {
        $this->ajax_only();
        $this->check_consultant_access('consultant_portal', 'view');
        
        // Verify ownership for regular consultants
        if (is_consultant() && !is_junior_consultant() && !has_permission('consultant_portal', '', 'view')) {
            if (!$this->consultant_portal_model->can_access($id, get_staff_user_id())) {
                return $this->json_response(false, 'You do not have access to this appointment');
            }
        }
        
        $result = $this->hospital_appointments_model->confirm($id);
        return $this->json_response($result['success'], $result['message']);
    }

    /**
     * Reject consultant appointment (AJAX)
     */
    public function reject_consultant_appointment()
    {
        $this->ajax_only();
        $this->check_consultant_access('consultant_portal', 'view');
        
        $id = $this->input->post('id');
        $reason = $this->input->post('reason');
        
        if (empty($id)) {
            return $this->json_response(false, 'Appointment ID is required');
        }
        
        // Verify ownership for regular consultants
        if (is_consultant() && !is_junior_consultant() && !has_permission('consultant_portal', '', 'view')) {
            if (!$this->consultant_portal_model->can_access($id, get_staff_user_id())) {
                return $this->json_response(false, 'You do not have access to this appointment');
            }
        }
        
        $result = $this->hospital_appointments_model->cancel($id, $reason);
        return $this->json_response($result['success'], $result['message']);
    }

    /**
     * Delete consultant appointment (AJAX) - JC and Admin only
     */
    public function delete_consultant_appointment($id)
    {
        $this->ajax_only();
        
        // Check access - Admin OR JC only (regular consultants cannot delete)
        if (!is_junior_consultant() && !has_permission('consultant_portal', '', 'delete')) {
            return $this->json_response(false, 'Only Junior Consultants and Admins can delete appointments');
        }
        
        $result = $this->hospital_appointments_model->delete($id);
        return $this->json_response($result['success'], $result['message']);
    }

    /**
     * Get consultant statistics (AJAX)
     */
    public function get_consultant_statistics()
    {
        $this->ajax_only();
        $this->check_consultant_access('consultant_portal', 'view');
        
        $staff_id = get_staff_user_id();
        $is_jc = $this->is_jc_or_admin();
        
        $stats = $this->consultant_portal_model->get_statistics($staff_id, $is_jc);
        return $this->json_response(true, '', ['data' => $stats]);
    }

    /**
     * Consultant sees patient - consultation interface
     */
    public function consultant_see_patient($appointment_id)
    {
        // Check if user is consultant or JC
        if (!is_consultant() && !is_junior_consultant()) {
            access_denied('Consultant Access Required');
        }
        
        // Get appointment with patient details
        $data['appointment'] = $this->consultant_portal_model->get($appointment_id);
        
        if (!$data['appointment']) {
            set_alert('danger', 'Appointment not found');
            redirect(admin_url('hospital_management/consultant_appointments'));
        }
        
        // Permission check - consultant can only see their own appointments
        if (!is_junior_consultant() && $data['appointment']['consultant_id'] != get_staff_user_id()) {
            access_denied('You can only view your own appointments');
        }
        
        // Get patient details
        $data['patient'] = $this->hospital_patients_model->get($data['appointment']['patient_id']);
        
        // Get visit record for this appointment
        $data['visit'] = $this->consultant_portal_model->get_visit_by_appointment($appointment_id);
        
        // Get previous visits for this patient
        $all_visits = $this->hospital_visits_model->get_by_patient($data['patient']->id);
        
        // Filter out current visit and limit to last 5
        $data['previous_visits'] = [];
        foreach ($all_visits as $visit) {
            if ($visit->appointment_id != $appointment_id) {
                $data['previous_visits'][] = [
                    'visit_date' => $visit->visit_date,
                    'visit_time' => $visit->visit_time,
                    'diagnosis' => $visit->diagnosis,
                    'treatment_given' => $visit->treatment_given,
                ];
            }
            if (count($data['previous_visits']) >= 5) break;
        }
        
        $data['title'] = 'Consultation - ' . $data['patient']->name;
        $this->load->view('consultant_see_patient', $data);
    }

    /**
     * Save consultation data (POST)
     */
    public function save_consultation()
    {
        if (!is_consultant() && !is_junior_consultant()) {
            ajax_access_denied();
        }
        
        $appointment_id = $this->input->post('appointment_id');
        $patient_id = $this->input->post('patient_id');
        $visit_id = $this->input->post('visit_id');
        $action = $this->input->post('action'); // 'save' or 'complete'
        
        // Prepare visit data
        $visit_data = [
            'id' => $visit_id,
            'patient_id' => $patient_id,
            'appointment_id' => $appointment_id,
            'consultant_id' => get_staff_user_id(),
            'visit_date' => date('Y-m-d'),
            'visit_time' => date('H:i:s'),
            'visit_type' => 'consultation',
            'reason' => $this->input->post('chief_complaint'),
            'chief_complaint' => $this->input->post('chief_complaint'),
            'diagnosis' => $this->input->post('diagnosis'),
            'treatment_given' => $this->input->post('treatment_given'),
            'prescription' => $this->input->post('prescription'),
            'notes' => $this->input->post('notes'),
            'status' => $action === 'complete' ? 'completed' : 'ongoing',
        ];
        
        // Prepare visit details data
        $visit_details_data = [
          // Vitals
    'temperature' => $this->input->post('temperature'),
    'blood_pressure' => $this->input->post('blood_pressure'),
    'pulse_rate' => $this->input->post('pulse_rate'),
    'weight' => $this->input->post('weight'),
    'height' => $this->input->post('height'),
    'spo2' => $this->input->post('spo2'),
    
    // Medical Info (map your fields to existing columns)
    'symptoms' => $this->input->post('symptoms'),
    'medical_history' => $this->input->post('examination_notes'), // ✅ Map to existing column
    'allergies' => $this->input->post('allergies'),
    'current_medications' => $this->input->post('current_medications'),
    
    // Tests
    'lab_tests_ordered' => $this->input->post('investigations'), // ✅ Map to existing column
    'lab_results' => $this->input->post('lab_results'),
    'imaging_ordered' => $this->input->post('imaging_ordered'),
    'imaging_results' => $this->input->post('imaging_results'),
    
    // Follow-up
    'follow_up_required' => $this->input->post('follow_up_required') ? 1 : 0,
    'follow_up_date' => $this->input->post('follow_up_date'),
    'follow_up_notes' => $this->input->post('medical_advice'), 
        ];
        
        // Save visit
        $result = $this->hospital_visits_model->save($visit_data, $visit_details_data);
        
        if ($result['success']) {
            // Update appointment status if completed
            if ($action === 'complete') {
                $this->hospital_appointments_model->update($appointment_id, ['status' => 'completed']);
            }
            
            $message = $action === 'complete' ? 'Consultation completed successfully' : 'Consultation saved successfully';
            set_alert('success', $message);
            redirect(admin_url('hospital_management/consultant_appointments'));
        } else {
            set_alert('danger', $result['message']);
            redirect(admin_url('hospital_management/consultant_see_patient/' . $appointment_id));
        }
    }

    /**
     * Auto-save consultation draft (AJAX)
     */
    public function autosave_consultation()
    {
        if (!is_consultant() && !is_junior_consultant()) {
            return $this->json_response(false, 'Access denied');
        }
        
        // Save draft to session
        $draft_data = $this->input->post();
        $this->session->set_userdata('consultation_draft_' . $draft_data['appointment_id'], $draft_data);
        
        return $this->json_response(true, 'Draft saved');
    }

    // ==========================================
    // VISIT MANAGEMENT
    // ==========================================

    /**
     * List all visits
     */
    public function visits()
    {
        $this->check_permission('hospital_management', 'view');
        
        $data['visits'] = $this->hospital_visits_model->get_all();
        $data['title'] = 'Visit Records';
        
        $this->load->view('hospital_management/visits', $data);
    }

    /**
     * Manage visit form (Create/Edit)
     */
    public function manage_visit($id = '')
    {
        $this->check_permission('hospital_management', 'create');
        
        if ($id) {
            $data['visit'] = $this->hospital_visits_model->get($id);
            $data['visit_details'] = $this->hospital_visits_model->get_visit_details($id);
        }
        
        $data['patients'] = $this->hospital_patients_model->get_all();
        $data['consultants'] = $this->hospital_appointments_model->get_consultants();
        $data['title'] = $id ? 'Edit Visit' : 'Create Visit';
        
        $this->load->view('hospital_management/manage_visit', $data);
    }

    /**
     * Save visit (AJAX)
     */
    public function save_visit()
    {
        $this->check_permission('hospital_management', 'create');
        
        $data = $this->input->post();
        $details_data = $this->input->post('details');
        
        $result = $this->hospital_visits_model->save($data, $details_data);
        return $this->json_response($result['success'], $result['message']);
    }

    /**
     * Save visit from consultant portal (AJAX)
     */
    public function consultant_save_visit()
    {
        if (!$this->check_consultant_access()) {
            return $this->json_response(false, 'Access denied');
        }
        
        $visit_id = $this->input->post('visit_id');
        $appointment_id = $this->input->post('appointment_id');
        
        // Prepare visit data
        $visit_data = [
            'id' => $visit_id,
            'patient_id' => $this->input->post('patient_id'),
            'appointment_id' => $appointment_id,
            'consultant_id' => get_staff_user_id(),
            'visit_date' => $this->input->post('visit_date'),
            'visit_time' => $this->input->post('visit_time'),
            'visit_type' => $this->input->post('visit_type'),
            'reason' => $this->input->post('reason'),
            'chief_complaint' => $this->input->post('chief_complaint'),
            'diagnosis' => $this->input->post('diagnosis'),
            'treatment_given' => $this->input->post('treatment_given'),
            'prescription' => $this->input->post('prescription'),
            'notes' => $this->input->post('notes'),
            'status' => $this->input->post('status', 'ongoing')
        ];
        
        // Prepare visit details
        $details_data = [
            'patient_type_for_visit' => $this->input->post('patient_type_for_visit'),
            'fee_payment_status' => $this->input->post('fee_payment_status'),
            'fee_amount' => $this->input->post('fee_amount'),
            'payment_method' => $this->input->post('payment_method'),
            'referred_by' => $this->input->post('referred_by'),
            'symptoms' => $this->input->post('symptoms'),
            'temperature' => $this->input->post('temperature'),
            'blood_pressure' => $this->input->post('blood_pressure'),
            'pulse_rate' => $this->input->post('pulse_rate'),
            'weight' => $this->input->post('weight'),
            'follow_up_required' => $this->input->post('follow_up_required') ? 1 : 0,
            'follow_up_date' => $this->input->post('follow_up_date')
        ];
        
        // Save visit and details
        $result = $this->hospital_visits_model->save($visit_data, $details_data);
        
        // If marking as completed, update appointment status
        if ($this->input->post('status') === 'completed') {
            $this->hospital_appointments_model->confirm($appointment_id);
        }
        
        return $this->json_response($result['success'], $result['message']);
    }

    // ==========================================
    // HELPER METHODS (PRIVATE)
    // ==========================================

    /**
     * Check if request is AJAX only
     */
    private function ajax_only()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
    }

    /**
     * Check permission - throws access_denied if failed
     * 
     * @param string $feature Feature name
     * @param string $capability Capability (view, create, edit, delete)
     */
    private function check_permission($feature, $capability)
    {
        if (!is_hospital_administrator() && !has_permission($feature, '', $capability)) {
            access_denied(ucwords(str_replace('_', ' ', $feature)));
        }
    }

    /**
     * Check receptionist access (receptionist role OR permission)
     * 
     * @param string $feature Feature name
     * @param string $capability Capability
     */
    private function check_receptionist_access($feature, $capability)
    {
        if (!is_receptionist() && !has_permission($feature, '', $capability)) {
            access_denied(ucwords(str_replace('_', ' ', $feature)));
        }
    }

    /**
     * Check consultant access (consultant/JC role OR permission)
     * 
     * @param string $feature Feature name (default: consultant_portal)
     * @param string $capability Capability (default: view)
     * @return bool True if has access
     */
    private function check_consultant_access($feature = 'consultant_portal', $capability = 'view')
    {
        if (!is_consultant_or_jc() && !has_permission($feature, '', $capability)) {
            if ($this->input->is_ajax_request()) {
                return false;
            }
            access_denied(ucwords(str_replace('_', ' ', $feature)));
        }
        return true;
    }

    /**
     * Check if user is JC or Admin
     * 
     * @return bool
     */
    private function is_jc_or_admin()
    {
        // If admin (not consultant/jc), treat as JC (see all)
        if (!is_consultant_or_jc() && has_permission('consultant_portal', '', 'view')) {
            return true;
        }
        
        return is_junior_consultant();
    }

    /**
     * Return JSON response
     * 
     * @param bool $success Success status
     * @param string $message Message
     * @param array $data Additional data
     * @param bool $include_csrf Include CSRF tokens
     */
    private function json_response($success, $message, $data = [], $include_csrf = false)
    {
        $response = [
            'success' => $success,
            'message' => $message,
        ];
        
        // Merge additional data
        if (!empty($data)) {
            $response = array_merge($response, $data);
        }
        
        // Add CSRF tokens if requested
        if ($include_csrf) {
            $response['csrf_token_name'] = $this->security->get_csrf_token_name();
            $response['csrf_token_hash'] = $this->security->get_csrf_hash();
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}