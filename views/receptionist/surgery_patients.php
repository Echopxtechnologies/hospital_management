<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<style>
    /* Hospital Theme Styling */
    .hospital-header {
        background: linear-gradient(135deg, #6f42c1 0%, #9b59b6 100%);
        color: white;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .stat-card {
        background: white;
        border-left: 4px solid #6f42c1;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }
    
    .stat-card:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    
    .stat-card h3 {
        color: #6f42c1;
        font-weight: bold;
        margin: 0;
    }
    
    .stat-card.stat-pending { border-left-color: #ffc107; }
    .stat-card.stat-paid { border-left-color: #17a2b8; }
    .stat-card.stat-approved { border-left-color: #28a745; }
    .stat-card.stat-today { border-left-color: #007bff; }
    .stat-card.stat-completed { border-left-color: #6c757d; }
    
    /* DataTable custom styling */
    .table-surgery-patients {
        font-size: 13px;
    }
    
    .table-surgery-patients td {
        vertical-align: middle !important;
    }
    
    .btn-action-group {
        white-space: nowrap;
    }
    
    .btn-action-group .btn {
        margin-right: 5px;
    }
    
    .amount-display {
        font-weight: bold;
        color: #28a745;
    }
    
    .discount-display {
        font-weight: bold;
        color: #dc3545;
    }
    
    /* Payment Modal Styling */
    .payment-summary {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    
    .payment-summary .row {
        margin-bottom: 10px;
    }
    
    .payment-summary .amount {
        font-size: 18px;
        font-weight: bold;
        color: #28a745;
    }
    
    .form-group label {
        font-weight: 600;
    }
</style>

<div id="wrapper">
    <div class="content">
        <!-- Header -->
        <div class="hospital-header">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="no-margin">
                        <i class="fa fa-procedures"></i> Surgery Patients Management
                    </h3>
                    <p class="no-margin" style="opacity: 0.9; margin-top: 5px;">
                        Process payments and approve surgery requests
                    </p>
                </div>
                <div class="col-md-4 text-right">
                    <h4 class="no-margin">
                        <i class="fa fa-hospital-o"></i> Reception Desk
                    </h4>
                    <p class="no-margin" style="opacity: 0.9; margin-top: 5px;">
                        <?php echo date('l, F j, Y'); ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <!-- Pending Payment -->
            <div class="col-md-2 col-sm-6">
                <div class="stat-card stat-pending">
                    <h3><?php echo isset($statistics['pending_payment']) ? (int)$statistics['pending_payment'] : 0; ?></h3>
                    <p class="text-muted no-margin">
                        <i class="fa fa-credit-card"></i> Pending Payment
                    </p>
                    <small class="text-muted">Awaiting payment</small>
                </div>
            </div>
            
            <!-- Paid (Awaiting Approval) -->
            <div class="col-md-2 col-sm-6">
                <div class="stat-card stat-paid">
                    <h3><?php echo isset($statistics['paid']) ? (int)$statistics['paid'] : 0; ?></h3>
                    <p class="text-muted no-margin">
                        <i class="fa fa-check-square-o"></i> Paid
                    </p>
                    <small class="text-muted">Ready for approval</small>
                </div>
            </div>
            
            <!-- Approved -->
            <div class="col-md-2 col-sm-6">
                <div class="stat-card stat-approved">
                    <h3><?php echo isset($statistics['approved']) ? (int)$statistics['approved'] : 0; ?></h3>
                    <p class="text-muted no-margin">
                        <i class="fa fa-thumbs-up"></i> Approved
                    </p>
                    <small class="text-muted">Ready for surgery</small>
                </div>
            </div>
            
            <!-- Today's Surgeries -->
            <div class="col-md-3 col-sm-6">
                <div class="stat-card stat-today">
                    <h3><?php echo isset($statistics['today_surgeries']) ? (int)$statistics['today_surgeries'] : 0; ?></h3>
                    <p class="text-muted no-margin">
                        <i class="fa fa-calendar-check-o"></i> Today's Surgeries
                    </p>
                    <small class="text-muted">Scheduled for today</small>
                </div>
            </div>
            
            <!-- Completed -->
            <div class="col-md-3 col-sm-6">
                <div class="stat-card stat-completed">
                    <h3><?php echo isset($statistics['completed']) ? (int)$statistics['completed'] : 0; ?></h3>
                    <p class="text-muted no-margin">
                        <i class="fa fa-check-circle"></i> Completed
                    </p>
                    <small class="text-muted">All surgeries done</small>
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
                        <table class="table dt-table table-surgery-patients table-striped table-hover" data-order-col="0" data-order-type="desc">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Visit #</th>
                                    <th>Surgery Type</th>
                                    <th>Requested By</th>
                                    <th>Counselor</th>
                                    <th>Quoted Amount</th>
                                    <th>Discount</th>
                                    <th>Final Amount</th>
                                    <th>Payment Status</th>
                                    <th>Surgery Status</th>
                                    <th>Surgery Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($surgery_requests)): ?>
                                    <?php foreach ($surgery_requests as $request): ?>
                                        <?php
                                        // Calculate amounts
                                        $quoted_amount = floatval($request['quoted_amount'] ?? 0);
                                        $discount_amount = floatval($request['counseling_discount_amount'] ?? 0);
                                        $copay_amount = floatval($request['copay_amount'] ?? 0);
                                        $final_amount = $quoted_amount - $discount_amount;
                                        ?>
                                        <tr>
                                            <!-- Patient Info -->
                                            <td>
                                                <strong><?php echo $request['patient_name']; ?></strong><br>
                                                <small class="text-muted">
                                                    <?php echo $request['patient_number']; ?> | 
                                                    <?php echo $request['patient_age']; ?>Y / <?php echo $request['patient_gender']; ?>
                                                </small><br>
                                                <small class="text-muted">
                                                    <i class="fa fa-phone"></i> <?php echo $request['patient_mobile']; ?>
                                                </small>
                                            </td>
                                            
                                            <!-- Visit Number -->
                                            <td>
                                                <?php echo $request['visit_number']; ?><br>
                                                <small class="text-muted"><?php echo date('d M Y', strtotime($request['visit_date'])); ?></small>
                                            </td>
                                            
                                            <!-- Surgery Type -->
                                            <td>
                                                <strong><?php echo $request['surgery_name'] ?? 'N/A'; ?></strong><br>
                                                <small class="text-muted"><?php echo $request['surgery_code'] ?? ''; ?></small><br>
                                                <?php if ($request['request_type'] == 'simple'): ?>
                                                    <span class="label label-info">Simple</span>
                                                <?php else: ?>
                                                    <span class="label label-primary">Detailed</span>
                                                <?php endif; ?>
                                            </td>
                                            
                                            <!-- Requested By (Doctor) -->
                                            <td>
                                                <small>
                                                    Dr. <?php echo $request['doctor_firstname'] . ' ' . $request['doctor_lastname']; ?>
                                                </small>
                                            </td>
                                            
                                            <!-- Counselor -->
                                            <td>
                                                <?php if (!empty($request['counselor_firstname'])): ?>
                                                    <small>
                                                        <?php echo $request['counselor_firstname'] . ' ' . $request['counselor_lastname']; ?>
                                                    </small>
                                                <?php else: ?>
                                                    <small class="text-muted">Not assigned</small>
                                                <?php endif; ?>
                                            </td>
                                            
                                            <!-- Quoted Amount -->
                                            <td>
                                                <span class="amount-display">
                                                    ₹<?php echo number_format($quoted_amount, 2); ?>
                                                </span>
                                            </td>
                                            
                                            <!-- Discount -->
                                            <td>
                                                <?php if ($discount_amount > 0): ?>
                                                    <span class="discount-display">
                                                        -₹<?php echo number_format($discount_amount, 2); ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">₹0.00</span>
                                                <?php endif; ?>
                                            </td>
                                            
                                            <!-- Final Amount -->
                                            <td>
                                                <strong style="color: #28a745; font-size: 15px;">
                                                    ₹<?php echo number_format($final_amount, 2); ?>
                                                </strong>
                                            </td>
                                            
                                            <!-- Payment Status -->
                                            <td>
                                                <?php if ($request['payment_status'] == 'paid'): ?>
                                                    <span class="label label-success">
                                                        <i class="fa fa-check-circle"></i> Paid
                                                    </span>
                                                <?php else: ?>
                                                    <span class="label label-warning">
                                                        <i class="fa fa-clock-o"></i> Unpaid
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            
                                            <!-- Surgery Status -->
                                            <td>
                                                <?php if ($request['status'] == 'approved'): ?>
                                                    <span class="label label-success">
                                                        <i class="fa fa-thumbs-up"></i> Approved
                                                    </span>
                                                <?php elseif ($request['status'] == 'completed'): ?>
                                                    <span class="label label-default">
                                                        <i class="fa fa-check-circle"></i> Completed
                                                    </span>
                                                <?php else: ?>
                                                    <span class="label label-info">
                                                        <i class="fa fa-hourglass-half"></i> Pending
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            
                                            <!-- Surgery Date -->
                                            <td>
                                                <?php if (!empty($request['surgery_date'])): ?>
                                                    <small><?php echo date('d M Y', strtotime($request['surgery_date'])); ?></small>
                                                <?php else: ?>
                                                    <small class="text-muted">Not scheduled</small>
                                                <?php endif; ?>
                                            </td>
                                            
                                            <!-- Actions -->
                                            <td class="text-center btn-action-group">
                                                <!-- View Button -->
                                                <a href="<?php echo admin_url('hospital_management/view_surgery_request/' . $request['id']); ?>" 
                                                   class="btn btn-sm btn-info"
                                                   data-toggle="tooltip" 
                                                   title="View Details">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                
                                                <!-- Pay Button (if unpaid) -->
                                                <?php if ($request['payment_status'] == 'unpaid' && $request['counseling_status'] == 'accepted'): ?>
                                                    <button type="button" 
                                                            class="btn btn-warning btn-sm btn-process-payment" 
                                                            data-id="<?php echo $request['id']; ?>"
                                                            data-patient="<?php echo htmlspecialchars($request['patient_name']); ?>"
                                                            data-surgery="<?php echo htmlspecialchars($request['surgery_name'] ?? 'Surgery'); ?>"
                                                            data-quoted="<?php echo $quoted_amount; ?>"
                                                            data-discount="<?php echo $discount_amount; ?>"
                                                            data-final="<?php echo $final_amount; ?>"
                                                            data-toggle="tooltip" 
                                                            title="Process Payment">
                                                        <i class="fa fa-credit-card"></i> Pay
                                                    </button>
                                                <?php endif; ?>
                                                
                                                <!-- Approve Button (if paid but not approved) -->
                                                <?php if ($request['payment_status'] == 'paid' && $request['status'] == 'pending'): ?>
                                                    <button type="button" 
                                                            class="btn btn-success btn-sm btn-approve-surgery" 
                                                            data-id="<?php echo $request['id']; ?>"
                                                            data-patient="<?php echo htmlspecialchars($request['patient_name']); ?>"
                                                            data-surgery="<?php echo htmlspecialchars($request['surgery_name'] ?? 'Surgery'); ?>"
                                                            data-toggle="tooltip" 
                                                            title="Approve for Surgery">
                                                        <i class="fa fa-check"></i> Approve
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

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <i class="fa fa-credit-card"></i> Process Surgery Payment
                </h4>
            </div>
            <div class="modal-body">
                <!-- Payment Summary -->
                <div class="payment-summary">
                    <h5 class="text-primary"><i class="fa fa-info-circle"></i> Payment Summary</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Patient:</strong> <span id="modal-patient-name"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Surgery:</strong> <span id="modal-surgery-name"></span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Quoted Amount:</strong><br>
                            <span class="amount" id="modal-quoted-amount"></span>
                        </div>
                        <div class="col-md-4">
                            <strong>Discount:</strong><br>
                            <span class="discount-display" id="modal-discount-amount"></span>
                        </div>
                        <div class="col-md-4">
                            <strong>Final Amount:</strong><br>
                            <span class="amount text-success" id="modal-final-amount"></span>
                        </div>
                    </div>
                </div>

                <!-- Payment Form -->
                <form id="paymentForm">
                    <input type="hidden" id="payment-request-id" name="request_id">
                    <input type="hidden" id="payment-final-amount-value" name="payment_amount">
                    
                    <div class="row">
                        <!-- Payment Method -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payment-method">
                                    <i class="fa fa-money"></i> Payment Method <span class="text-danger">*</span>
                                </label>
                                <select class="form-control selectpicker" id="payment-method" name="payment_method" required>
                                    <option value="">Select Payment Method</option>
                                    <option value="cash">Cash</option>
                                    <option value="card">Card (Debit/Credit)</option>
                                    <option value="upi">UPI</option>
                                    <option value="net_banking">Net Banking</option>
                                    <option value="cheque">Cheque</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Transaction ID -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="transaction-id">
                                    <i class="fa fa-hashtag"></i> Transaction ID
                                </label>
                                <input type="text" class="form-control" id="transaction-id" name="transaction_id" placeholder="For digital payments">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Payment Reference -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payment-reference">
                                    <i class="fa fa-bookmark"></i> Payment Reference
                                </label>
                                <input type="text" class="form-control" id="payment-reference" name="payment_reference" placeholder="Receipt number, cheque number">
                            </div>
                        </div>
                        
                        <!-- Notes -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payment-notes">
                                    <i class="fa fa-comment"></i> Notes
                                </label>
                                <textarea class="form-control" id="payment-notes" name="notes" rows="1" placeholder="Any additional notes"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-success" id="btn-confirm-payment">
                    <i class="fa fa-check"></i> Confirm Payment
                </button>
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
    initDataTable('.table-surgery-patients', window.location.href, [11], [11], {
        "order": [[10, "desc"]], // Order by surgery date column
        "pageLength": 25,
        "responsive": true,
        "columnDefs": [
            {
                "targets": [11], // Actions column
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
    
    // Process Payment Button Click
    $(document).on('click', '.btn-process-payment', function() {
        var requestId = $(this).data('id');
        var patientName = $(this).data('patient');
        var surgeryName = $(this).data('surgery');
        var quotedAmount = parseFloat($(this).data('quoted'));
        var discountAmount = parseFloat($(this).data('discount'));
        var finalAmount = parseFloat($(this).data('final'));
        
        // Populate modal
        $('#payment-request-id').val(requestId);
        $('#modal-patient-name').text(patientName);
        $('#modal-surgery-name').text(surgeryName);
        $('#modal-quoted-amount').text('₹' + quotedAmount.toFixed(2));
        $('#modal-discount-amount').text('-₹' + discountAmount.toFixed(2));
        $('#modal-final-amount').text('₹' + finalAmount.toFixed(2));
        $('#payment-final-amount-value').val(finalAmount.toFixed(2));
        
        // Reset form
        $('#paymentForm')[0].reset();
        $('.selectpicker').selectpicker('refresh');
        
        // Show modal
        $('#paymentModal').modal('show');
    });
    
    // Confirm Payment Button Click
    $('#btn-confirm-payment').on('click', function() {
        var $btn = $(this);
        var paymentMethod = $('#payment-method').val();
        
        // Validation
        if (!paymentMethod) {
            alert_float('warning', 'Please select a payment method');
            return;
        }
        
        if (confirm('Confirm payment processing?\n\nThis will record the payment and enable surgery approval.')) {
            var originalHtml = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');
            
            var formData = {
                request_id: $('#payment-request-id').val(),
                payment_method: paymentMethod,
                payment_amount: $('#payment-final-amount-value').val(),
                transaction_id: $('#transaction-id').val(),
                payment_reference: $('#payment-reference').val(),
                notes: $('#payment-notes').val()
            };
            
            formData[csrfTokenName] = csrfTokenHash;
            
            $.ajax({
                url: '<?php echo admin_url("hospital_management/process_surgery_payment"); ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response && response.success) {
                        // Update CSRF tokens
                        if (response.csrf_token_name) {
                            csrfTokenName = response.csrf_token_name;
                        }
                        if (response.csrf_token_hash) {
                            csrfTokenHash = response.csrf_token_hash;
                        }
                        
                        alert_float('success', response.message || 'Payment processed successfully');
                        
                        $('#paymentModal').modal('hide');
                        
                        // Reload page after 1 second
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        alert_float('danger', response.message || 'Failed to process payment');
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
    
    // Approve Surgery Button Click
    $(document).on('click', '.btn-approve-surgery', function() {
        var $btn = $(this);
        var requestId = $btn.data('id');
        var patientName = $btn.data('patient');
        var surgeryName = $btn.data('surgery');
        
        if (confirm('Approve surgery for ' + patientName + '?\n\nSurgery: ' + surgeryName + '\n\nThis will mark the surgery as ready for scheduling.')) {
            var originalHtml = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            
            var data = {
                request_id: requestId
            };
            data[csrfTokenName] = csrfTokenHash;
            
            $.ajax({
                url: '<?php echo admin_url("hospital_management/approve_surgery_request"); ?>',
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
                        
                        alert_float('success', response.message || 'Surgery approved successfully');
                        
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        alert_float('danger', response.message || 'Failed to approve surgery');
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