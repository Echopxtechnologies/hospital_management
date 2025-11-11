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
                                <h3 class="text-warning"><?php echo (int)$statistics['pending']; ?></h3>
                                <p class="text-muted">Pending Approval</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <h3 class="text-info"><?php echo (int)$statistics['approved']; ?></h3>
                                <p class="text-muted">Awaiting Technician</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <h3 class="text-primary"><?php echo (int)$statistics['in_progress']; ?></h3>
                                <p class="text-muted">In Progress</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <h3 class="text-success"><?php echo (int)$statistics['completed']; ?></h3>
                                <p class="text-muted">Completed</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <h3 class="text-danger"><?php echo (int)(isset($statistics['unpaid']) ? $statistics['unpaid'] : 0); ?></h3>
                                <p class="text-muted">Unpaid</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <h3 class="text-muted"><?php echo (int)$statistics['today']; ?></h3>
                                <p class="text-muted">Today's Total</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PENDING APPROVAL SECTION -->
            <?php if (!empty($pending_requests)): ?>
            <div class="col-md-12">
                <div class="panel_s lab-pending-panel" style="background:#00FFFF;">
                    <div class="panel-body lab-gradient-header" >
                        <h4 class="lab-header-title">
                            <i class="fa fa-clock-o"></i> Pending Approval 
                            <span class="badge lab-badge"><?php echo count($pending_requests); ?></span>
                        </h4>
                        <p class="text-muted">These requests need payment and approval before technicians can process them.</p>
                        <hr>
                        
                        <!-- Pending Requests Table - LET PERFEX AUTO-INITIALIZE -->
                        <table class="table table-striped dt-table" id="pending-requests-table" data-order-col="9" data-order-type="desc">
                            <thead class="lab-table-header">
                                <tr>
                                    <th>Request #</th>
                                    <th>Patient</th>
                                    <th>Patient Type</th>
                                    <th>Category</th>
                                    <th>Doctor</th>
                                    <th>Items</th>
                                    <th>Amount</th>
                                    <th>Payment Status</th>
                                    <th>Priority</th>
                                    <th>Created</th>
                                    <th class="text-center not-export" width="220">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pending_requests as $req): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($req['request_number']); ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($req['patient_name']); ?><br>
                                        <small class="text-muted"><?php echo htmlspecialchars($req['patient_number']); ?></small>
                                    </td>
                                    <td>
                                        <span class="label label-info">
                                            <?php echo htmlspecialchars($req['patient_type']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($req['category_name']); ?></td>
                                    <td>Dr <?php echo htmlspecialchars($req['doctor_firstname'] . ' ' . $req['doctor_lastname']); ?></td>
                                    <td><?php echo (int)$req['items_count']; ?></td>
                                    <td data-order="<?php echo (float)$req['final_amount']; ?>">
                                        ₹<?php echo number_format((float)$req['final_amount'], 2); ?>
                                    </td>
                                    <td>
                                        <?php 
                                        $payment = $this->hospital_requests_model->check_request_payment($req['id']);
                                        if ($payment && $payment->payment_status === 'paid'): ?>
                                            <span class="label label-success"><i class="fa fa-check"></i> Paid</span>
                                        <?php elseif ($payment && $payment->payment_status === 'partial'): ?>
                                            <span class="label label-warning"><i class="fa fa-exclamation"></i> Partial</span>
                                        <?php else: ?>
                                            <span class="label label-danger"><i class="fa fa-times"></i> Unpaid</span>
                                        <?php endif; ?>
                                    </td>
                                    <td data-order="<?php echo ($req['priority'] == 'emergency') ? 3 : (($req['priority'] == 'urgent') ? 2 : 1); ?>">
                                        <?php if ($req['priority'] == 'emergency'): ?>
                                            <span class="label label-danger"><i class="fa fa-exclamation-triangle"></i> EMERGENCY</span>
                                        <?php elseif ($req['priority'] == 'urgent'): ?>
                                            <span class="label label-warning"><i class="fa fa-exclamation"></i> Urgent</span>
                                        <?php else: ?>
                                            <span class="label label-default">Normal</span>
                                        <?php endif; ?>
                                    </td>
                                    <td data-order="<?php echo strtotime($req['created_at']); ?>">
                                        <?php echo _dt($req['created_at']); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php 
                                        $payment_check = $this->hospital_requests_model->check_request_payment($req['id']);
                                        if (!$payment_check || $payment_check->payment_status !== 'paid'): ?>
                                            <a href="<?php echo admin_url('hospital_management/process_payment/' . (int)$req['id']); ?>" 
                                               class="btn btn-primary btn-sm"
                                               style="background:#28A745; color:white;">
                                                <i class="fa fa-credit-card"></i> Pay
                                            </a>
                                        <?php else: ?>
                                            <button type="button" 
                                                    class="btn btn-success btn-sm approve-btn" 
                                                    data-id="<?php echo (int)$req['id']; ?>" 
                                                    data-request="<?php echo htmlspecialchars($req['request_number']); ?>">
                                                <i class="fa fa-check"></i> Approve
                                            </button>
                                        <?php endif; ?>
                                        <button type="button" 
                                                class="btn btn-danger btn-sm cancel-btn" 
                                                data-id="<?php echo (int)$req['id']; ?>" 
                                                data-request="<?php echo htmlspecialchars($req['request_number']); ?>">
                                            <i class="fa fa-times"></i> Cancel
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Main Lab Records -->
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="no-margin lab-header-title">
                                    <i class="fa fa-list-alt"></i> Lab Records
                                </h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <div class="btn-group" id="status-filter-group">
                                    <button type="button" class="btn btn-default filter-btn active" data-filter="all">
                                        All <span class="badge"><?php echo count($records); ?></span>
                                    </button>
                                    <button type="button" class="btn btn-default filter-btn" data-filter="completed">
                                        Completed <span class="badge badge-success"><?php echo (int)$statistics['completed']; ?></span>
                                    </button>
                                    <button type="button" class="btn btn-default filter-btn" data-filter="in_progress">
                                        In Progress <span class="badge badge-primary"><?php echo (int)$statistics['in_progress']; ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr class="hr-panel-heading">
                        
                        <!-- Records Table -->
                        <?php if (empty($records)): ?>
                            <div class="alert lab-empty-alert text-center">
                                <i class="fa fa-info-circle"></i> No lab records found. Approve pending requests to see them here.
                            </div>
                        <?php else: ?>
                            <table class="table table-striped dt-table" id="lab-records-table" data-order-col="7" data-order-type="desc">
                                <thead class="lab-table-header">
                                    <tr>
                                        <th>Request #</th>
                                        <th>Patient</th>
                                        <th>Category</th>
                                        <th>Doctor</th>
                                        <th>Technician</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Created</th>
                                        <th class="text-center not-export">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($records as $record): ?>
                                        <tr data-status="<?php echo htmlspecialchars($record['status']); ?>">
                                            <td><?php echo htmlspecialchars($record['request_number']); ?></td>
                                            <td>
                                                <?php echo htmlspecialchars($record['patient_name']); ?><br>
                                                <small class="text-muted"><?php echo htmlspecialchars($record['patient_number']); ?></small>
                                            </td>
                                            <td><?php echo htmlspecialchars($record['category_name']); ?></td>
                                            <td>Dr <?php echo htmlspecialchars($record['doctor_firstname'] . ' ' . $record['doctor_lastname']); ?></td>
                                            <td>
                                                <?php if (!empty($record['technician_firstname'])): ?>
                                                    <?php echo htmlspecialchars($record['technician_firstname'] . ' ' . $record['technician_lastname']); ?>
                                                <?php else: ?>
                                                    <span class="text-muted">Not assigned</span>
                                                <?php endif; ?>
                                            </td>
                                            <td data-order="<?php echo ($record['status'] == 'completed') ? 3 : (($record['status'] == 'in_progress') ? 2 : 1); ?>">
                                                <?php if ($record['status'] == 'approved'): ?>
                                                    <span class="label label-warning">Approved</span>
                                                <?php elseif ($record['status'] == 'in_progress'): ?>
                                                    <span class="label label-info">In Progress</span>
                                                <?php elseif ($record['status'] == 'completed'): ?>
                                                    <span class="label label-success">Completed</span>
                                                <?php endif; ?>
                                            </td>
                                            <td data-order="<?php echo (float)$record['final_amount']; ?>">
                                                ₹<?php echo number_format((float)$record['final_amount'], 2); ?>
                                            </td>
                                            <td data-order="<?php echo strtotime($record['created_at']); ?>">
                                                <?php echo _dt($record['created_at']); ?>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" 
                                                        class="btn btn-default btn-xs view-details-btn"
                                                        data-id="<?php echo (int)$record['id']; ?>"
                                                        title="View Details">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Request Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header lab-modal-header">
                <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
                <h4 class="modal-title">
                    <i class="fa fa-times-circle"></i> Cancel Request
                </h4>
            </div>
            <form id="cancelForm">
                <div class="modal-body">
                    <input type="hidden" name="request_id" id="cancel-request-id">
                    <p>Cancel request: <strong id="cancel-request-num"></strong></p>
                    <div class="form-group">
                        <label for="cancel_reason">Cancellation Reason <span class="text-danger">*</span></label>
                        <textarea name="reason" 
                                  id="cancel_reason" 
                                  class="form-control" 
                                  rows="3" 
                                  required
                                  maxlength="500"
                                  placeholder="Please provide a reason for cancellation"></textarea>
                        <small class="text-muted">Maximum 500 characters</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-times"></i> Cancel Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php init_tail(); ?>

<style>
/* Lab Module Styling */
.lab-pending-panel {
    border-left: 4px solid #00b4db;
    box-shadow: 0 2px 8px rgba(0, 180, 219, 0.2);
}

.lab-gradient-header {
    background: linear-gradient(135deg, #e0f7fa 0%, #b2ebf2 100%);
}

.lab-header-title {
    color: #0ba6b4ff;
}

.lab-badge {
    background-color: #00b4db;
    color: white;
}

.lab-table-header {
    background: linear-gradient(135deg, #00b4db 0%, #0083b0 100%);
    color: white !important;
}

.lab-table-header th {
    color: white !important;
}

.lab-empty-alert {
    background: linear-gradient(135deg, #e0f7fa 0%, #b2ebf2 100%);
    color: #00838f;
    border: 1px solid #00b4db;
}

.lab-modal-header {
    background: linear-gradient(135deg, #00b4db 0%, #0083b0 100%);
    color: white;
}

.filter-btn.active {
    background: linear-gradient(135deg, #00b4db 0%, #0083b0 100%);
    color: white;
    border: none;
}

/* Performance optimization: Hide columns on mobile */
@media (max-width: 768px) {
    .dt-table th:nth-child(n+6),
    .dt-table td:nth-child(n+6) {
        display: none;
    }
}
</style>

<script>
(function() {
    'use strict';
    
    // ============================================
    // SECURE CSRF TOKEN MANAGEMENT
    // ============================================
    var csrfToken = {
        name: <?php echo json_encode($this->security->get_csrf_token_name()); ?>,
        hash: <?php echo json_encode($this->security->get_csrf_hash()); ?>
    };
    
    // Update CSRF token after each AJAX request
    function updateCsrfToken(response) {
        if (response && response.csrf_token_name && response.csrf_token_hash) {
            csrfToken.name = response.csrf_token_name;
            csrfToken.hash = response.csrf_token_hash;
        }
    }
    
    // ============================================
    // WAIT FOR PERFEX TO INITIALIZE DATATABLES
    // ============================================
    $(document).ready(function() {
        
        // Wait a bit for Perfex's DataTable initialization
        setTimeout(function() {
            
            // ============================================
            // STATUS FILTER BUTTONS (AFTER DATATABLE READY)
            // ============================================
            $('#status-filter-group').on('click', '.filter-btn', function(e) {
                e.preventDefault();
                
                $('#status-filter-group .filter-btn').removeClass('active');
                $(this).addClass('active');
                
                var filter = $(this).data('filter');
                var table = $('#lab-records-table').DataTable();
                
                if (filter === 'all') {
                    table.column(5).search('').draw();
                } else if (filter === 'completed') {
                    table.column(5).search('Completed').draw();
                } else if (filter === 'in_progress') {
                    table.column(5).search('In Progress').draw();
                }
            });
            
        }, 500); // Wait 500ms for Perfex initialization
        
        // ============================================
        // APPROVE REQUEST - EVENT DELEGATION
        // ============================================
        $(document).on('click', '.approve-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var $btn = $(this);
            var requestId = $btn.data('id');
            var requestNum = $btn.data('request');
            
            if (!requestId || !requestNum) {
                alert_float('danger', 'Invalid request data');
                return false;
            }
            
            if (!confirm('Approve request ' + requestNum + '?\n\nThis will allow technicians to process it.')) {
                return false;
            }
            
            var originalHtml = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            
            var requestData = {
                request_id: requestId
            };
            requestData[csrfToken.name] = csrfToken.hash;
            
            $.ajax({
                url: admin_url + 'hospital_management/approve_request',
                type: 'POST',
                data: requestData,
                dataType: 'json',
                success: function(response) {
                    updateCsrfToken(response);
                    
                    if (response && response.success) {
                        alert_float('success', response.message || 'Request approved successfully');
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        alert_float('danger', response.message || 'Failed to approve request');
                        $btn.prop('disabled', false).html(originalHtml);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Approve error:', error);
                    alert_float('danger', 'Network error. Please try again.');
                    $btn.prop('disabled', false).html(originalHtml);
                }
            });
            
            return false;
        });
        
        // ============================================
        // CANCEL REQUEST MODAL - EVENT DELEGATION
        // ============================================
        $(document).on('click', '.cancel-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var requestId = $(this).data('id');
            var requestNum = $(this).data('request');
            
            if (!requestId || !requestNum) {
                alert_float('danger', 'Invalid request data');
                return false;
            }
            
            $('#cancel-request-id').val(requestId);
            $('#cancel-request-num').text(requestNum);
            $('#cancel_reason').val('');
            $('#cancelModal').modal('show');
            
            return false;
        });
        
        // ============================================
        // VIEW DETAILS BUTTON - EVENT DELEGATION
        // ============================================
        $(document).on('click', '.view-details-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var recordId = $(this).data('id');
            
            if (!recordId) {
                alert_float('danger', 'Invalid record ID');
                return false;
            }
            
            // Redirect to details page or open modal
            window.location.href = admin_url + 'hospital_management/view_lab_record/' + recordId;
            
            return false;
        });
        
        // ============================================
        // SUBMIT CANCEL REQUEST
        // ============================================
        $('#cancelForm').on('submit', function(e) {
            e.preventDefault();
            
            var requestId = $('#cancel-request-id').val();
            var reason = $('#cancel_reason').val().trim();
            
            if (!requestId) {
                alert_float('danger', 'Invalid request ID');
                return false;
            }
            
            if (!reason || reason.length < 5) {
                alert_float('warning', 'Please provide a reason (minimum 5 characters)');
                $('#cancel_reason').focus();
                return false;
            }
            
            var $submitBtn = $('#cancelForm button[type="submit"]');
            var originalText = $submitBtn.html();
            $submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Cancelling...');
            
            var requestData = {
                request_id: requestId,
                reason: reason
            };
            requestData[csrfToken.name] = csrfToken.hash;
            
            $.ajax({
                url: admin_url + 'hospital_management/cancel_request',
                type: 'POST',
                data: requestData,
                dataType: 'json',
                success: function(response) {
                    updateCsrfToken(response);
                    
                    if (response && response.success) {
                        $('#cancelModal').modal('hide');
                        alert_float('success', response.message || 'Request cancelled successfully');
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        alert_float('danger', response.message || 'Failed to cancel request');
                        $submitBtn.prop('disabled', false).html(originalText);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Cancel error:', error);
                    alert_float('danger', 'Network error. Please try again.');
                    $submitBtn.prop('disabled', false).html(originalText);
                }
            });
            
            return false;
        });
        
        // ============================================
        // RESET MODAL ON CLOSE
        // ============================================
        $('#cancelModal').on('hidden.bs.modal', function() {
            $('#cancelForm')[0].reset();
            $('#cancelForm button[type="submit"]').prop('disabled', false).html('<i class="fa fa-times"></i> Cancel Request');
        });
        
    }); // End document.ready
    
})();
</script>