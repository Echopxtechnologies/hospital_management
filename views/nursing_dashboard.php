<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Header -->
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <i class="fa fa-hospital"></i> Nursing Portal - Patient Management
                        </h4>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel_s">
                            <div class="panel-body text-center">
                                <h3 class="text-info"><?php echo $stats['total_paid']; ?></h3>
                                <p class="text-muted">Total Paid Patients</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel_s">
                            <div class="panel-body text-center">
                                <h3 class="text-warning"><?php echo $stats['non_admitted']; ?></h3>
                                <p class="text-muted">Awaiting Admission</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel_s">
                            <div class="panel-body text-center">
                                <h3 class="text-success"><?php echo $stats['admitted']; ?></h3>
                                <p class="text-muted">Currently Admitted</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Non-Admitted Patients -->
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="bold">
                            <i class="fa fa-clock-o text-warning"></i> Awaiting Admission
                        </h4>
                        <hr>
                        
                        <div class="table-responsive">
                            <table class="table table-striped dt-table">
                                <thead>
                                    <tr>
                                        <th>Patient Info</th>
                                        <th>Surgery Details</th>
                                        <th>Consultant</th>
                                        <th>Requested Room</th>
                                        <th>Surgery Date</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($non_admitted_patients)): ?>
                                        <?php foreach($non_admitted_patients as $patient): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo $patient['patient_name']; ?></strong><br>
                                                <small class="text-muted">
                                                    <?php echo $patient['patient_number']; ?> | 
                                                    <?php echo $patient['patient_age']; ?>Y | 
                                                    <?php echo strtoupper($patient['patient_gender']); ?>
                                                </small><br>
                                                <small><i class="fa fa-phone"></i> <?php echo $patient['patient_mobile']; ?></small>
                                            </td>
                                            <td>
                                                <strong><?php echo $patient['surgery_name']; ?></strong><br>
                                                <small class="text-muted">OP: <?php echo $patient['op_number'] ?? 'N/A'; ?></small>
                                            </td>
                                            <td>
                                                Dr. <?php echo $patient['consultant_firstname'] . ' ' . $patient['consultant_lastname']; ?>
                                            </td>
                                            <td>
                                                <span class="label label-info">
                                                    <?php echo $patient['requested_room_type']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php echo date('d M Y', strtotime($patient['surgery_date'])); ?>
                                            </td>
                                            <td>
                                                ₹<?php echo number_format($patient['quoted_amount'], 2); ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo admin_url('hospital_management/manage_admission/' . $patient['surgery_request_id']); ?>" 
                                                   class="btn btn-success btn-sm">
                                                    <i class="fa fa-bed"></i> Admit Patient
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No patients awaiting admission</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Admitted Patients -->
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="bold">
                            <i class="fa fa-bed text-success"></i> Currently Admitted Patients
                        </h4>
                        <hr>
                        
                        <div class="table-responsive">
                            <table class="table table-striped dt-table">
                                <thead>
                                    <tr>
                                        <th>Patient Info</th>
                                        <th>Surgery Details</th>
                                        <th>Ward/Room</th>
                                        <th>Admission Date</th>
                                        <th>Surgery Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($admitted_patients)): ?>
                                        <?php foreach($admitted_patients as $patient): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo $patient['patient_name']; ?></strong><br>
                                                <small class="text-muted">
                                                    <?php echo $patient['patient_number']; ?> | 
                                                    <?php echo $patient['patient_age']; ?>Y | 
                                                    <?php echo strtoupper($patient['patient_gender']); ?>
                                                </small><br>
                                                <small><i class="fa fa-phone"></i> <?php echo $patient['patient_mobile']; ?></small>
                                            </td>
                                            <td>
                                                <strong><?php echo $patient['surgery_name']; ?></strong><br>
                                                <small class="text-muted">OP: <?php echo $patient['op_number'] ?? 'N/A'; ?></small>
                                            </td>
                                            <td>
                                                <strong><?php echo $patient['ward_name']; ?></strong><br>
                                                <small class="text-muted">Room: <?php echo $patient['room_number']; ?></small>
                                            </td>
                                            <td>
                                                <?php echo date('d M Y', strtotime($patient['admission_date'])); ?>
                                            </td>
                                            <td>
                                                <?php echo date('d M Y', strtotime($patient['surgery_date'])); ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo admin_url('hospital_management/manage_admission/' . $patient['surgery_request_id']); ?>" 
                                                   class="btn btn-info btn-sm">
                                                    <i class="fa fa-eye"></i> View Details
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No admitted patients</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>