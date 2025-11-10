<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<style>
/* Simple Medical Theme - Aqua Blue */
.medical-header {
    background: linear-gradient(135deg, #17a2b8 0%, #20c9e7 100%);
    color: white;
    padding: 20px;
    border-radius: 5px;
    margin-bottom: 20px;
}

.medical-header h4 {
    margin: 0;
    color: white;
}

/* Statistics Cards - Simple Rectangle Design */
.stats-row {
    margin-bottom: 20px;
}

.stat-box {
    background: white;
    border: 1px solid #17a2b8;
    border-left: 4px solid #17a2b8;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 15px;
}

.stat-box.confirmed {
    border-left-color: #28a745;
}

.stat-box.completed {
    border-left-color: #007bff;
}

.stat-box h3 {
    margin: 0 0 5px 0;
    color: #17a2b8;
    font-size: 28px;
    font-weight: 600;
}

.stat-box.confirmed h3 {
    color: #28a745;
}

.stat-box.completed h3 {
    color: #007bff;
}

.stat-box p {
    margin: 0;
    color: #666;
    font-size: 13px;
}

/* Filter Section */
.filter-section {
    background: #f8f9fa;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 20px;
}

.filter-section .section-title {
    margin-top: 0;
}

.filter-btn-group {
    margin-bottom: 10px;
}

.filter-btn-group .btn {
    margin-right: 5px;
    margin-bottom: 5px;
}

.btn-filter {
    background: white;
    border: 1px solid #17a2b8;
    color: #17a2b8;
}

.btn-filter:hover,
.btn-filter.active {
    background: #17a2b8;
    color: white;
    border-color: #17a2b8;
}

/* Table Styling */
.table-container {
    background: white;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 20px;
}

.table thead {
    background: #17a2b8;
    color: white;
}

.table thead th {
    border-color: #17a2b8;
    font-weight: 600;
}

.section-title {
    color: #17a2b8;
    font-weight: 600;
    margin-bottom: 15px;
}

/* Labels */
.label {
    padding: 5px 10px;
    border-radius: 3px;
    font-size: 11px;
    font-weight: 600;
}

/* Buttons */
.btn-medical {
    background: #17a2b8;
    color: white;
    border: none;
}

.btn-medical:hover {
    background: #138496;
    color: white;
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
                            <h4>
                                <i class="fa fa-calendar"></i> My Appointments
                            </h4>
                        </div>

                        <!-- Statistics Cards - 3 Boxes (Removed Pending) -->
                        <div class="row stats-row">
                            <div class="col-md-4">
                                <div class="stat-box">
                                    <h3><?php echo $statistics['total']; ?></h3>
                                    <p>Total Appointments</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-box confirmed">
                                    <h3><?php echo $statistics['confirmed']; ?></h3>
                                    <p>Confirmed</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-box completed">
                                    <h3><?php echo $statistics['completed']; ?></h3>
                                    <p>Completed</p>
                                </div>
                            </div>
                        </div>

                        <!-- Date Filter Section -->
                        <div class="filter-section">
                            <h4 class="section-title">
                                <i class="fa fa-filter"></i> Filter Appointments
                            </h4>
                            
                            <?php echo form_open(admin_url('hospital_management/consultant_appointments'), ['method' => 'get']); ?>
                            
                            <!-- Quick Filter Buttons -->
                            <div class="filter-btn-group">
                                <button type="submit" 
                                        name="filter_type" 
                                        value="today" 
                                        class="btn btn-filter <?php echo ($filter_type == 'today') ? 'active' : ''; ?>">
                                    <i class="fa fa-calendar-day"></i> Today
                                </button>
                                <button type="submit" 
                                        name="filter_type" 
                                        value="week" 
                                        class="btn btn-filter <?php echo ($filter_type == 'week') ? 'active' : ''; ?>">
                                    <i class="fa fa-calendar-week"></i> This Week
                                </button>
                                <button type="submit" 
                                        name="filter_type" 
                                        value="month" 
                                        class="btn btn-filter <?php echo ($filter_type == 'month') ? 'active' : ''; ?>">
                                    <i class="fa fa-calendar"></i> This Month
                                </button>
                                <button type="submit" 
                                        name="filter_type" 
                                        value="all" 
                                        class="btn btn-filter <?php echo ($filter_type == 'all') ? 'active' : ''; ?>">
                                    <i class="fa fa-list"></i> All Appointments
                                </button>
                            </div>

                            <!-- Custom Date Range -->
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="from_date">From Date</label>
                                        <input type="date" 
                                               class="form-control" 
                                               name="from_date" 
                                               id="from_date" 
                                               value="<?php echo $from_date; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="to_date">To Date</label>
                                        <input type="date" 
                                               class="form-control" 
                                               name="to_date" 
                                               id="to_date" 
                                               value="<?php echo $to_date; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label><br>
                                        <button type="submit" 
                                                name="filter_type" 
                                                value="custom" 
                                                class="btn btn-medical">
                                            <i class="fa fa-filter"></i> Apply Filter
                                        </button>
                                        <a href="<?php echo admin_url('hospital_management/consultant_appointments'); ?>" 
                                           class="btn btn-default">
                                            <i class="fa fa-refresh"></i> Reset
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label><br>
                                        <span class="text-muted">
                                            <i class="fa fa-info-circle"></i> 
                                            <?php echo $filter_info; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <?php echo form_close(); ?>
                        </div>

                        <!-- Appointments Table -->
                        <div class="table-container">
                            <h4 class="section-title">
                                <i class="fa fa-list"></i> Appointments List 
                                <span class="text-muted">(<?php echo count($appointments); ?> records)</span>
                            </h4>
                            
                            <?php if (!empty($appointments)): ?>
                            <table class="table table-striped table-hover dt-table" id="appointments-table">
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
                                            <td>
                                                <strong style="color: #17a2b8;">
                                                    <?php echo $apt['appointment_number']; ?>
                                                </strong>
                                            </td>
                                            <td>
                                                <strong><?php echo $apt['patient_name']; ?></strong>
                                                <?php if (!empty($apt['is_new_patient']) && $apt['is_new_patient']): ?>
                                                    <br><span class="label label-info">New</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo $apt['patient_number']; ?></td>
                                            <td><?php echo $apt['patient_mobile']; ?></td>
                                            <td><?php echo date('d M Y', strtotime($apt['appointment_date'])); ?></td>
                                            <td><?php echo date('h:i A', strtotime($apt['appointment_time'])); ?></td>
                                            <td>
                                                <?php 
                                                    if (!empty($apt['reason_for_appointment'])) {
                                                        $reason_badges = [
                                                            'consultation' => 'label-default',
                                                            'procedure' => 'label-primary',
                                                            'surgery' => 'label-danger'
                                                        ];
                                                        $badge = $reason_badges[$apt['reason_for_appointment']] ?? 'label-default';
                                                        echo '<span class="label ' . $badge . '">' . ucfirst($apt['reason_for_appointment']) . '</span>';
                                                    } else {
                                                        echo '<span class="label label-default">N/A</span>';
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    if (!empty($apt['patient_mode'])) {
                                                        if ($apt['patient_mode'] === 'walk_in') {
                                                            echo '<span class="label label-warning">Walk-in</span>';
                                                        } else {
                                                            echo '<span class="label label-info">Appointment</span>';
                                                        }
                                                    } else {
                                                        echo '<span class="label label-default">N/A</span>';
                                                    }
                                                ?>
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
                                                <!-- SEE PATIENT BUTTON - Only for confirmed appointments -->
                                                <?php if ($apt['status'] === 'confirmed'): ?>
                                                    <a href="<?php echo admin_url('hospital_management/consultant_see_patient/' . $apt['id']); ?>" 
                                                       class="btn btn-medical btn-sm" 
                                                       title="See Patient">
                                                        <i class="fa fa-user-md"></i> See Patient
                                                    </a>
                                                <?php endif; ?>
                                                
                                                <!-- VIEW PATIENT DETAILS - Only if visit exists -->
                                                <?php if (!empty($apt['visit_id'])): ?>
                                                    <a href="<?php echo admin_url('hospital_management/view_visit/' . $apt['visit_id']); ?>" 
                                                       class="btn btn-sm btn-info" 
                                                       target="_blank"
                                                       title="View Visit Details">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php else: ?>
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> No appointments found for the selected date range.
                            </div>
                            <?php endif; ?>
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
    $('#appointments-table').DataTable({
        order: [[4, 'desc'], [5, 'desc']], // Sort by date and time
        pageLength: 25,
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search appointments..."
        }
    });
});
</script>