<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<style>
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
                                        <!-- If editing, go back to view patient -->
                                        <a href="<?php echo admin_url('hospital_management/view_patient/' . $patient->id); ?>" 
                                           class="btn btn-light" style="background: #f8fcfdff; color: black;">
                                            <i class="fa fa-arrow-left"></i> Back to Patient Details
                                        </a>
                                    <?php else: ?>
                                        <!-- If creating new, go back to patient list -->
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
                                           required>
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
                                           value="<?php echo isset($patient) ? $patient->dob : ''; ?>">
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
                                    <input type="text" 
                                           class="form-control" 
                                           name="mobile_number" 
                                           id="mobile_number"
                                           value="<?php echo isset($patient) ? $patient->mobile_number : ''; ?>" 
                                           required>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="phone">Alternate Phone</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="phone" 
                                           id="phone"
                                           value="<?php echo isset($patient) ? $patient->phone : ''; ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" 
                                           class="form-control" 
                                           name="email" 
                                           id="email"
                                           value="<?php echo isset($patient) ? $patient->email : ''; ?>">
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
                                              rows="2"><?php echo isset($patient) ? $patient->address : ''; ?></textarea>
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
                                           value="<?php echo isset($patient) ? $patient->address_landmark : ''; ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="city" 
                                           id="city"
                                           value="<?php echo isset($patient) ? $patient->city : ''; ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="state" 
                                           id="state"
                                           value="<?php echo isset($patient) ? $patient->state : ''; ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="pincode">Pincode</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="pincode" 
                                           id="pincode"
                                           value="<?php echo isset($patient) ? $patient->pincode : ''; ?>">
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
                                           placeholder="Enter membership ID if applicable">
                                    <small class="text-muted">Optional: Patient's membership identification number</small>
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
                                           placeholder="Enter patient ID from other hospital">
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
                                           placeholder="Name of person/organization who recommended">
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
                                           placeholder="Emergency contact person name">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="emergency_contact_number">Contact Number</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="emergency_contact_number" 
                                           id="emergency_contact_number"
                                           value="<?php echo isset($patient) ? $patient->emergency_contact_number : ''; ?>"
                                           placeholder="Emergency contact phone number">
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
                                           placeholder="e.g., Father, Mother, Spouse">
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
                                    <small class="text-muted">Accepted: PDF, JPG, PNG, DOC (Max 5MB)</small>
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
                                    <!-- If editing, cancel goes back to view patient -->
                                    <a href="<?php echo admin_url('hospital_management/view_patient/' . $patient->id); ?>" 
                                       class="btn btn-default pull-right mright5">
                                        <i class="fa fa-times"></i> Cancel
                                    </a>
                                <?php else: ?>
                                    <!-- If creating new, cancel goes back to patient list -->
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
    
    // Show/hide other hospital patient ID field
    $('input[name="registered_other_hospital"]').on('change', function() {
        if ($(this).val() == '1') {
            $('#other_hospital_id_group').slideDown();
        } else {
            $('#other_hospital_id_group').slideUp();
            $('#other_hospital_patient_id').val('');
        }
    });
    
    // Show/hide recommended by field
    $('input[name="recommended_to_hospital"]').on('change', function() {
        if ($(this).val() == '1') {
            $('#recommended_by_group').slideDown();
        } else {
            $('#recommended_by_group').slideUp();
            $('#recommended_by').val('');
        }
    });
    
    // Auto-calculate age from DOB
    $('#dob').on('change', function() {
        var dob = new Date($(this).val());
        var today = new Date();
        var age = today.getFullYear() - dob.getFullYear();
        var m = today.getMonth() - dob.getMonth();
        
        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
            age--;
        }
        
        if (age >= 0) {
            $('#age').val(age);
        }
    });
    
    // Form validation
    $('#patient-form').on('submit', function(e) {
        var hasError = false;
        
        // Validate required fields
        if (!$('#name').val().trim()) {
            alert_float('warning', 'Patient name is required');
            hasError = true;
        }
        
        if (!$('#mobile_number').val().trim()) {
            alert_float('warning', 'Mobile number is required');
            hasError = true;
        }
        
        if (!$('#gender').val()) {
            alert_float('warning', 'Gender is required');
            hasError = true;
        }
        
        if (!$('#patient_type').val()) {
            alert_float('warning', 'Patient type is required');
            hasError = true;
        }
        
        if (hasError) {
            e.preventDefault();
            return false;
        }
    });
});
</script>