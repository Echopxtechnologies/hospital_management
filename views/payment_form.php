<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <i class="fa fa-credit-card"></i> Process Payment
                        </h4>
                        <hr class="hr-panel-heading">
                        
                        <!-- Server-Side Validation Errors -->
                        <?php if (validation_errors()): ?>
                        <div class="alert alert-danger">
                            <?php echo validation_errors(); ?>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Patient & Request Info -->
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Patient:</strong> <?php echo htmlspecialchars($payment_details['patient_name'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <p><strong>Patient Number:</strong> <?php echo htmlspecialchars($payment_details['patient_number'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <p><strong>Patient Type:</strong> 
                                    <?php 
                                    $patient_type = htmlspecialchars($payment_details['patient_type'], ENT_QUOTES, 'UTF-8');
                                    $discount = (float)$payment_details['discount_percentage'];
                                    
                                    // Color coding based on discount
                                    if ($discount >= 100) {
                                        $badge_class = 'label-success'; // FREE
                                    } elseif ($discount >= 50) {
                                        $badge_class = 'label-warning'; // High discount
                                    } elseif ($discount > 0) {
                                        $badge_class = 'label-info'; // Some discount
                                    } else {
                                        $badge_class = 'label-default'; // Regular
                                    }
                                    ?>
                                    <span class="label <?php echo $badge_class; ?>" style="font-size: 13px; padding: 5px 10px;">
                                        <?php echo $patient_type; ?>
                                        <?php if ($discount >= 100): ?>
                                            <i class="fa fa-gift"></i> FREE
                                        <?php elseif ($discount > 0): ?>
                                            (<?php echo number_format($discount, 2); ?>% OFF)
                                        <?php endif; ?>
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Request Number:</strong> <?php echo htmlspecialchars($payment_details['request_number'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <p><strong>Visit Number:</strong> <?php echo htmlspecialchars($payment_details['visit_number'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <p><strong>Category:</strong> <?php echo htmlspecialchars($payment_details['category_name'], ENT_QUOTES, 'UTF-8'); ?></p>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <!-- Items Table -->
                        <h5><strong>Request Items</strong></h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Item Code</th>
                                    <th class="text-right">Quantity</th>
                                    <th class="text-right">Unit Price</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($payment_details['items'] as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['item_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($item['item_code'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="text-right"><?php echo (int)$item['quantity']; ?></td>
                                    <td class="text-right">₹<?php echo number_format((float)$item['unit_price'], 2); ?></td>
                                    <td class="text-right">₹<?php echo number_format((float)$item['total_price'], 2); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        
                        <hr>
                        
                        <!-- Payment Form -->
                        <?php echo form_open('', ['id' => 'payment-form']); ?>
                        <input type="hidden" name="request_id" value="<?php echo (int)$payment_details['request_id']; ?>">
                        
                        <!-- Payment Calculation -->
                        <div class="row">
                            <div class="col-md-6 col-md-offset-6">
                                <table class="table">
                                    <tr>
                                        <td><strong>Subtotal:</strong></td>
                                        <td class="text-right">
                                            <strong>₹<span id="subtotal-display"><?php echo number_format((float)$payment_details['subtotal'], 2); ?></span></strong>
                                            <input type="hidden" name="subtotal" id="subtotal" value="<?php echo number_format((float)$payment_details['subtotal'], 2, '.', ''); ?>">
                                        </td>
                                    </tr>
                                    
                                    <!-- EDITABLE DISCOUNT -->
                                    <tr>
                                        <td>
                                            <strong>Discount:</strong>
                                            <br>
                                            <small class="text-muted">Auto: <?php echo number_format((float)$payment_details['discount_percentage'], 2); ?>% (₹<?php echo number_format((float)$payment_details['discount_amount'], 2); ?>)</small>
                                        </td>
                                        <td class="text-right">
                                            <div class="input-group">
                                                <span class="input-group-addon">₹</span>
                                                <input type="number" 
                                                       step="0.01" 
                                                       class="form-control text-right" 
                                                       name="discount_amount" 
                                                       id="discount_amount" 
                                                       value="<?php echo number_format((float)$payment_details['discount_amount'], 2, '.', ''); ?>"
                                                       min="0"
                                                       max="<?php echo number_format((float)$payment_details['subtotal'], 2, '.', ''); ?>"
                                                       style="width: 120px;">
                                            </div>
                                            <small class="text-muted">Adjust if needed</small>
                                        </td>
                                    </tr>
                                    
                                    <tr class="active" style="border-top: 2px solid #ddd;">
                                        <td><strong>Total Amount to Pay:</strong></td>
                                        <td class="text-right">
                                            <h4 class="text-primary bold" style="margin: 5px 0;">
                                                ₹<span id="final-amount-display"><?php echo number_format((float)$payment_details['final_amount'], 2); ?></span>
                                                <input type="hidden" name="final_amount" id="final_amount" value="<?php echo number_format((float)$payment_details['final_amount'], 2, '.', ''); ?>">
                                            </h4>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="paid_amount">Amount Paid <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" 
                                           name="paid_amount" id="paid_amount" 
                                           value="<?php echo number_format((float)$payment_details['final_amount'], 2, '.', ''); ?>" 
                                           min="0" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                                    <select name="payment_method" id="payment_method" class="form-control selectpicker" required>
                                        <option value="">Select Method</option>
                                        <?php foreach ($payment_methods as $method): ?>
                                        <option value="<?php echo htmlspecialchars($method, ENT_QUOTES, 'UTF-8'); ?>">
                                            <?php echo htmlspecialchars(ucfirst($method), ENT_QUOTES, 'UTF-8'); ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="transaction_id">Transaction ID / Reference</label>
                                    <input type="text" class="form-control" name="transaction_id" 
                                           maxlength="100"
                                           placeholder="UPI ID, Transaction Number, etc.">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_reference">Payment Reference</label>
                                    <input type="text" class="form-control" name="payment_reference" 
                                           maxlength="100"
                                           placeholder="Cheque No., Card Last 4 Digits, etc.">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="notes">Notes (Optional)</label>
                            <textarea name="notes" class="form-control" rows="3" maxlength="500"></textarea>
                        </div>
                        
                        <div class="form-group text-right">
                            <a href="<?php echo admin_url('hospital_management/lab_records'); ?>" 
                               class="btn btn-default">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success" id="submit-payment-btn">
                                <i class="fa fa-check"></i> Complete Payment
                            </button>
                        </div>
                        
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>

<script>
$(document).ready(function() {
    'use strict';
    
    // Initialize selectpicker
    if ($.fn.selectpicker) {
        $('.selectpicker').selectpicker();
    }
    
    // Debounce function to reduce excessive calculations
    function debounce(func, wait) {
        var timeout;
        return function executedFunction() {
            var context = this;
            var args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                func.apply(context, args);
            }, wait);
        };
    }
    
    // Format number for display
    function formatCurrency(amount) {
        return parseFloat(amount).toFixed(2);
    }
    
    // Real-time discount calculation (debounced)
    var calculateDiscount = debounce(function() {
        var subtotal = parseFloat($('#subtotal').val()) || 0;
        var discount = parseFloat($('#discount_amount').val()) || 0;
        
        // Validate discount
        if (discount > subtotal) {
            discount = subtotal;
            $('#discount_amount').val(formatCurrency(discount));
        }
        
        if (discount < 0) {
            discount = 0;
            $('#discount_amount').val('0.00');
        }
        
        // Calculate final amount
        var finalAmount = subtotal - discount;
        
        // Update display (single DOM update)
        $('#final-amount-display').text(formatCurrency(finalAmount));
        $('#final_amount').val(formatCurrency(finalAmount));
        $('#paid_amount').val(formatCurrency(finalAmount));
    }, 300); // Wait 300ms after user stops typing
    
    // Single event listener (optimized)
    $('#discount_amount').on('input', calculateDiscount);
    
    // Validate paid amount (debounced)
    var validatePaidAmount = debounce(function() {
        var finalAmount = parseFloat($('#final_amount').val()) || 0;
        var paidAmount = parseFloat($('#paid_amount').val()) || 0;
        
        if (paidAmount < 0) {
            $('#paid_amount').val('0.00');
        } else if (paidAmount > finalAmount) {
            $('#paid_amount').val(formatCurrency(finalAmount));
        }
    }, 300);
    
    $('#paid_amount').on('input', validatePaidAmount);
    
    // Handle payment form submission
    $('#payment-form').on('submit', function(e) {
        e.preventDefault();
        
        // Validate before submit
        var paidAmount = parseFloat($('#paid_amount').val()) || 0;
        var finalAmount = parseFloat($('#final_amount').val()) || 0;
        
        if (paidAmount <= 0) {
            alert_float('warning', 'Please enter a valid paid amount');
            return false;
        }
        
        if (!$('#payment_method').val()) {
            alert_float('warning', 'Please select a payment method');
            return false;
        }
        
        var $btn = $('#submit-payment-btn');
        var originalText = $btn.html();
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');
        
        $.ajax({
            url: admin_url + 'hospital_management/save_payment',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert_float('success', response.message);
                    // Disable form to prevent double submission
                    $('#payment-form :input').prop('disabled', true);
                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 1000);
                } else {
                    alert_float('danger', response.message || 'Payment failed');
                    $btn.prop('disabled', false).html(originalText);
                }
            },
            error: function(xhr, status, error) {
                console.error('Payment Error:', error);
                alert_float('danger', 'An error occurred while processing payment');
                $btn.prop('disabled', false).html(originalText);
            }
        });
        
        return false;
    });
});
</script>