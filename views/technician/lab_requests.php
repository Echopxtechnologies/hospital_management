<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <!-- Statistics Cards -->
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <h3 class="text-info"><?php echo $statistics['assigned']; ?></h3>
                                <p class="text-muted">Assigned to Me</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <h3 class="text-primary"><?php echo $statistics['in_progress']; ?></h3>
                                <p class="text-muted">In Progress</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <h3 class="text-success"><?php echo $statistics['completed']; ?></h3>
                                <p class="text-muted">Completed</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <h3 class="text-success"><?php echo $statistics['today_completed']; ?></h3>
                                <p class="text-muted">Today's Completed</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <h3 class="text-danger"><?php echo $statistics['urgent']; ?></h3>
                                <p class="text-muted">Urgent</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="no-margin">
                                    <i class="fa fa-flask text-primary"></i> My Lab Requests
                                </h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default filter-btn active" data-filter="all">
                                        All <span class="badge"><?php echo count($requests); ?></span>
                                    </button>
                                    <button type="button" class="btn btn-default filter-btn" data-filter="approved">
                                        New <span class="badge badge-info"><?php echo $statistics['assigned']; ?></span>
                                    </button>
                                    <button type="button" class="btn btn-default filter-btn" data-filter="in_progress">
                                        In Progress <span class="badge badge-primary"><?php echo $statistics['in_progress']; ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr class="hr-panel-heading">
                        
                        <?php if (empty($requests)): ?>
                            <div class="alert alert-info text-center">
                                <i class="fa fa-info-circle"></i> No requests assigned to you.
                            </div>
                        <?php else: ?>
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
                                                        <h5 class="bold no-margin">
                                                            <?php echo $request['request_number']; ?>
                                                        </h5>
                                                        <p class="text-muted no-margin" style="font-size: 12px;">
                                                            <i class="fa fa-user-circle"></i> 
                                                            <?php echo $request['patient_name']; ?> 
                                                            (<?php echo $request['patient_number']; ?>)
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                                <hr style="margin: 10px 0;">
                                                
                                                <!-- Request Details -->
                                                <div class="mtop10">
                                                    <p class="text-muted no-margin">
                                                        <i class="fa fa-flask"></i> <strong>Category:</strong> 
                                                        <span class="pull-right"><?php echo $request['category_name']; ?></span>
                                                    </p>
                                                    <p class="text-muted no-margin">
                                                        <i class="fa fa-list"></i> <strong>Items:</strong> 
                                                        <span class="pull-right"><?php echo $request['items_count']; ?> items</span>
                                                    </p>
                                                    <p class="text-muted no-margin">
                                                        <i class="fa fa-user-md"></i> <strong>Doctor:</strong> 
                                                        <span class="pull-right">Dr <?php echo $request['doctor_firstname'] . ' ' . $request['doctor_lastname']; ?></span>
                                                    </p>
                                                    <p class="text-muted no-margin">
                                                        <i class="fa fa-calendar"></i> <strong>Date:</strong> 
                                                        <span class="pull-right"><?php echo _dt($request['created_at']); ?></span>
                                                    </p>
                                                </div>
                                                
                                                <hr style="margin: 10px 0;">
                                                
                                                <!-- Status & Priority -->
                                                <div class="mtop10">
                                                    <div class="row">
                                                        <div class="col-xs-6">
                                                            <strong>Priority:</strong>
                                                            <?php if ($request['priority'] == 'emergency'): ?>
                                                                <span class="label label-danger">EMERGENCY</span>
                                                            <?php elseif ($request['priority'] == 'urgent'): ?>
                                                                <span class="label label-warning">URGENT</span>
                                                            <?php else: ?>
                                                                <span class="label label-success">NORMAL</span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="col-xs-6 text-right">
                                                            <strong>Status:</strong>
                                                            <?php if ($request['status'] == 'approved'): ?>
                                                                <span class="label label-info">New</span>
                                                            <?php elseif ($request['status'] == 'in_progress'): ?>
                                                                <span class="label label-primary">In Progress</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Actions -->
                                                <div class="mtop15 text-right">
                                                    <a href="<?php echo admin_url('hospital_management/lab_request/' . $request['id']); ?>" 
                                                       class="btn btn-primary btn-sm">
                                                        <i class="fa fa-eye"></i> View Details
                                                    </a>
                                                    
                                                    <?php if ($request['status'] == 'approved'): ?>
                                                        <button type="button" 
                                                                class="btn btn-info btn-sm start-btn" 
                                                                data-id="<?php echo $request['id']; ?>">
                                                            <i class="fa fa-play"></i> Start
                                                        </button>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($request['status'] == 'in_progress'): ?>
                                                        <button type="button" 
                                                                class="btn btn-success btn-sm complete-btn" 
                                                                data-id="<?php echo $request['id']; ?>">
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

<style>
.request-item {
    margin-bottom: 20px;
}
.request-item .panel_s {
    transition: all 0.3s ease;
    height: 100%;
}
.request-item .panel_s:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transform: translateY(-2px);
}
.filter-btn.active {
    background-color: #03a9f4;
    color: white;
}
</style>

<script>
var csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';
var csrfTokenHash = '<?php echo $this->security->get_csrf_hash(); ?>';

$(function() {
    // Filter buttons
    $('.filter-btn').on('click', function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
        
        var filter = $(this).data('filter');
        
        if (filter === 'all') {
            $('.request-item').slideDown();
        } else {
            $('.request-item').hide();
            $('.request-item[data-status="' + filter + '"]').slideDown();
        }
    });
    
    // Start processing
    $('.start-btn').on('click', function() {
        var id = $(this).data('id');
        
        if (confirm('Start processing this request?')) {
            updateStatus(id, 'start');
        }
    });
    
    // Complete request
    $('.complete-btn').on('click', function() {
        var id = $(this).data('id');
        
        if (confirm('Mark this request as completed?')) {
            var notes = prompt('Add completion notes (optional):');
            updateStatus(id, 'complete', notes);
        }
    });
});

function updateStatus(requestId, action, notes) {
    var url = action === 'start' 
        ? '<?php echo admin_url("hospital_management/start_request"); ?>' 
        : '<?php echo admin_url("hospital_management/complete_request"); ?>';
    
    var data = {
        request_id: requestId,
        notes: notes || ''
    };
    data[csrfTokenName] = csrfTokenHash;
    
    $.post(url, data, function(response) {
        if (response.success) {
            csrfTokenName = response.csrf_token_name;
            csrfTokenHash = response.csrf_token_hash;
            
            alert_float('success', response.message);
            setTimeout(function() {
                window.location.reload();
            }, 1000);
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
}
</script>