<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="no-margin">
                                    <i class="fa fa-users"></i> Patient Records
                                </h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="<?php echo admin_url('hospital_management/manage_patient'); ?>" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Add New Patient
                                </a>
                            </div>
                        </div>
                        <hr class="hr-panel-heading">

                        <!-- Statistics -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="panel_s">
                                    <div class="panel-body text-center" style="background: #f8f9fa; padding: 20px;">
                                        <h3 class="bold no-margin"><?php echo count($patients); ?></h3>
                                        <p class="text-muted">Total Patients</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Patients Table -->
                        <div class="row mtop15">
                            <div class="col-md-12">
                                <table class="table dt-table" id="patients-table">
                                    <thead>
                                        <tr>
                                            <th>Patient #</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Age</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Patient Type</th>
                                            <th>City</th>
                                            <th>Registered</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($patients as $patient): ?>
                                            <tr>
                                                <td>
                                                    <strong><?php echo $patient->patient_number; ?></strong>
                                                </td>
                                                <td>
                                                    <a href="<?php echo admin_url('hospital_management/view_patient/' . $patient->id); ?>">
                                                        <strong><?php echo $patient->name; ?></strong>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $gender_icons = [
                                                            'male' => 'fa-mars text-primary',
                                                            'female' => 'fa-venus text-danger',
                                                            'other' => 'fa-genderless'
                                                        ];
                                                        $icon = $gender_icons[$patient->gender] ?? 'fa-genderless';
                                                    ?>
                                                    <i class="fa <?php echo $icon; ?>"></i> 
                                                    <?php echo ucfirst($patient->gender); ?>
                                                </td>
                                                <td><?php echo $patient->age ?: '-'; ?></td>
                                                <td><?php echo $patient->mobile_number; ?></td>
                                                <td><?php echo $patient->email ?: '-'; ?></td>
                                                <td>
                                                    <span class="label label-default">
                                                        <?php echo $patient->patient_type; ?>
                                                    </span>
                                                </td>
                                                <td><?php echo $patient->city ?: '-'; ?></td>
                                                <td><?php echo date('d M Y', strtotime($patient->created_at)); ?></td>
                                                <td>
                                                    <a href="<?php echo admin_url('hospital_management/view_patient/' . $patient->id); ?>" 
                                                       class="btn btn-default btn-sm" 
                                                       title="View Details">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    
                                                    <a href="<?php echo admin_url('hospital_management/manage_patient/' . $patient->id); ?>" 
                                                       class="btn btn-primary btn-sm" 
                                                       title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    
                                                    <?php if (has_permission('hospital_management', '', 'delete')): ?>
                                                        <a href="<?php echo admin_url('hospital_management/delete_patient/' . $patient->id); ?>" 
                                                           class="btn btn-danger btn-sm delete-patient" 
                                                           title="Delete"
                                                           onclick="return confirm('Are you sure you want to delete this patient and all related records?');">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    <?php endif; ?>
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

<?php init_tail(); ?>

<script>
$(function() {
    'use strict';
    
    // Initialize DataTable
    $('#patients-table').DataTable({
        order: [[8, 'desc']], // Sort by registered date
        pageLength: 25,
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search patients..."
        },
        columnDefs: [
            {
                targets: [9], // Actions column
                orderable: false
            }
        ]
    });
});
</script>