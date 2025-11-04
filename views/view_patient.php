<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <!-- Header -->
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="no-margin">
                                    <i class="fa fa-user"></i> 
                                    Patient Details: <?php echo $patient->name; ?>
                                </h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="<?php echo admin_url('hospital_management/manage_patient/' . $patient->id); ?>" 
                                   class="btn btn-primary">
                                    <i class="fa fa-edit"></i> Edit Patient
                                </a>
                                <a href="<?php echo admin_url('hospital_management/patients'); ?>" 
                                   class="btn btn-default">
                                    <i class="fa fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                        <hr>

                        <!-- Patient Info Card -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel_s">
                                    <div class="panel-body" style="background: #f8f9fa;">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <strong>Patient Number:</strong><br>
                                                <h4 class="text-primary"><?php echo $patient->patient_number; ?></h4>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Gender:</strong><br>
                                                <p><?php echo ucfirst($patient->gender); ?></p>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Age:</strong><br>
                                                <p><?php echo $patient->age ?: 'Not specified'; ?> years</p>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Blood Group:</strong><br>
                                                <p><?php echo $patient->blood_group ?: 'Not specified'; ?></p>
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
                                            <i class="fa fa-calendar"></i> Appointments
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab_visits" data-toggle="tab">
                                            <i class="fa fa-stethoscope"></i> Visit History
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab_documents" data-toggle="tab">
                                            <i class="fa fa-file"></i> Documents
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content mtop15">
                                    
                                    <!-- TAB 1: Basic Information -->
                                    <div class="tab-pane active" id="tab_info">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4 class="bold">Personal Details</h4>
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
                                                            <span class="label label-default">
                                                                <?php echo $patient->patient_type; ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <h4 class="bold">Contact Information</h4>
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
                                                <h4 class="bold">Emergency Contact</h4>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th width="40%">Contact Name</th>
                                                        <td><?php echo $patient->emergency_contact_name ?: 'Not provided'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Contact Number</th>
                                                        <td><?php echo $patient->emergency_contact_number ?: 'Not provided'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Relation</th>
                                                        <td><?php echo $patient->emergency_contact_relation ?: 'Not provided'; ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TAB 2: Appointments -->
                                    <div class="tab-pane" id="tab_appointments">
                                        <h4 class="bold">Appointment History</h4>
                                        
                                        <?php if (!empty($appointments)): ?>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Appointment #</th>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th>Consultant</th>
                                                        <th>Reason</th>
                                                        <th>Mode</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($appointments as $apt): ?>
                                                        <tr>
                                                            <td><?php echo $apt->appointment_number; ?></td>
                                                            <td><?php echo date('d M Y', strtotime($apt->appointment_date)); ?></td>
                                                            <td><?php echo date('h:i A', strtotime($apt->appointment_time)); ?></td>
                                                            <td><?php echo $apt->consultant_firstname . ' ' . $apt->consultant_lastname; ?></td>
                                                            <td>
                                                                <span class="label label-default">
                                                                    <?php echo ucfirst($apt->reason_for_appointment); ?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <?php if ($apt->patient_mode === 'walk_in'): ?>
                                                                    <span class="label label-warning">Walk-in</span>
                                                                <?php else: ?>
                                                                    <span class="label label-info">Appointment</span>
                                                                <?php endif; ?>
                                                            </td>
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
                                                                <a href="<?php echo admin_url('hospital_management/view_appointment/' . $apt->id); ?>" 
                                                                   class="btn btn-default btn-sm">
                                                                    <i class="fa fa-eye"></i> View
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <div class="alert alert-info">
                                                No appointments found for this patient.
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- TAB 3: Visit History -->
                                    <div class="tab-pane" id="tab_visits">
                                        <h4 class="bold">Visit History</h4>
                                        
                                        <?php if (!empty($visits)): ?>
                                            <table class="table table-striped">
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
                                                            <td><?php echo $visit->visit_number; ?></td>
                                                            <td><?php echo date('d M Y', strtotime($visit->visit_date)); ?></td>
                                                            <td><?php echo date('h:i A', strtotime($visit->visit_time)); ?></td>
                                                            <td><?php echo $visit->consultant_firstname . ' ' . $visit->consultant_lastname; ?></td>
                                                            <td>
                                                                <span class="label label-info">
                                                                    <?php echo ucfirst($visit->visit_type); ?>
                                                                </span>
                                                            </td>
                                                            <td><?php echo ucfirst($visit->reason); ?></td>
                                                            <td><?php echo substr($visit->diagnosis ?? 'Not recorded', 0, 50) . '...'; ?></td>
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
                                                                   class="btn btn-default btn-sm">
                                                                    <i class="fa fa-eye"></i> View
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <div class="alert alert-info">
                                                No visit records found for this patient.
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- TAB 4: Documents -->
                                    <div class="tab-pane" id="tab_documents">
                                        <h4 class="bold">Patient Documents</h4>
                                        
                                        <?php if (!empty($documents)): ?>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Document Type</th>
                                                        <th>File Name</th>
                                                        <th>File Type</th>
                                                        <th>Size</th>
                                                        <th>Uploaded</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($documents as $doc): ?>
                                                        <tr>
                                                            <td>
                                                                <span class="label label-info">
                                                                    <?php echo ucwords(str_replace('_', ' ', $doc['document_type'])); ?>
                                                                </span>
                                                            </td>
                                                            <td><?php echo $doc['document_name']; ?></td>
                                                            <td><?php echo strtoupper(pathinfo($doc['original_filename'], PATHINFO_EXTENSION)); ?></td>
                                                            <td><?php echo number_format($doc['file_size'] / 1024, 2); ?> KB</td>
                                                            <td><?php echo date('d M Y h:i A', strtotime($doc['uploaded_at'])); ?></td>
                                                            <td>
                                                                <a href="<?php echo admin_url('hospital_management/download_document/' . $doc['id']); ?>" 
                                                                   class="btn btn-primary btn-sm" 
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
                                                No documents uploaded for this patient.
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