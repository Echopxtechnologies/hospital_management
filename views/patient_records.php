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
    .stat-card {
        background: #f8f9fa;
        border-left: 4px solid #17a2b8;
        padding: 20px;
        border-radius: 5px;
    }
    .stat-card h3 {
        color: #17a2b8;
        font-weight: bold;
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
                                        <i class="fa fa-users"></i> Patient Records
                                    </h4>
                                </div>
                                <div class="col-md-4 text-right">
                                    <a href="<?php echo admin_url('hospital_management/manage_patient'); ?>" 
                                       class="btn btn-light"
                                        style="background: #f8fcfdff; color: black;">
                                        <i class="fa fa-plus"></i> Add New Patient
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Statistics -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <h3 class="no-margin"><?php echo count($patients); ?></h3>
                                    <p class="text-muted">Total Patients</p>
                                </div>
                            </div>
                        </div>

                        <!-- Patients Table -->
                        <div class="row mtop15">
                            <div class="col-md-12">
                                <table class="table dt-table table-hover" id="patients-table">
                                    <thead style="background: #17a2b8; color: white;">
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
                                                    <strong style="color: #17a2b8;"><?php echo $patient->patient_number; ?></strong>
                                                </td>
                                                <td>
                                                    <a href="<?php echo admin_url('hospital_management/view_patient/' . $patient->id); ?>" 
                                                       style="color: #17a2b8; font-weight: 600;">
                                                        <?php echo $patient->name; ?>
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
                                                    <span class="label" style="background: #17a2b8;">
                                                        <?php echo $patient->patient_type; ?>
                                                    </span>
                                                </td>
                                                <td><?php echo $patient->city ?: '-'; ?></td>
                                                <td><?php echo date('d M Y', strtotime($patient->created_at)); ?></td>
                                                <td>
                                                    <a href="<?php echo admin_url('hospital_management/view_patient/' . $patient->id); ?>" 
                                                       class="btn btn-sm" 
                                                       style="background: #17a2b8; color: white;"
                                                       title="View Details">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    
                                                    <a href="<?php echo admin_url('hospital_management/manage_patient/' . $patient->id); ?>" 
                                                       class="btn btn-primary btn-sm" 
                                                    style="background: #17a2b8; color: white;"
                                                       title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    
                                                    <?php if (has_permission('hospital_management', '', 'delete')): ?>
                                                        <a href="<?php echo admin_url('hospital_management/delete_patient/' . $patient->id); ?>" 
                                                           class="btn btn-danger btn-sm delete-patient" 
                                                            style="color: white;"
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