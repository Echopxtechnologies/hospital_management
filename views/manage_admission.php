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
                                    <i class="fa fa-bed"></i> Manage Admission
                                </h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="<?php echo admin_url('hospital_management/nursing_dashboard'); ?>" 
                                   class="btn btn-default">
                                    <i class="fa fa-arrow-left"></i> Back to Nursing Portal
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admission Form -->
                <div class="panel_s">
                    <div class="panel-body">
                        <?php echo form_open(admin_url('hospital_management/save_admission'), ['id' => 'admission-form']); ?>
                        <input type="hidden" name="surgery_request_id" value="<?php echo $surgery_request->id; ?>">
                        
                        <!-- Patient Info (Read-only) -->
                        <div class="form-group">
                            <label>Patient Name</label>
                            <input type="text" class="form-control" 
                                   value="<?php echo $surgery_request->patient_name; ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label>Consultant Name</label>
                            <input type="text" class="form-control" 
                                   value="Dr. <?php echo $surgery_request->consultant_firstname . ' ' . $surgery_request->consultant_lastname; ?>" 
                                   readonly>
                        </div>

                        <!-- Admission Date -->
                        <div class="form-group">
                            <label for="admission_date">Admission Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="admission_date" id="admission_date"
                                   value="<?php echo !empty($admission['admission_date']) ? $admission['admission_date'] : date('Y-m-d'); ?>" 
                                   <?php echo !empty($admission) && $admission['admission_status'] == 'admitted' ? 'readonly' : 'required'; ?>>
                        </div>

                        <!-- Surgery Date (Read-only) -->
                        <div class="form-group">
                            <label>Surgery Date</label>
                            <input type="text" class="form-control" 
                                   value="<?php echo date('Y-m-d H:i:s', strtotime($surgery_request->surgery_date)); ?>" 
                                   readonly>
                        </div>

                        <!-- Ward Selection -->
                        <div class="form-group">
                            <label for="ward_id">Ward Number <span class="text-danger">*</span></label>
                            <select class="form-control selectpicker" name="ward_id" id="ward_id" 
                                    data-live-search="true" 
                                    <?php echo !empty($admission) && $admission['admission_status'] == 'admitted' ? 'disabled' : 'required'; ?>>
                                <option value="">Select Ward/Room</option>
                                <?php 
                                // Show current ward even if not available
                                if(!empty($admission) && !empty($admission['ward_id'])):
                                ?>
                                    <option value="<?php echo $admission['ward_id']; ?>" selected>
                                        <?php echo $admission['ward_name']; ?> 
                                        (<?php echo $admission['room_number']; ?>) - 
                                        <?php echo ucfirst($admission['ward_type']); ?>
                                    </option>
                                <?php endif; ?>
                                
                                <?php if(!empty($wards) && (empty($admission) || $admission['admission_status'] != 'admitted')): ?>
                                    <?php foreach($wards as $ward): ?>
                                        <?php if(empty($admission) || $ward['id'] != $admission['ward_id']): ?>
                                            <option value="<?php echo $ward['id']; ?>">
                                                <?php echo $ward['ward_name']; ?> 
                                                (<?php echo $ward['room_number']; ?>) - 
                                                <?php echo ucfirst($ward['ward_type']); ?>
                                                [<?php echo $ward['available_beds']; ?> beds available]
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <?php if(!empty($surgery_request->requested_room_type)): ?>
                                <small class="text-muted">
                                    <i class="fa fa-info-circle"></i> Requested: 
                                    <strong><?php echo $surgery_request->requested_room_type; ?></strong>
                                </small>
                            <?php endif; ?>
                        </div>

                        <!-- Admission/Discharge Notes -->
                        <div class="form-group">
                            <label for="admission_notes">
                                <?php echo !empty($admission) && $admission['admission_status'] == 'admitted' ? 'Enter Discharge Notes' : 'Admission Notes'; ?>
                            </label>
                            <textarea class="form-control" name="admission_notes" id="admission_notes" 
                                      rows="5" placeholder="Enter notes here..."><?php echo !empty($admission['admission_notes']) ? $admission['admission_notes'] : ''; ?></textarea>
                        </div>

                        <!-- Action Buttons -->
                        <div class="form-group">
                            <?php if(empty($admission) || $admission['admission_status'] != 'admitted'): ?>
                                <!-- Admit Button -->
                                <button type="submit" class="btn btn-success btn-lg" id="admit-btn">
                                    <i class="fa fa-check"></i> Admit Patient
                                </button>
                            <?php else: ?>
                                <!-- Update and Discharge Buttons -->
                                <button type="submit" class="btn btn-info btn-lg" id="update-btn">
                                    <i class="fa fa-save"></i> Update Info
                                </button>
                                <button type="button" class="btn btn-danger btn-lg" id="discharge-btn">
                                    <i class="fa fa-sign-out"></i> Discharge Now
                                </button>
                            <?php endif; ?>
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
$(function() {
    'use strict';
    
    // Initialize selectpicker
    $('.selectpicker').selectpicker('refresh');
    
    // Admission Form Submit
    $('#admission-form').on('submit', function(e) {
        e.preventDefault();
        
        var $submitBtn = $('#admit-btn, #update-btn');
        var originalBtnText = $submitBtn.html();
        
        // Disable button and show loading
        $submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    alert_float('success', response.message);
                    setTimeout(function() {
                        window.location.href = '<?php echo admin_url("hospital_management/nursing_dashboard"); ?>';
                    }, 1500);
                } else {
                    alert_float('danger', response.message || 'An error occurred');
                    $submitBtn.prop('disabled', false).html(originalBtnText);
                }
            },
            error: function(xhr, status, error) {
                console.error('Ajax Error:', status, error);
                alert_float('danger', 'Failed to process request. Please try again.');
                $submitBtn.prop('disabled', false).html(originalBtnText);
            }
        });
    });
    
    // Discharge Button
    $('#discharge-btn').on('click', function() {
        if(!confirm('Are you sure you want to discharge this patient?')) {
            return false;
        }
        
        var $dischargeBtn = $(this);
        var originalBtnText = $dischargeBtn.html();
        
        // Disable button and show loading
        $dischargeBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Discharging...');
        
        var formData = {
            surgery_request_id: $('input[name="surgery_request_id"]').val(),
            discharge_date: '<?php echo date("Y-m-d"); ?>',
            discharge_time: '<?php echo date("H:i:s"); ?>',
            discharge_notes: $('#admission_notes').val(),
            <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
        };
        
        $.ajax({
            url: '<?php echo admin_url("hospital_management/discharge_patient"); ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    alert_float('success', response.message);
                    setTimeout(function() {
                        window.location.href = '<?php echo admin_url("hospital_management/nursing_dashboard"); ?>';
                    }, 1500);
                } else {
                    alert_float('danger', response.message || 'Failed to discharge patient');
                    $dischargeBtn.prop('disabled', false).html(originalBtnText);
                }
            },
            error: function(xhr, status, error) {
                console.error('Discharge Error:', status, error);
                alert_float('danger', 'Failed to discharge patient. Please try again.');
                $dischargeBtn.prop('disabled', false).html(originalBtnText);
            }
        });
    });
});
</script>