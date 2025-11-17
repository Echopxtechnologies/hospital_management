<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<style>
    /* Hospital Theme Styling */
    .hospital-header {
        background: linear-gradient(135deg, #17a2b8 0%, #20c9e7 100%);
        color: white;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .stat-card {
        background: white;
        border-left: 4px solid #17a2b8;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    
    .stat-card h3 {
        color: #17a2b8;
        font-weight: bold;
        margin: 0;
    }
    
    .stat-card.stat-available { border-left-color: #17a2b8; }
    .stat-card.stat-assigned { border-left-color: #ffc107; }
    .stat-card.stat-progress { border-left-color: #007bff; }
    .stat-card.stat-completed { border-left-color: #28a745; }
    .stat-card.stat-urgent { border-left-color: #dc3545; }
    
    .priority-indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }
    
    .priority-emergency {
        background-color: #dc3545;
        animation: pulse 1.5s infinite;
    }
    
    .priority-urgent {
        background-color: #ffc107;
    }
    
    .priority-normal {
        background-color: #28a745;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    /* DataTable custom styling */
    .table-lab-requests {
        font-size: 13px;
    }
    
    .table-lab-requests td {
        vertical-align: middle !important;
    }
    
    .btn-action-group {
        white-space: nowrap;
    }
    
    .btn-action-group .btn {
        margin-right: 5px;
    }
</style>

<div id="wrapper">
    <div class="content">
        <!-- Header -->
        <div class="hospital-header">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="no-margin">
                        <i class="fa fa-flask"></i> Lab Requests Portal
                    </h3>
                    <p class="no-margin" style="opacity: 0.9; margin-top: 5px;">
                        View and manage your assigned lab test requests (Category 1 only)
                    </p>
                </div>
                <div class="col-md-4 text-right">
                    <h4 class="no-margin">
                        <i class="fa fa-user-md"></i> Technician Portal
                    </h4>
                    <p class="no-margin" style="opacity: 0.9; margin-top: 5px;">
                        <?php echo date('l, F j, Y'); ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <!-- Available Requests (Approved) -->
            <div class="col-md-2 col-sm-6">
                <div class="stat-card stat-available">
                    <h3><?php echo isset($statistics['available']) ? (int)$statistics['available'] : 0; ?></h3>
                    <p class="text-muted no-margin">
                        <i class="fa fa-inbox"></i> Available
                    </p>
                    <small class="text-muted">Ready to pick up</small>
                </div>
            </div>
            
            <!-- Assigned to Me -->
            <div class="col-md-2 col-sm-6">
                <div class="stat-card stat-assigned">
                    <h3><?php echo isset($statistics['assigned']) ? (int)$statistics['assigned'] : 0; ?></h3>
                    <p class="text-muted no-margin">
                        <i class="fa fa-hand-paper-o"></i> Assigned
                    </p>
                    <small class="text-muted">Picked by me</small>
                </div>
            </div>
            
            <!-- In Progress -->
            <div class="col-md-2 col-sm-6">
                <div class="stat-card stat-progress">
                    <h3><?php echo isset($statistics['in_progress']) ? (int)$statistics['in_progress'] : 0; ?></h3>
                    <p class="text-muted no-margin">
                        <i class="fa fa-spinner"></i> In Progress
                    </p>
                    <small class="text-muted">Working on</small>
                </div>
            </div>
            
            <!-- Completed -->
            <div class="col-md-2 col-sm-6">
                <div class="stat-card stat-completed">
                    <h3><?php echo isset($statistics['completed']) ? (int)$statistics['completed'] : 0; ?></h3>
                    <p class="text-muted no-margin">
                        <i class="fa fa-check-circle"></i> Completed
                    </p>
                    <small class="text-muted">All time</small>
                </div>
            </div>
            
            <!-- Today's Completed -->
            <div class="col-md-2 col-sm-6">
                <div class="stat-card stat-completed">
                    <h3><?php echo isset($statistics['today_completed']) ? (int)$statistics['today_completed'] : 0; ?></h3>
                    <p class="text-muted no-margin">
                        <i class="fa fa-calendar-check-o"></i> Today
                    </p>
                    <small class="text-muted">Completed today</small>
                </div>
            </div>
            
            <!-- Urgent -->
            <div class="col-md-2 col-sm-6">
                <div class="stat-card stat-urgent">
                    <h3><?php echo isset($statistics['urgent']) ? (int)$statistics['urgent'] : 0; ?></h3>
                    <p class="text-muted no-margin">
                        <i class="fa fa-exclamation-triangle"></i> Urgent
                    </p>
                    <small class="text-muted">Needs attention</small>
                </div>
            </div>
        </div>

        <!-- DataTable -->
        <div class="row mtop20">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="clearfix"></div>
                        
                        <!-- DataTable -->
                        <table class="table dt-table table-lab-requests table-striped table-hover" data-order-col="0" data-order-type="desc">
                            <thead>
                                <tr>
                                    <th>Request #</th>
                                    <th>Patient</th>
                                    <th>Visit #</th>
                                    <th>Category</th>
                                    <th>Items</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Requested By</th>
                                    <th>Technician</th>
                                    <th>Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($requests)): ?>
                                    <?php foreach ($requests as $request): ?>
                                        <tr>
                                            <!-- Request Number -->
                                            <td>
                                                <strong><?php echo $request['request_number']; ?></strong>
                                            </td>
                                            
                                            <!-- Patient Info -->
                                            <td>
                                                <strong><?php echo $request['patient_name']; ?></strong><br>
                                                <small class="text-muted">
                                                    <?php echo $request['patient_number']; ?> | 
                                                    <?php echo $request['patient_age']; ?>Y / <?php echo $request['patient_gender']; ?>
                                                </small>
                                            </td>
                                            
                                            <!-- Visit Number -->
                                            <td>
                                                <?php echo $request['visit_number']; ?><br>
                                                <small class="text-muted"><?php echo date('d M Y', strtotime($request['visit_date'])); ?></small>
                                            </td>
                                            
                                            <!-- Category -->
                                            <td>
                                                <span class="label label-info">
                                                    <?php echo $request['category_name']; ?>
                                                </span>
                                            </td>
                                            
                                            <!-- Items Count -->
                                            <td class="text-center">
                                                <span class="badge badge-primary">
                                                    <?php echo $request['items_count']; ?> item(s)
                                                </span>
                                            </td>
                                            
                                            <!-- Priority -->
                                            <td>
                                                <?php if ($request['priority'] == 'emergency'): ?>
                                                    <span class="label label-danger">
                                                        <span class="priority-indicator priority-emergency"></span> EMERGENCY
                                                    </span>
                                                <?php elseif ($request['priority'] == 'urgent'): ?>
                                                    <span class="label label-warning">
                                                        <span class="priority-indicator priority-urgent"></span> URGENT
                                                    </span>
                                                <?php else: ?>
                                                    <span class="label label-success">
                                                        <span class="priority-indicator priority-normal"></span> NORMAL
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            
                                            <!-- Status -->
                                            <td>
                                                <?php if ($request['status'] == 'approved'): ?>
                                                    <span class="label label-info">
                                                        <i class="fa fa-inbox"></i> Available
                                                    </span>
                                                <?php elseif ($request['status'] == 'in_progress'): ?>
                                                    <span class="label label-primary">
                                                        <i class="fa fa-spinner fa-spin"></i> In Progress
                                                    </span>
                                                <?php elseif ($request['status'] == 'completed'): ?>
                                                    <span class="label label-success">
                                                        <i class="fa fa-check-circle"></i> Completed
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            
                                            <!-- Requested By -->
                                            <td>
                                                <small>
                                                    <?php echo $request['doctor_firstname'] . ' ' . $request['doctor_lastname']; ?>
                                                </small>
                                            </td>
                                            
                                            <!-- Technician -->
                                            <td>
                                                <?php if (!empty($request['technician_firstname'])): ?>
                                                    <small>
                                                        <?php echo $request['technician_firstname'] . ' ' . $request['technician_lastname']; ?>
                                                    </small>
                                                <?php else: ?>
                                                    <small class="text-muted">Not assigned</small>
                                                <?php endif; ?>
                                            </td>
                                            
                                            <!-- Date -->
                                            <td>
                                                <small><?php echo date('d M Y', strtotime($request['created_at'])); ?></small><br>
                                                <small class="text-muted"><?php echo date('h:i A', strtotime($request['created_at'])); ?></small>
                                            </td>
                                            
                                            <!-- Actions -->
                                            <td class="text-center btn-action-group">
                                                <a href="<?php echo admin_url('hospital_management/lab_request/' . $request['id']); ?>" 
                                                   class="btn btn-sm btn-info"
                                                   data-toggle="tooltip" 
                                                   title="View Details">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                
                                                <?php if ($request['status'] == 'approved'): ?>
                                                    <button type="button" 
                                                            class="btn btn-primary btn-sm start-btn" 
                                                            data-id="<?php echo $request['id']; ?>"
                                                            data-request="<?php echo $request['request_number']; ?>"
                                                            data-toggle="tooltip" 
                                                            title="Start Processing">
                                                        <i class="fa fa-play"></i>
                                                    </button>
                                                <?php endif; ?>
                                                
                                                <?php if ($request['status'] == 'in_progress'): ?>
                                                    <button type="button" 
                                                            class="btn btn-success btn-sm complete-btn" 
                                                            data-id="<?php echo $request['id']; ?>"
                                                            data-request="<?php echo $request['request_number']; ?>"
                                                            data-toggle="tooltip" 
                                                            title="Mark as Complete">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>

<script>
var csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';
var csrfTokenHash = '<?php echo $this->security->get_csrf_hash(); ?>';

$(function() {
    'use strict';
    
    // Initialize DataTable
    initDataTable('.table-lab-requests', window.location.href, [10], [10], {
        "order": [[9, "desc"]], // Order by date column (index 9)
        "pageLength": 25,
        "responsive": true,
        "columnDefs": [
            {
                "targets": [10], // Actions column
                "orderable": false,
                "searchable": false
            }
        ],
        "drawCallback": function(settings) {
            // Re-initialize tooltips after table redraw
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
    
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Start processing
    $(document).on('click', '.start-btn', function() {
        var $btn = $(this);
        var id = $btn.data('id');
        var requestNum = $btn.data('request');
        
        if (confirm('Start processing request ' + requestNum + '?\n\nThis will assign the request to you and open the lab report form.')) {
            var originalHtml = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            
            var data = {
                request_id: id
            };
            data[csrfTokenName] = csrfTokenHash;
            
            $.ajax({
                url: '<?php echo admin_url("hospital_management/start_request"); ?>',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response && response.success) {
                        if (response.csrf_token_name) {
                            csrfTokenName = response.csrf_token_name;
                        }
                        if (response.csrf_token_hash) {
                            csrfTokenHash = response.csrf_token_hash;
                        }
                        
                        alert_float('success', response.message || 'Request started successfully');
                        
                        if (response.redirect_url) {
                            window.location.href = response.redirect_url;
                        } else {
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        }
                    } else {
                        alert_float('danger', response.message || 'Failed to start request');
                        $btn.prop('disabled', false).html(originalHtml);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert_float('danger', 'Network error. Please try again.');
                    $btn.prop('disabled', false).html(originalHtml);
                }
            });
        }
    });
    
    // Complete request
    $(document).on('click', '.complete-btn', function() {
        var $btn = $(this);
        var id = $btn.data('id');
        var requestNum = $btn.data('request');
        
        if (confirm('Mark request ' + requestNum + ' as completed?\n\nThe lab amount will be added to the visit bill.')) {
            var notes = prompt('Add completion notes (optional):');
            
            var originalHtml = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            
            var data = {
                request_id: id,
                notes: notes || ''
            };
            data[csrfTokenName] = csrfTokenHash;
            
            $.ajax({
                url: '<?php echo admin_url("hospital_management/complete_request"); ?>',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response && response.success) {
                        if (response.csrf_token_name) {
                            csrfTokenName = response.csrf_token_name;
                        }
                        if (response.csrf_token_hash) {
                            csrfTokenHash = response.csrf_token_hash;
                        }
                        
                        alert_float('success', response.message || 'Request completed successfully');
                        
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        alert_float('danger', response.message || 'Failed to complete request');
                        $btn.prop('disabled', false).html(originalHtml);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert_float('danger', 'Network error. Please try again.');
                    $btn.prop('disabled', false).html(originalHtml);
                }
            });
        }
    });
});
</script>