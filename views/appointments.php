<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<style>
/* =====================================================
   HOSPITAL THEME - AQUA BLUE & WHITE
   ===================================================== */
:root {
    --hospital-primary: #00ACC1;
    --hospital-primary-dark: #0097A7;
    --hospital-primary-light: #B2EBF2;
    --hospital-secondary: #FFFFFF;
    --hospital-success: #26A69A;
    --hospital-warning: #FF9800;
    --hospital-danger: #E53935;
    --hospital-info: #42A5F5;
    --hospital-border: #E0F7FA;
}

/* =====================================================
   VALIDATION STYLING - RED/GREEN BORDERS
   ===================================================== */
.form-control.is-invalid {
    border-color: #E53935 !important;
    border-width: 2px !important;
    box-shadow: 0 0 0 0.2rem rgba(229, 57, 53, 0.25) !important;
    background-color: #FFEBEE !important;
}

.form-control.is-valid {
    border-color: #26A69A !important;
    border-width: 2px !important;
    box-shadow: 0 0 0 0.2rem rgba(38, 166, 154, 0.25) !important;
    background-color: #E0F2F1 !important;
}

.error-message {
    color: #E53935;
    font-size: 11px;
    margin-top: 3px;
    display: block;
    font-weight: 500;
}

.success-message {
    color: #26A69A;
    font-size: 11px;
    margin-top: 3px;
    display: block;
    font-weight: 500;
}

/* Remove spinner from number inputs */
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type="number"] {
    -moz-appearance: textfield;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: linear-gradient(135deg, #FFFFFF 0%, #E0F7FA 100%);
    border-left: 4px solid var(--hospital-primary);
    border-radius: 4px;
    padding: 10px;
    box-shadow: 0 2px 4px rgba(0, 172, 193, 0.1);
    transition: all 0.3s ease;
}

.stat-card:hover {
    box-shadow: 0 4px 12px rgba(0, 172, 193, 0.2);
    transform: translateY(-2px);
}

.stat-card i {
    font-size: 28px;
    color: var(--hospital-primary);
    margin-bottom: 10px;
    display: block;
}

.stat-card h3 {
    font-size: 32px;
    font-weight: 700;
    margin: 8px 0;
    color: #263238;
}

.stat-card p {
    font-size: 13px;
    color: #546E7A;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-card.today { border-left-color: var(--hospital-info); }
.stat-card.today i { color: var(--hospital-info); }
.stat-card.pending { border-left-color: var(--hospital-warning); }
.stat-card.pending i { color: var(--hospital-warning); }
.stat-card.confirmed { border-left-color: var(--hospital-success); }
.stat-card.confirmed i { color: var(--hospital-success); }

/* Header Section */
.appointment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid var(--hospital-border);
}

.appointment-header h3 {
    color: var(--hospital-primary);
    font-weight: 600;
    margin: 0;
}

.appointment-header h3 i {
    margin-right: 10px;
}

/* Button Styling */
.btn-new-appointment {
    background: var(--hospital-primary);
    color: #fff;
    padding: 12px 24px;
    border-radius: 4px;
    text-decoration: none;
    border: none;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 172, 193, 0.3);
}

.btn-new-appointment:hover {
    background: var(--hospital-primary-dark);
    color: #fff;
    text-decoration: none;
    box-shadow: 0 4px 8px rgba(0, 172, 193, 0.4);
    transform: translateY(-1px);
}

.btn-new-appointment i {
    margin-right: 8px;
}

.modal-lg {
    max-width: 900px;
}

/* Modal Styling */
.modal-header {
    background: linear-gradient(135deg, var(--hospital-primary) 0%, var(--hospital-primary-dark) 100%);
    color: white;
    border-radius: 4px 4px 0 0;
}

.modal-header .modal-title {
    font-weight: 600;
}

.modal-header .close {
    color: white;
    opacity: 0.8;
}

.modal-header .close:hover {
    opacity: 1;
}

/* Form Sections */
.patient-type-section {
    background: linear-gradient(135deg, #E0F7FA 0%, #B2EBF2 100%);
    padding: 18px;
    border-radius: 4px;
    margin-bottom: 20px;
    border: 1px solid var(--hospital-border);
}

.form-section-divider {
    border-top: 2px solid var(--hospital-border);
    margin: 25px 0;
    padding-top: 20px;
}

.patient-search-info {
    background: #E1F5FE;
    padding: 12px 15px;
    border-radius: 4px;
    margin-bottom: 15px;
    font-size: 13px;
    color: #01579B;
    border-left: 3px solid var(--hospital-info);
}

.form-section-title {
    font-size: 15px;
    font-weight: 600;
    color: var(--hospital-primary);
    margin-bottom: 15px;
    padding-bottom: 8px;
    border-bottom: 2px solid var(--hospital-border);
}

/* Action Buttons */
.btn-success {
    background: var(--hospital-success);
    border-color: var(--hospital-success);
}

.btn-success:hover {
    background: #1E7C6E;
    border-color: #1E7C6E;
}

.btn-warning {
    background: var(--hospital-warning);
    border-color: var(--hospital-warning);
}

.btn-danger {
    background: var(--hospital-danger);
    border-color: var(--hospital-danger);
}

.btn-primary {
    background: var(--hospital-primary);
    border-color: var(--hospital-primary);
}

.btn-primary:hover {
    background: var(--hospital-primary-dark);
    border-color: var(--hospital-primary-dark);
}

/* Form Controls */
.form-control:focus {
    border-color: var(--hospital-primary);
    box-shadow: 0 0 0 0.2rem rgba(0, 172, 193, 0.25);
}

.selectpicker.btn-default:focus {
    border-color: var(--hospital-primary) !important;
    box-shadow: 0 0 0 0.2rem rgba(0, 172, 193, 0.25) !important;
}

/* Table Styling */
.panel_s {
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 172, 193, 0.08);
}

.table thead {
    background: linear-gradient(135deg, #E0F7FA 0%, #B2EBF2 100%);
}

.table thead th {
    color: var(--hospital-primary-dark);
    font-weight: 600;
    border-bottom: 2px solid var(--hospital-primary);
}

/* Alert Messages */
.alert-info {
    background: #E1F5FE;
    border-color: var(--hospital-info);
    color: #01579B;
}

/* Modal Footer */
.modal-footer {
    border-top: 2px solid var(--hospital-border);
}

/* Time Picker */
.time-picker-container {
    display: flex;
    gap: 10px;
    align-items: center;
}

.time-section {
    flex: 1;
}

.time-section label {
    display: block;
    margin-bottom: 5px;
    font-size: 12px;
    color: #666;
}

.time-buttons {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 5px;
}

.time-btn {
    padding: 8px 5px;
    border: 1px solid #ddd;
    background: #fff;
    border-radius: 4px;
    cursor: pointer;
    font-size: 13px;
    transition: all 0.2s;
}

.time-btn:hover {
    background: #f5f5f5;
    border-color: #999;
}

.time-btn.selected {
    background: #333;
    color: #fff;
    border-color: #333;
}

.time-separator {
    font-size: 24px;
    font-weight: bold;
    padding-top: 20px;
}

.selected-time-display {
    background: #e8f5e9;
    padding: 10px;
    border-radius: 4px;
    margin-top: 10px;
    text-align: center;
    font-weight: 600;
    color: #2e7d32;
}
</style>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="appointment-header">
                    <h3><i class="fa fa-calendar-check-o"></i> Manage Appointments</h3>
                    <button class="btn-new-appointment" data-toggle="modal" data-target="#appointmentModal">
                        <i class="fa fa-plus"></i> Create Appointment
                    </button>
                </div>
                
                <!-- Statistics -->
                <div class="stats-grid">
                    <div class="stat-card today">
                        <h3><?php echo $statistics['today']; ?></h3>
                        <p>Today's Appointments</p>
                    </div>
                    
                    <div class="stat-card pending">
                        <h3><?php echo $statistics['pending']; ?></h3>
                        <p>Pending</p>
                    </div>
                    
                    <div class="stat-card confirmed">
                        <h3><?php echo $statistics['confirmed']; ?></h3>
                        <p>Confirmed</p>
                    </div>
                    
                    <div class="stat-card">
                        <h3><?php echo $statistics['total']; ?></h3>
                        <p>Total Appointments</p>
                    </div>
                </div>
                
                <!-- Appointments Table -->
                <div class="panel_s">
                    <div class="panel-body">
                        <table class="table dt-table" id="appointments_table">
                            <thead>
                                <tr>
                                    <th>Appointment #</th>
                                    <th>Patient ID</th>
                                    <th>Patient Name</th>
                                    <th>Mobile</th>
                                    <th>Date</th>
                                    <th>Consultant</th>
                                    <th>Reason</th>
                                    <th>Mode</th>
                                    <th>Appointment Time</th>
                                    <th>Time Reported</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($appointments as $apt) { ?>
                                <tr>
                                    <td><strong><?php echo $apt->appointment_number; ?></strong></td>
                                    <td><span class="label label-primary"><?php echo $apt->patient_number; ?></span></td>
                                    <td><?php echo $apt->patient_name; ?></td>
                                    <td>
                                        <a href="tel:<?php echo $apt->patient_mobile; ?>">
                                            <?php echo $apt->patient_mobile; ?>
                                        </a>
                                    </td>
                                    <td><?php echo date('d M Y', strtotime($apt->appointment_date)); ?></td>
                                    <td><?php echo $apt->consultant_firstname . ' ' . $apt->consultant_lastname; ?></td>
                                    <td><?php echo !empty($apt->visit_reason) ? ucfirst($apt->visit_reason) : '-'; ?></td>
                                    <td>
                                        <span class="label label-default">
                                            <?php echo !empty($apt->visit_type) ? ucfirst(str_replace('_', '-', $apt->visit_type)) : '-'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-info">
                                            <i class="fa fa-clock-o"></i> 
                                            <?php echo date('h:i A', strtotime($apt->appointment_time)); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php 
                                        if (!empty($apt->time_reported)) {
                                            echo '<span class="text-success">';
                                            echo '<i class="fa fa-clock-o"></i> ';
                                            echo date('d-M-Y h:i A', strtotime($apt->time_reported));
                                            echo '</span>';
                                        } else {
                                            echo '<span class="text-muted">-</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $status_class = '';
                                        switch($apt->status) {
                                            case 'pending': $status_class = 'label-warning'; break;
                                            case 'confirmed': $status_class = 'label-success'; break;
                                            case 'cancelled': $status_class = 'label-danger'; break;
                                            case 'completed': $status_class = 'label-info'; break;
                                        }
                                        ?>
                                        <span class="label <?php echo $status_class; ?>">
                                            <?php echo ucfirst($apt->status); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($apt->status == 'pending') { ?>
                                        <button class="btn btn-success btn-sm" onclick="confirmAppointment(<?php echo $apt->id; ?>)">
                                            <i class="fa fa-check"></i> Confirm
                                        </button>
                                        <?php } ?>
                                        
                                        <?php if ($apt->status != 'cancelled') { ?>
                                        <button class="btn btn-warning btn-sm" onclick="cancelAppointment(<?php echo $apt->id; ?>)">
                                            <i class="fa fa-ban"></i> Cancel
                                        </button>
                                        <?php } ?>
                                        
                                        <button class="btn btn-danger btn-sm" onclick="deleteAppointment(<?php echo $apt->id; ?>)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Appointment Modal -->
<div class="modal fade" id="appointmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-calendar-plus-o"></i> Create New Appointment</h4>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('', ['id' => 'appointmentForm']); ?>
                    
                    <!-- Hidden Control Fields -->
                    <input type="hidden" name="patient_id" id="patient_id" value="">
                    <input type="hidden" name="is_new_patient" id="is_new_patient" value="1">
                    <input type="hidden" name="patient_mode" id="patient_mode" value="appointment">
                    
                    <!-- Patient Type Selection -->
                    <div class="patient-type-section">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label"><strong>Patient Type:</strong></label>
                                <div>
                                    <label class="radio-inline">
                                        <input type="radio" name="patient_type_option" value="existing" checked>
                                        Existing Patient
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="patient_type_option" value="new">
                                        New Patient
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-6" id="modeSelection" style="display:none;">
                                <label class="control-label"><strong>Appointment Mode:</strong></label>
                                <div>
                                    <label class="radio-inline">
                                        <input type="radio" name="mode_option" value="appointment" checked>
                                        Appointment
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="mode_option" value="walk_in">
                                        Walk-in
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- EXISTING PATIENT SELECTION -->
                    <div id="existingPatientSection" style="display:block;">
                        <div class="patient-search-info">
                            <i class="fa fa-info-circle"></i> 
                            <strong>Search by:</strong> Patient ID (e.g., PAT2025001), Name, or Mobile Number
                        </div>
                        
                        <div class="form-group">
                            <label for="existing_patient_dropdown" class="control-label">Select Patient *</label>
                            <select id="existing_patient_dropdown" class="form-control selectpicker" data-live-search="true">
                                <option value="">-- Type to search patients --</option>
                            </select>
                        </div>
                        
                        <div id="existingPatientModeSection" style="display:none;">
                            <div class="form-group">
                                <label class="control-label"><strong>Appointment Mode:</strong></label>
                                <div>
                                    <label class="radio-inline">
                                        <input type="radio" name="existing_mode_option" value="appointment" checked>
                                        Appointment
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="existing_mode_option" value="walk_in">
                                        Walk-in
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- PATIENT FORM -->
                    <div id="patientFormSection" style="display:none;">
                        <div class="alert alert-info" id="formModeInfo">
                            <i class="fa fa-info-circle"></i> <span id="formModeText">Quick registration</span>
                        </div>
                        
                        <!-- Basic Information -->
                        <div class="form-section-title"><i class="fa fa-user"></i> Basic Information</div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Name <span class="text-danger" id="name_required">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Full name" maxlength="100">
                                    <small class="text-muted">Letters and spaces only, 3-100 characters</small>
                                    <span class="feedback-message" id="name_feedback"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group" id="gender_group">
                                    <label class="control-label">Gender <span class="text-danger" id="gender_required">*</span></label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="">Select</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group" id="age_group">
                                    <label class="control-label">Age</label>
                                    <input type="number" name="age" id="age" class="form-control" min="0" max="150">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row" id="extended_basic_fields">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Date of Birth</label>
                                    <input type="date" name="dob" id="dob" class="form-control" max="<?php echo date('Y-m-d'); ?>">
                                    <small class="text-muted">Cannot be a future date</small>
                                    <span class="feedback-message" id="dob_feedback"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label">Patient Type <span class="text-danger" id="patient_type_required">*</span></label>
                                    <select name="patient_type" id="patient_type" class="form-control">
                                        <option value="Regular">Regular</option>
                                        <?php 
                                        $this->load->model('hospital_patients_model');
                                        $patient_types = $this->hospital_patients_model->get_patient_types();
                                        foreach ($patient_types as $type) {
                                            echo '<option value="' . $type['type_name'] . '">' . $type['type_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Contact Details -->
                        <div class="form-section-title" id="contact_section"><i class="fa fa-phone"></i> Contact Details</div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Mobile <span class="text-danger" id="mobile_required">*</span></label>
                                    <input type="tel" name="mobile_number" id="mobile_number" class="form-control" maxlength="10" placeholder="10-digit mobile">
                                    <small class="text-muted">10 digits, starts with 6-9</small>
                                    <span class="feedback-message" id="mobile_feedback"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-4" id="phone_group">
                                <div class="form-group">
                                    <label class="control-label">Alternate Phone</label>
                                    <input type="tel" name="phone" id="phone" class="form-control" maxlength="10" placeholder="10-digit phone">
                                    <small class="text-muted">10 digits only</small>
                                    <span class="feedback-message" id="phone_feedback"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-4" id="email_group">
                                <div class="form-group">
                                    <label class="control-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" maxlength="100" placeholder="email@example.com">
                                    <small class="text-muted">Valid email format</small>
                                    <span class="feedback-message" id="email_feedback"></span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Address Details -->
                        <div id="address_section">
                            <div class="form-section-title"><i class="fa fa-map-marker"></i> Address Details</div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Address</label>
                                        <textarea name="address" id="address" class="form-control" rows="2" maxlength="250" placeholder="Maximum 250 characters"></textarea>
                                        <small class="text-muted"><span id="address_count">0</span>/250 characters</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Landmark</label>
                                        <input type="text" name="address_landmark" id="address_landmark" class="form-control" maxlength="100">
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">City</label>
                                        <input type="text" name="city" id="city" class="form-control" maxlength="50" placeholder="Letters only">
                                        <small class="text-muted">Letters and spaces only</small>
                                        <span class="feedback-message" id="city_feedback"></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">State</label>
                                        <input type="text" name="state" id="state" class="form-control" maxlength="50" placeholder="Letters only">
                                        <small class="text-muted">Letters and spaces only</small>
                                        <span class="feedback-message" id="state_feedback"></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">Pincode</label>
                                        <input type="text" name="pincode" id="pincode" class="form-control" maxlength="6" placeholder="6 digits">
                                        <small class="text-muted">6 digits only</small>
                                        <span class="feedback-message" id="pincode_feedback"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Other Details -->
                        <div id="other_details_section">
                            <div class="form-section-title"><i class="fa fa-clipboard"></i> Other Details</div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Registered at Other Hospital?</label>
                                        <div>
                                            <label class="radio-inline">
                                                <input type="radio" name="registered_other_hospital" value="1"> Yes
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="registered_other_hospital" value="0" checked> No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6" id="other_hospital_id_section" style="display:none;">
                                    <div class="form-group">
                                        <label class="control-label">Patient ID of Other Hospital</label>
                                        <input type="text" name="other_hospital_patient_id" id="other_hospital_patient_id" 
                                               class="form-control" placeholder="Alphanumeric only" maxlength="50">
                                        <small class="text-muted">Alphanumeric only, max 50 characters</small>
                                        <span class="feedback-message" id="other_hospital_id_feedback"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Fee Payment?</label>
                                        <div>
                                            <label class="radio-inline">
                                                <input type="radio" name="fee_payment" value="yes"> Yes
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="fee_payment" value="no"> No
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="fee_payment" value="not_applicable" checked> N/A
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Recommendation Section -->
                        <div id="recommendation_section">
                            <div class="form-section-title"><i class="fa fa-handshake-o"></i> Recommendation Details</div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Have You Been Recommended To This Hospital?</label>
                                        <div>
                                            <label class="radio-inline">
                                                <input type="radio" name="recommended_to_hospital" value="1" class="recommendation_toggle"> Yes
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="recommended_to_hospital" value="0" class="recommendation_toggle" checked> No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="recommendation_details" style="display:none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Recommended By</label>
                                            <input type="text" name="recommended_by" id="recommended_by" class="form-control" maxlength="100" placeholder="Name (letters only)">
                                            <small class="text-muted">Letters and spaces only</small>
                                            <span class="feedback-message" id="recommended_by_feedback"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Recommendation File (Multiple files allowed)</label>
                                            <input type="file" name="recommendation_file[]" id="recommendation_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" multiple>
                                            <small class="text-muted">Max 5MB per file, PDF/JPG/PNG/DOC/DOCX only</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Membership Section -->
                        <div id="membership_section">
                            <div class="form-section-title"><i class="fa fa-id-card"></i> Membership (Optional)</div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Membership ID</label>
                                        <input type="text" 
                                            name="membership_id" 
                                            id="membership_id" 
                                            class="form-control" 
                                            placeholder="e.g., MEM2025001"
                                            maxlength="50">
                                        <small class="text-muted">Alphanumeric only, max 50 characters</small>
                                        <span class="feedback-message" id="membership_id_feedback"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- APPOINTMENT DETAILS -->
                    <div class="form-section-divider"></div>
                    <h5 style="margin-bottom: 15px; color: #333;"><i class="fa fa-calendar"></i> Appointment Details</h5>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="reason_for_appointment" class="control-label">Reason for Appointment *</label>
                                <select id="reason_for_appointment" name="reason_for_appointment" class="form-control selectpicker" data-width="100%" required>
                                    <option value="">-- Select --</option>
                                    <option value="consultation">Consultation</option>
                                    <option value="procedure">Procedure</option>
                                    <option value="surgery">Surgery</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="appointment_date" class="control-label">Appointment Date *</label>
                                <select id="appointment_date" name="appointment_date" class="form-control" required>
                                    <option value="">-- Select Date --</option>
                                    <?php
                                    for ($i = 0; $i < 15; $i++) {
                                        $date = date('Y-m-d', strtotime("+$i days"));
                                        $display = date('d-M-Y', strtotime("+$i days"));
                                        echo '<option value="' . $date . '">' . $display . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Time Picker -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Appointment Time *</label>
                                <input type="hidden" id="appointment_time" name="appointment_time" required>
                                
                                <div class="time-picker-container">
                                    <div class="time-section">
                                        <label>Hour</label>
                                        <div class="time-buttons" id="hourButtons">
                                            <?php for ($h = 0; $h < 24; $h++): ?>
                                            <button type="button" class="time-btn" data-hour="<?php echo str_pad($h, 2, '0', STR_PAD_LEFT); ?>">
                                                <?php echo str_pad($h, 2, '0', STR_PAD_LEFT); ?>
                                            </button>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="time-separator">:</div>
                                    
                                    <div class="time-section">
                                        <label>Minute</label>
                                        <div class="time-buttons" id="minuteButtons">
                                            <?php for ($m = 0; $m < 60; $m += 5): ?>
                                            <button type="button" class="time-btn" data-minute="<?php echo str_pad($m, 2, '0', STR_PAD_LEFT); ?>">
                                                <?php echo str_pad($m, 2, '0', STR_PAD_LEFT); ?>
                                            </button>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="time-separator">:</div>
                                    
                                    <div class="time-section">
                                        <label>Second</label>
                                        <div class="time-buttons" id="secondButtons">
                                            <button type="button" class="time-btn selected" data-second="00">00</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="selected-time-display" id="timeDisplay" style="display:none;">
                                    Selected Time: <span id="displayTime">--:--:--</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Consultant -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="consultant_id" class="control-label">
                                    <span class="text-danger">*</span> Consultant
                                </label>
                                <select name="consultant_id" id="consultant_id" 
                                        class="form-control selectpicker" 
                                        data-live-search="true" 
                                        data-width="100%" 
                                        required>
                                    <option value="">Select Consultant</option>
                                    <?php foreach ($consultants as $consultant): ?>
                                        <option value="<?php echo $consultant['staff_id']; ?>">
                                            <?php echo htmlspecialchars($consultant['full_name']); ?>
                                            <?php if (!empty($consultant['email'])): ?>
                                                - <?php echo htmlspecialchars($consultant['email']); ?>
                                            <?php endif; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="notes" class="control-label">Notes (Optional)</label>
                                <textarea id="notes" name="notes" class="form-control" rows="2" placeholder="Additional notes" maxlength="500"></textarea>
                                <small class="text-muted"><span id="notes_count">0</span>/500 characters</small>
                            </div>
                        </div>
                    </div>
                    
                <?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="button" id="saveAppointmentBtn" class="btn btn-primary">
                    <i class="fa fa-check"></i> Create Appointment
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cancel Appointment</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="cancel_appointment_id">
                <div class="form-group">
                    <label>Cancellation Reason:</label>
                    <textarea id="cancellation_reason" class="form-control" rows="3" placeholder="Enter reason" maxlength="250"></textarea>
                    <small class="text-muted"><span id="cancel_count">0</span>/250 characters</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" onclick="submitCancellation()">
                    <i class="fa fa-ban"></i> Cancel Appointment
                </button>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>

<script>
// ============================================================================
// GLOBALS
// ============================================================================
let csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';
let csrfTokenHash = '<?php echo $this->security->get_csrf_hash(); ?>';

// ============================================================================
// ENHANCED VALIDATION FUNCTIONS WITH VISUAL FEEDBACK
// ============================================================================

/**
 * Show validation feedback (green border + success message OR red border + error message)
 */
function showValidationFeedback(fieldId, isValid, message = '') {
    const $field = $('#' + fieldId);
    const $feedback = $('#' + fieldId + '_feedback');
    
    // Remove previous classes
    $field.removeClass('is-valid is-invalid');
    
    if (isValid) {
        $field.addClass('is-valid');
        if (message) {
            $feedback.removeClass('error-message').addClass('success-message').html('<i class="fa fa-check-circle"></i> ' + message);
        } else {
            $feedback.empty();
        }
    } else {
        $field.addClass('is-invalid');
        if (message) {
            $feedback.removeClass('success-message').addClass('error-message').html('<i class="fa fa-times-circle"></i> ' + message);
        } else {
            $feedback.empty();
        }
    }
}

/**
 * Clear validation feedback
 */
function clearValidationFeedback(fieldId) {
    const $field = $('#' + fieldId);
    const $feedback = $('#' + fieldId + '_feedback');
    
    $field.removeClass('is-valid is-invalid');
    $feedback.empty();
}

/**
 * Validate name - only letters and spaces, 3-100 characters
 */
function validateName(name, fieldId) {
    const trimmed = name.trim();
    
    if (trimmed.length === 0) {
        clearValidationFeedback(fieldId);
        return { valid: false, message: '' };
    }
    
    if (trimmed.length < 3) {
        return { valid: false, message: 'Minimum 3 characters required' };
    }
    
    const nameRegex = /^[a-zA-Z\s]+$/;
    if (!nameRegex.test(trimmed)) {
        return { valid: false, message: 'Only letters and spaces allowed' };
    }
    
    return { valid: true, message: 'Valid name' };
}

/**
 * Enhanced email validation - prevents multiple consecutive dots
 */
function validateEmail(email, fieldId) {
    const trimmed = email.trim();
    
    if (trimmed.length === 0) {
        clearValidationFeedback(fieldId);
        return { valid: true, message: '' }; // Optional field
    }
    
    // Check for multiple consecutive dots
    if (/\.{2,}/.test(trimmed)) {
        return { valid: false, message: 'Multiple consecutive dots not allowed' };
    }
    
    // Check for dots at start or end of local part or domain
    if (/^\.|\.$|@\.|\.@/.test(trimmed)) {
        return { valid: false, message: 'Invalid dot placement' };
    }
    
    // Standard email format validation
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailRegex.test(trimmed)) {
        return { valid: false, message: 'Invalid email format' };
    }
    
    // Check domain has valid structure (no consecutive dots in domain)
    const domain = trimmed.split('@')[1];
    if (domain && /\.{2,}/.test(domain)) {
        return { valid: false, message: 'Invalid domain format' };
    }
    
    return { valid: true, message: 'Valid email' };
}

/**
 * Validate mobile - exactly 10 digits, starts with 6-9
 */
function validateMobile(mobile, fieldId) {
    const trimmed = mobile.trim();
    
    if (trimmed.length === 0) {
        clearValidationFeedback(fieldId);
        return { valid: false, message: '' };
    }
    
    if (trimmed.length < 10) {
        return { valid: false, message: '10 digits required' };
    }
    
    const mobileRegex = /^[6-9]\d{9}$/;
    if (!mobileRegex.test(trimmed)) {
        return { valid: false, message: 'Must start with 6-9 and be 10 digits' };
    }
    
    return { valid: true, message: 'Valid mobile number' };
}

/**
 * Validate phone - exactly 10 digits
 */
function validatePhone(phone, fieldId) {
    const trimmed = phone.trim();
    
    if (trimmed.length === 0) {
        clearValidationFeedback(fieldId);
        return { valid: true, message: '' }; // Optional
    }
    
    if (trimmed.length < 10) {
        return { valid: false, message: '10 digits required' };
    }
    
    const phoneRegex = /^\d{10}$/;
    if (!phoneRegex.test(trimmed)) {
        return { valid: false, message: 'Exactly 10 digits required' };
    }
    
    return { valid: true, message: 'Valid phone number' };
}

/**
 * Validate pincode - exactly 6 digits
 */
function validatePincode(pincode, fieldId) {
    const trimmed = pincode.trim();
    
    if (trimmed.length === 0) {
        clearValidationFeedback(fieldId);
        return { valid: true, message: '' }; // Optional
    }
    
    if (trimmed.length < 6) {
        return { valid: false, message: '6 digits required' };
    }
    
    const pincodeRegex = /^\d{6}$/;
    if (!pincodeRegex.test(trimmed)) {
        return { valid: false, message: 'Exactly 6 digits required' };
    }
    
    return { valid: true, message: 'Valid pincode' };
}

/**
 * Validate city/state - only letters and spaces
 */
function validateTextOnly(text, fieldId) {
    const trimmed = text.trim();
    
    if (trimmed.length === 0) {
        clearValidationFeedback(fieldId);
        return { valid: true, message: '' }; // Optional
    }
    
    const textRegex = /^[a-zA-Z\s]+$/;
    if (!textRegex.test(trimmed)) {
        return { valid: false, message: 'Only letters and spaces allowed' };
    }
    
    return { valid: true, message: 'Valid' };
}

/**
 * Validate alphanumeric (for IDs, membership)
 */
function validateAlphanumeric(text, fieldId) {
    const trimmed = text.trim();
    
    if (trimmed.length === 0) {
        clearValidationFeedback(fieldId);
        return { valid: true, message: '' }; // Optional
    }
    
    const alphanumericRegex = /^[a-zA-Z0-9\s]+$/;
    if (!alphanumericRegex.test(trimmed)) {
        return { valid: false, message: 'Only letters and numbers allowed' };
    }
    
    return { valid: true, message: 'Valid' };
}

/**
 * Validate DOB - cannot be future date
 */
function validateDOB(dob, fieldId) {
    if (!dob) {
        clearValidationFeedback(fieldId);
        return { valid: true, message: '' }; // Optional
    }
    
    const inputDate = new Date(dob);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    if (inputDate > today) {
        return { valid: false, message: 'Future date not allowed' };
    }
    
    return { valid: true, message: 'Valid date' };
}

/**
 * Calculate age from DOB
 */
function calculateAge(dob) {
    if (!dob) return '';
    
    const birthDate = new Date(dob);
    const today = new Date();
    
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();
    
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    
    return age >= 0 ? age : '';
}

/**
 * Validate file
 */
function validateFile(file) {
    const maxSize = 5 * 1024 * 1024; // 5MB
    const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png', 
                          'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    
    if (file.size > maxSize) {
        return { valid: false, message: file.name + ': File size must be less than 5MB' };
    }
    
    if (!allowedTypes.includes(file.type)) {
        return { valid: false, message: file.name + ': Only PDF, JPG, PNG, DOC, DOCX files allowed' };
    }
    
    return { valid: true };
}

// ============================================================================
// REAL-TIME INPUT VALIDATION WITH VISUAL FEEDBACK
// ============================================================================

function setupInputValidations() {
    
    // Name validation
    $('#name, #recommended_by').on('input', function() {
        const fieldId = $(this).attr('id');
        let value = $(this).val();
        
        // Remove numbers and special characters
        value = value.replace(/[^a-zA-Z\s]/g, '');
        $(this).val(value);
        
        // Validate and show feedback
        const result = validateName(value, fieldId);
        showValidationFeedback(fieldId, result.valid, result.message);
    });
    
    // Email validation with enhanced checks
    $('#email').on('input blur', function() {
        const value = $(this).val().trim();
        const result = validateEmail(value, 'email');
        showValidationFeedback('email', result.valid, result.message);
    });
    
    // Mobile number validation
    $('#mobile_number').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        
        if (value.length > 10) {
            value = value.substring(0, 10);
        }
        
        $(this).val(value);
        $('#mobile_exists_alert').remove();
        
        // Format validation
        const result = validateMobile(value, 'mobile_number');
        showValidationFeedback('mobile_number', result.valid, result.message);
        
        // DB check if valid (debounced)
        if (result.valid) {
            clearTimeout(mobileCheckTimeout);
            mobileCheckTimeout = setTimeout(function() {
                checkMobileExists(value, 'mobile_number');
            }, 800);
        }
    });
    
    $('#mobile_number').on('blur', function() {
        const value = $(this).val().trim();
        if (value.length === 10) {
            clearTimeout(mobileCheckTimeout);
            checkMobileExists(value, 'mobile_number');
        }
    });
    
    // Alternate phone validation
    $('#phone').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        
        if (value.length > 10) {
            value = value.substring(0, 10);
        }
        
        $(this).val(value);
        
        const result = validatePhone(value, 'phone');
        showValidationFeedback('phone', result.valid, result.message);
    });
    
    // Pincode validation
    $('#pincode').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        
        if (value.length > 6) {
            value = value.substring(0, 6);
        }
        
        $(this).val(value);
        
        const result = validatePincode(value, 'pincode');
        showValidationFeedback('pincode', result.valid, result.message);
    });
    
    // City validation
    $('#city').on('input', function() {
        let value = $(this).val();
        value = value.replace(/[^a-zA-Z\s]/g, '');
        $(this).val(value);
        
        const result = validateTextOnly(value, 'city');
        showValidationFeedback('city', result.valid, result.message);
    });
    
    // State validation
    $('#state').on('input', function() {
        let value = $(this).val();
        value = value.replace(/[^a-zA-Z\s]/g, '');
        $(this).val(value);
        
        const result = validateTextOnly(value, 'state');
        showValidationFeedback('state', result.valid, result.message);
    });
    
    // Other Hospital Patient ID - alphanumeric
    $('#other_hospital_patient_id').on('input', function() {
        let value = $(this).val();
        value = value.replace(/[^a-zA-Z0-9\s]/g, '');
        $(this).val(value);
        
        const result = validateAlphanumeric(value, 'other_hospital_patient_id');
        showValidationFeedback('other_hospital_patient_id', result.valid, result.message);
    });
    
    // Membership ID - alphanumeric
    $('#membership_id').on('input', function() {
        let value = $(this).val();
        value = value.replace(/[^a-zA-Z0-9\s]/g, '');
        $(this).val(value);
        
        const result = validateAlphanumeric(value, 'membership_id');
        showValidationFeedback('membership_id', result.valid, result.message);
    });
    
    // DOB validation
    $('#dob').on('change', function() {
        const dob = $(this).val();
        const result = validateDOB(dob, 'dob');
        
        if (!result.valid) {
            showValidationFeedback('dob', false, result.message);
            $(this).val('');
            $('#age').val('');
            alert_float('warning', 'Date of birth cannot be a future date');
            return;
        }
        
        showValidationFeedback('dob', true, result.message);
        
        if (dob) {
            const age = calculateAge(dob);
            $('#age').val(age);
            if (age < 18) {
                alert_float('info', 'Patient is a minor (Age: ' + age + ')');
            }
        } else {
            $('#age').val('');
        }
    });
    
    // Character counters
    $('#address').on('input', function() {
        const count = $(this).val().length;
        $('#address_count').text(count);
        
        if (count >= 250) {
            $(this).addClass('is-invalid');
        } else if (count > 0) {
            $(this).removeClass('is-invalid').addClass('is-valid');
        } else {
            $(this).removeClass('is-valid is-invalid');
        }
    });
    
    $('#notes').on('input', function() {
        $('#notes_count').text($(this).val().length);
    });
    
    $('#cancellation_reason').on('input', function() {
        $('#cancel_count').text($(this).val().length);
    });
    
    // File upload validation
    $('#recommendation_file').on('change', function() {
        const files = this.files;
        let totalSize = 0;
        let errors = [];
        
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            totalSize += file.size;
            
            const validation = validateFile(file);
            if (!validation.valid) {
                errors.push(validation.message);
            }
        }
        
        if (totalSize > 10 * 1024 * 1024) {
            errors.push('Total file size must be less than 10MB');
        }
        
        if (errors.length > 0) {
            alert_float('danger', errors.join('<br>'));
            $(this).val('');
            return false;
        }
        
        if (files.length > 0) {
            alert_float('success', files.length + ' file(s) selected successfully');
        }
    });
}

// ============================================================================
// FORM VALIDATION
// ============================================================================

function validateAppointmentForm() {
    const isNewPatient = $('#is_new_patient').val();
    const patientMode = $('#patient_mode').val();
    
    // Validate appointment fields
    if (!$('#appointment_date').val()) {
        alert_float('warning', 'Please select appointment date');
        $('#appointment_date').focus();
        return false;
    }
    
    if (!$('#appointment_time').val()) {
        alert_float('warning', 'Please select appointment time');
        return false;
    }
    
    if (!$('#consultant_id').val()) {
        alert_float('warning', 'Please select a consultant');
        $('#consultant_id').selectpicker('toggle');
        return false;
    }
    
    if (!$('#reason_for_appointment').val()) {
        alert_float('warning', 'Please select reason for appointment');
        $('#reason_for_appointment').selectpicker('toggle');
        return false;
    }
    
    // Validate patient data for new patients
    if (isNewPatient == '1') {
        
        // Name
        const name = $('#name').val().trim();
        const nameResult = validateName(name, 'name');
        if (!nameResult.valid) {
            alert_float('warning', 'Please enter a valid patient name (3-100 characters, letters only)');
            $('#name').focus();
            showValidationFeedback('name', false, nameResult.message || 'Invalid name');
            return false;
        }
        
        // Mobile
      const mobile = $('#mobile_number').val().trim();
        const mobileResult = validateMobile(mobile, 'mobile_number');
        if (!mobileResult.valid) {
            alert_float('warning', 'Please enter a valid 10-digit mobile number starting with 6-9');
            $('#mobile_number').focus();
            showValidationFeedback('mobile_number', false, mobileResult.message || 'Invalid mobile');
            return false;
        }
        
        // Check if duplicate alert is showing
        if ($('#mobile_exists_alert').length > 0) {
            alert_float('warning', 'This mobile number already exists. Please use the existing patient or enter a different number.');
            $('#mobile_number').focus();
            return false;
        }
        
        // Walk-in specific validations
        if (patientMode === 'walk_in') {
            const gender = $('#gender').val();
            if (!gender) {
                alert_float('warning', 'Please select gender for walk-in registration');
                $('#gender').focus();
                return false;
            }
            
            const patientType = $('#patient_type').val();
            if (!patientType) {
                alert_float('warning', 'Please select patient type for walk-in registration');
                $('#patient_type').focus();
                return false;
            }
            
            // Email
            const email = $('#email').val().trim();
            if (email) {
                const emailResult = validateEmail(email, 'email');
                if (!emailResult.valid) {
                    alert_float('warning', 'Please enter a valid email address: ' + emailResult.message);
                    $('#email').focus();
                    showValidationFeedback('email', false, emailResult.message);
                    return false;
                }
            }
            
            // Phone
            const phone = $('#phone').val().trim();
            if (phone) {
                const phoneResult = validatePhone(phone, 'phone');
                if (!phoneResult.valid) {
                    alert_float('warning', 'Alternate phone must be exactly 10 digits');
                    $('#phone').focus();
                    showValidationFeedback('phone', false, phoneResult.message);
                    return false;
                }
            }
            
            // DOB
            const dob = $('#dob').val();
            if (dob) {
                const dobResult = validateDOB(dob, 'dob');
                if (!dobResult.valid) {
                    alert_float('warning', 'Date of birth cannot be a future date');
                    $('#dob').focus();
                    showValidationFeedback('dob', false, dobResult.message);
                    return false;
                }
            }
            
            // City
            const city = $('#city').val().trim();
            if (city) {
                const cityResult = validateTextOnly(city, 'city');
                if (!cityResult.valid) {
                    alert_float('warning', 'City name must contain only letters and spaces');
                    $('#city').focus();
                    showValidationFeedback('city', false, cityResult.message);
                    return false;
                }
            }
            
            // State
            const state = $('#state').val().trim();
            if (state) {
                const stateResult = validateTextOnly(state, 'state');
                if (!stateResult.valid) {
                    alert_float('warning', 'State name must contain only letters and spaces');
                    $('#state').focus();
                    showValidationFeedback('state', false, stateResult.message);
                    return false;
                }
            }
            
            // Pincode
            const pincode = $('#pincode').val().trim();
            if (pincode) {
                const pincodeResult = validatePincode(pincode, 'pincode');
                if (!pincodeResult.valid) {
                    alert_float('warning', 'Pincode must be exactly 6 digits');
                    $('#pincode').focus();
                    showValidationFeedback('pincode', false, pincodeResult.message);
                    return false;
                }
            }
            
            // Other Hospital ID
            const otherHospitalId = $('#other_hospital_patient_id').val().trim();
            if (otherHospitalId) {
                const idResult = validateAlphanumeric(otherHospitalId, 'other_hospital_patient_id');
                if (!idResult.valid) {
                    alert_float('warning', 'Other hospital patient ID must be alphanumeric only');
                    $('#other_hospital_patient_id').focus();
                    showValidationFeedback('other_hospital_patient_id', false, idResult.message);
                    return false;
                }
            }
            
            // Recommended By
            const recommendedBy = $('#recommended_by').val().trim();
            if (recommendedBy) {
                const recResult = validateName(recommendedBy, 'recommended_by');
                if (!recResult.valid) {
                    alert_float('warning', 'Recommended by name must contain only letters and spaces');
                    $('#recommended_by').focus();
                    showValidationFeedback('recommended_by', false, recResult.message);
                    return false;
                }
            }
            
            // Membership ID
            const membershipId = $('#membership_id').val().trim();
            if (membershipId) {
                const memResult = validateAlphanumeric(membershipId, 'membership_id');
                if (!memResult.valid) {
                    alert_float('warning', 'Membership ID must be alphanumeric only');
                    $('#membership_id').focus();
                    showValidationFeedback('membership_id', false, memResult.message);
                    return false;
                }
            }
        }
        
    } else {
        // Existing patient validation
        if (!$('#patient_id').val()) {
            alert_float('warning', 'Please select a patient');
            $('#existing_patient_dropdown').selectpicker('toggle');
            return false;
        }
    }
    
    return true;
}

// ============================================================================
// DOCUMENT READY
// ============================================================================
$(document).ready(function() {
    $('.selectpicker').selectpicker();
    setupInputValidations();
    loadPatients();
    
    $('input[name="patient_type_option"]').on('change', handlePatientTypeChange);
    $('input[name="mode_option"]').on('change', handleNewPatientModeChange);
    $('#existing_patient_dropdown').on('change', handleExistingPatientSelection);
    $('input[name="existing_mode_option"]').on('change', handleExistingPatientModeChange);
    
    $('.recommendation_toggle').on('change', function() {
        if ($('input[name="recommended_to_hospital"]:checked').val() == '1') {
            $('#recommendation_details').slideDown();
        } else {
            $('#recommendation_details').slideUp();
        }
    });
    
    $('input[name="registered_other_hospital"]').on('change', function() {
        if ($(this).val() == '1') {
            $('#other_hospital_id_section').slideDown();
        } else {
            $('#other_hospital_id_section').slideUp();
            $('#other_hospital_patient_id').val('');
            clearValidationFeedback('other_hospital_patient_id');
        }
    });
    
    initializeTimePicker();
    $('#saveAppointmentBtn').on('click', handleSaveAppointment);
    $('#appointmentModal').on('hidden.bs.modal', resetModal);
    
    handlePatientTypeChange();
});

// ============================================================================
// PATIENT TYPE HANDLING
// ============================================================================
function handlePatientTypeChange() {
    const type = $('input[name="patient_type_option"]:checked').val();
    
    if (type === 'existing') {
        $('#is_new_patient').val('0');
        $('#existingPatientSection').show();
        $('#modeSelection').hide();
        $('#patientFormSection').hide();
        $('#existing_patient_dropdown').val('').selectpicker('refresh');
        $('#patient_id').val('');
        $('#existingPatientModeSection').hide();
    } else {
        $('#is_new_patient').val('1');
        $('#existingPatientSection').hide();
        $('#modeSelection').show();
        $('#patient_id').val('');
        handleNewPatientModeChange();
    }
}

function handleNewPatientModeChange() {
    const mode = $('input[name="mode_option"]:checked').val();
    $('#patient_mode').val(mode);
    
    if (mode === 'appointment') {
        showPatientForm('minimal');
    } else {
        showPatientForm('full');
    }
}

function handleExistingPatientSelection() {
    const patientId = $(this).val();
    
    if (patientId) {
        $('#patient_id').val(patientId);
        $('#existingPatientModeSection').show();
        loadPatientData(patientId);
    } else {
        $('#patient_id').val('');
        $('#existingPatientModeSection').hide();
        $('#patientFormSection').hide();
    }
}

function handleExistingPatientModeChange() {
    const mode = $('input[name="existing_mode_option"]:checked').val();
    $('#patient_mode').val(mode);
    
    const patientId = $('#patient_id').val();
    
    if (!patientId) {
        alert_float('warning', 'Please select a patient first');
        return;
    }
    
    if (mode === 'appointment') {
        $('#patientFormSection').hide();
    } else {
        loadPatientData(patientId, function() {
            showPatientForm('full');
        });
    }
}

function showPatientForm(mode) {
    $('#patientFormSection').show();
    
    if (mode === 'minimal') {
        $('#formModeText').text('Quick registration - Only Name and Mobile required');
        $('#name_required, #mobile_required').show();
        $('#gender_required, #patient_type_required').hide();
        $('#gender_group, #age_group, #extended_basic_fields, #phone_group, #email_group').hide();
        $('#address_section, #other_details_section, #recommendation_section, #membership_section').hide();
        
        $('#gender').val('other');
        $('#patient_type').val('Regular');
        $('input[name="registered_other_hospital"][value="0"]').prop('checked', true);
        $('input[name="fee_payment"][value="not_applicable"]').prop('checked', true);
        $('input[name="recommended_to_hospital"][value="0"]').prop('checked', true);
    } else {
        $('#formModeText').text('Complete patient registration - Fields marked with * are required');
        $('#name_required, #mobile_required, #gender_required, #patient_type_required').show();
        $('#gender_group, #age_group, #extended_basic_fields, #phone_group, #email_group').show();
        $('#address_section, #other_details_section, #recommendation_section, #membership_section').show();
    }
}

// ============================================================================
// DATA LOADING
// ============================================================================
function loadPatients() {
    $.ajax({
        url: admin_url + 'hospital_management/get_patients_dropdown',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                let options = '<option value="">-- Type to search patients --</option>';
                response.patients.forEach(function(patient) {
                    options += `<option value="${patient.id}">${patient.patient_number} - ${patient.name} - ${patient.mobile_number}</option>`;
                });
                $('#existing_patient_dropdown').html(options).selectpicker('refresh');
            }
        }
    });
}

function loadPatientData(patientId, callback) {
    $.ajax({
        url: admin_url + 'hospital_management/get_patient_details/' + patientId,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const p = response.patient;
                
                $('#name').val(p.name || '');
                $('#gender').val(p.gender || '');
                $('#age').val(p.age || '');
                $('#dob').val(p.dob || '');
                $('#patient_type').val(p.patient_type || 'Regular');
                $('#mobile_number').val(p.mobile_number || '');
                $('#phone').val(p.phone || '');
                $('#email').val(p.email || '');
                $('#address').val(p.address || '');
                $('#address_landmark').val(p.address_landmark || '');
                $('#city').val(p.city || '');
                $('#state').val(p.state || '');
                $('#pincode').val(p.pincode || '');
                
                $('input[name="registered_other_hospital"][value="' + (p.registered_other_hospital || '0') + '"]').prop('checked', true);
                $('input[name="fee_payment"][value="' + (p.fee_payment || 'not_applicable') + '"]').prop('checked', true);
                
                if (p.registered_other_hospital == '1') {
                    $('#other_hospital_id_section').show();
                    $('#other_hospital_patient_id').val(p.other_hospital_patient_id || '');
                } else {
                    $('#other_hospital_id_section').hide();
                }
                
                const recommended = p.recommended_to_hospital == '1' ? '1' : '0';
                $('input[name="recommended_to_hospital"][value="' + recommended + '"]').prop('checked', true);
                if (recommended == '1') {
                    $('#recommendation_details').show();
                    $('#recommended_by').val(p.recommended_by || '');
                }
                
                $('#membership_id').val(p.membership_id || '');
                
                if (callback) callback();
            }
        }
    });
}

// ============================================================================
// TIME PICKER
// ============================================================================
function initializeTimePicker() {
    let selectedHour = null;
    let selectedMinute = null;
    let selectedSecond = '00';
    
    $('#hourButtons .time-btn').click(function() {
        $('#hourButtons .time-btn').removeClass('selected');
        $(this).addClass('selected');
        selectedHour = $(this).data('hour');
        updateTimeDisplay();
    });
    
    $('#minuteButtons .time-btn').click(function() {
        $('#minuteButtons .time-btn').removeClass('selected');
        $(this).addClass('selected');
        selectedMinute = $(this).data('minute');
        updateTimeDisplay();
    });
    
    function updateTimeDisplay() {
        if (selectedHour !== null && selectedMinute !== null && selectedSecond !== null) {
            const timeString = selectedHour + ':' + selectedMinute + ':' + selectedSecond;
            $('#appointment_time').val(timeString);
            $('#displayTime').text(timeString);
            $('#timeDisplay').fadeIn();
        }
    }
}

// ============================================================================
// SAVE APPOINTMENT
// ============================================================================
function handleSaveAppointment() {
    const $btn = $(this);
    
    if (!validateAppointmentForm()) {
        return;
    }
    
    const isNewPatient = $('#is_new_patient').val();
    const patientMode = $('#patient_mode').val();
    
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');
    
    const formData = new FormData($('#appointmentForm')[0]);
    
    if (isNewPatient == '0') {
        const patientFields = [
            'name', 'gender', 'age', 'dob', 'patient_type',
            'mobile_number', 'phone', 'email', 
            'address', 'address_landmark', 'city', 'state', 'pincode',
            'registered_other_hospital', 'other_hospital_patient_id',
            'recommended_to_hospital', 'recommended_by',
            'membership_id', 'recommendation_file[]'
        ];
        
        patientFields.forEach(field => {
            formData.delete(field);
        });
    }
    
    formData.set('patient_id', $('#patient_id').val());
    formData.set('is_new_patient', isNewPatient);
    formData.set('patient_mode', patientMode);
    formData.append(csrfTokenName, csrfTokenHash);
    
    $.ajax({
        url: admin_url + 'hospital_management/save_appointment',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                if (response.csrf_token_name && response.csrf_token_hash) {
                    csrfTokenName = response.csrf_token_name;
                    csrfTokenHash = response.csrf_token_hash;
                }
                alert_float('success', response.message);
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else {
                alert_float('danger', response.message);
                $btn.prop('disabled', false).html('<i class="fa fa-check"></i> Create Appointment');
            }
        },
        error: function(xhr, status, error) {
            let errorMsg = 'Error creating appointment';
            if (xhr.status === 419) {
                errorMsg = 'Session expired. Please refresh and try again.';
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            alert_float('danger', errorMsg);
            $btn.prop('disabled', false).html('<i class="fa fa-check"></i> Create Appointment');
        }
    });
}

// ============================================================================
// MODAL RESET
// ============================================================================
function resetModal() {
    $('#appointmentForm')[0].reset();
    $('#patient_id').val('');
    $('#is_new_patient').val('1');
    $('#patient_mode').val('appointment');
    
    $('input[name="patient_type_option"][value="existing"]').prop('checked', true);
    $('input[name="mode_option"][value="appointment"]').prop('checked', true);
    $('input[name="existing_mode_option"][value="appointment"]').prop('checked', true);
    
    $('#existingPatientSection').show();
    $('#modeSelection').hide();
    $('#patientFormSection').hide();
    $('#existingPatientModeSection').hide();
    $('#recommendation_details').hide();
    $('#other_hospital_id_section').hide();
    
    $('.selectpicker').selectpicker('refresh');
    
    $('#hourButtons .time-btn').removeClass('selected');
    $('#minuteButtons .time-btn').removeClass('selected');
    $('#appointment_time').val('');
    $('#timeDisplay').hide();
    
    $('#address_count').text('0');
    $('#notes_count').text('0');
    
    // Clear all validation feedback
    $('.form-control').removeClass('is-valid is-invalid');
    $('.feedback-message').empty();
}

// ============================================================================
// APPOINTMENT ACTIONS
// ============================================================================
function confirmAppointment(id) {
    if (confirm('Confirm this appointment?')) {
        $.ajax({
            url: admin_url + 'hospital_management/confirm_appointment/' + id,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert_float('success', response.message);
                    location.reload();
                } else {
                    alert_float('danger', response.message);
                }
            }
        });
    }
}

function cancelAppointment(id) {
    $('#cancel_appointment_id').val(id);
    $('#cancel_count').text('0');
    $('#cancellation_reason').val('');
    $('#cancelModal').modal('show');
}

function submitCancellation() {
    const id = $('#cancel_appointment_id').val();
    const reason = $('#cancellation_reason').val().trim();
    
    if (!reason) {
        alert_float('warning', 'Please enter cancellation reason');
        return;
    }
    
    if (reason.length < 10) {
        alert_float('warning', 'Cancellation reason must be at least 10 characters');
        return;
    }
    
    $.ajax({
        url: admin_url + 'hospital_management/cancel_appointment',
        type: 'POST',
        data: { id: id, reason: reason },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert_float('success', response.message);
                $('#cancelModal').modal('hide');
                location.reload();
            } else {
                alert_float('danger', response.message);
            }
        }
    });
}

function deleteAppointment(id) {
    if (confirm('Are you sure you want to delete this appointment? This action cannot be undone.')) {
        $.ajax({
            url: admin_url + 'hospital_management/delete_appointment/' + id,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert_float('success', response.message);
                    location.reload();
                } else {
                    alert_float('danger', response.message);
                }
            }
        });
    }
}

// ============================================================================
// MOBILE NUMBER VALIDATION WITH DB CHECK (MAIN MOBILE ONLY)
// ============================================================================

let mobileCheckTimeout = null;

/**
 * Check if mobile exists in database (AJAX)
 */
function checkMobileExists(mobile, fieldId) {
    const patientId = $('#patient_id').val();
    const isNewPatient = $('#is_new_patient').val();
    
    // Only check for NEW patients
    if (isNewPatient == '0' && patientId) {
        return;
    }
    
    $.ajax({
        url: admin_url + 'hospital_management/check_mobile_exists',
        type: 'POST',
        data: {
            mobile_number: mobile,
            patient_id: patientId,
            [csrfTokenName]: csrfTokenHash
        },
        dataType: 'json',
        success: function(response) {
            if (response.csrf_token_name && response.csrf_token_hash) {
                csrfTokenName = response.csrf_token_name;
                csrfTokenHash = response.csrf_token_hash;
            }
            
            if (response.exists) {
                const patient = response.patient;
                const message = `Exists: ${patient.patient_number} - ${patient.name}`;
                showValidationFeedback(fieldId, false, message);
                showMobileExistsAlert(patient);
            } else {
                showValidationFeedback(fieldId, true, 'Available');
            }
        },
        error: function() {
            console.error('Failed to check mobile number');
        }
    });
}

/**
 * Show alert when mobile number exists
 */
function showMobileExistsAlert(patient) {
    const alertHtml = `
        <div class="alert alert-warning" id="mobile_exists_alert" style="margin-top: 10px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-exclamation-triangle"></i>
            <strong>Patient Already Exists!</strong><br>
            Patient: <strong>${patient.patient_number} - ${patient.name}</strong><br>
            Mobile: <strong>${patient.mobile_number}</strong>
            <hr style="margin: 10px 0;">
            <button type="button" class="btn btn-sm btn-info" onclick="useExistingPatient(${patient.id})">
                <i class="fa fa-user"></i> Use This Patient
            </button>
        </div>
    `;
    
    $('#mobile_exists_alert').remove();
    $('#mobile_number').closest('.form-group').after(alertHtml);
}

/**
 * Use existing patient
 */
function useExistingPatient(patientId) {
    $('input[name="patient_type_option"][value="existing"]').prop('checked', true).trigger('change');
    $('#existing_patient_dropdown').val(patientId).selectpicker('refresh').trigger('change');
    $('#mobile_exists_alert').remove();
    clearValidationFeedback('mobile_number');
    $('#mobile_number').val('');
    alert_float('success', 'Existing patient selected');
}
</script>