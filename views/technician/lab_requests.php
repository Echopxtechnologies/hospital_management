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
    
    .stat-card.stat-available {
        border-left-color: #17a2b8;
    }
    
    .stat-card.stat-assigned {
        border-left-color: #ffc107;
    }
    
    .stat-card.stat-progress {
        border-left-color: #007bff;
    }
    
    .stat-card.stat-completed {
        border-left-color: #28a745;
    }
    
    .stat-card.stat-urgent {
        border-left-color: #dc3545;
    }
    
    .request-item {
        margin-bottom: 20px;
    }
    
    .request-item .panel_s {
        transition: all 0.3s ease;
        height: 100%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .request-item .panel_s:hover {
        box-shadow: 0 6px 16px rgba(0,0,0,0.15);
        transform: translateY(-3px);
    }
    
    .filter-btn.active {
        background-color: #17a2b8;
        color: white;
        border-color: #17a2b8;
    }
    
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
    
    .badge-hospital {
        background: #17a2b8;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 12px;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }
    
    .empty-state i {
        font-size: 64px;
        color: #dee2e6;
        margin-bottom: 20px;
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
                        View and manage your assigned lab requests
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
                    <small class="text-muted">High priority</small>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row mtop20">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <!-- Filter Bar -->
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="no-margin">
                                    <i class="fa fa-list"></i> My Lab Requests
                                    <span class="badge-hospital"><?php echo count($requests); ?> Total</span>
                                </h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default filter-btn active" data-filter="all">
                                        <i class="fa fa-list"></i> All 
                                        <span class="badge"><?php echo count($requests); ?></span>
                                    </button>
                                    <button type="button" class="btn btn-default filter-btn" data-filter="approved">
                                        <i class="fa fa-inbox"></i> Available
                                        <span class="badge badge-info"><?php 
                                            $available = 0;
                                            foreach ($requests as $r) {
                                                if ($r['status'] == 'approved') $available++;
                                            }
                                            echo $available;
                                        ?></span>
                                    </button>
                                    <button type="button" class="btn btn-default filter-btn" data-filter="in_progress">
                                        <i class="fa fa-spinner"></i> Working
                                        <span class="badge badge-primary"><?php 
                                            $in_progress = 0;
                                            foreach ($requests as $r) {
                                                if ($r['status'] == 'in_progress') $in_progress++;
                                            }
                                            echo $in_progress;
                                        ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr class="hr-panel-heading">
                        
                        <?php if (empty($requests)): ?>
                            <!-- Empty State -->
                            <div class="empty-state">
                                <i class="fa fa-clipboard"></i>
                                <h4>No Lab Requests Available</h4>
                                <p class="text-muted">
                                    There are currently no lab requests assigned to you or available for pickup.<br>
                                    New requests will appear here once they are approved by the receptionist.
                                </p>
                            </div>
                        <?php else: ?>
                            <!-- Requests Grid -->
                            <div class="row" id="requests-container">
                                <?php foreach ($requests as $request): ?>
                                    <div class="col-md-6 col-lg-4 request-item" data-status="<?php echo $request['status']; ?>">
                                        <div class="panel_s" style="border-left: 4px solid <?php 
                                            echo $request['priority'] == 'emergency' ? '#dc3545' : 
                                                 ($request['priority'] == 'urgent' ? '#ffc107' : '#28a745'); 
                                        ?>;">
                                            <div class="panel-body">
                                                <!-- Header -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h5 class="bold no-margin" style="color: #17a2b8;">
                                                            <i class="fa fa-flask"></i> <?php echo $request['request_number']; ?>
                                                        </h5>
                                                        <p class="text-muted no-margin" style="font-size: 12px; margin-top: 5px;">
                                                            <i class="fa fa-user-circle"></i> 
                                                            <?php echo $request['patient_name']; ?>
                                                        </p>
                                                        <p class="text-muted no-margin" style="font-size: 11px;">
                                                            <?php echo $request['patient_number']; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                                <hr style="margin: 10px 0;">
                                                
                                                <!-- Request Details -->
                                                <div class="mtop10">
                                                    <p class="text-muted no-margin" style="font-size: 13px;">
                                                        <i class="fa fa-flask"></i> <strong>Category:</strong> 
                                                        <span class="pull-right"><?php echo $request['category_name']; ?></span>
                                                    </p>
                                                    <p class="text-muted no-margin" style="font-size: 13px;">
                                                        <i class="fa fa-list"></i> <strong>Items:</strong> 
                                                        <span class="pull-right"><?php echo $request['items_count']; ?> items</span>
                                                    </p>
                                                    <p class="text-muted no-margin" style="font-size: 13px;">
                                                        <i class="fa fa-user-md"></i> <strong>Doctor:</strong> 
                                                        <span class="pull-right">Dr <?php echo $request['doctor_firstname'] . ' ' . $request['doctor_lastname']; ?></span>
                                                    </p>
                                                    <p class="text-muted no-margin" style="font-size: 13px;">
                                                        <i class="fa fa-calendar"></i> <strong>Date:</strong> 
                                                        <span class="pull-right"><?php echo _dt($request['created_at']); ?></span>
                                                    </p>
                                                </div>
                                                
                                                <hr style="margin: 10px 0;">
                                                
                                                <!-- Status & Priority -->
                                                <div class="mtop10">
                                                    <div class="row">
                                                        <div class="col-xs-6">
                                                            <strong style="font-size: 12px;">Priority:</strong><br>
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
                                                        </div>
                                                        <div class="col-xs-6 text-right">
                                                            <strong style="font-size: 12px;">Status:</strong><br>
                                                            <?php if ($request['status'] == 'approved'): ?>
                                                                <span class="label label-info">
                                                                    <i class="fa fa-inbox"></i> Available
                                                                </span>
                                                            <?php elseif ($request['status'] == 'in_progress'): ?>
                                                                <span class="label label-primary">
                                                                    <i class="fa fa-spinner fa-spin"></i> In Progress
                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Actions -->
                                                <div class="mtop15 text-right">
                                                    <a href="<?php echo admin_url('hospital_management/lab_request/' . $request['id']); ?>" 
                                                       class="btn btn-sm"
                                                       style="background: #17a2b8; color: white;">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
                                                    
                                                    <?php if ($request['status'] == 'approved'): ?>
                                                        <button type="button" 
                                                                class="btn btn-info btn-sm start-btn" 
                                                                data-id="<?php echo $request['id']; ?>"
                                                                data-request="<?php echo $request['request_number']; ?>">
                                                            <i class="fa fa-play"></i> Start Work
                                                        </button>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($request['status'] == 'in_progress'): ?>
                                                        <button type="button" 
                                                                class="btn btn-success btn-sm complete-btn" 
                                                                data-id="<?php echo $request['id']; ?>"
                                                                data-request="<?php echo $request['request_number']; ?>">
                                                            <i class="fa fa-check"></i> Complete
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
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
    
    // Filter buttons
    $('.filter-btn').on('click', function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
        
        var filter = $(this).data('filter');
        
        if (filter === 'all') {
            $('.request-item').slideDown(300);
        } else {
            $('.request-item').hide();
            $('.request-item[data-status="' + filter + '"]').slideDown(300);
        }
    });
    
    // Start processing
    $('.start-btn').on('click', function() {
        var $btn = $(this);
        var id = $btn.data('id');
        var requestNum = $btn.data('request');
        
        if (confirm('Start processing request ' + requestNum + '?\n\nThis will open the lab report form.')) {
            var originalHtml = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Starting...');
            
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
    $('.complete-btn').on('click', function() {
        var $btn = $(this);
        var id = $btn.data('id');
        var requestNum = $btn.data('request');
        
        if (confirm('Mark request ' + requestNum + ' as completed?\n\nThe lab amount will be added to the visit bill.')) {
            var notes = prompt('Add completion notes (optional):');
            
            var originalHtml = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Completing...');
            
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