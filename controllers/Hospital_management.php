<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Hospital_management extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('hospital_users_model');
        $this->load->model('hospital_patients_model');
        $this->load->model('hospital_appointments_model'); 
        
    }
    /**
     * Dashboard
     */
    public function index()
    {
        if (!is_hospital_administrator() && !has_permission('hospital_users', '', 'view')) {
            access_denied('Hospital Management');
        }
        
        $data['title'] = 'Hospital Management Dashboard';
        $this->load->view('dashboard', $data);
    }
    // ==========================================
    // Admin section 
    // ==========================================
    // 1.user listing & managing &user view 
    public function users()
    {
        if (!is_hospital_administrator() && !has_permission('hospital_users', '', 'view')) {
            access_denied('Hospital Users');
        }
        
        $data['title'] = 'Hospital Users Management';
        $data['users'] = $this->hospital_users_model->get_all_users();
        
        $this->load->view('users', $data);
    }
    public function manage_user($id = null)
    {
        if ($id && !is_hospital_administrator() && !has_permission('hospital_users', '', 'edit')) {
            access_denied('Hospital Users');
        }
        
        if (!$id && !is_hospital_administrator() && !has_permission('hospital_users', '', 'create')) {
            access_denied('Hospital Users');
        }
        
        $data['roles'] = $this->hospital_users_model->get_allowed_roles();
        
        if ($id) {
            $data['user'] = $this->hospital_users_model->get($id);
            
            if (!$data['user']) {
                show_404();
            }
            
            $data['title'] = 'Edit User';
        } else {
            $data['title'] = 'Create New User';
        }
        
        $this->load->view('manage_user', $data);
    }
    public function view($id)
    {
        if (!is_hospital_administrator() && !has_permission('hospital_users', '', 'view')) {
            access_denied('Hospital Users');
        }
        
        $data['user'] = $this->hospital_users_model->get($id);
        
        if (!$data['user']) {
            show_404();
        }
        
        $data['title'] = 'User Details';
        $this->load->view('view_user', $data);
    }
    public function save()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $id = $this->input->post('id');
        
        if ($id && !is_hospital_administrator() && !has_permission('hospital_users', '', 'edit')) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'You do not have permission to edit users']);
            return;
        }
        
        if (!$id && !is_hospital_administrator() && !has_permission('hospital_users', '', 'create')) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'You do not have permission to create users']);
            return;
        }
        
        $role_id = $this->input->post('role_id');
        if ($role_id == 6) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Cannot create or modify Admin role users']);
            return;
        }
        
        $result = $this->hospital_users_model->save($this->input->post());
        
        header('Content-Type: application/json');
        echo json_encode($result);
    }
    public function delete($id)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        if (!is_hospital_administrator() && !has_permission('hospital_users', '', 'delete')) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'You do not have permission to delete users']);
            return;
        }
        
        $user = $this->hospital_users_model->get($id);
        if ($user && $user->role_id == 6) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Cannot delete Admin role users']);
            return;
        }
        
        $result = $this->hospital_users_model->delete($id);
        
        header('Content-Type: application/json');
        echo json_encode($result);
    }
    public function create_role()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        if (!is_hospital_administrator() && !has_permission('hospital_users', '', 'create')) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'You do not have permission to create roles']);
            return;
        }
        
        $role_name = trim($this->input->post('role_name'));
        
        if (strtolower($role_name) === 'admin') {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Cannot create Admin role']);
            return;
        }
        
        if (empty($role_name)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Role name is required']);
            return;
        }
        
        $result = $this->hospital_users_model->create_role($role_name);
        
        header('Content-Type: application/json');
        echo json_encode($result);
    }
    public function get_roles()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        if (!is_hospital_administrator() && !has_permission('hospital_users', '', 'view')) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'No permission']);
            return;
        }
        
        $roles = $this->hospital_users_model->get_roles_with_count();
        
        header('Content-Type: application/json');
        echo json_encode($roles);
    }
    public function get_role_permissions($role_id)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        if (!is_hospital_administrator() && !has_permission('hospital_users', '', 'view')) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'No permission']);
            return;
        }
        
        $permissions = $this->hospital_users_model->get_role_permissions($role_id);
        
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'permissions' => $permissions]);
    }
    public function update_role_permissions()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        if (!is_hospital_administrator() && !has_permission('hospital_users', '', 'edit')) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'No permission']);
            return;
        }
        
        $role_id = $this->input->post('role_id');
        $permissions = $this->input->post('permissions');
        
        if ($role_id == 6) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Cannot modify Admin role permissions']);
            return;
        }
        
        $result = $this->hospital_users_model->update_role_permissions($role_id, $permissions);
        
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    // ==========================================
    // APPOINTMENTS MANAGEMENT - SIMPLIFIED
    // ==========================================
    
    /**
     * GET: View appointments page with data
     */
    public function appointments()
    {
        if (!is_receptionist() && !has_permission('reception_management', '', 'view')) {
            access_denied('Appointments Management');
        }
        
        $data['title'] = 'Appointments Management';
        $data['appointments'] = $this->hospital_appointments_model->get_all();
        $data['statistics'] = $this->hospital_appointments_model->get_statistics();
        $data['consultants'] = $this->hospital_appointments_model->get_consultants();
        $data['patient_types'] = $this->hospital_patients_model->get_patient_types();
        $data['patients'] = $this->hospital_appointments_model->get_patients_for_dropdown();
        
        $this->load->view('appointments', $data);
    }
    
 public function save_appointment()
{
    if (!$this->input->is_ajax_request()) {
        show_404();
    }

    $this->load->model('hospital_appointments_model');
    
    $post = $this->input->post();
    // Access the value:
    $reason = $data['reason_for_appointment'];
    // ========== BUILD APPOINTMENT DATA ARRAY ==========
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
        
        // Visit detail fields
        'symptoms'               => $post['symptoms'] ?? null,
        'referred_by'            => $post['referred_by'] ?? null,
        'temperature'            => $post['temperature'] ?? null,
        'blood_pressure'         => $post['blood_pressure'] ?? null,
        'pulse_rate'             => $post['pulse_rate'] ?? null,
        'weight'                 => $post['weight'] ?? null,
        'fee_payment_status'     => $post['fee_payment_status'] ?? 'pending',
        'fee_amount'             => $post['fee_amount'] ?? null,
        'payment_method'         => $post['payment_method'] ?? null,
        'follow_up_required'     => isset($post['follow_up_required']) ? 1 : 0,
        'follow_up_date'         => $post['follow_up_date'] ?? null,
    ];

    // ========== BUILD PATIENT DATA ARRAY (only for new patients) ==========
    $patient_data = [];
    
    if (isset($post['is_new_patient']) && $post['is_new_patient'] == 1) {
        if (!empty($post['name']) || !empty($post['mobile_number'])) {
            $patient_data = [
                'name'                      => $post['name'] ?? '',
                'gender'                    => $post['gender'] ?? '',
                'age'                       => $post['age'] ?? null,
                'dob'                       => $post['dob'] ?? null,
                'patient_type'              => $post['patient_type'] ?? 'Regular',
                'mobile_number'             => $post['mobile_number'] ?? '',
                'phone'                     => $post['phone'] ?? null,
                'email'                     => $post['email'] ?? null,
                'address'                   => $post['address'] ?? null,
                'address_landmark'          => $post['address_landmark'] ?? null,
                'city'                      => $post['city'] ?? null,
                'state'                     => $post['state'] ?? null,
                'pincode'                   => $post['pincode'] ?? null,
                'registered_other_hospital' => $post['registered_other_hospital'] ?? 0,
                'other_hospital_patient_id' => $post['other_hospital_patient_id'] ?? null,
                'fee_payment'               => $post['fee_payment'] ?? 'not_applicable',
                'recommended_to_hospital'   => $post['recommended_to_hospital'] ?? 0,
                'recommended_by'            => $post['recommended_by'] ?? null,
                'has_membership'            => $post['has_membership'] ?? 0,
                'membership_type'           => $post['membership_type'] ?? null,
                'membership_number'         => $post['membership_number'] ?? null,
                'membership_expiry_date'    => $post['membership_expiry_date'] ?? null,
                'membership_notes'          => $post['membership_notes'] ?? null,
            ];
        }
    }

    // ========== HANDLE FILE UPLOADS ==========
    $files = [];
    if (!empty($_FILES['recommendation_file']['name'][0])) {
        $files['recommendation_file'] = $_FILES['recommendation_file'];
    }

    // ========== CALL MODEL ==========
    $result = $this->hospital_appointments_model->save($appointment_data, $patient_data, $files);

    // ========== RETURN JSON RESPONSE ==========
    echo json_encode([
        'success'           => $result['success'],
        'message'           => $result['message'],
        'id'                => $result['id'] ?? null,
        'appointment_number' => $result['appointment_number'] ?? null,
        'csrf_token_name'   => $this->security->get_csrf_token_name(),
        'csrf_token_hash'   => $this->security->get_csrf_hash(),
    ]);
}
     /**
     * Get patients for dropdown (AJAX)
     */
    public function get_patients_dropdown()
    {
        if (!has_permission('hospital_management', '', 'view')) {
            echo json_encode(['success' => false, 'message' => 'Access denied']);
            return;
        }
        
        $search = $this->input->get('search', true);
        
        $this->load->model('hospital_appointments_model');
        $patients = $this->hospital_appointments_model->get_patients_for_dropdown($search);
        
        echo json_encode([
            'success' => true,
            'patients' => $patients
        ]);
    }
    
  
    /**
     * Get patient details via AJAX
     */
    public function get_patient_details($patient_id)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        if (!is_receptionist() && !has_permission('reception_management', '', 'view')) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'No permission']);
            return;
        }
        
        $patient = $this->hospital_patients_model->get($patient_id);
        $documents = $this->hospital_patients_model->get_patient_documents($patient_id);
        
        if ($patient) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'patient' => $patient,
                'documents' => $documents
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Patient not found'
            ]);
        }
    }
    
/**
 * Save/Update patient information
 */
public function save_patient()
{
    if (!$this->input->is_ajax_request()) {
        show_404();
    }
    
    if (!is_receptionist() && !has_permission('reception_management', '', 'edit')) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'No permission']);
        return;
    }
    
    $patient_id = $this->input->post('id');
    
    $data = [
        'name'                      => $this->input->post('name'),
        'gender'                    => $this->input->post('gender'),
        'dob'                       => $this->input->post('dob'),
        'age'                       => $this->input->post('age'),
        'address'                   => $this->input->post('address'),
        'address_landmark'          => $this->input->post('address_landmark'),
        'city'                      => $this->input->post('city'),
        'state'                     => $this->input->post('state'),
        'pincode'                   => $this->input->post('pincode'),
        'phone'                     => $this->input->post('phone'),
        'mobile_number'             => $this->input->post('mobile_number'),
        'email'                     => $this->input->post('email'),
        'reason_for_appointment'    => $this->input->post('reason_for_appointment'),
        'patient_type'              => $this->input->post('patient_type'),
        'fee_payment'               => $this->input->post('fee_payment'),
    ];
    
    $result = $this->hospital_patients_model->update_patient_info($patient_id, $data);
    
    header('Content-Type: application/json');
    echo json_encode($result);
}
  /**
 * Download patient document (QUICK FIX)
 */
public function download_document($document_id = null)
{
    $document_id = intval($document_id);
    
    if ($document_id <= 0) {
        show_404();
    }
    
    $this->load->model('hospital_patients_model');
    $document = $this->hospital_patients_model->get_document_file($document_id);
    
    if (!$document) {
        show_404();
    }
    
    $this->load->helper('download');
    force_download($document->original_filename, $document->file_data);
}
    
    /**
     * Delete patient document
     */
    public function delete_document($document_id)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        if (!is_receptionist() && !has_permission('reception_management', '', 'delete')) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'No permission']);
            return;
        }
        
        $result = $this->hospital_patients_model->delete_document($document_id);
        
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    
/**
 * Manage patient (edit patient form)
 * Shows the patient edit form with document management
 */
public function manage_patient($id = null)
{
    if (!$id) {
        redirect(admin_url('hospital_management/patient_records'));
    }
    
    if (!is_receptionist() && !has_permission('reception_management', '', 'view')) {
        access_denied('Patient Records');
    }
    
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
 * Shows complete patient information with documents and appointment history
 */
public function view_patient($id)
{
    if (!is_receptionist() && !has_permission('reception_management', '', 'view')) {
        access_denied('Patient Records');
    }
    
    $data['patient'] = $this->hospital_patients_model->get($id);
    
    if (!$data['patient']) {
        show_404();
    }
    
    $data['title'] = 'Patient Details - ' . $data['patient']->name;
    
    $this->load->view('view_patient', $data);
}
    
    /**
     * Confirm appointment
     */
    public function confirm_appointment($id)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $result = $this->hospital_appointments_model->confirm($id);
        
        header('Content-Type: application/json');
        echo json_encode($result);
    }
    
    /**
     * Cancel appointment
     */
    public function cancel_appointment()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $id = $this->input->post('id');
        $reason = $this->input->post('reason');
        
        $result = $this->hospital_appointments_model->cancel($id, $reason);
        
        header('Content-Type: application/json');
        echo json_encode($result);
    }
    
    /**
     * Delete appointment
     */
    public function delete_appointment($id)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $result = $this->hospital_appointments_model->delete($id);
        
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    /**
     * Patient Records Management
     */
    public function patient_records()
    {
        if (!is_receptionist() && !has_permission('reception_management', '', 'view')) {
            access_denied('Patient Records');
        }
        
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
     * Delete patient
     */
    public function delete_patient($id)
    {
        if (!$this->input->is_ajax_request() || $this->input->method() !== 'post') {
            show_404();
        }
        
        if (!is_hospital_administrator() && !has_permission('hospital_patients', '', 'delete')) {
            echo json_encode(['success' => false, 'message' => 'Access denied']);
            return;
        }
        
        $result = $this->hospital_patients_model->delete($id);
        
        echo json_encode($result);
    }
// consultant
// ============================================
  
 public function consultant_appointments()
{
    // Admin can access via permissions, Consultant/JC via role
    if (!is_consultant_or_jc() && !has_permission('consultant_portal', '', 'view')) {
        access_denied('Consultant Portal');
    }
    
    $this->load->model('consultant_portal_model');
    
    $staff_id = get_staff_user_id();
    $is_jc = is_junior_consultant();
    
    // If admin (not consultant/jc), treat as JC (see all)
    if (!is_consultant_or_jc() && has_permission('consultant_portal', '', 'view')) {
        $is_jc = true;
    }
    
    // Fetch appointments and statistics
    $data['appointments'] = $this->consultant_portal_model->get_appointments($staff_id, $is_jc);
    $data['statistics'] = $this->consultant_portal_model->get_statistics($staff_id, $is_jc);
    $data['title'] = 'My Appointments';
    $data['is_jc'] = $is_jc;
    
    $this->load->view('consultant_appointments', $data);
}
    
    /**
     * Get appointments (AJAX)
     */
    public function get_consultant_appointments()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        // Admin can access via permissions, Consultant/JC via role
        if (!is_consultant_or_jc() && !has_permission('consultant_portal', '', 'view')) {
            echo json_encode(['success' => false, 'message' => 'Access denied']);
            return;
        }
        
        $this->load->model('consultant_portal_model');
        
        $staff_id = get_staff_user_id();
        $is_jc = is_junior_consultant();
        
        // If admin (not consultant/jc), treat as JC (see all)
        if (!is_consultant_or_jc() && has_permission('consultant_portal', '', 'view')) {
            $is_jc = true; // Admin sees all
        }
        
        $appointments = $this->consultant_portal_model->get_appointments($staff_id, $is_jc);
        
        echo json_encode(['success' => true, 'data' => $appointments]);
    }
    
   /**
 * Get single appointment (AJAX)
 */
public function get_appointment_details($id)
{
    if (!$this->input->is_ajax_request()) {
        show_404();
    }
    
    // Admin can access via permissions, Consultant/JC via role
    if (!is_consultant_or_jc() && !has_permission('consultant_portal', '', 'view')) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Access denied']);
        return;
    }
    
    $this->load->model('consultant_portal_model');
    
    $appointment = $this->consultant_portal_model->get($id);
    
    if (!$appointment) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Appointment not found']);
        return;
    }
    
    // Consultant can only see their own (JC and Admin see all)
    if (is_consultant() && !is_junior_consultant() && !has_permission('consultant_portal', '', 'view')) {
        if (!$this->consultant_portal_model->can_access($id, get_staff_user_id())) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Access denied to this appointment']);
            return;
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'data' => $appointment]);
}
    /**
 * Confirm appointment (Consultant Portal)
 */
public function confirm_consultant_appointment($id)
{
    if (!$this->input->is_ajax_request()) {
        show_404();
    }
    
    // Check access - Admin OR Consultant/JC
    if (!is_consultant_or_jc() && !has_permission('consultant_portal', '', 'view')) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Access denied']);
        return;
    }
    
    $this->load->model('consultant_portal_model');
    
    // If consultant (not JC), verify they own this appointment
    if (is_consultant() && !is_junior_consultant() && !has_permission('consultant_portal', '', 'view')) {
        if (!$this->consultant_portal_model->can_access($id, get_staff_user_id())) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'You do not have access to this appointment']);
            return;
        }
    }
    
    // Use the appointments model to confirm
    $result = $this->hospital_appointments_model->confirm($id);
    
    header('Content-Type: application/json');
    echo json_encode($result);
}

/**
 * Reject appointment (Consultant Portal)
 */
public function reject_consultant_appointment()
{
    if (!$this->input->is_ajax_request()) {
        show_404();
    }
    
    // Check access - Admin OR Consultant/JC
    if (!is_consultant_or_jc() && !has_permission('consultant_portal', '', 'view')) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Access denied']);
        return;
    }
    
    $id = $this->input->post('id');
    $reason = $this->input->post('reason');
    
    if (empty($id)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Appointment ID is required']);
        return;
    }
    
    $this->load->model('consultant_portal_model');
    
    // If consultant (not JC), verify they own this appointment
    if (is_consultant() && !is_junior_consultant() && !has_permission('consultant_portal', '', 'view')) {
        if (!$this->consultant_portal_model->can_access($id, get_staff_user_id())) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'You do not have access to this appointment']);
            return;
        }
    }
    
    // Use cancel method with reason
    $result = $this->hospital_appointments_model->cancel($id, $reason);
    
    header('Content-Type: application/json');
    echo json_encode($result);
}

/**
 * Delete appointment (Consultant Portal)
 */
public function delete_consultant_appointment($id)
{
    if (!$this->input->is_ajax_request()) {
        show_404();
    }
    
    // Check access - Admin OR JC only (regular consultants cannot delete)
    if (!is_junior_consultant() && !has_permission('consultant_portal', '', 'delete')) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Only Junior Consultants and Admins can delete appointments']);
        return;
    }
    
    // Perform deletion
    $result = $this->hospital_appointments_model->delete($id);
    
    header('Content-Type: application/json');
    echo json_encode($result);
}

/**
 * Get consultant statistics (AJAX)
 */
public function get_consultant_statistics()
{
    if (!$this->input->is_ajax_request()) {
        show_404();
    }
    
    // Check access
    if (!is_consultant_or_jc() && !has_permission('consultant_portal', '', 'view')) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Access denied']);
        return;
    }
    
    $this->load->model('consultant_portal_model');
    
    $staff_id = get_staff_user_id();
    $is_jc = is_junior_consultant();
    
    // If admin (not consultant/jc), treat as JC (see all)
    if (!is_consultant_or_jc() && has_permission('consultant_portal', '', 'view')) {
        $is_jc = true;
    }
    
    $stats = $this->consultant_portal_model->get_statistics($staff_id, $is_jc);
    
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'data' => $stats]);
}
// Visit Management
public function visits()
{
    if (!has_permission('hospital_management', '', 'view')) {
        access_denied('Hospital Management');
    }
    
    $this->load->model('hospital_visits_model');
    
    $data['visits'] = $this->hospital_visits_model->get_all();
    $data['title'] = 'Visit Records';
    
    $this->load->view('hospital_management/visits', $data);
}

public function manage_visit($id = '')
{
    if (!has_permission('hospital_management', '', 'create')) {
        access_denied('Hospital Management');
    }
    
    $this->load->model('hospital_visits_model');
    $this->load->model('hospital_patients_model');
    $this->load->model('hospital_appointments_model');
    
    if ($id) {
        $data['visit'] = $this->hospital_visits_model->get($id);
        $data['visit_details'] = $this->hospital_visits_model->get_visit_details($id);
    }
    
    $data['patients'] = $this->hospital_patients_model->get_all();
    $data['consultants'] = $this->hospital_appointments_model->get_consultants();
    $data['title'] = $id ? 'Edit Visit' : 'Create Visit';
    
    $this->load->view('hospital_management/manage_visit', $data);
}

public function save_visit()
{
    if (!has_permission('hospital_management', '', 'create')) {
        ajax_access_denied();
    }
    
    $this->load->model('hospital_visits_model');
    
    $data = $this->input->post();
    $details_data = $this->input->post('details');
    
    $result = $this->hospital_visits_model->save($data, $details_data);
    
    echo json_encode($result);
}

/**
 * Consultant: See Patient (Load Visit Form)
 */
public function consultant_see_patient($appointment_id = '')
{
    if (!$this->check_consultant_access()) {
        access_denied('Consultant Portal');
    }
    
    if (empty($appointment_id)) {
        redirect(admin_url('hospital_management/consultant_appointments'));
    }
    
    // Load models
    $this->load->model('consultant_portal_model');
    $this->load->model('hospital_visits_model');
    $this->load->model('hospital_patients_model');
    
    // Check access permission
    if (!$this->consultant_portal_model->can_access($appointment_id, get_staff_user_id())) {
        access_denied('This appointment is not assigned to you');
    }
    
    // Get appointment details
    $data['appointment'] = $this->consultant_portal_model->get($appointment_id);
    
    if (!$data['appointment']) {
        set_alert('danger', 'Appointment not found');
        redirect(admin_url('hospital_management/consultant_appointments'));
    }
    
    // Get or create visit record
    $visit = $this->consultant_portal_model->get_visit_by_appointment($appointment_id);
    
    if ($visit) {
        $data['visit'] = $visit;
        $data['visit_details'] = $this->hospital_visits_model->get_visit_details($visit['id']);
    } else {
        // Create visit if doesn't exist
        $visit_data = [
            'patient_id' => $data['appointment']['patient_id'],
            'appointment_id' => $appointment_id,
            'consultant_id' => $data['appointment']['consultant_id'],
            'visit_date' => $data['appointment']['appointment_date'],
            'visit_time' => $data['appointment']['appointment_time'],
            'visit_type' => $data['appointment']['patient_mode'] === 'walk_in' ? 'walk_in' : 'appointment',
            'reason' => $data['appointment']['reason_for_appointment'],
            'status' => 'ongoing'
        ];
        
        $result = $this->hospital_visits_model->save($visit_data);
        
        if ($result['success']) {
            $data['visit'] = $this->hospital_visits_model->get($result['id']);
            $data['visit_details'] = null;
        }
    }
    
    // Get patient types for dropdown
    $data['patient_types'] = $this->hospital_patients_model->get_patient_types();
    
    $data['title'] = 'See Patient - ' . $data['appointment']['patient_name'];
    $this->load->view('consultant/see_patient', $data);
}

/**
 * Consultant: Save Visit Details (AJAX)
 */
public function consultant_save_visit()
{
    if (!$this->check_consultant_access()) {
        echo json_encode(['success' => false, 'message' => 'Access denied']);
        return;
    }
    
    $this->load->model('hospital_visits_model');
    
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
        $this->load->model('hospital_appointments_model');
        $this->hospital_appointments_model->confirm($appointment_id); // Or create a complete method
    }
    
    echo json_encode($result);
}
// ==========================================
// Helper function 
// ==========================================
// Check email availability (AJAX)  
    public function check_email()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $email = $this->input->post('email');
        $user_id = $this->input->post('user_id');
        
        $exists = $this->hospital_users_model->email_exists($email, $user_id);
        
        header('Content-Type: application/json');
        echo json_encode(['available' => !$exists]);
    }

    public function roles()
{
    if (!is_hospital_administrator() && !has_permission('hospital_users', '', 'view')) {
        access_denied('Hospital Management');
    }
    
    $this->load->model('roles_model');
    $all_roles = $this->roles_model->get();
    
    $roles_with_count = [];
    foreach ($all_roles as $role) {
        $this->db->where('role_id', $role['roleid']);
        $this->db->where('active', 1);
        $count = $this->db->count_all_results(db_prefix() . 'hospital_users');
        
        $role['total_users'] = $count;
        $roles_with_count[] = $role;
    }
    
    $data['title'] = 'Role Management';
    $data['roles'] = $roles_with_count;
    $this->load->view('roles', $data);
}
public function delete_role($role_id)
{
    if (!$this->input->is_ajax_request()) {
        show_404();
    }
    
    if (!is_hospital_administrator() && !has_permission('hospital_users', '', 'delete')) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'No permission to delete roles']);
        return;
    }
    
    // Cannot delete Admin role
    if ($role_id == 1) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Cannot delete Admin role']);
        return;
    }
    
    // Check if role has users
    $this->db->where('role_id', $role_id);
    $this->db->where('active', 1);
    $user_count = $this->db->count_all_results(db_prefix() . 'hospital_users');
    
    if ($user_count > 0) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Cannot delete role with assigned users. Please reassign users first.']);
        return;
    }
    
    // Delete role
    $this->load->model('roles_model');
    $deleted = $this->roles_model->delete($role_id);
    
    if ($deleted) {
        log_activity('Hospital Role Deleted [ID: ' . $role_id . ']');
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Role deleted successfully']);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Failed to delete role']);
    }
}
}