<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<style>
    .medical-header {
        background: linear-gradient(135deg, #17a2b8 0%, #20c9e7 100%);
        color: white;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .patient-info-card {
        background: #f8f9fa;
        border: 1px solid #17a2b8;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .patient-info-card .info-item {
        border-bottom: 1px solid #e9ecef;
        padding: 10px 0;
    }
    .patient-info-card .info-item:last-child {
        border-bottom: none;
    }
    .nav-tabs > li.active > a {
        background: #17a2b8 !important;
        color: white !important;
        border-color: #17a2b8 !important;
    }
    .nav-tabs > li > a:hover {
        background: #e9ecef;
    }
    .table thead {
        background: #17a2b8;
        color: white;
    }
    .section-title {
        color: #17a2b8;
        font-weight: 600;
        margin-bottom: 15px;
    }
    .info-label {
        color: #17a2b8;
        font-weight: 600;
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
                                        <i class="fa fa-user"></i> 
                                        Patient Details: <?php echo $patient->name; ?>
                                    </h4>
                                </div>
                                <div class="col-md-4 text-right">
                                    <a href="<?php echo admin_url('hospital_management/manage_patient/' . $patient->id); ?>" 
                                       class="btn btn-light"
                                       style="background: #f8fcfdff; color: black;">
                                        <i class="fa fa-edit"></i> Edit Patient
                                    </a>
                                    <a href="<?php echo admin_url('hospital_management/patient_records'); ?>" 
                                       class="btn btn-light" style="background: #f8fcfdff; color: black;">
                                        <i class="fa fa-arrow-left"></i> Back to List
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Patient Info Card -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="patient-info-card">
                                    <div class="row">
                                        <div class="col-md-3 text-center">
                                            <div style="background: #17a2b8; color: white; padding: 30px; border-radius: 5px;">
                                                <i class="fa fa-user" style="font-size: 48px;"></i>
                                                <h4 class="mtop10"><?php echo $patient->patient_number; ?></h4>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="info-item">
                                                <strong class="info-label">Gender:</strong><br>
                                                <?php echo ucfirst($patient->gender); ?>
                                            </div>
                                            <div class="info-item">
                                                <strong class="info-label">Age:</strong><br>
                                                <?php echo $patient->age ?: 'Not specified'; ?> years
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="info-item">
                                                <strong class="info-label">Blood Group:</strong><br>
                                                <?php echo $patient->blood_group ?: 'Not specified'; ?>
                                            </div>
                                            <div class="info-item">
                                                <strong class="info-label">Mobile:</strong><br>
                                                <?php echo $patient->mobile_number; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="info-item">
                                                <strong class="info-label">Patient Type:</strong><br>
                                                <span class="label" style="background: #17a2b8;">
                                                    <?php echo $patient->patient_type; ?>
                                                </span>
                                            </div>
                                            <div class="info-item">
                                                <strong class="info-label">Registered:</strong><br>
                                                <?php echo date('d M Y', strtotime($patient->created_at)); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabs -->
                        <div class="row mtop15">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="active">
                                        <a href="#tab_info" data-toggle="tab">
                                            <i class="fa fa-info-circle"></i> Basic Information
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab_appointments" data-toggle="tab">
                                            <i class="fa fa-calendar"></i> Appointments (<?php echo count($appointments); ?>)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab_visits" data-toggle="tab">
                                            <i class="fa fa-stethoscope"></i> Visit History (<?php echo count($visits); ?>)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab_documents" data-toggle="tab">
                                            <i class="fa fa-file"></i> Documents (<?php echo count($documents); ?>)
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content mtop15">
                                    
                                    <!-- TAB 1: Basic Information -->
                                    <div class="tab-pane active" id="tab_info">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4 class="section-title">
                                                    <i class="fa fa-user"></i> Personal Details
                                                </h4>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th width="40%">Full Name</th>
                                                        <td><?php echo $patient->name; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Date of Birth</th>
                                                        <td><?php echo $patient->dob ? date('d M Y', strtotime($patient->dob)) : 'Not specified'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Age</th>
                                                        <td><?php echo $patient->age ?: 'Not specified'; ?> years</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Gender</th>
                                                        <td><?php echo ucfirst($patient->gender); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Blood Group</th>
                                                        <td><?php echo $patient->blood_group ?: 'Not specified'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Patient Type</th>
                                                        <td>
                                                            <span class="label" style="background: #17a2b8;">
                                                                <?php echo $patient->patient_type; ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <?php if (!empty($patient->membership_id)): ?>
                                                    <tr>
                                                        <th>Membership ID</th>
                                                        <td><strong><?php echo $patient->membership_id; ?></strong></td>
                                                    </tr>
                                                    <?php endif; ?>
                                                </table>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <h4 class="section-title">
                                                    <i class="fa fa-phone"></i> Contact Information
                                                </h4>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th width="40%">Mobile Number</th>
                                                        <td><?php echo $patient->mobile_number; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Alternate Phone</th>
                                                        <td><?php echo $patient->phone ?: 'Not provided'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Email</th>
                                                        <td><?php echo $patient->email ?: 'Not provided'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Address</th>
                                                        <td><?php echo $patient->address ?: 'Not provided'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Landmark</th>
                                                        <td><?php echo $patient->address_landmark ?: 'Not provided'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>City</th>
                                                        <td><?php echo $patient->city ?: 'Not provided'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>State</th>
                                                        <td><?php echo $patient->state ?: 'Not provided'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Pincode</th>
                                                        <td><?php echo $patient->pincode ?: 'Not provided'; ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="row mtop15">
                                            <div class="col-md-6">
                                                <h4 class="section-title">
                                                    <i class="fa fa-exclamation-triangle"></i> Emergency Contact
                                                </h4>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th width="40%">Contact Name</th>
                                                        <td><?php echo !empty($patient->emergency_contact_name) ? $patient->emergency_contact_name : 'Not provided'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Contact Number</th>
                                                        <td><?php echo !empty($patient->emergency_contact_number) ? $patient->emergency_contact_number : 'Not provided'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Relation</th>
                                                        <td><?php echo !empty($patient->emergency_contact_relation) ? $patient->emergency_contact_relation : 'Not provided'; ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <h4 class="section-title">
                                                    <i class="fa fa-hospital-o"></i> Other Details
                                                </h4>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th width="40%">Registered at Other Hospital</th>
                                                        <td>
                                                            <?php if ($patient->registered_other_hospital == 1): ?>
                                                                <span class="label label-success">Yes</span>
                                                            <?php else: ?>
                                                                <span class="label label-default">No</span>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                    <?php if ($patient->registered_other_hospital == 1 && !empty($patient->other_hospital_patient_id)): ?>
                                                    <tr>
                                                        <th>Other Hospital Patient ID</th>
                                                        <td><strong><?php echo $patient->other_hospital_patient_id; ?></strong></td>
                                                    </tr>
                                                    <?php endif; ?>
                                                    <tr>
                                                        <th>Recommended to Hospital</th>
                                                        <td>
                                                            <?php if ($patient->recommended_to_hospital == 1): ?>
                                                                <span class="label label-success">Yes</span>
                                                            <?php else: ?>
                                                                <span class="label label-default">No</span>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                    <?php if ($patient->recommended_to_hospital == 1 && !empty($patient->recommended_by)): ?>
                                                    <tr>
                                                        <th>Recommended By</th>
                                                        <td><?php echo $patient->recommended_by; ?></td>
                                                    </tr>
                                                    <?php endif; ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TAB 2: Appointments -->
                                    <div class="tab-pane" id="tab_appointments">
                                        <h4 class="section-title">
                                            <i class="fa fa-calendar"></i> Appointment History
                                        </h4>
                                        
                                        <?php if (!empty($appointments)): ?>
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Appointment #</th>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th>Consultant</th>
                                                        <th>Status</th>
                                                        <th>Notes</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($appointments as $apt): ?>
                                                        <tr>
                                                            <td>
                                                                <strong style="color: #17a2b8;">
                                                                    <?php echo $apt->appointment_number; ?>
                                                                </strong>
                                                            </td>
                                                            <td><?php echo date('d M Y', strtotime($apt->appointment_date)); ?></td>
                                                            <td><?php echo date('h:i A', strtotime($apt->appointment_time)); ?></td>
                                                            <td><?php echo $apt->consultant_firstname . ' ' . $apt->consultant_lastname; ?></td>
                                                            <td>
                                                                <?php 
                                                                    $status_badges = [
                                                                        'pending' => 'label-warning',
                                                                        'confirmed' => 'label-success',
                                                                        'cancelled' => 'label-danger',
                                                                        'completed' => 'label-primary'
                                                                    ];
                                                                    $badge = $status_badges[$apt->status] ?? 'label-default';
                                                                ?>
                                                                <span class="label <?php echo $badge; ?>">
                                                                    <?php echo ucfirst($apt->status); ?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                    if (!empty($apt->notes)) {
                                                                        echo substr($apt->notes, 0, 50);
                                                                        echo strlen($apt->notes) > 50 ? '...' : '';
                                                                    } else {
                                                                        echo '-';
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <a href="<?php echo admin_url('hospital_management/view_appointment/' . $apt->id); ?>" 
                                                                   class="btn btn-sm"
                                                                   style="background: #17a2b8; color: white;">
                                                                    <i class="fa fa-eye"></i> View
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <div class="alert alert-info">
                                                <i class="fa fa-info-circle"></i> No appointments found for this patient.
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- TAB 3: Visit History -->
                                    <div class="tab-pane" id="tab_visits">
                                        <h4 class="section-title">
                                            <i class="fa fa-stethoscope"></i> Visit History
                                        </h4>
                                        
                                        <?php if (!empty($visits)): ?>
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Visit #</th>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th>Consultant</th>
                                                        <th>Visit Type</th>
                                                        <th>Reason</th>
                                                        <th>Diagnosis</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($visits as $visit): ?>
                                                        <tr>
                                                            <td>
                                                                <strong style="color: #17a2b8;">
                                                                    <?php echo $visit->visit_number; ?>
                                                                </strong>
                                                            </td>
                                                            <td><?php echo date('d M Y', strtotime($visit->visit_date)); ?></td>
                                                            <td><?php echo date('h:i A', strtotime($visit->visit_time)); ?></td>
                                                            <td><?php echo $visit->consultant_firstname . ' ' . $visit->consultant_lastname; ?></td>
                                                            <td>
                                                                <span class="label label-info">
                                                                    <?php echo ucfirst(str_replace('_', ' ', $visit->visit_type)); ?>
                                                                </span>
                                                            </td>
                                                            <td><?php echo ucfirst($visit->reason); ?></td>
                                                            <td>
                                                                <?php 
                                                                    if (!empty($visit->diagnosis)) {
                                                                        echo substr($visit->diagnosis, 0, 50);
                                                                        echo strlen($visit->diagnosis) > 50 ? '...' : '';
                                                                    } else {
                                                                        echo 'Not recorded';
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                    $status_badges = [
                                                                        'ongoing' => 'label-warning',
                                                                        'completed' => 'label-success',
                                                                        'cancelled' => 'label-danger'
                                                                    ];
                                                                    $badge = $status_badges[$visit->status] ?? 'label-default';
                                                                ?>
                                                                <span class="label <?php echo $badge; ?>">
                                                                    <?php echo ucfirst($visit->status); ?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <a href="<?php echo admin_url('hospital_management/view_visit/' . $visit->id); ?>" 
                                                                   class="btn btn-sm"
                                                                   style="background: #17a2b8; color: white;">
                                                                    <i class="fa fa-eye"></i> View
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <div class="alert alert-info">
                                                <i class="fa fa-info-circle"></i> No visit records found for this patient.
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- TAB 4: Documents -->
                                    <div class="tab-pane" id="tab_documents">
                                        <h4 class="section-title">
                                            <i class="fa fa-file"></i> Patient Documents
                                        </h4>
                                        
                                        <?php if (!empty($documents)): ?>
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Document Type</th>
                                                        <th>Document Name</th>
                                                        <th>Original Filename</th>
                                                        <th>File Type</th>
                                                        <th>Size</th>
                                                        <th>Uploaded By</th>
                                                        <th>Uploaded At</th>
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
                                                            <td><?php echo $doc['original_filename']; ?></td>
                                                            <td><?php echo $doc['file_type']; ?></td>
                                                            <td><?php echo number_format($doc['file_size'] / 1024, 2); ?> KB</td>
                                                            <td>
                                                                <?php 
                                                                    if (!empty($doc['uploaded_by'])) {
                                                                        $uploader = get_staff_full_name($doc['uploaded_by']);
                                                                        echo $uploader ?: 'Staff ID: ' . $doc['uploaded_by'];
                                                                    } else {
                                                                        echo 'System';
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td><?php echo date('d M Y h:i A', strtotime($doc['uploaded_at'])); ?></td>
                                                            <td>
                                                                <a href="<?php echo admin_url('hospital_management/download_document/' . $doc['id']); ?>" 
                                                                   class="btn btn-sm" 
                                                                   style="background: #17a2b8; color: white;"
                                                                   target="_blank">
                                                                    <i class="fa fa-download"></i> Download
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <div class="alert alert-info">
                                                <i class="fa fa-info-circle"></i> No documents uploaded for this patient yet.
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>