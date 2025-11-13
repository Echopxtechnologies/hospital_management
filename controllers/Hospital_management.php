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
 * Manage patient form (Create/Edit)
 */
public function manage_patient($id = null)
{
    // Permission check
    if ($id) {
        $this->check_receptionist_access('reception_management', 'edit');
        $data['patient'] = $this->hospital_patients_model->get($id);
        
        if (!$data['patient']) {
            show_404();
        }
        
        // Get patient documents if editing
        $data['documents'] = $this->hospital_patients_model->get_patient_documents($id);
        $data['title'] = 'Edit Patient';
    } else {
        $this->check_receptionist_access('reception_management', 'create');
        $data['documents'] = [];
        $data['title'] = 'Add New Patient';
    }
    
    // Get patient types for dropdown
    $data['patient_types'] = $this->hospital_patients_model->get_patient_types();
    
    $this->load->view('manage_patient', $data);
}

/**
 * View patient details with all related data
 */
public function view_patient($id)
{
    $this->check_receptionist_access('reception_management', 'view');
    
    // Get patient basic info
    $data['patient'] = $this->hospital_patients_model->get($id);
    if (!$data['patient']) {
        show_404();
    }
    
    // Get appointments for this patient
    $this->db->select(
        db_prefix() . 'hospital_appointments.*,' .
        db_prefix() . 'staff.firstname as consultant_firstname,' .
        db_prefix() . 'staff.lastname as consultant_lastname'
    );
    $this->db->from(db_prefix() . 'hospital_appointments');
    $this->db->join(db_prefix() . 'staff', db_prefix() . 'staff.staffid = ' . db_prefix() . 'hospital_appointments.consultant_id', 'left');
    $this->db->where(db_prefix() . 'hospital_appointments.patient_id', $id);
    $this->db->order_by(db_prefix() . 'hospital_appointments.appointment_date', 'DESC');
    $data['appointments'] = $this->db->get()->result();
    
    // Get visits for this patient
    $this->db->select(
        db_prefix() . 'hospital_visits.*,' .
        db_prefix() . 'staff.firstname as consultant_firstname,' .
        db_prefix() . 'staff.lastname as consultant_lastname'
    );
    $this->db->from(db_prefix() . 'hospital_visits');
    $this->db->join(db_prefix() . 'staff', db_prefix() . 'staff.staffid = ' . db_prefix() . 'hospital_visits.consultant_id', 'left');
    $this->db->where(db_prefix() . 'hospital_visits.patient_id', $id);
    $this->db->order_by(db_prefix() . 'hospital_visits.visit_date', 'DESC');
    $data['visits'] = $this->db->get()->result();
    
    // Get documents for this patient - USE result_array() because model returns array
    $data['documents'] = $this->hospital_patients_model->get_patient_documents($id);
    
    $data['title'] = 'Patient Details - ' . $data['patient']->name;
    $this->load->view('view_patient', $data);
}

/**
 * Save patient (Create/Update)
 */
public function save_patient()
{
    // Permission check
    $id = $this->input->post('id');
    if ($id) {
        $this->check_receptionist_access('reception_management', 'edit');
    } else {
        $this->check_receptionist_access('reception_management', 'create');
    }
    
    // Collect form data
    $patient_data = [
        'id' => $id,
        
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
        
        // Membership
        'membership_id' => $this->input->post('membership_id'),
        
        // Other Hospital
        'registered_other_hospital' => $this->input->post('registered_other_hospital') ? 1 : 0,
        'other_hospital_patient_id' => $this->input->post('other_hospital_patient_id'),
        
        // Recommendation
        'recommended_to_hospital' => $this->input->post('recommended_to_hospital') ? 1 : 0,
        'recommended_by' => $this->input->post('recommended_by'),
        
        // Emergency Contact
        'emergency_contact_name' => $this->input->post('emergency_contact_name'),
        'emergency_contact_number' => $this->input->post('emergency_contact_number'),
        'emergency_contact_relation' => $this->input->post('emergency_contact_relation'),
    ];
    
    // Handle document upload
    $document_type = $this->input->post('document_type');
    $uploaded_documents = [];
    
    if (!empty($_FILES['document_file']['name'])) {
        $config['upload_path'] = TEMP_FOLDER;
        $config['allowed_types'] = 'pdf|jpg|jpeg|png|doc|docx';
        $config['max_size'] = 5120; // 5MB
        
        $this->load->library('upload', $config);
        
        if ($this->upload->do_upload('document_file')) {
            $upload_data = $this->upload->data();
            $uploaded_documents[$document_type] = [
                'name' => $upload_data['file_name'],
                'type' => $upload_data['file_type'],
                'tmp_name' => $upload_data['full_path'],
                'size' => $upload_data['file_size'] * 1024,
                'error' => UPLOAD_ERR_OK
            ];
        }
    }
    
    // Save patient
    $result = $this->hospital_patients_model->save($patient_data, $uploaded_documents);
    
    if ($result['success']) {
        set_alert('success', $result['message']);
        redirect(admin_url('hospital_management/view_patient/' . $result['id']));
    } else {
        set_alert('danger', $result['message']);
        redirect(admin_url('hospital_management/manage_patient/' . $id));
    }
}


/**
 * Delete patient document
 */
public function delete_document($document_id, $patient_id)
{
   $this->check_receptionist_access('reception_management', 'delete');
    
    $result = $this->hospital_patients_model->delete_document($document_id);
    
    if ($result['success']) {
        set_alert('success', $result['message']);
    } else {
        set_alert('danger', $result['message']);
    }
    
    redirect(admin_url('hospital_management/manage_patient/' . $patient_id));
}    /**
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
   /**
 * Consultant Appointments List with Date Filtering
 */
public function consultant_appointments()
{
    // Check if user is consultant
    if (!is_consultant() && !is_junior_consultant()) {
        access_denied('Consultant Portal');
    }
    
    $staff_id = get_staff_user_id();
    $is_jc = is_junior_consultant();
    
    // Get filter parameters from GET request
    $filter_type = $this->input->get('filter_type') ?: 'today';
    $from_date = $this->input->get('from_date') ?: date('Y-m-d');
    $to_date = $this->input->get('to_date') ?: date('Y-m-d');
    
    // Calculate date range based on filter type
    switch ($filter_type) {
        case 'today':
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d');
            $filter_info = "Showing: Today's appointments";
            break;
            
        case 'week':
            // Get current week (Sunday to Saturday)
            $from_date = date('Y-m-d', strtotime('sunday this week'));
            $to_date = date('Y-m-d', strtotime('saturday this week'));
            $filter_info = "Showing: This week's appointments";
            break;
            
        case 'month':
            // Get current month
            $from_date = date('Y-m-01'); // First day of month
            $to_date = date('Y-m-t'); // Last day of month
            $filter_info = "Showing: This month's appointments";
            break;
            
        case 'all':
            $from_date = null;
            $to_date = null;
            $filter_info = "Showing: All appointments";
            break;
            
        case 'custom':
            // Use the dates from input
            if (empty($from_date) || empty($to_date)) {
                $from_date = date('Y-m-d');
                $to_date = date('Y-m-d');
                $filter_info = "Showing: Today's appointments";
            } else {
                $filter_info = "Showing: " . date('d M Y', strtotime($from_date)) . " to " . date('d M Y', strtotime($to_date));
            }
            break;
            
        default:
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d');
            $filter_info = "Showing: Today's appointments";
            $filter_type = 'today';
    }
    
    // Load model
    $this->load->model('consultant_portal_model');
    
    // Get filtered appointments
     $include_completed = ($filter_type === 'all');
    $appointments = $this->consultant_portal_model->get_appointments($staff_id, $is_jc, $from_date, $to_date);
    
    // Get statistics
    $statistics = $this->consultant_portal_model->get_statistics($staff_id, $is_jc);
    
    // Prepare data for view
    $data = [
        'appointments' => $appointments,
        'statistics' => $statistics,
        'filter_type' => $filter_type,
        'from_date' => $from_date ?: date('Y-m-d'),
        'to_date' => $to_date ?: date('Y-m-d'),
        'filter_info' => $filter_info,
        'title' => 'My Appointments'
    ];
    
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
 * Consultant see patient - Full visit form
 */
public function consultant_see_patient($appointment_id)
{
    // Check consultant access
    $staff_id = get_staff_user_id();
    
    // Load appointment with patient details
    $this->load->model('consultant_portal_model');
    $appointment = $this->consultant_portal_model->get($appointment_id);
    
    if (!$appointment) {
        show_404();
    }
    
    // Verify access
    $access_check = $this->consultant_portal_model->verify_access($appointment_id, $staff_id);
    if (!$access_check['has_access']) {
        set_alert('danger', $access_check['message'] ?? 'Access denied');
        redirect(admin_url('hospital_management/consultant_portal'));
    }
    
    // Get existing visit if any
    $visit = $this->consultant_portal_model->get_visit_by_appointment($appointment_id);
    
    // Get patient's visit history
    $visit_history = $this->hospital_visits_model->get_patient_visits($appointment['patient_id']);
    
    // Get dropdown data
    $data['icd_codes'] = $this->get_icd_codes();
    $data['medicine_drops'] = $this->get_medicine_drops();
    // Get surgery types directly for view
    $this->db->select('id, surgery_name, surgery_code, category');
    $this->db->where('is_active', 1);
    $this->db->order_by('display_order', 'ASC');
    $data['surgery_types'] = $this->db->get(db_prefix() . 'hospital_surgery_types')->result_array();
    $data['lens_types'] = $this->get_lens_types();

    // ADD THIS NEW CODE - Load all request categories and items
    $data['request_categories'] = $this->consultant_portal_model->get_request_categories();
    $data['request_items_grouped'] = [];

    foreach ($data['request_categories'] as $category) {
        $data['request_items_grouped'][$category['id']] = $this->consultant_portal_model->get_request_items_by_category($category['id']);
    }

    // Load existing requests for this visit
    if (!empty($visit)) {
        // Load existing requests using NEW clean method
$data['existing_requests'] = $this->consultant_portal_model->get_requests_by_appointment($appointment_id);
    } else {
        $data['existing_requests'] = [];
    }


// Load surgery counselling requests - SAME PATTERN
if (!empty($visit)) {
    $data['surgery_requests'] = $this->consultant_portal_model->get_surgery_requests_by_appointment($appointment_id);
} else {
    $data['surgery_requests'] = [];
}

 $data['title'] = 'Patient Consultation - ' . $appointment['patient_name'];
$data['appointment'] = $appointment;  // ADD THIS LINE
$data['visit'] = $visit;              // ADD THIS LINE
$data['visit_history'] = $visit_history;  // ADD THIS LINE
    
$this->load->view('consultant_see_patient', $data);
}

/**
 * Get medicines by category (AJAX)
 */
public function get_medicines_by_category()
{
    if ($this->input->is_ajax_request()) {
        $category = $this->input->get('category');
        
        $this->load->model('hospital_visits_model');
        $medicines = $this->hospital_visits_model->get_medicines($category);
        
        echo json_encode([
            'success' => true,
            'medicines' => $medicines
        ]);
        exit;
    }
}
// ==========================================
// REQUEST SYSTEM AJAX METHODS
// ==========================================

/**
 * Get request items by category (AJAX)
 */
public function get_request_items()
{
    if ($this->input->is_ajax_request()) {
        $category_id = $this->input->post('category_id');
        
        $items = $this->consultant_portal_model->get_request_items_by_category($category_id);
        
        echo json_encode([
            'success' => true,
            'items' => $items
        ]);
    }
}

public function save_visit_request()
{
    if ($this->input->is_ajax_request()) {
        $selected_items = $this->input->post('selected_items');
        
        // Check if visit_id exists
        $visit_id = $this->input->post('visit_id');
        if (empty($visit_id) || $visit_id === 'null') {
            echo json_encode([
                'success' => false,
                'message' => 'Visit ID is required. Please ensure visit is created first.'
            ]);
            exit;
        }
        
        $data = [
            'visit_id' => $visit_id,
            'category_id' => $this->input->post('category_id'),
            'selected_items' => $selected_items,  // Already an array from JavaScript
            'total_amount' => $this->input->post('total_amount'),
            'final_amount' => $this->input->post('final_amount'),
            'priority' => $this->input->post('priority') ?: 'normal',
            'doctor_notes' => $this->input->post('doctor_notes')
        ];
        
        $result = $this->consultant_portal_model->save_visit_request($data);
        
        // Include CSRF tokens in response
        $result['csrf_token_name'] = $this->security->get_csrf_token_name();
        $result['csrf_token_hash'] = $this->security->get_csrf_hash();
        
        echo json_encode($result);
        exit;
    }
}

/**
 * Get visit requests (AJAX)
 */
public function get_visit_requests()
{
    if ($this->input->is_ajax_request()) {
        $visit_id = $this->input->post('visit_id');
        
        $requests = $this->consultant_portal_model->get_visit_requests($visit_id);
        
        echo json_encode([
            'success' => true,
            'requests' => $requests
        ]);
    }
}


/**
 * Save visit details (AJAX)
 */
/**
 * Save visit details (AJAX) - WITH DETAILED ERROR LOGGING
 */
public function save_visit_details()
{
    if ($this->input->is_ajax_request()) {
        $this->load->model('hospital_visits_model');
        
        $visit_id = $this->input->post('visit_id');
        $tab = $this->input->post('tab');
        
        // Validate visit_id
        if (!$visit_id || !is_numeric($visit_id)) {
            log_activity('Hospital Visit Details - ERROR: Invalid visit ID received: ' . var_export($visit_id, true));
            echo json_encode([
                'success' => false,
                'message' => 'Invalid visit ID: ' . $visit_id,
                'debug' => 'visit_id must be numeric'
            ]);
            exit;
        }
        
        // Verify visit exists
        $this->db->where('id', $visit_id);
        $visit_exists = $this->db->get(db_prefix() . 'hospital_visits')->row();
        
        if (!$visit_exists) {
            log_activity('Hospital Visit Details - ERROR: Visit ID ' . $visit_id . ' does not exist in database');
            echo json_encode([
                'success' => false,
                'message' => 'Visit not found in database (ID: ' . $visit_id . ')',
                'debug' => 'Visit record does not exist'
            ]);
            exit;
        }
        
        log_activity('Hospital Visit Details - Saving tab "' . $tab . '" for visit ID: ' . $visit_id);
        
        // Prepare data based on tab
        $data = [];
        
        try {
            switch($tab) {
                case 'history':
                    $data = [
                        'allergies' => $this->input->post('allergies'),
                        'systemic_history' => $this->input->post('systemic_history'),
                        'family_history' => $this->input->post('family_history'),
                        'ocular_diseases' => $this->input->post('ocular_diseases'),
                        'surgical_history' => $this->input->post('surgical_history'),
                        'medication' => $this->input->post('medication'),
                        'present_complaint' => $this->input->post('present_complaint'),
                        'dilating_drops' => $this->input->post('dilating_drops')
                    ];
                    break;
                    
                case 'examination':
                    // Build examination data
                    $examination = [
                        'visual_acuity_aided' => [
                            'right' => $this->input->post('visual_acuity_aided_right'),
                            'left' => $this->input->post('visual_acuity_aided_left')
                        ],
                        'visual_acuity_unaided' => [
                            'right' => $this->input->post('visual_acuity_unaided_right'),
                            'left' => $this->input->post('visual_acuity_unaided_left')
                        ],
                        'gonioscopy' => [
                            'right' => $this->input->post('gonioscopy_right'),
                            'left' => $this->input->post('gonioscopy_left')
                        ],
                        'near_vision' => [
                            'right' => $this->input->post('near_vision_right'),
                            'left' => $this->input->post('near_vision_left')
                        ],
                        'auto_ref' => [
                            'right' => $this->input->post('auto_ref_right'),
                            'left' => $this->input->post('auto_ref_left')
                        ],
                        'lids_adnexa_orbit' => [
                            'right' => $this->input->post('lids_adnexa_orbit_right'),
                            'left' => $this->input->post('lids_adnexa_orbit_left')
                        ],
                        'anterior_segment' => [
                            'right' => $this->input->post('anterior_segment_right'),
                            'left' => $this->input->post('anterior_segment_left')
                        ],
                        'pupil' => [
                            'right' => $this->input->post('pupil_right'),
                            'left' => $this->input->post('pupil_left')
                        ],
                        'iop' => [
                            'right' => $this->input->post('iop_right'),
                            'left' => $this->input->post('iop_left')
                        ],
                        'fundus' => [
                            'right' => $this->input->post('fundus_right'),
                            'left' => $this->input->post('fundus_left')
                        ],
                        'ocnm' => [
                            'right' => $this->input->post('ocnm_right'),
                            'left' => $this->input->post('ocnm_left')
                        ],
                        'lacrimal_syringing' => [
                            'right' => $this->input->post('lacrimal_syringing_right'),
                            'left' => $this->input->post('lacrimal_syringing_left')
                        ]
                    ];
                    
                    $data = ['examination_data' => json_encode($examination)];
                    break;
                    
                case 'retinoscopy':
                    $retinoscopy = [
                        'right' => [
                            'ds' => $this->input->post('right_ds'),
                            'dc' => $this->input->post('right_dc'),
                            'axis' => $this->input->post('right_axis'),
                            'add' => $this->input->post('right_add')
                        ],
                        'left' => [
                            'ds' => $this->input->post('left_ds'),
                            'dc' => $this->input->post('left_dc'),
                            'axis' => $this->input->post('left_axis'),
                            'add' => $this->input->post('left_add')
                        ],
                        'type_of_dilatation' => $this->input->post('type_of_dilatation')
                    ];
                    
                    $data = ['retinoscopy_data' => json_encode($retinoscopy)];
                    break;
                    
                case 'diagnosis':
                    $icd_codes = $this->input->post('icd_codes');
                    $data = [
                        'opinion_plan_of_care' => $this->input->post('opinion_plan_of_care'),
                        'icd_codes' => is_array($icd_codes) ? implode(',', $icd_codes) : $icd_codes,
                        'review_required' => $this->input->post('review_required'),
                        'review_period' => $this->input->post('review_period'),
                        'systematic_exam_ordered' => $this->input->post('systematic_exam_ordered')
                    ];
                    break;
                    
               case 'medicine':
    $medicines_input = $this->input->post('medicines');
    // Decode if JSON string, otherwise use as array
    $medicines_raw = is_string($medicines_input) 
        ? json_decode($medicines_input, true) 
        : (is_array($medicines_input) ? $medicines_input : []);
                    $medicines_detailed = [];
                    $total_fee = 0.00;
                    
                    if (!empty($medicines_raw) && is_array($medicines_raw)) {
                        foreach ($medicines_raw as $med) {
                            if (!empty($med['medicine_id'])) {
                                $medicine_info = $this->hospital_visits_model->get_medicine($med['medicine_id']);
                                
                                if ($medicine_info) {
                                    $medicine_entry = [
                                        'medicine_id' => $medicine_info['id'],
                                        'medicine_name' => $medicine_info['medicine_name'],
                                        'generic_name' => $medicine_info['generic_name'],
                                        'category' => $medicine_info['category'],
                                        'strength' => $medicine_info['strength'],
                                        'price' => (float)$medicine_info['price'],
                                        'eye' => $med['eye'] ?? 'both',
                                        'dose' => $med['dose'] ?? '1',
                                        'unit' => $med['unit'] ?? 'drop',
                                        'interval' => $med['interval'] ?? '',
                                        'frequency' => $med['frequency'] ?? 'day',
                                        'instructions' => $med['instructions'] ?? ''
                                    ];
                                    
                                    $medicines_detailed[] = $medicine_entry;
                                    $total_fee += $medicine_entry['price'];
                                }
                            }
                        }
                    }
                    
                    $data = [
                        'medicine_prescription_details' => json_encode($medicines_detailed),
                        'medicine_instructions' => $this->input->post('medicine_instructions'), // ← ADD THIS
                        'fee_amount' => $total_fee,
                        'total_fee' => $total_fee
                    ];
                    break;
                    
                case 'spectacle':
                    $data = [
                        'spectacle_right_sph' => $this->input->post('right_sph'),
                        'spectacle_right_cyl' => $this->input->post('right_cyl'),
                        'spectacle_right_axis' => $this->input->post('right_axis'),
                        'spectacle_right_near_vision' => $this->input->post('right_near_vision'),
                        'spectacle_right_distance_vision' => $this->input->post('right_distance_vision'),
                        'spectacle_left_sph' => $this->input->post('left_sph'),
                        'spectacle_left_cyl' => $this->input->post('left_cyl'),
                        'spectacle_left_axis' => $this->input->post('left_axis'),
                        'spectacle_left_near_vision' => $this->input->post('left_near_vision'),
                        'spectacle_left_distance_vision' => $this->input->post('left_distance_vision'),
                        'bifocals' => $this->input->post('bifocals'),
                        'back_vertex' => $this->input->post('back_vertex'),
                        'interpupillary' => $this->input->post('interpupillary'),
                        'spectacle_remarks' => $this->input->post('spectacle_remarks'),
                        'lens_type' => $this->input->post('lens_type')
                    ];
                    break;
                    
                case 'pediatric':
                    $data = ['pediatric_notes' => $this->input->post('pediatric_notes')];
                    break;
                    
                default:
                    log_activity('Hospital Visit Details - ERROR: Invalid tab specified: ' . $tab);
                    echo json_encode([
                        'success' => false,
                        'message' => 'Invalid tab specified: ' . $tab
                    ]);
                    exit;
            }
            
            // Log what we're trying to save
            log_activity('Hospital Visit Details - Data to save: ' . json_encode($data));
            
            // Update visit details
            $success = $this->hospital_visits_model->update_visit_details($visit_id, $data);
            
            // Get database error if failed
            $db_error = $this->db->error();
            
            if (!$success) {
                log_activity('Hospital Visit Details - ERROR: Failed to save. DB Error: ' . json_encode($db_error));
            }
            
            echo json_encode([
                'success' => $success,
                'message' => $success ? 'Saved successfully' : 'Failed to save. Check logs for details.',
                'total_fee' => $total_fee ?? null,
                'db_error' => !$success ? $db_error : null,
                'csrf_token_name' => $this->security->get_csrf_token_name(),
                'csrf_token_hash' => $this->security->get_csrf_hash()
            ]);
            
        } catch (Exception $e) {
            log_activity('Hospital Visit Details - EXCEPTION: ' . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Exception occurred: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
        
        exit;
    }
}

/**
 * Complete visit (AJAX)
 */
public function complete_visit()
{
    if ($this->input->is_ajax_request()) {
        $visit_id = $this->input->post('visit_id');
        $appointment_id = $this->input->post('appointment_id');
        
        $this->load->model('hospital_visits_model');
        
        // Mark visit as completed
        $success = $this->hospital_visits_model->complete_visit($visit_id, get_staff_user_id());
        
        // Also update appointment status to completed
        if ($success) {
            $this->hospital_appointments_model->update($appointment_id, ['status' => 'completed']);
        }
        
        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Visit completed successfully' : 'Failed to complete visit',
            'redirect' => admin_url('hospital_management/consultant_appointments')
        ]);
        exit;
    }
}

// Helper methods for dropdowns
private function get_icd_codes() {
    // Return array of ICD codes - you can create a table or return static array
    return [
        'H35.0' => 'Background retinopathy',
        'H40.1' => 'Primary open-angle glaucoma',
        'H25.9' => 'Cataract, unspecified',
        // Add more codes...
    ];
}

private function get_medicine_drops() {
    return [
        'Moxifloxacin 0.5%',
        'Timolol 0.5%',
        'Latanoprost 0.005%',
        'Prednisolone 1%',
        // Add more...
    ];
}

public function get_surgery_types()
{
    $this->ajax_only();
    
    $this->db->select('id, surgery_name, surgery_code, category');
    $this->db->where('is_active', 1);
    $this->db->order_by('display_order', 'ASC');
    $types = $this->db->get(db_prefix() . 'hospital_surgery_types')->result_array();
    
    return $this->json_response(true, '', ['surgery_types' => $types], true);
}
private function get_lens_types() {
    return [
        'Single Vision',
        'Bifocal',
        'Progressive',
        'Anti-Reflective Coating'
    ];
}

/**
 * View visit (Read-only version)
 * 
 * @param int $visit_id Visit ID
 */
public function view_visit($visit_id)
{
    // Get visit record
    $this->db->where('id', $visit_id);
    $visit_record = $this->db->get(db_prefix() . 'hospital_visits')->row_array();
    
    if (!$visit_record) {
        show_404();
    }
    
    $appointment_id = $visit_record['appointment_id'];
    
    // Load data
    $this->load->model('consultant_portal_model');
    $appointment = $this->consultant_portal_model->get($appointment_id);
    
    if (!$appointment) {
        show_404();
    }
    
    // Get visit with ALL details
    $visit = $this->hospital_visits_model->get_visit_with_details($visit_id);
    
    if (!$visit) {
        $visit = $this->consultant_portal_model->get_visit_by_appointment($appointment_id);
    }
    
    // Get patient's visit history
    $visit_history = $this->hospital_visits_model->get_patient_visits($appointment['patient_id']);
    
    // Parse medicines
    $medicines_saved = [];
    if (!empty($visit['medicine_prescription_details'])) {
        $decoded = json_decode($visit['medicine_prescription_details'], true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $medicines_saved = $decoded;
        }
    }
    
    // Prepare data
    $data['title'] = 'Visit Details - ' . $visit_record['visit_number'];
    $data['appointment'] = $appointment;
    $data['visit'] = $visit;
    $data['visit_history'] = $visit_history;
    $data['medicines_saved'] = $medicines_saved;
    $data['visit_number'] = $visit_record['visit_number'];
    $data['visit_id'] = $visit_id;
    
    // Load view
    $this->load->view('hospital_management/view_visit', $data);
}

/**
 * Download visit as PDF - WORKING VERSION
 * 
 * @param int $visit_id Visit ID
 */
public function download_visit_pdf($visit_id)
{
    // Get visit record
    $this->db->where('id', $visit_id);
    $visit_record = $this->db->get(db_prefix() . 'hospital_visits')->row_array();
    
    if (!$visit_record) {
        show_404();
    }
    
    $appointment_id = $visit_record['appointment_id'];
    
    // Load data
    $this->load->model('consultant_portal_model');
    $appointment = $this->consultant_portal_model->get($appointment_id);
    
    if (!$appointment) {
        show_404();
    }
    
    // Get visit with ALL details
    $visit = $this->hospital_visits_model->get_visit_with_details($visit_id);
    
    if (!$visit) {
        $visit = $this->consultant_portal_model->get_visit_by_appointment($appointment_id);
    }
    
    // Parse medicines
    $medicines_saved = [];
    if (!empty($visit['medicine_prescription_details'])) {
        $decoded = json_decode($visit['medicine_prescription_details'], true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $medicines_saved = $decoded;
        }
    }
    
    // Prepare data for PDF
    $data = [
        'appointment' => $appointment,
        'visit' => $visit,
        'medicines_saved' => $medicines_saved,
        'visit_number' => $visit_record['visit_number']
    ];
    
    // Generate HTML content
    $html = $this->load->view('visit_pdf_template', $data, true);
    
    try {
        // CORRECT PATH: Include TCPDF from vendor folder
        require_once(APPPATH . 'vendor/tecnickcom/tcpdf/tcpdf.php');
        
        // Create new PDF instance
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // Set document information
        $pdf->SetCreator('Hospital Management System');
        $pdf->SetAuthor('Dr ' . $appointment['consultant_firstname'] . ' ' . $appointment['consultant_lastname']);
        $pdf->SetTitle('Visit Details - ' . $visit_record['visit_number']);
        $pdf->SetSubject('Patient Visit Report');
        
        // Remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        
        // Set margins
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(TRUE, 15);
        
        // Add a page
        $pdf->AddPage();
        
        // Set font
        $pdf->SetFont('helvetica', '', 10);
        
        // Write HTML content
        $pdf->writeHTML($html, true, false, true, false, '');
        
        // Generate filename
        $filename = 'Visit_' . $visit_record['visit_number'] . '_' . date('Y-m-d') . '.pdf';
        
        // Output PDF (D = force download)
        $pdf->Output($filename, 'D');
        
    } catch (Exception $e) {
        // Log error
        log_activity('PDF Generation Error: ' . $e->getMessage());
        
        // Show error to user
        set_alert('danger', 'Failed to generate PDF: ' . $e->getMessage());
        redirect(admin_url('hospital_management/view_visit/' . $visit_id));
    }
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
   // ============================================
// TECHNICIAN PORTAL METHODS
// ============================================

/**
 * Technician Dashboard
 */
public function technician_dashboard()
{
    // Check if user is technician
    if (!is_technician() && !has_permission('technician_portal', '', 'view')) {
        access_denied('Technician Portal');
    }
    
    $data['title'] = 'Technician Dashboard';
    $this->load->view('technician/dashboard', $data);
}
public function lab_records()
{
    $this->check_receptionist_access('reception_management', 'view');
    
    $this->load->model('hospital_requests_model');
    
    // Get PENDING requests (need approval)
    $data['pending_requests'] = $this->hospital_requests_model->get_pending_requests();
    
    // Get ALL lab records (approved, in_progress, completed)
    $data['records'] = $this->hospital_requests_model->get_all_lab_records();
    
    // Get statistics
    $data['statistics'] = $this->hospital_requests_model->get_receptionist_statistics();
    
    // Get list of technicians
    $data['technicians'] = $this->hospital_requests_model->get_technicians();
    
    $data['title'] = 'Procedures & Lab Records';
    $this->load->view('lab_records', $data);
}
/**
 * Approve pending request (AJAX)
 */
public function approve_request()
{
    $this->ajax_only();
    $this->check_receptionist_access('reception_management', 'edit');
    
    $request_id = $this->input->post('request_id');
    
    $this->load->model('hospital_requests_model');
    $result = $this->hospital_requests_model->approve_request($request_id);
    
    return $this->json_response($result['success'], $result['message'], [], true);
}
/**
 * Get request details (AJAX) - For modal
 */
public function get_request_details()
{
    $this->ajax_only();
    $this->check_receptionist_access('reception_management', 'view');
    
    $request_id = $this->input->post('request_id');
    
    $this->load->model('hospital_requests_model');
    $request = $this->hospital_requests_model->get_request_with_items($request_id);
    
    if ($request) {
        return $this->json_response(true, '', ['request' => $request], true);
    }
    
    return $this->json_response(false, 'Request not found', [], true);
}

/**
 * Assign request to technician (AJAX)
 */
public function assign_request()
{
    $this->ajax_only();
    $this->check_receptionist_access('reception_management', 'edit');
    
    $request_id = $this->input->post('request_id');
    $technician_id = $this->input->post('technician_id');
    
    if (empty($technician_id)) {
        return $this->json_response(false, 'Please select a technician', [], true);
    }
    
    $this->load->model('hospital_requests_model');
    $result = $this->hospital_requests_model->assign_to_technician($request_id, $technician_id);
    
    return $this->json_response($result['success'], $result['message'], [], true);
}

/**
 * Cancel request (AJAX)
 */
public function cancel_request()
{
    $this->ajax_only();
    $this->check_receptionist_access('reception_management', 'delete');
    
    $request_id = $this->input->post('request_id');
    $reason = $this->input->post('reason');
    
    $this->load->model('hospital_requests_model');
    $result = $this->hospital_requests_model->cancel_request($request_id, $reason);
    
    return $this->json_response($result['success'], $result['message'], [], true);
}

/**
 * Lab Requests - Technician View
 */
public function lab_requests()
{
    // Check if user is technician or has permission
    if (!is_technician() && !has_permission('technician_portal', '', 'view')) {
        access_denied('technician_portal');
    }
    
    $staff_id = get_staff_user_id();
    
    // Load model
    $this->load->model('hospital_requests_model');
    
    // CRITICAL FIX: Use get_technician_requests() which shows ALL approved requests
    $data['requests'] = $this->hospital_requests_model->get_technician_requests($staff_id);
    
    // Get statistics
    $data['statistics'] = $this->hospital_requests_model->get_technician_statistics($staff_id);
    
    // Debug logging
    log_activity('Technician Portal: Staff #' . $staff_id . ' viewing lab requests. Found: ' . count($data['requests']) . ' requests');
    
    $data['title'] = 'My Lab Requests';
    $this->load->view('technician/lab_requests', $data);
}

/**
 * View request detail (Technician)
 */
public function lab_request($request_id)
{
    if (!is_technician() && !has_permission('technician_portal', '', 'view')) {
        access_denied('technician_portal');
    }
    
    $this->load->model('hospital_requests_model');
    
    $data['request'] = $this->hospital_requests_model->get_request_with_items($request_id);
    
    if (!$data['request']) {
        show_404();
    }
    
    // Log view
    log_activity('Technician viewing lab request #' . $request_id);
    
    $data['title'] = 'Lab Request Details';
    $this->load->view('technician/lab_request_detail', $data);
}

/**
 * Lab Report Form (opens after clicking Start)
 */
public function lab_report_form($request_id = null)
{
    if (!is_technician() && !has_permission('technician_portal', '', 'view')) {
        access_denied('technician_portal');
    }
    
    if (!$request_id) {
        show_404();
    }
    
    $staff_id = get_staff_user_id();
    
    $this->load->model('hospital_requests_model');
    
    // Get request details
    $data['request'] = $this->hospital_requests_model->get_request_with_items($request_id);
    
    if (!$data['request']) {
        show_404();
    }
    
    // Verify assigned to me
    if ($data['request']['status'] != 'in_progress' || $data['request']['assigned_technician_id'] != $staff_id) {
        set_alert('danger', 'This request is not assigned to you');
        redirect(admin_url('hospital_management/lab_requests'));
    }
    
    // Check existing report
    $data['existing_report'] = $this->hospital_requests_model->get_lab_report($request_id);
    
    $data['title'] = 'Lab Report Entry';
    $this->load->view('technician/lab_report_form', $data);
}

/**
 * Save Lab Report (form submission)
 */
public function save_lab_report()
{
    if (!is_technician() && !has_permission('technician_portal', '', 'edit')) {
        access_denied('technician_portal');
    }
    
    $request_id = $this->input->post('request_id');
    $staff_id = get_staff_user_id();
    
    $this->load->model('hospital_requests_model');
    
    // Verify request
    $this->db->where('id', $request_id);
    $this->db->where('assigned_technician_id', $staff_id);
    $this->db->where('status', 'in_progress');
    $request = $this->db->get(db_prefix() . 'hospital_visit_requests')->row();
    
    if (!$request) {
        set_alert('danger', 'Invalid request');
        redirect(admin_url('hospital_management/lab_requests'));
    }
    
    // Get patient ID from visit
    $this->db->select('patient_id');
    $this->db->where('id', $request->visit_id);
    $visit = $this->db->get(db_prefix() . 'hospital_visits')->row();
    
    // Prepare report data
    $report_data = [
        'request_id' => $request_id,
        'visit_id' => $request->visit_id,
        'patient_id' => $visit ? $visit->patient_id : 0,
        'technician_id' => $staff_id,
        'report_date' => date('Y-m-d H:i:s'),
        
        // Bio-Chemistry
        'fasting_blood_sugar' => $this->input->post('fasting_blood_sugar'),
        'postprandial_blood_sugar' => $this->input->post('postprandial_blood_sugar'),
        'blood_urea' => $this->input->post('blood_urea'),
        'serum_creatinine' => $this->input->post('serum_creatinine'),
        
        // Serology
        'hiv_1_2' => $this->input->post('hiv_1_2'),
        'hbsag' => $this->input->post('hbsag'),
        'hcv' => $this->input->post('hcv'),
        
        // Haematology
        'haemoglobin' => $this->input->post('haemoglobin'),
        'total_wbc_count' => $this->input->post('total_wbc_count'),
        'neutrophils' => $this->input->post('neutrophils'),
        'lymphocytes' => $this->input->post('lymphocytes'),
        'eosinophils' => $this->input->post('eosinophils'),
        'monocytes' => $this->input->post('monocytes'),
        'basophils' => $this->input->post('basophils'),
        'rbc' => $this->input->post('rbc'),
        'platelet_count' => $this->input->post('platelet_count'),
        'pcv' => $this->input->post('pcv'),
        'mcv' => $this->input->post('mcv'),
        'mch' => $this->input->post('mch'),
        'mchc' => $this->input->post('mchc'),
        'bleeding_time' => $this->input->post('bleeding_time'),
        'clotting_time' => $this->input->post('clotting_time'),
        
        // Urine Analysis
        'urine_colour' => $this->input->post('urine_colour'),
        'urine_ph' => $this->input->post('urine_ph'),
        'urine_sp_gravity' => $this->input->post('urine_sp_gravity'),
        'urine_protein' => $this->input->post('urine_protein'),
        'urine_glucose' => $this->input->post('urine_glucose'),
        'pus_cells' => $this->input->post('pus_cells'),
        'epithelial_cells' => $this->input->post('epithelial_cells'),
        'rbc_urine' => $this->input->post('rbc_urine'),
        
        // Notes
        'technician_notes' => $this->input->post('technician_notes'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    // Save report
    $result = $this->hospital_requests_model->save_lab_report($report_data);
    // print_r($result);
    
    if ($result['success']) {
        // Complete request
        $this->hospital_requests_model->complete_request($request_id, $staff_id, 'Lab report completed');
        
        set_alert('success', 'Lab report saved and request completed');
    } else {
        set_alert('danger', 'Failed to save lab report');
    }
    
    redirect(admin_url('hospital_management/lab_requests'));
}

public function summa($request_id,$staff_id,$default = 'Lab report completed')
{
    $this->load->model('hospital_requests_model');
    $result = $this->hospital_requests_model->complete_request($request_id, $staff_id, $default);
    print_r($result);

}
/**
 * Start request (AJAX) - CORRECTED
 */
public function start_request()
{
    $this->ajax_only();
    
    // Check technician permission
    if (!is_technician() && !has_permission('technician_portal', '', 'edit')) {
        return $this->json_response(false, 'Access denied', [], true);
    }
    
    $request_id = $this->input->post('request_id');
    $staff_id = get_staff_user_id();
    
    // Validate request_id
    if (empty($request_id)) {
        return $this->json_response(false, 'Invalid request ID', [], true);
    }
    
    $this->load->model('hospital_requests_model');
    $result = $this->hospital_requests_model->start_processing($request_id, $staff_id);
    
    if ($result['success']) {
        // Add redirect URL to result
        $result['redirect_url'] = admin_url('hospital_management/lab_report_form/' . $request_id);
    }
    
    return $this->json_response(
        $result['success'], 
        $result['message'], 
        ['redirect_url' => $result['redirect_url'] ?? ''], 
        true
    );
}

/**
 * Complete request (AJAX)
 */
public function complete_request()
{
    $this->ajax_only();
    
    if (!is_technician() && !has_permission('technician_portal', '', 'edit')) {
        ajax_access_denied();
    }
    
    $request_id = $this->input->post('request_id');
    $notes = $this->input->post('notes');
    $staff_id = get_staff_user_id();
    
    $this->load->model('hospital_requests_model');
    $result = $this->hospital_requests_model->complete_request($request_id, $staff_id, $notes);
    
    return $this->json_response($result['success'], $result['message'], [], true);
}




/**
 * Start JC Consultation (Similar to start_processing for lab requests)
 * Records which Junior Consultant is seeing the patient
 * 
 * @return JSON response
 */
public function start_jc_consultation()
{
    $this->ajax_only();
    
    // Check if user is Junior Consultant or has consultant access
    if (!is_junior_consultant() && !is_consultant() && !has_permission('consultant_portal', '', 'view')) {
        return $this->json_response(false, 'Access denied. Only consultants can start consultations.', [], true);
    }
    
    $appointment_id = $this->input->post('appointment_id');
    $visit_id = $this->input->post('visit_id');
    $staff_id = get_staff_user_id();
    
    // Validate inputs
    if (empty($appointment_id) || empty($visit_id)) {
        return $this->json_response(false, 'Missing required parameters', [], true);
    }
    
    // Load model
    $this->load->model('consultant_portal_model');
    
    // Call model method to record JC consultation start
    $result = $this->consultant_portal_model->start_jc_consultation($visit_id, $staff_id);
    
    if ($result['success']) {
        // Add redirect URL to result - redirect to consultant see patient page
        $result['redirect_url'] = admin_url('hospital_management/consultant_see_patient/' . $appointment_id);
    }
    
    return $this->json_response(
        $result['success'], 
        $result['message'], 
        ['redirect_url' => $result['redirect_url'] ?? ''], 
        true
    );
}
// ============================================
// SURGERY COUNSELLING METHODS
// ============================================

/**
 * Save surgery request (AJAX)
 */
public function save_surgery_request()
{
    $this->ajax_only();
    $this->check_consultant_access('consultant_portal', 'create');
    
    $visit_id = $this->input->post('visit_id');
    $patient_id = $this->input->post('patient_id');
    $request_type = $this->input->post('request_type');
    
    // Validate
    if (empty($patient_id) || empty($request_type)) {
        return $this->json_response(false, 'Missing required fields', [], true);
    }
    
    // Prepare data - visit_id can be NULL
    $data = [
        'visit_id' => (!empty($visit_id) && $visit_id !== 'null') ? $visit_id : null,
        'patient_id' => $patient_id,
        'request_type' => $request_type,
        'requested_by' => get_staff_user_id(),
        'requested_at' => date('Y-m-d H:i:s'),
        'status' => 'pending'
    ];
    
    // Common fields
    $data['surgery_type_id'] = $this->input->post('surgery_type_id');
    $data['surgery_details'] = $this->input->post('surgery_details');
    
    // Detailed fields
    if ($request_type === 'detailed') {
        $data['doing_surgery'] = $this->input->post('doing_surgery');
        $data['surgery_name'] = $this->input->post('surgery_name');
        $data['lens_preference'] = $this->input->post('lens_preference');
        $data['standby_lens'] = $this->input->post('standby_lens');
        $data['disposables_instruments'] = $this->input->post('disposables_instruments');
        $data['admission_hours_before'] = $this->input->post('admission_hours_before');
        $data['overnight_admission'] = $this->input->post('overnight_admission');
        $data['special_instructions'] = $this->input->post('special_instructions');
        $data['nil_oral_instructions'] = $this->input->post('nil_oral_instructions');
        $data['preferred_datetime'] = $this->input->post('preferred_datetime');
        $data['lens_power'] = $this->input->post('lens_power');
        $data['a_constant_used'] = $this->input->post('a_constant_used');
        $data['formula_used'] = $this->input->post('formula_used');
        $data['anesthesia'] = $this->input->post('anesthesia');
    }
    
    // Insert
    $inserted = $this->db->insert(db_prefix() . 'hospital_surgery_requests', $data);
    
    if ($inserted) {
        $request_id = $this->db->insert_id();
        log_activity('Surgery Request Created [ID: ' . $request_id . ', Type: ' . $request_type . ']');
        return $this->json_response(true, 'Surgery request submitted successfully', ['request_id' => $request_id], true);
    }
    
    return $this->json_response(false, 'Failed to save surgery request', [], true);
}

/**
 * Process Payment for Visit Request (Lab/Procedure)
 * @param int $request_id
 */
public function process_payment($request_id = null)
{
    if (!has_permission('hospital_management', '', 'view')) {
        access_denied('hospital_management');
    }
    
    if (!$request_id) {
        show_404();
    }
    
    $this->load->model('hospital_requests_model');
    
    // Get payment details
    $data['payment_details'] = $this->hospital_requests_model->get_request_payment_details($request_id);
    
    if (!$data['payment_details']) {
        set_alert('danger', 'Request not found');
        redirect(admin_url('hospital_management/lab_records'));
    }
    
    // Check if payment already exists
    $existing_payment = $this->hospital_requests_model->check_request_payment($request_id);
    $data['existing_payment'] = $existing_payment;
    
    $data['title'] = _l('Process Payment');
    $data['payment_methods'] = ['cash', 'card', 'upi', 'netbanking', 'cheque', 'insurance'];
    
    $this->load->view('payment_form', $data);
}
/**
 * Save Payment (AJAX)
 */
public function save_payment()
{
    if (!has_permission('hospital_management', '', 'create')) {
        ajax_access_denied();
    }
    
    $this->load->model('hospital_requests_model');
    
    $request_id = $this->input->post('request_id');
    
    // Get request details
    $payment_calc = $this->hospital_requests_model->get_request_payment_details($request_id);
    
    if (!$payment_calc) {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        return;
    }
    
    // Generate payment number
    $payment_number = 'PAY-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    
    // Get form values
    $subtotal = floatval($this->input->post('subtotal')); // From form
    $discount_amount = floatval($this->input->post('discount_amount')); // From form (MANUAL)
    $paid_amount = floatval($this->input->post('paid_amount'));
    
    // Calculate final amount AFTER discount
    $final_amount = $subtotal - $discount_amount;
    
    // Calculate discount percentage
    $discount_percentage = ($subtotal > 0) ? (($discount_amount / $subtotal) * 100) : 0;
    
    // Determine payment status
    if ($paid_amount >= $final_amount) {
        $payment_status = 'paid';
        $balance = 0;
    } elseif ($paid_amount > 0) {
        $payment_status = 'partial';
        $balance = $final_amount - $paid_amount;
    } else {
        $payment_status = 'unpaid';
        $balance = $final_amount;
    }
    
    // Prepare payment record
    $insert_data = [
        'payment_number' => $payment_number,
        'patient_id' => $payment_calc['patient_id'],
        'visit_id' => $payment_calc['visit_id'],
        'visit_request_id' => $request_id,
        'subtotal_amount' => $subtotal,
        'discount_percentage' => number_format($discount_percentage, 2, '.', ''),
        'discount_amount' => number_format($discount_amount, 2, '.', ''),
        'final_amount' => number_format($final_amount, 2, '.', ''),
        'paid_amount' => number_format($paid_amount, 2, '.', ''),
        'balance_amount' => number_format($balance, 2, '.', ''),
        'payment_status' => $payment_status,
        'payment_method' => $this->input->post('payment_method'),
        'payment_date' => date('Y-m-d H:i:s'),
        'transaction_id' => $this->input->post('transaction_id') ?: null,
        'payment_reference' => $this->input->post('payment_reference') ?: null,
        'patient_type' => $payment_calc['patient_type'],
        'discount_reason' => 'Manual discount applied by receptionist',
        'request_category' => $payment_calc['category_name'],
        'notes' => $this->input->post('notes') ?: null,
        'collected_by' => get_staff_user_id(),
        'created_by' => get_staff_user_id()
    ];
    
    $this->db->insert(db_prefix() . 'hospital_payments', $insert_data);
    $payment_id = $this->db->insert_id();
    
   if ($payment_id) {
    // Update visit_request discount, final amounts, AND STATUS
    $update_data = [
        'discount_amount' => number_format($discount_amount, 2, '.', ''),
        'final_amount' => number_format($final_amount, 2, '.', '')
    ];
    
    // Auto-approve if fully paid
    if ($payment_status === 'paid') {
        $update_data['status'] = 'approved';
        $update_data['approved_by'] = get_staff_user_id();
        $update_data['approved_at'] = date('Y-m-d H:i:s');
    }
    
    $this->db->where('id', $request_id);
    $this->db->update(db_prefix() . 'hospital_visit_requests', $update_data);
        
        log_activity('Payment Processed: ' . $payment_number . ' for Request #' . $payment_calc['request_number']);
        
        echo json_encode([
            'success' => true,
            'message' => 'Payment processed successfully',
            'payment_id' => $payment_id,
            'payment_number' => $payment_number,
            'redirect' => admin_url('hospital_management/lab_records')
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save payment']);
    }
}

/**
 * Check if user is Junior Consultant
 * @return bool
 */
function is_junior_consultant()
{
    if (!is_logged_in()) {
        return false;
    }
    
    $CI = &get_instance();
    $staff_id = get_staff_user_id();
    
    // Get staff role
    $CI->db->select('role');
    $CI->db->where('staffid', $staff_id);
    $staff = $CI->db->get(db_prefix() . 'staff')->row();
    
    if (!$staff) {
        return false;
    }
    
    // Check if role name is "Junior Consultant"
    $CI->db->select('name');
    $CI->db->where('roleid', $staff->role);
    $role = $CI->db->get(db_prefix() . 'roles')->row();
    
    return $role && strtolower($role->name) === 'junior consultant';
}

/**
 * Check if user is Consultant
 * @return bool
 */
function is_consultant()
{
    if (!is_logged_in()) {
        return false;
    }
    
    $CI = &get_instance();
    $staff_id = get_staff_user_id();
    
    // Get staff role
    $CI->db->select('role');
    $CI->db->where('staffid', $staff_id);
    $staff = $CI->db->get(db_prefix() . 'staff')->row();
    
    if (!$staff) {
        return false;
    }
    
    // Check if role name is "Consultant"
    $CI->db->select('name');
    $CI->db->where('roleid', $staff->role);
    $role = $CI->db->get(db_prefix() . 'roles')->row();
    
    return $role && strtolower($role->name) === 'consultant';
}
}