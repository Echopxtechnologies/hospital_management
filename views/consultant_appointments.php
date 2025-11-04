<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <i class="fa fa-calendar"></i> My Appointments
                        </h4>
                        <hr class="hr-panel-heading">

                        <!-- Statistics Cards -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="panel_s">
                                    <div class="panel-body text-center" style="background: #f8f9fa; padding: 20px;">
                                        <h3 class="bold no-margin"><?php echo $statistics['total']; ?></h3>
                                        <p class="text-muted">Total Appointments</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="panel_s">
                                    <div class="panel-body text-center" style="background: #fff3cd; padding: 20px;">
                                        <h3 class="bold no-margin"><?php echo $statistics['pending']; ?></h3>
                                        <p class="text-muted">Pending</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="panel_s">
                                    <div class="panel-body text-center" style="background: #d4edda; padding: 20px;">
                                        <h3 class="bold no-margin"><?php echo $statistics['confirmed']; ?></h3>
                                        <p class="text-muted">Confirmed</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="panel_s">
                                    <div class="panel-body text-center" style="background: #d1ecf1; padding: 20px;">
                                        <h3 class="bold no-margin"><?php echo $statistics['today']; ?></h3>
                                        <p class="text-muted">Today's Appointments</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Appointments Table -->
                        <div class="row mtop15">
                            <div class="col-md-12">
                                <table class="table dt-table" id="appointments-table">
                                    <thead>
                                        <tr>
                                            <th>Appointment #</th>
                                            <th>Patient Name</th>
                                            <th>Patient #</th>
                                            <th>Mobile</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Reason</th>
                                            <th>Mode</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($appointments as $apt): ?>
                                            <tr>
                                                <td><?php echo $apt['appointment_number']; ?></td>
                                                <td>
                                                    <strong><?php echo $apt['patient_name']; ?></strong>
                                                    <?php if ($apt['is_new_patient']): ?>
                                                        <span class="label label-info">New</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo $apt['patient_number']; ?></td>
                                                <td><?php echo $apt['patient_mobile']; ?></td>
                                                <td><?php echo date('d M Y', strtotime($apt['appointment_date'])); ?></td>
                                                <td><?php echo date('h:i A', strtotime($apt['appointment_time'])); ?></td>
                                                <td>
                                                    <?php 
                                                        $reason_badges = [
                                                            'consultation' => 'label-default',
                                                            'procedure' => 'label-primary',
                                                            'surgery' => 'label-danger'
                                                        ];
                                                        $badge = $reason_badges[$apt['reason_for_appointment']] ?? 'label-default';
                                                    ?>
                                                    <span class="label <?php echo $badge; ?>">
                                                        <?php echo ucfirst($apt['reason_for_appointment']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if ($apt['patient_mode'] === 'walk_in'): ?>
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
                                                        $status_badge = $status_badges[$apt['status']] ?? 'label-default';
                                                    ?>
                                                    <span class="label <?php echo $status_badge; ?>">
                                                        <?php echo ucfirst($apt['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <!-- SEE PATIENT BUTTON -->
                                                    <?php if ($apt['status'] !== 'cancelled' && $apt['status'] !== 'completed'): ?>
                                                        <a href="<?php echo admin_url('hospital_management/consultant_see_patient/' . $apt['id']); ?>" 
                                                           class="btn btn-info btn-sm" 
                                                           title="See Patient">
                                                            <i class="fa fa-user-md"></i> See Patient
                                                        </a>
                                                    <?php endif; ?>
                                                    
                                                    <!-- VIEW DETAILS -->
                                                    <a href="#" 
                                                       class="btn btn-default btn-sm view-appointment" 
                                                       data-id="<?php echo $apt['id']; ?>"
                                                       title="View Details">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Appointment Modal -->
<div class="modal fade" id="viewAppointmentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Appointment Details</h4>
            </div>
            <div class="modal-body" id="appointment-details-content">
                <div class="text-center">
                    <i class="fa fa-spinner fa-spin fa-3x"></i>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>

<script>
$(function() {
    'use strict';
    
    // Initialize DataTable
    var appointmentsTable = $('#appointments-table').DataTable({
        order: [[4, 'desc'], [5, 'desc']], // Sort by date and time
        pageLength: 25,
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search appointments..."
        }
    });
    
    // View appointment details
    $(document).on('click', '.view-appointment', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        
        $('#viewAppointmentModal').modal('show');
        $('#appointment-details-content').html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-3x"></i></div>');
        
        $.get(admin_url + 'hospital_management/get_appointment_details/' + id, function(response) {
            $('#appointment-details-content').html(response);
        }).fail(function() {
            $('#appointment-details-content').html('<div class="alert alert-danger">Error loading appointment details</div>');
        });
    });
});
</script>