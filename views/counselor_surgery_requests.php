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
                            <i class="fa fa-procedures"></i> Surgery Requests Management
                        </h4>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="panel_s">
                            <div class="panel-body text-center">
                                <h3 class="text-info"><?php echo $stats['total_requests']; ?></h3>
                                <p class="text-muted">Total Requests</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="panel_s">
                            <div class="panel-body text-center">
                                <h3 class="text-warning"><?php echo $stats['pending']; ?></h3>
                                <p class="text-muted">Pending</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="panel_s">
                            <div class="panel-body text-center">
                                <h3 class="text-success"><?php echo $stats['approved']; ?></h3>
                                <p class="text-muted">Approved</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="panel_s">
                            <div class="panel-body text-center">
                                <h3 class="text-primary"><?php echo $stats['completed']; ?></h3>
                                <p class="text-muted">Completed</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Surgery Requests Table -->
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading">
                        
                        <div class="table-responsive">
                            <table class="table table-striped dt-table" id="surgery-requests-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Patient Info</th>
                                        <th>Visit #</th>
                                        <th>Surgery Name</th>
                                        <th>Surgery Details</th>
                                        <th>Ward/Room</th>
                                        <th>Counseling Status</th>
                                        <th>Payment Status</th>
                                        <th>Status</th>
                                        <th>Requested By</th>
                                        <th>Request Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($surgery_requests)): ?>
                                        <?php foreach($surgery_requests as $request): ?>
                                        <tr>
                                            <td>
                                                <strong>#<?php echo $request['id']; ?></strong>
                                            </td>
                                            <td>
                                                <strong><?php echo $request['patient_name']; ?></strong><br>
                                                <small class="text-muted">
                                                    <?php echo $request['patient_number']; ?> | 
                                                    <?php echo $request['patient_age']; ?>Y | 
                                                    <?php echo strtoupper($request['patient_gender']); ?>
                                                </small><br>
                                                <small><i class="fa fa-phone"></i> <?php echo $request['patient_mobile']; ?></small>
                                            </td>
                                            <td>
                                                <span class="label label-default">
                                                    <?php echo $request['visit_number']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if(!empty($request['surgery_name'])): ?>
                                                    <strong><?php echo htmlspecialchars($request['surgery_name']); ?></strong>
                                                    <br><small class="text-muted">
                                                        Code: <?php echo $request['surgery_code']; ?>
                                                    </small>
                                                    <br><small>
                                                        <span class="label label-primary label-sm">
                                                            <?php echo $request['surgery_category']; ?>
                                                        </span>
                                                        <span class="label label-info label-sm">
                                                            <?php echo ucwords($request['request_type']); ?>
                                                        </span>
                                                    </small>
                                                <?php else: ?>
                                                    <span class="text-muted">Not specified</span>
                                                    <br><small>
                                                        <span class="label label-info label-sm">
                                                            <?php echo ucwords($request['request_type']); ?>
                                                        </span>
                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if(!empty($request['surgery_details'])): ?>
                                                    <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                        <?php 
                                                        $details = strip_tags($request['surgery_details']);
                                                        echo htmlspecialchars(substr($details, 0, 100));
                                                        if(strlen($details) > 100) echo '...';
                                                        ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted">No details</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if(!empty($request['room_type'])): ?>
                                                    <span class="label label-info">
                                                        <?php echo $request['room_type']; ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">Not assigned</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php 
                                                $counseling_status = $request['counseling_status'] ?? 'pending';
                                                $counseling_class = 'default';
                                                if($counseling_status == 'accepted') $counseling_class = 'success';
                                                elseif($counseling_status == 'pending') $counseling_class = 'warning';
                                                elseif($counseling_status == 'rejected') $counseling_class = 'danger';
                                                ?>
                                                <span class="label label-<?php echo $counseling_class; ?>">
                                                    <?php echo strtoupper($counseling_status); ?>
                                                </span>
                                                <?php if(!empty($request['counseled_at'])): ?>
                                                    <br><small class="text-muted">
                                                        <?php echo date('d M Y', strtotime($request['counseled_at'])); ?>
                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php 
                                                $payment_status_class = 'default';
                                                if($request['payment_status'] == 'paid') $payment_status_class = 'success';
                                                elseif($request['payment_status'] == 'partial') $payment_status_class = 'info';
                                                elseif($request['payment_status'] == 'unpaid') $payment_status_class = 'danger';
                                                ?>
                                                <span class="label label-<?php echo $payment_status_class; ?>">
                                                    <?php echo strtoupper($request['payment_status']); ?>
                                                </span>
                                                <?php if(!empty($request['quoted_amount']) && $request['quoted_amount'] > 0): ?>
                                                    <br><small class="text-success">
                                                        <strong>₹<?php echo number_format($request['quoted_amount'], 2); ?></strong>
                                                    </small>
                                                <?php elseif(!empty($request['total_amount']) && $request['total_amount'] > 0): ?>
                                                    <br><small class="text-muted">
                                                        ₹<?php echo number_format($request['total_amount'], 2); ?>
                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php 
                                                $status_class = 'default';
                                                if($request['status'] == 'approved') $status_class = 'success';
                                                elseif($request['status'] == 'pending') $status_class = 'warning';
                                                elseif($request['status'] == 'scheduled') $status_class = 'info';
                                                elseif($request['status'] == 'completed') $status_class = 'primary';
                                                elseif($request['status'] == 'cancelled') $status_class = 'danger';
                                                ?>
                                                <span class="label label-<?php echo $status_class; ?>">
                                                    <?php echo strtoupper($request['status']); ?>
                                                </span>
                                                <?php if(!empty($request['surgery_date'])): ?>
                                                    <br><small class="text-muted">
                                                        <i class="fa fa-calendar"></i> <?php echo date('d M Y', strtotime($request['surgery_date'])); ?>
                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if(!empty($request['doctor_firstname'])): ?>
                                                    <span data-toggle="tooltip" title="Requested By">
                                                        Dr. <?php echo $request['doctor_firstname'] . ' ' . $request['doctor_lastname']; ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">N/A</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php echo date('d M Y', strtotime($request['requested_at'])); ?>
                                                <br><small class="text-muted"><?php echo date('h:i A', strtotime($request['requested_at'])); ?></small>
                                            </td>
                                            <td>
                                                <!-- Counsel Patient Button -->
                                                <a href="<?php echo admin_url('hospital_management/view_patient_counseling/' . $request['id']); ?>" 
                                                   class="btn btn-sm btn-info btn-block" 
                                                   data-toggle="tooltip" 
                                                   title="View & Counsel Patient">
                                                    <i class="fa fa-user-md"></i> Counsel
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="11" class="text-center text-muted">
                                                <br>
                                                <i class="fa fa-info-circle fa-3x"></i>
                                                <br><br>
                                                No surgery requests found
                                                <br><br>
                                            </td>
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

<script>
$(function() {
    // Initialize DataTable with better sorting
    var surgeryTable = $('#surgery-requests-table').DataTable({
        "order": [[9, "desc"]], // Sort by Request Date (column index 9)
        "pageLength": 25,
        "language": {
            "search": "Search Surgery Requests:",
            "lengthMenu": "Show _MENU_ requests per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ requests",
            "infoEmpty": "No surgery requests available",
            "infoFiltered": "(filtered from _MAX_ total requests)",
            "zeroRecords": "No matching surgery requests found"
        },
        "columnDefs": [
            {
                "targets": [10], // Actions column
                "orderable": false
            }
        ],
        "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>rtip',
        "responsive": true
    });
    
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Add quick filter buttons
    $('.panel-body .table-responsive').before(`
        <div class="row mbot15">
            <div class="col-md-12">
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-default filter-btn active" data-status="all">
                        <i class="fa fa-list"></i> All (<?php echo $stats['total_requests']; ?>)
                    </button>
                    <button type="button" class="btn btn-warning filter-btn" data-status="pending">
                        <i class="fa fa-clock-o"></i> Pending (<?php echo $stats['pending']; ?>)
                    </button>
                    <button type="button" class="btn btn-success filter-btn" data-status="approved">
                        <i class="fa fa-check"></i> Approved (<?php echo $stats['approved']; ?>)
                    </button>
                    <button type="button" class="btn btn-primary filter-btn" data-status="completed">
                        <i class="fa fa-check-circle"></i> Completed (<?php echo $stats['completed']; ?>)
                    </button>
                </div>
                
                <div class="btn-group btn-group-sm pull-right" role="group">
                    <button type="button" class="btn btn-default counseling-filter-btn active" data-counseling="all">
                        All Counseling
                    </button>
                    <button type="button" class="btn btn-warning counseling-filter-btn" data-counseling="pending">
                        Pending Counseling
                    </button>
                    <button type="button" class="btn btn-success counseling-filter-btn" data-counseling="accepted">
                        Accepted
                    </button>
                </div>
            </div>
        </div>
    `);
    
    // Filter button click handler for Status
    $('.filter-btn').on('click', function() {
        var status = $(this).data('status');
        
        // Remove active class from all status buttons
        $('.filter-btn').removeClass('active');
        
        // Add active class to clicked button
        $(this).addClass('active');
        
        // Filter table
        if (status === 'all') {
            surgeryTable.column(7).search('').draw();
        } else {
            surgeryTable.column(7).search('^' + status + '$', true, false).draw();
        }
    });
    
    // Filter button click handler for Counseling Status
    $('.counseling-filter-btn').on('click', function() {
        var counselingStatus = $(this).data('counseling');
        
        // Remove active class from all counseling buttons
        $('.counseling-filter-btn').removeClass('active');
        
        // Add active class to clicked button
        $(this).addClass('active');
        
        // Filter table
        if (counselingStatus === 'all') {
            surgeryTable.column(5).search('').draw();
        } else {
            surgeryTable.column(5).search('^' + counselingStatus + '$', true, false).draw();
        }
    });
});
</script>

<style>
/* Custom styles for better readability */
.dt-table tbody tr:hover {
    background-color: #f9f9f9;
}

.filter-btn, .counseling-filter-btn {
    margin-right: 5px;
    margin-bottom: 10px;
}

.filter-btn.active, .counseling-filter-btn.active {
    box-shadow: inset 0 3px 5px rgba(0,0,0,.125);
}

.label-sm {
    font-size: 10px;
    padding: 2px 6px;
}

/* Make action buttons full width in their cell */
.btn-block {
    display: block;
    width: 100%;
}

/* Improve table cell spacing */
.dt-table td {
    vertical-align: middle !important;
}

/* Better label spacing */
.label {
    margin-right: 3px;
}

/* Responsive table improvements */
@media screen and (max-width: 768px) {
    .table-responsive {
        border: 0;
    }
    
    .btn-group {
        display: block;
    }
    
    .btn-group .btn {
        display: block;
        width: 100%;
        margin-bottom: 5px;
    }
    
    .pull-right {
        float: none !important;
        margin-top: 10px;
    }
}

/* Surgery details truncation */
.dt-table td > div {
    max-width: 200px;
}
</style>
</body>
</html>