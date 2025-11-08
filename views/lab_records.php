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
                                <h3 class="text-warning"><?php echo $statistics['pending']; ?></h3>
                                <p class="text-muted">Pending Assignment</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <h3 class="text-info"><?php echo $statistics['approved']; ?></h3>
                                <p class="text-muted">Assigned</p>
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
                                <h3 class="text-info"><?php echo $statistics['today']; ?></h3>
                                <p class="text-muted">Today's Requests</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <i class="fa fa-flask text-primary"></i> Procedures & Lab Records
                        </h4>
                        <hr class="hr-panel-heading">
                        
                        <?php if (empty($pending_requests)): ?>
                            <div class="alert alert-info text-center">
                                <i class="fa fa-info-circle"></i> No pending requests found.
                            </div>
                        <?php else: ?>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Request #</th>
                                        <th>Patient</th>
                                        <th>Doctor</th>
                                        <th>Category</th>
                                        <th>Items</th>
                                        <th>Amount</th>
                                        <th>Priority</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pending_requests as $request): ?>
                                        <tr>
                                            <td><strong><?php echo $request['request_number']; ?></strong></td>
                                            <td>
                                                <?php echo $request['patient_name']; ?><br>
                                                <small class="text-muted"><?php echo $request['patient_number']; ?></small>
                                            </td>
                                            <td>Dr <?php echo $request['doctor_firstname'] . ' ' . $request['doctor_lastname']; ?></td>
                                            <td><?php echo $request['category_name']; ?></td>
                                            <td><span class="badge"><?php echo $request['items_count']; ?> items</span></td>
                                            <td><strong>₹<?php echo number_format($request['final_amount'], 2); ?></strong></td>
                                            <td>
                                                <?php if ($request['priority'] == 'emergency'): ?>
                                                    <span class="label label-danger">EMERGENCY</span>
                                                <?php elseif ($request['priority'] == 'urgent'): ?>
                                                    <span class="label label-warning">URGENT</span>
                                                <?php else: ?>
                                                    <span class="label label-success">NORMAL</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo _dt($request['created_at']); ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary view-details-btn" 
                                                        data-id="<?php echo $request['id']; ?>">
                                                    <i class="fa fa-eye"></i> View & Assign
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

<!-- ============================================
     REQUEST DETAILS MODAL
============================================ -->
<div class="modal fade" id="requestModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Request Details</h4>
            </div>
            <div class="modal-body" id="modalBody">
                <div class="text-center">
                    <i class="fa fa-spinner fa-spin fa-3x"></i>
                    <p>Loading...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>

<style>
.request-detail-section {
    margin-bottom: 20px;
    padding: 15px;
    background: #f9f9f9;
    border-radius: 4px;
}
.request-detail-section h5 {
    margin-top: 0;
    color: #333;
    font-weight: 600;
    border-bottom: 2px solid #00bcd4;
    padding-bottom: 5px;
}
</style>

<script>
var csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';
var csrfTokenHash = '<?php echo $this->security->get_csrf_hash(); ?>';

$(function() {
    // View Details Button
    $('.view-details-btn').on('click', function() {
        var requestId = $(this).data('id');
        loadRequestDetails(requestId);
    });
});

// Load request details into modal
function loadRequestDetails(requestId) {
    $('#requestModal').modal('show');
    $('#modalBody').html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-3x"></i><p>Loading...</p></div>');
    
    var data = {
        request_id: requestId
    };
    data[csrfTokenName] = csrfTokenHash;
    
    $.post('<?php echo admin_url("hospital_management/get_request_details"); ?>', data, function(response) {
        if (response.success) {
            csrfTokenName = response.csrf_token_name;
            csrfTokenHash = response.csrf_token_hash;
            
            displayRequestDetails(response.request);
        } else {
            $('#modalBody').html('<div class="alert alert-danger">' + response.message + '</div>');
        }
    }, 'json');
}

// Display request details in modal
function displayRequestDetails(request) {
    var priorityLabel = '';
    if (request.priority == 'emergency') {
        priorityLabel = '<span class="label label-danger">EMERGENCY</span>';
    } else if (request.priority == 'urgent') {
        priorityLabel = '<span class="label label-warning">URGENT</span>';
    } else {
        priorityLabel = '<span class="label label-success">NORMAL</span>';
    }
    
    var html = `
        <!-- Patient Info -->
        <div class="request-detail-section">
            <h5><i class="fa fa-user"></i> Patient Information</h5>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Name:</strong> ${request.patient_name}</p>
                    <p><strong>Patient ID:</strong> ${request.patient_number}</p>
                    <p><strong>Age/Gender:</strong> ${request.patient_age} yrs / ${request.patient_gender}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Mobile:</strong> ${request.patient_mobile}</p>
                    <p><strong>Visit #:</strong> ${request.visit_number}</p>
                    <p><strong>Visit Date:</strong> ${request.visit_date}</p>
                </div>
            </div>
        </div>
        
        <!-- Request Info -->
        <div class="request-detail-section">
            <h5><i class="fa fa-flask"></i> Request Information</h5>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Request #:</strong> ${request.request_number}</p>
                    <p><strong>Category:</strong> ${request.category_name}</p>
                    <p><strong>Requested By:</strong> Dr ${request.doctor_firstname} ${request.doctor_lastname}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Priority:</strong> ${priorityLabel}</p>
                    <p><strong>Total Amount:</strong> <span style="font-size:16px; color:#4caf50;">₹${parseFloat(request.final_amount).toFixed(2)}</span></p>
                    <p><strong>Created:</strong> ${request.created_at}</p>
                </div>
            </div>
        </div>
        
        <!-- Items Table -->
        <div class="request-detail-section">
            <h5><i class="fa fa-list"></i> Requested Items (${request.items.length})</h5>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Subcategory</th>
                        <th>Qty</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
    `;
    
    request.items.forEach(function(item) {
        html += `
            <tr>
                <td>${item.item_code}</td>
                <td>${item.item_name}</td>
                <td>${item.subcategory_name}</td>
                <td>${item.quantity}</td>
                <td>₹${parseFloat(item.total_price).toFixed(2)}</td>
            </tr>
        `;
    });
    
    html += `
                </tbody>
            </table>
        </div>
        
        <!-- Doctor's Notes -->
    `;
    
    if (request.doctor_notes) {
        html += `
        <div class="request-detail-section">
            <h5><i class="fa fa-sticky-note"></i> Doctor's Notes</h5>
            <p>${request.doctor_notes}</p>
        </div>
        `;
    }
    
    // Assignment Section
    html += `
        <div class="request-detail-section">
            <h5><i class="fa fa-user-md"></i> Assign to Technician</h5>
            <form id="assignForm">
                <div class="form-group">
                    <label>Select Technician <span class="text-danger">*</span></label>
                    <select name="technician_id" class="form-control selectpicker" data-live-search="true" required>
                        <option value="">-- Select Technician --</option>
                        <?php foreach ($technicians as $tech): ?>
                            <option value="<?php echo $tech['staffid']; ?>">
                                <?php echo $tech['firstname'] . ' ' . $tech['lastname']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <input type="hidden" name="request_id" value="${request.id}">
                
                <div class="text-right">
                    <button type="button" class="btn btn-danger" onclick="cancelRequest(${request.id})">
                        <i class="fa fa-times"></i> Cancel Request
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check"></i> Assign & Send to Lab
                    </button>
                </div>
            </form>
        </div>
    `;
    
    $('#modalBody').html(html);
    $('.selectpicker').selectpicker('refresh');
    
    // Handle assignment form submit
    $('#assignForm').on('submit', function(e) {
        e.preventDefault();
        assignRequest($(this).serialize());
    });
}

// Assign request to technician
function assignRequest(formData) {
    var data = formData + '&' + csrfTokenName + '=' + csrfTokenHash;
    
    $.post('<?php echo admin_url("hospital_management/assign_request"); ?>', data, function(response) {
        if (response.success) {
            csrfTokenName = response.csrf_token_name;
            csrfTokenHash = response.csrf_token_hash;
            
            alert_float('success', response.message);
            $('#requestModal').modal('hide');
            
            setTimeout(function() {
                window.location.reload();
            }, 1000);
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
}

// Cancel request
function cancelRequest(requestId) {
    var reason = prompt('Please enter cancellation reason:');
    
    if (reason && reason.trim() !== '') {
        var data = {
            request_id: requestId,
            reason: reason
        };
        data[csrfTokenName] = csrfTokenHash;
        
        $.post('<?php echo admin_url("hospital_management/cancel_request"); ?>', data, function(response) {
            if (response.success) {
                csrfTokenName = response.csrf_token_name;
                csrfTokenHash = response.csrf_token_hash;
                
                alert_float('success', response.message);
                $('#requestModal').modal('hide');
                
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