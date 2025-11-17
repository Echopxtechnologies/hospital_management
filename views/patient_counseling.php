<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Header -->
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="no-margin">
                                    <i class="fa fa-user-md"></i> Patient Counseling
                                </h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="<?php echo admin_url('hospital_management/counselor_surgery_requests'); ?>" 
                                   class="btn btn-default">
                                    <i class="fa fa-arrow-left"></i> Back to Surgery Requests
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Patient Info Card -->
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Patient:</strong> <?php echo $surgery_request->patient_name; ?>
                            </div>
                            <div class="col-md-3">
                                <strong>Patient #:</strong> <?php echo $surgery_request->patient_number; ?>
                            </div>
                            <div class="col-md-3">
                                <strong>Age/Gender:</strong> <?php echo $surgery_request->age; ?>Y / <?php echo strtoupper($surgery_request->gender); ?>
                            </div>
                            <div class="col-md-3">
                                <strong>Mobile:</strong> <?php echo $surgery_request->mobile_number; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabbed Form -->
                <div class="panel_s">
                    <div class="panel-body">
                        
                        <!-- Nav Tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#simple-surgery" aria-controls="simple-surgery" role="tab" data-toggle="tab">
                                    <i class="fa fa-info-circle"></i> Simple Surgery Request Form
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#counselling" aria-controls="counselling" role="tab" data-toggle="tab">
                                    <i class="fa fa-comments"></i> Counselling
                                </a>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content mtop15">
                            
                            <!-- Tab 1: Simple Surgery Request -->
                            <div role="tabpanel" class="tab-pane active" id="simple-surgery">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="bold">Surgery Information</h4>
                                        <hr>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Surgery Name</label>
                                            <input type="text" class="form-control" 
                                                   value="<?php echo $surgery_request->surgery_name ?? 'N/A'; ?>" 
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Surgery Code</label>
                                            <input type="text" class="form-control" 
                                                   value="<?php echo $surgery_request->surgery_code ?? 'N/A'; ?>" 
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <input type="text" class="form-control" 
                                                   value="<?php echo $surgery_request->surgery_category ?? 'N/A'; ?>" 
                                                   readonly>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Request Type</label>
                                            <input type="text" class="form-control" 
                                                   value="<?php echo ucwords($surgery_request->request_type); ?>" 
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Request Status</label>
                                            <input type="text" class="form-control" 
                                                   value="<?php echo strtoupper($surgery_request->status); ?>" 
                                                   readonly>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Details</label>
                                            <textarea class="form-control" rows="4" readonly><?php echo $surgery_request->surgery_details ?? 'No details provided'; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 2: Counselling -->
                            <div role="tabpanel" class="tab-pane" id="counselling">
                                <?php echo form_open('', ['id' => 'counseling-form']); ?>
                                <input type="hidden" name="surgery_request_id" value="<?php echo $surgery_request->id; ?>">
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="bold">Counselling Information</h4>
                                        <hr>
                                    </div>
                                </div>

                                <!-- Row 1 -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="op_number">OP Number</label>
                                            <input type="text" class="form-control" name="op_number" id="op_number"
                                                   value="<?php echo $surgery_request->op_number ?? ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="iol_type">Type of IOL <span class="text-danger">*</span></label>
                                            <select class="form-control selectpicker" name="iol_type" id="iol_type" required>
                                                <option value="">Select IOL Type</option>
                                                <?php foreach($iol_types as $iol): ?>
                                                    <option value="<?php echo $iol; ?>" 
                                                        <?php echo ($surgery_request->iol_type == $iol) ? 'selected' : ''; ?>>
                                                        <?php echo $iol; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="anaesthesia_type">Anaesthesia <span class="text-danger">*</span></label>
                                            <select class="form-control selectpicker" name="anaesthesia_type" id="anaesthesia_type" required>
                                                <option value="">Select Anaesthesia Type</option>
                                                <?php foreach($anesthesia_types as $anesthesia): ?>
                                                    <option value="<?php echo $anesthesia; ?>"
                                                        <?php echo ($surgery_request->anaesthesia_type == $anesthesia) ? 'selected' : ''; ?>>
                                                        <?php echo $anesthesia; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Row 2: Fix Surgery Checkbox -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fix_surgery">Fix Surgery</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="fix_surgery" id="fix_surgery" value="yes"
                                                        <?php echo ($surgery_request->fix_surgery == 'yes') ? 'checked' : ''; ?>>
                                                    <strong>Yes, assign a consultant</strong>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Row 3: Consultant Dropdown (conditionally shown) -->
                                <div class="row" id="consultant-row" style="display: <?php echo ($surgery_request->fix_surgery == 'yes') ? 'block' : 'none'; ?>;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="assigned_consultant_id">Choose Consultant <span class="text-danger">*</span></label>
                                            <select class="form-control selectpicker" name="assigned_consultant_id" 
                                                    id="assigned_consultant_id" data-live-search="true">
                                                <option value="">Select Consultant</option>
                                                <?php foreach($consultants as $consultant): ?>
                                                    <option value="<?php echo $consultant['staffid']; ?>"
                                                        <?php echo ($surgery_request->assigned_consultant_id == $consultant['staffid']) ? 'selected' : ''; ?>>
                                                        Dr. <?php echo $consultant['firstname'] . ' ' . $consultant['lastname']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Row 4: Dates -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="admission_date">Admission Date</label>
                                            <input type="date" class="form-control" name="admission_date" id="admission_date"
                                                   value="<?php echo $surgery_request->admission_date ?? ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="surgery_date">Surgery Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="surgery_date" id="surgery_date"
                                                   value="<?php echo $surgery_request->surgery_date ?? ''; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Row 5: Consent & Room Type -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="surgery_consent">Surgery Consent</label>
                                            <select class="form-control selectpicker" name="surgery_consent" id="surgery_consent">
                                                <option value="no" <?php echo ($surgery_request->surgery_consent == 'no') ? 'selected' : ''; ?>>No</option>
                                                <option value="yes" <?php echo ($surgery_request->surgery_consent == 'yes') ? 'selected' : ''; ?>>Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="room_type">Type of Room <span class="text-danger">*</span></label>
                                            <select class="form-control selectpicker" name="room_type" id="room_type" required>
                                                <option value="">Select Room Type</option>
                                                <?php foreach($room_types as $room): ?>
                                                    <option value="<?php echo $room; ?>"
                                                        <?php echo ($surgery_request->room_type == $room) ? 'selected' : ''; ?>>
                                                        <?php echo $room; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Row 6: Remarks & Status -->
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="counseling_remarks">Remarks</label>
                                            <textarea class="form-control" name="counseling_remarks" id="counseling_remarks" 
                                                      rows="3"><?php echo $surgery_request->counseling_remarks ?? ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="counseling_status">Status</label>
                                            <select class="form-control selectpicker" name="counseling_status" id="counseling_status">
                                                <option value="pending" <?php echo ($surgery_request->counseling_status == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                                <option value="accepted" <?php echo ($surgery_request->counseling_status == 'accepted') ? 'selected' : ''; ?>>Accepted</option>
                                                <option value="rejected" <?php echo ($surgery_request->counseling_status == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Row 7: Payment Information -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="bold mtop15">Payment Quote</h5>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="payment_type">Payment Type</label>
                                            <select class="form-control selectpicker" name="payment_type" id="payment_type">
                                                <option value="cash" <?php echo ($surgery_request->payment_type == 'cash') ? 'selected' : ''; ?>>Cash</option>
                                                <option value="cashless" <?php echo ($surgery_request->payment_type == 'cashless') ? 'selected' : ''; ?>>Cashless</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="surgery_amount">Surgery Amount (₹) <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" class="form-control" name="surgery_amount" 
                                                   id="surgery_amount" value="<?php echo $surgery_request->surgery_amount ?? '0.00'; ?>" 
                                                   required onkeyup="calculateQuotedAmount()" onchange="calculateQuotedAmount()">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="counseling_discount_amount">Discount Amount (₹)</label>
                                            <input type="number" step="0.01" class="form-control" name="counseling_discount_amount" 
                                                   id="counseling_discount_amount" value="<?php echo $surgery_request->counseling_discount_amount ?? '0.00'; ?>"
                                                   onkeyup="calculateQuotedAmount()" onchange="calculateQuotedAmount()">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="copay_amount">Copay Amount (₹)</label>
                                            <input type="number" step="0.01" class="form-control" name="copay_amount" 
                                                   id="copay_amount" value="<?php echo $surgery_request->copay_amount ?? '0.00'; ?>">
                                        </div>
                                    </div>
                                </div>

                                <!-- Quoted Amount Display -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-info">
                                            <strong>Quoted Amount (Final): ₹<span id="quoted_amount_display"><?php echo number_format($surgery_request->quoted_amount ?? 0, 2); ?></span></strong>
                                            <p class="no-margin"><small>This amount will be used for payment processing by receptionist</small></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fa fa-save"></i> Save Counseling Data
                                        </button>
                                    </div>
                                </div>

                                <?php echo form_close(); ?>
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
// Calculate quoted amount in real-time
function calculateQuotedAmount() {
    var surgeryAmount = parseFloat($('#surgery_amount').val()) || 0;
    var discountAmount = parseFloat($('#counseling_discount_amount').val()) || 0;
    var quotedAmount = surgeryAmount - discountAmount;
    
    if (quotedAmount < 0) {
        quotedAmount = 0;
    }
    
    $('#quoted_amount_display').text(quotedAmount.toFixed(2));
}

// Form submission
$(function() {
    // Show/Hide consultant dropdown based on Fix Surgery checkbox
    $('#fix_surgery').on('change', function() {
        if ($(this).is(':checked')) {
            $('#consultant-row').slideDown();
            $('#assigned_consultant_id').attr('required', true);
        } else {
            $('#consultant-row').slideUp();
            $('#assigned_consultant_id').attr('required', false);
            $('#assigned_consultant_id').val('').selectpicker('refresh');
        }
    });

    $('#counseling-form').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        
        $.ajax({
            url: admin_url + 'hospital_management/save_counseling',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert_float('success', response.message);
                    // Optionally redirect back to surgery requests list
                    setTimeout(function() {
                        window.location.href = admin_url + 'hospital_management/counselor_surgery_requests';
                    }, 1500);
                } else {
                    alert_float('danger', response.message);
                }
            },
            error: function() {
                alert_float('danger', 'An error occurred while saving counseling data');
            }
        });
    });
    
    // Initialize selectpicker
    $('.selectpicker').selectpicker();
});
</script>
</body>
</html>