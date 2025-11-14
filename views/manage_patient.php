<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<style>
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

    /* ===================================================== */

    .medical-header {
        background: linear-gradient(135deg, #17a2b8 0%, #20c9e7 100%);
        color: white;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .section-header {
        color: #17a2b8;
        border-bottom: 2px solid #17a2b8;
        padding-bottom: 10px;
        margin-top: 20px;
        margin-bottom: 15px;
    }
    .form-group label {
        font-weight: 600;
        color: #333;
    }
    .btn-medical {
        background: #17a2b8;
        color: white;
        border: none;
    }
    .btn-medical:hover {
        background: #138496;
        color: white;
    }
    .required-star {
        color: #dc3545;
    }
</style>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <!-- Header -->
                        <div class="medical-header">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4 class="no-margin">
                                        <i class="fa fa-users"></i> 
                                        <?php echo isset($patient) ? 'Edit Patient' : 'Add New Patient'; ?>
                                    </h4>
                                </div>
                                <div class="col-md-4 text-right">
                                    <?php if (isset($patient)): ?>
                                        <a href="<?php echo admin_url('hospital_management/view_patient/' . $patient->id); ?>" 
                                           class="btn btn-light" style="background: #f8fcfdff; color: black;">
                                            <i class="fa fa-arrow-left"></i> Back to Patient Details
                                        </a>
                                    <?php else: ?>
                                        <a href="<?php echo admin_url('hospital_management/patient_records'); ?>" 
                                           class="btn btn-light" style="background: #f8fcfdff; color: black;">
                                            <i class="fa fa-arrow-left"></i> Back to Patients
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <?php echo form_open_multipart(admin_url('hospital_management/save_patient'), ['id' => 'patient-form']); ?>
                        
                        <?php if (isset($patient)): ?>
                            <input type="hidden" name="id" value="<?php echo $patient->id; ?>">
                        <?php endif; ?>

                        <!-- Patient Basic Information -->
                        <h4 class="section-header">
                            <i class="fa fa-user"></i> Patient Information
                        </h4>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Full Name <span class="required-star">*</span></label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="name" 
                                           id="name"
                                           value="<?php echo isset($patient) ? $patient->name : ''; ?>" 
                                           maxlength="100"
                                           placeholder="Enter full name"
                                           required>
                                    <small class="text-muted">Letters and spaces only, 3-100 characters</small>
                                    <span class="feedback-message" id="name_feedback"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="gender">Gender <span class="required-star">*</span></label>
                                    <select class="form-control selectpicker" name="gender" id="gender" required>
                                        <option value="">Select</option>
                                        <option value="male" <?php echo (isset($patient) && $patient->gender === 'male') ? 'selected' : ''; ?>>Male</option>
                                        <option value="female" <?php echo (isset($patient) && $patient->gender === 'female') ? 'selected' : ''; ?>>Female</option>
                                        <option value="other" <?php echo (isset($patient) && $patient->gender === 'other') ? 'selected' : ''; ?>>Other</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="dob">Date of Birth</label>
                                    <input type="date" 
                                           class="form-control" 
                                           name="dob" 
                                           id="dob"
                                           value="<?php echo isset($patient) ? $patient->dob : ''; ?>"
                                           max="<?php echo date('Y-m-d'); ?>">
                                    <small class="text-muted">Cannot be future date</small>
                                    <span class="feedback-message" id="dob_feedback"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="age">Age</label>
                                    <input type="number" 
                                           class="form-control" 
                                           name="age" 
                                           id="age"
                                           value="<?php echo isset($patient) ? $patient->age : ''; ?>" 
                                           min="0" 
                                           max="150">
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="blood_group">Blood Group</label>
                                    <select class="form-control selectpicker" name="blood_group" id="blood_group">
                                        <option value="">Select</option>
                                        <?php 
                                        $blood_groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                                        foreach ($blood_groups as $bg): 
                                        ?>
                                            <option value="<?php echo $bg; ?>" <?php echo (isset($patient) && $patient->blood_group === $bg) ? 'selected' : ''; ?>>
                                                <?php echo $bg; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <h4 class="section-header">
                            <i class="fa fa-phone"></i> Contact Information
                        </h4>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mobile_number">Mobile Number <span class="required-star">*</span></label>
                                    <input type="tel" 
                                           class="form-control" 
                                           name="mobile_number" 
                                           id="mobile_number"
                                           value="<?php echo isset($patient) ? $patient->mobile_number : ''; ?>" 
                                           maxlength="10"
                                           placeholder="10-digit mobile number"
                                           required>
                                    <small class="text-muted">10 digits, starts with 6-9</small>
                                    <span class="feedback-message" id="mobile_number_feedback"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="phone">Alternate Phone</label>
                                    <input type="tel" 
                                           class="form-control" 
                                           name="phone" 
                                           id="phone"
                                           value="<?php echo isset($patient) ? $patient->phone : ''; ?>"
                                           maxlength="10"
                                           placeholder="10-digit phone number">
                                    <small class="text-muted">10 digits only</small>
                                    <span class="feedback-message" id="phone_feedback"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" 
                                           class="form-control" 
                                           name="email" 
                                           id="email"
                                           value="<?php echo isset($patient) ? $patient->email : ''; ?>"
                                           maxlength="100"
                                           placeholder="email@example.com">
                                    <small class="text-muted">Valid email format</small>
                                    <span class="feedback-message" id="email_feedback"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <h4 class="section-header">
                            <i class="fa fa-map-marker"></i> Address
                        </h4>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Street Address</label>
                                    <textarea class="form-control" 
                                              name="address" 
                                              id="address" 
                                              rows="2"
                                              maxlength="250"
                                              placeholder="Maximum 250 characters"><?php echo isset($patient) ? $patient->address : ''; ?></textarea>
                                    <small class="text-muted"><span id="address_count">0</span>/250 characters</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="address_landmark">Landmark</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="address_landmark" 
                                           id="address_landmark"
                                           value="<?php echo isset($patient) ? $patient->address_landmark : ''; ?>"
                                           maxlength="100">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="city" 
                                           id="city"
                                           value="<?php echo isset($patient) ? $patient->city : ''; ?>"
                                           maxlength="50"
                                           placeholder="Letters only">
                                    <small class="text-muted">Letters and spaces only</small>
                                    <span class="feedback-message" id="city_feedback"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="state" 
                                           id="state"
                                           value="<?php echo isset($patient) ? $patient->state : ''; ?>"
                                           maxlength="50"
                                           placeholder="Letters only">
                                    <small class="text-muted">Letters and spaces only</small>
                                    <span class="feedback-message" id="state_feedback"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="pincode">Pincode</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="pincode" 
                                           id="pincode"
                                           value="<?php echo isset($patient) ? $patient->pincode : ''; ?>"
                                           maxlength="6"
                                           placeholder="6 digits">
                                    <small class="text-muted">6 digits only</small>
                                    <span class="feedback-message" id="pincode_feedback"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Patient Classification -->
                        <h4 class="section-header">
                            <i class="fa fa-tag"></i> Patient Classification
                        </h4>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="patient_type">Patient Type <span class="required-star">*</span></label>
                                    <select class="form-control selectpicker" 
                                            name="patient_type" 
                                            id="patient_type" 
                                            data-live-search="true" 
                                            required>
                                        <option value="">Select Patient Type</option>
                                        <?php foreach ($patient_types as $type): ?>
                                            <option value="<?php echo $type['type_name']; ?>" 
                                                    <?php echo (isset($patient) && $patient->patient_type === $type['type_name']) ? 'selected' : ''; ?>>
                                                <?php echo $type['type_name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="membership_id">Membership ID</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="membership_id" 
                                           id="membership_id"
                                           value="<?php echo isset($patient) ? $patient->membership_id : ''; ?>"
                                           maxlength="50"
                                           placeholder="e.g., MEM2025001">
                                    <small class="text-muted">Alphanumeric only, max 50 characters</small>
                                    <span class="feedback-message" id="membership_id_feedback"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Other Hospital Registration -->
                        <h4 class="section-header">
                            <i class="fa fa-hospital-o"></i> Other Hospital Registration
                        </h4>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Registered at Other Hospital?</label>
                                    <div>
                                        <label class="radio-inline">
                                            <input type="radio" 
                                                   name="registered_other_hospital" 
                                                   value="0" 
                                                   id="registered_other_hospital_no"
                                                   <?php echo (!isset($patient) || $patient->registered_other_hospital == 0) ? 'checked' : ''; ?>>
                                            No
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" 
                                                   name="registered_other_hospital" 
                                                   value="1" 
                                                   id="registered_other_hospital_yes"
                                                   <?php echo (isset($patient) && $patient->registered_other_hospital == 1) ? 'checked' : ''; ?>>
                                            Yes
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group" id="other_hospital_id_group" style="<?php echo (isset($patient) && $patient->registered_other_hospital == 1) ? '' : 'display: none;'; ?>">
                                    <label for="other_hospital_patient_id">Patient ID at Other Hospital</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="other_hospital_patient_id" 
                                           id="other_hospital_patient_id"
                                           value="<?php echo isset($patient) ? $patient->other_hospital_patient_id : ''; ?>"
                                           maxlength="50"
                                           placeholder="Alphanumeric only">
                                    <small class="text-muted">Alphanumeric only, max 50 characters</small>
                                    <span class="feedback-message" id="other_hospital_patient_id_feedback"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Recommendation -->
                        <h4 class="section-header">
                            <i class="fa fa-user-md"></i> Recommendation Details
                        </h4>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Recommended to Hospital?</label>
                                    <div>
                                        <label class="radio-inline">
                                            <input type="radio" 
                                                   name="recommended_to_hospital" 
                                                   value="0" 
                                                   id="recommended_to_hospital_no"
                                                   <?php echo (!isset($patient) || $patient->recommended_to_hospital == 0) ? 'checked' : ''; ?>>
                                            No
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" 
                                                   name="recommended_to_hospital" 
                                                   value="1" 
                                                   id="recommended_to_hospital_yes"
                                                   <?php echo (isset($patient) && $patient->recommended_to_hospital == 1) ? 'checked' : ''; ?>>
                                            Yes
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group" id="recommended_by_group" style="<?php echo (isset($patient) && $patient->recommended_to_hospital == 1) ? '' : 'display: none;'; ?>">
                                    <label for="recommended_by">Recommended By</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="recommended_by" 
                                           id="recommended_by"
                                           value="<?php echo isset($patient) ? $patient->recommended_by : ''; ?>"
                                           maxlength="100"
                                           placeholder="Name (letters only)">
                                    <small class="text-muted">Letters and spaces only</small>
                                    <span class="feedback-message" id="recommended_by_feedback"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <h4 class="section-header">
                            <i class="fa fa-exclamation-triangle"></i> Emergency Contact
                        </h4>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="emergency_contact_name">Contact Name</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="emergency_contact_name" 
                                           id="emergency_contact_name"
                                           value="<?php echo isset($patient) ? $patient->emergency_contact_name : ''; ?>"
                                           maxlength="100"
                                           placeholder="Letters only">
                                    <small class="text-muted">Letters and spaces only</small>
                                    <span class="feedback-message" id="emergency_contact_name_feedback"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="emergency_contact_number">Contact Number</label>
                                    <input type="tel" 
                                           class="form-control" 
                                           name="emergency_contact_number" 
                                           id="emergency_contact_number"
                                           value="<?php echo isset($patient) ? $patient->emergency_contact_number : ''; ?>"
                                           maxlength="10"
                                           placeholder="10-digit number">
                                    <small class="text-muted">10 digits only</small>
                                    <span class="feedback-message" id="emergency_contact_number_feedback"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="emergency_contact_relation">Relation</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="emergency_contact_relation" 
                                           id="emergency_contact_relation"
                                           value="<?php echo isset($patient) ? $patient->emergency_contact_relation : ''; ?>" 
                                           maxlength="50"
                                           placeholder="e.g., Father, Mother">
                                    <small class="text-muted">Letters and spaces only</small>
                                    <span class="feedback-message" id="emergency_contact_relation_feedback"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Document Upload -->
                        <h4 class="section-header">
                            <i class="fa fa-file"></i> Documents
                        </h4>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="document_type">Document Type</label>
                                    <select class="form-control selectpicker" name="document_type" id="document_type">
                                        <option value="">Select Type</option>
                                        <option value="recommendation">Recommendation Letter</option>
                                        <option value="membership">Membership Card</option>
                                        <option value="medical_report">Medical Report</option>
                                        <option value="prescription">Prescription</option>
                                        <option value="lab_report">Lab Report</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="document_file">Upload Document</label>
                                    <input type="file" 
                                           class="form-control" 
                                           name="document_file" 
                                           id="document_file"
                                           accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                    <small class="text-muted">Max 5MB, PDF/JPG/PNG/DOC/DOCX only</small>
                                </div>
                            </div>
                        </div>

                        <!-- Existing Documents -->
                        <?php if (isset($patient) && !empty($documents)): ?>
                            <div class="row mtop15">
                                <div class="col-md-12">
                                    <h5 class="bold">Existing Documents</h5>
                                    <table class="table table-bordered">
                                        <thead style="background: #17a2b8; color: white;">
                                            <tr>
                                                <th>Type</th>
                                                <th>File Name</th>
                                                <th>Uploaded</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($documents as $doc): ?>
                                                <tr>
                                                    <td>
                                                        <span class="label" style="background: #17a2b8;">
                                                            <?php echo ucwords(str_replace('_', ' ', $doc['document_type'])); ?>
                                                        </span>
                                                    </td>
                                                    <td><?php echo $doc['document_name']; ?></td>
                                                    <td><?php echo date('d M Y', strtotime($doc['uploaded_at'])); ?></td>
                                                    <td>
                                                        <a href="<?php echo admin_url('hospital_management/download_document/' . $doc['id']); ?>" 
                                                           class="btn btn-sm btn-medical" 
                                                           target="_blank">
                                                            <i class="fa fa-download"></i> Download
                                                        </a>
                                                        <a href="<?php echo admin_url('hospital_management/delete_document/' . $doc['id'] . '/' . $patient->id); ?>" 
                                                           class="btn btn-danger btn-sm delete-document"
                                                           onclick="return confirm('Delete this document?');">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Form Actions -->
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-medical pull-right">
                                    <i class="fa fa-check"></i> <?php echo isset($patient) ? 'Update Patient' : 'Add Patient'; ?>
                                </button>
                                
                                <?php if (isset($patient)): ?>
                                    <a href="<?php echo admin_url('hospital_management/view_patient/' . $patient->id); ?>" 
                                       class="btn btn-default pull-right mright5">
                                        <i class="fa fa-times"></i> Cancel
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo admin_url('hospital_management/patient_records'); ?>" 
                                       class="btn btn-default pull-right mright5">
                                        <i class="fa fa-times"></i> Cancel
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php echo form_close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>

<script>
$(function() {
    'use strict';
    
    // ============================================================================
    // VALIDATION FUNCTIONS WITH VISUAL FEEDBACK
    // ============================================================================
    
    /**
     * Show validation feedback (green/red borders with messages)
     */
    function showValidationFeedback(fieldId, isValid, message = '') {
        const $field = $('#' + fieldId);
        const $feedback = $('#' + fieldId + '_feedback');
        
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
     * Validate name - letters and spaces only, 3-100 chars
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
     * Enhanced email validation
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
        
        // Check for dots at invalid positions
        if (/^\.|\.$|@\.|\.@/.test(trimmed)) {
            return { valid: false, message: 'Invalid dot placement' };
        }
        
        // Standard email format
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailRegex.test(trimmed)) {
            return { valid: false, message: 'Invalid email format' };
        }
        
        // Check domain structure
        const domain = trimmed.split('@')[1];
        if (domain && /\.{2,}/.test(domain)) {
            return { valid: false, message: 'Invalid domain format' };
        }
        
        return { valid: true, message: 'Valid email' };
    }
    
    /**
     * Validate mobile - 10 digits, starts with 6-9
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
     * Validate phone - 10 digits
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
     * Validate pincode - 6 digits
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
     * Validate text only (city/state) - letters and spaces
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
     * Validate alphanumeric
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
    // REAL-TIME INPUT VALIDATION
    // ============================================================================
    
    // Name fields - letters and spaces only
    $('#name, #recommended_by, #emergency_contact_name, #emergency_contact_relation').on('input', function() {
        const fieldId = $(this).attr('id');
        let value = $(this).val();
        
        // Remove numbers and special characters
        value = value.replace(/[^a-zA-Z\s]/g, '');
        $(this).val(value);
        
        // Validate and show feedback
        const result = validateName(value, fieldId);
        showValidationFeedback(fieldId, result.valid, result.message);
    });
    
    // Email validation
    $('#email').on('input blur', function() {
        const value = $(this).val().trim();
        const result = validateEmail(value, 'email');
        showValidationFeedback('email', result.valid, result.message);
    });
    
    // Mobile number validation
    $('#mobile_number').on('input', function() {
        let value = $(this).val().replace(/\D/g, ''); // Remove non-digits
        
        if (value.length > 10) {
            value = value.substring(0, 10);
        }
        
        $(this).val(value);
        
        const result = validateMobile(value, 'mobile_number');
        showValidationFeedback('mobile_number', result.valid, result.message);
    });
    
    // Phone numbers validation
    $('#phone, #emergency_contact_number').on('input', function() {
        const fieldId = $(this).attr('id');
        let value = $(this).val().replace(/\D/g, '');
        
        if (value.length > 10) {
            value = value.substring(0, 10);
        }
        
        $(this).val(value);
        
        const result = validatePhone(value, fieldId);
        showValidationFeedback(fieldId, result.valid, result.message);
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
    
    // City and State - letters only
    $('#city, #state').on('input', function() {
        const fieldId = $(this).attr('id');
        let value = $(this).val();
        value = value.replace(/[^a-zA-Z\s]/g, '');
        $(this).val(value);
        
        const result = validateTextOnly(value, fieldId);
        showValidationFeedback(fieldId, result.valid, result.message);
    });
    
    // Alphanumeric fields
    $('#other_hospital_patient_id, #membership_id').on('input', function() {
        const fieldId = $(this).attr('id');
        let value = $(this).val();
        value = value.replace(/[^a-zA-Z0-9\s]/g, '');
        $(this).val(value);
        
        const result = validateAlphanumeric(value, fieldId);
        showValidationFeedback(fieldId, result.valid, result.message);
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
        
        // Auto-calculate age
        if (dob) {
            var dobDate = new Date(dob);
            var today = new Date();
            var age = today.getFullYear() - dobDate.getFullYear();
            var m = today.getMonth() - dobDate.getMonth();
            
            if (m < 0 || (m === 0 && today.getDate() < dobDate.getDate())) {
                age--;
            }
            
            if (age >= 0) {
                $('#age').val(age);
            }
        } else {
            $('#age').val('');
        }
    });
    
    // Address character counter
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
    
    // Initialize address counter on page load
    if ($('#address').val()) {
        $('#address_count').text($('#address').val().length);
    }
    
    // File upload validation
    $('#document_file').on('change', function() {
        const file = this.files[0];
        
        if (!file) return;
        
        const validation = validateFile(file);
        if (!validation.valid) {
            alert_float('danger', validation.message);
            $(this).val('');
            return false;
        }
        
        alert_float('success', 'File selected: ' + file.name);
    });
    
    // ============================================================================
    // SHOW/HIDE CONDITIONAL FIELDS
    // ============================================================================
    
    // Show/hide other hospital patient ID field
    $('input[name="registered_other_hospital"]').on('change', function() {
        if ($(this).val() == '1') {
            $('#other_hospital_id_group').slideDown();
        } else {
            $('#other_hospital_id_group').slideUp();
            $('#other_hospital_patient_id').val('');
            clearValidationFeedback('other_hospital_patient_id');
        }
    });
    
    // Show/hide recommended by field
    $('input[name="recommended_to_hospital"]').on('change', function() {
        if ($(this).val() == '1') {
            $('#recommended_by_group').slideDown();
        } else {
            $('#recommended_by_group').slideUp();
            $('#recommended_by').val('');
            clearValidationFeedback('recommended_by');
        }
    });
    
    // ============================================================================
    // FORM SUBMISSION VALIDATION
    // ============================================================================
    
    $('#patient-form').on('submit', function(e) {
        var hasError = false;
        
        // Name validation
        const name = $('#name').val().trim();
        const nameResult = validateName(name, 'name');
        if (!nameResult.valid) {
            alert_float('warning', 'Please enter a valid patient name (3-100 characters, letters only)');
            $('#name').focus();
            showValidationFeedback('name', false, nameResult.message || 'Invalid name');
            hasError = true;
        }
        
        // Mobile validation
        const mobile = $('#mobile_number').val().trim();
        const mobileResult = validateMobile(mobile, 'mobile_number');
        if (!mobileResult.valid) {
            alert_float('warning', 'Please enter a valid 10-digit mobile number starting with 6-9');
            $('#mobile_number').focus();
            showValidationFeedback('mobile_number', false, mobileResult.message || 'Invalid mobile');
            hasError = true;
        }
        
        // Gender validation
        if (!$('#gender').val()) {
            alert_float('warning', 'Gender is required');
            hasError = true;
        }
        
        // Patient type validation
        if (!$('#patient_type').val()) {
            alert_float('warning', 'Patient type is required');
            hasError = true;
        }
        
        // Email validation (if provided)
        const email = $('#email').val().trim();
        if (email) {
            const emailResult = validateEmail(email, 'email');
            if (!emailResult.valid) {
                alert_float('warning', 'Please enter a valid email address: ' + emailResult.message);
                $('#email').focus();
                showValidationFeedback('email', false, emailResult.message);
                hasError = true;
            }
        }
        
        // Phone validation (if provided)
        const phone = $('#phone').val().trim();
        if (phone) {
            const phoneResult = validatePhone(phone, 'phone');
            if (!phoneResult.valid) {
                alert_float('warning', 'Alternate phone must be exactly 10 digits');
                $('#phone').focus();
                showValidationFeedback('phone', false, phoneResult.message);
                hasError = true;
            }
        }
        
        // DOB validation (if provided)
        const dob = $('#dob').val();
        if (dob) {
            const dobResult = validateDOB(dob, 'dob');
            if (!dobResult.valid) {
                alert_float('warning', 'Date of birth cannot be a future date');
                $('#dob').focus();
                showValidationFeedback('dob', false, dobResult.message);
                hasError = true;
            }
        }
        
        // City validation (if provided)
        const city = $('#city').val().trim();
        if (city) {
            const cityResult = validateTextOnly(city, 'city');
            if (!cityResult.valid) {
                alert_float('warning', 'City name must contain only letters and spaces');
                $('#city').focus();
                showValidationFeedback('city', false, cityResult.message);
                hasError = true;
            }
        }
        
        // State validation (if provided)
        const state = $('#state').val().trim();
        if (state) {
            const stateResult = validateTextOnly(state, 'state');
            if (!stateResult.valid) {
                alert_float('warning', 'State name must contain only letters and spaces');
                $('#state').focus();
                showValidationFeedback('state', false, stateResult.message);
                hasError = true;
            }
        }
        
        // Pincode validation (if provided)
        const pincode = $('#pincode').val().trim();
        if (pincode) {
            const pincodeResult = validatePincode(pincode, 'pincode');
            if (!pincodeResult.valid) {
                alert_float('warning', 'Pincode must be exactly 6 digits');
                $('#pincode').focus();
                showValidationFeedback('pincode', false, pincodeResult.message);
                hasError = true;
            }
        }
        
        // Emergency contact validation (if provided)
        const emergencyName = $('#emergency_contact_name').val().trim();
        if (emergencyName) {
            const emergencyNameResult = validateName(emergencyName, 'emergency_contact_name');
            if (!emergencyNameResult.valid) {
                alert_float('warning', 'Emergency contact name must contain only letters and spaces');
                $('#emergency_contact_name').focus();
                showValidationFeedback('emergency_contact_name', false, emergencyNameResult.message);
                hasError = true;
            }
        }
        
        const emergencyNumber = $('#emergency_contact_number').val().trim();
        if (emergencyNumber) {
            const emergencyNumberResult = validatePhone(emergencyNumber, 'emergency_contact_number');
            if (!emergencyNumberResult.valid) {
                alert_float('warning', 'Emergency contact number must be exactly 10 digits');
                $('#emergency_contact_number').focus();
                showValidationFeedback('emergency_contact_number', false, emergencyNumberResult.message);
                hasError = true;
            }
        }
        
        const emergencyRelation = $('#emergency_contact_relation').val().trim();
        if (emergencyRelation) {
            const emergencyRelationResult = validateTextOnly(emergencyRelation, 'emergency_contact_relation');
            if (!emergencyRelationResult.valid) {
                alert_float('warning', 'Emergency contact relation must contain only letters and spaces');
                $('#emergency_contact_relation').focus();
                showValidationFeedback('emergency_contact_relation', false, emergencyRelationResult.message);
                hasError = true;
            }
        }
        
        // Other hospital patient ID (if provided)
        const otherHospitalId = $('#other_hospital_patient_id').val().trim();
        if (otherHospitalId) {
            const idResult = validateAlphanumeric(otherHospitalId, 'other_hospital_patient_id');
            if (!idResult.valid) {
                alert_float('warning', 'Other hospital patient ID must be alphanumeric only');
                $('#other_hospital_patient_id').focus();
                showValidationFeedback('other_hospital_patient_id', false, idResult.message);
                hasError = true;
            }
        }
        
        // Recommended by (if provided)
        const recommendedBy = $('#recommended_by').val().trim();
        if (recommendedBy) {
            const recResult = validateName(recommendedBy, 'recommended_by');
            if (!recResult.valid) {
                alert_float('warning', 'Recommended by name must contain only letters and spaces');
                $('#recommended_by').focus();
                showValidationFeedback('recommended_by', false, recResult.message);
                hasError = true;
            }
        }
        
        // Membership ID (if provided)
        const membershipId = $('#membership_id').val().trim();
        if (membershipId) {
            const memResult = validateAlphanumeric(membershipId, 'membership_id');
            if (!memResult.valid) {
                alert_float('warning', 'Membership ID must be alphanumeric only');
                $('#membership_id').focus();
                showValidationFeedback('membership_id', false, memResult.message);
                hasError = true;
            }
        }
        
        if (hasError) {
            e.preventDefault();
            return false;
        }
    });
});
</script>