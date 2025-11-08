<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="bold">
                                    <i class="fa fa-flask text-primary"></i> Request Details
                                </h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="<?php echo admin_url('hospital_management/lab_requests'); ?>" class="btn btn-default">
                                    <i class="fa fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                        <hr class="hr-panel-heading">
                        
                        <!-- Request Header -->
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="bold">Request #<?php echo $request['request_number']; ?></h5>
                                <p><strong>Category:</strong> <?php echo $request['category_name']; ?></p>
                                <p><strong>Priority:</strong> 
                                    <?php if ($request['priority'] == 'emergency'): ?>
                                        <span class="label label-danger">EMERGENCY</span>
                                    <?php elseif ($request['priority'] == 'urgent'): ?>
                                        <span class="label label-warning">URGENT</span>
                                    <?php else: ?>
                                        <span class="label label-success">NORMAL</span>
                                    <?php endif; ?>
                                </p>
                                <p><strong>Status:</strong> 
                                    <?php if ($request['status'] == 'approved'): ?>
                                        <span class="label label-info">New - Not Started</span>
                                    <?php elseif ($request['status'] == 'in_progress'): ?>
                                        <span class="label label-primary">In Progress</span>
                                    <?php elseif ($request['status'] == 'completed'): ?>
                                        <span class="label label-success">Completed</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Patient:</strong> <?php echo $request['patient_name']; ?> (<?php echo $request['patient_number']; ?>)</p>
                                <p><strong>Doctor:</strong> Dr <?php echo $request['doctor_firstname'] . ' ' . $request['doctor_lastname']; ?></p>
                                <p><strong>Created:</strong> <?php echo _dt($request['created_at']); ?></p>
                                <p><strong>Total Amount:</strong> ₹<?php echo number_format($request['final_amount'], 2); ?></p>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <!-- Patient Info -->
                        <h5 class="bold">Patient Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Age:</strong> <?php echo $request['patient_age']; ?> years</p>
                                <p><strong>Gender:</strong> <?php echo ucfirst($request['patient_gender']); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Mobile:</strong> <?php echo $request['patient_mobile']; ?></p>
                                <p><strong>Visit #:</strong> <?php echo $request['visit_number']; ?></p>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <!-- Items Table -->
                        <h5 class="bold">Test Items (<?php echo count($request['items']); ?>)</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item Code</th>
                                    <th>Item Name</th>
                                    <th>Subcategory</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sn = 1; foreach ($request['items'] as $item): ?>
                                    <tr>
                                        <td><?php echo $sn++; ?></td>
                                        <td><?php echo $item['item_code']; ?></td>
                                        <td><?php echo $item['item_name']; ?></td>
                                        <td><?php echo $item['subcategory_name']; ?></td>
                                        <td><?php echo $item['quantity']; ?></td>
                                        <td>₹<?php echo number_format($item['total_price'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" class="text-right">Total:</th>
                                    <th>₹<?php echo number_format($request['final_amount'], 2); ?></th>
                                </tr>
                            </tfoot>
                        </table>
                        
                        <?php if (!empty($request['doctor_notes'])): ?>
                            <hr>
                            <h5 class="bold">Doctor's Notes</h5>
                            <p><?php echo nl2br($request['doctor_notes']); ?></p>
                        <?php endif; ?>
                        
                        <?php if (!empty($request['technician_notes'])): ?>
                            <hr>
                            <h5 class="bold">Technician Notes</h5>
                            <p><?php echo nl2br($request['technician_notes']); ?></p>
                        <?php endif; ?>
                        
                        <!-- Action Buttons -->
                        <?php if ($request['status'] != 'completed'): ?>
                            <hr>
                            <div class="text-right">
                                <?php if ($request['status'] == 'approved'): ?>
                                    <button class="btn btn-info btn-lg" onclick="startProcessing()">
                                        <i class="fa fa-play"></i> Start Processing
                                    </button>
                                <?php endif; ?>
                                
                                <?php if ($request['status'] == 'in_progress'): ?>
                                    <button class="btn btn-success btn-lg" onclick="completeRequest()">
                                        <i class="fa fa-check"></i> Mark as Completed
                                    </button>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <hr>
                            <div class="alert alert-success text-center">
                                <i class="fa fa-check-circle fa-2x"></i>
                                <h4>Request Completed</h4>
                                <p>Completed on: <?php echo _dt($request['completed_at']); ?></p>
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
var requestId = <?php echo $request['id']; ?>;

function startProcessing() {
    if (confirm('Start processing this request?')) {
        var data = {
            request_id: requestId
        };
        data[csrfTokenName] = csrfTokenHash;
        
        $.post('<?php echo admin_url("hospital_management/start_request"); ?>', data, function(response) {
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
}

function completeRequest() {
    if (confirm('Mark this request as completed?')) {
        var notes = prompt('Add completion notes (optional):');
        
        var data = {
            request_id: requestId,
            notes: notes || ''
        };
        data[csrfTokenName] = csrfTokenHash;
        
        $.post('<?php echo admin_url("hospital_management/complete_request"); ?>', data, function(response) {
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
}
</script>