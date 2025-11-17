<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<style>
/* Aqua Blue Medical Theme - Matching Consultant Appointments */
.medical-header {
    background: linear-gradient(135deg, #17a2b8 0%, #20c9e7 100%);
    color: white;
    padding: 20px;
    border-radius: 5px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.medical-header h3 {
    margin: 0;
    color: white;
    font-size: 24px;
    font-weight: 600;
}

.medical-header p {
    margin: 5px 0 0 0;
    opacity: 0.9;
    font-size: 14px;
}

.medical-header h4 {
    margin: 0;
    color: white;
    font-size: 18px;
}

/* Statistics Cards */
.stats-row {
    margin-bottom: 20px;
}

.stat-box {
    background: white;
    border: 1px solid #17a2b8;
    border-left: 4px solid #17a2b8;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
}

.stat-box:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.stat-box h3 {
    margin: 0 0 5px 0;
    color: #17a2b8;
    font-size: 28px;
    font-weight: 600;
}

.stat-box.stat-pending { 
    border-left-color: #ffc107; 
}
.stat-box.stat-pending h3 { 
    color: #ffc107; 
}

.stat-box.stat-paid { 
    border-left-color: #28a745; 
}
.stat-box.stat-paid h3 { 
    color: #28a745; 
}

.stat-box.stat-scheduled { 
    border-left-color: #17a2b8; 
}
.stat-box.stat-scheduled h3 { 
    color: #17a2b8; 
}

.stat-box.stat-completed { 
    border-left-color: #6c757d; 
}
.stat-box.stat-completed h3 { 
    color: #6c757d; 
}

.stat-box p {
    margin: 0;
    color: #666;
    font-size: 13px;
}

.stat-box small {
    color: #999;
    font-size: 11px;
}

/* Table Styling */
.table thead {
    background: #17a2b8;
    color: white;
}

.table thead th {
    border-color: #17a2b8;
    font-weight: 600;
    font-size: 12px;
}

.table-surgery-appointments {
    font-size: 13px;
}

.table-surgery-appointments td {
    vertical-align: middle !important;
}

/* Amount Displays */
.amount-display {
    font-weight: bold;
    color: #28a745;
    font-size: 14px;
}

.discount-display {
    font-weight: bold;
    color: #dc3545;
    font-size: 14px;
}

/* Labels/Badges */
.label {
    padding: 5px 10px;
    border-radius: 3px;
    font-size: 11px;
    font-weight: 600;
}

/* Section Title */
.section-title {
    color: #17a2b8;
    font-weight: 600;
    margin-bottom: 15px;
    font-size: 16px;
}
</style>

<div id="wrapper">
    <div class="content">
        <!-- Header -->
        <div class="medical-header">
            <div class="row">
                <div class="col-md-8">
                    <h3>
                        <i class="fa fa-procedures"></i> My Surgery Appointments
                    </h3>
                    <p>
                        View all surgery requests you have made for your patients
                    </p>
                </div>
                <div class="col-md-4 text-right">
                    <h4>
                        <i class="fa fa-user-md"></i> Consultant Portal
                    </h4>
                    <p>
                        <?php echo date('l, F j, Y'); ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <?php if (!empty($surgery_appointments)): ?>
        <div class="row stats-row">
            <?php
            // Calculate statistics
            $total = count($surgery_appointments);
            $pending_payment = 0;
            $paid = 0;
            $scheduled = 0;
            $completed = 0;
            
            foreach ($surgery_appointments as $sr) {
                if ($sr['payment_status'] == 'pending' || $sr['payment_status'] == 'unpaid') {
                    $pending_payment++;
                }
                if ($sr['payment_status'] == 'paid') {
                    $paid++;
                }
                if ($sr['surgery_status'] == 'scheduled') {
                    $scheduled++;
                }
                if ($sr['surgery_status'] == 'completed') {
                    $completed++;
                }
            }
            ?>
            
            <div class="col-md-3 col-sm-6">
                <div class="stat-box">
                    <h3><?php echo $total; ?></h3>
                    <p><i class="fa fa-procedures"></i> Total Surgery Requests</p>
                    <small>All surgery appointments</small>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6">
                <div class="stat-box stat-pending">
                    <h3><?php echo $pending_payment; ?></h3>
                    <p><i class="fa fa-credit-card"></i> Pending Payment</p>
                    <small>Awaiting payment</small>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6">
                <div class="stat-box stat-paid">
                    <h3><?php echo $paid; ?></h3>
                    <p><i class="fa fa-check-circle"></i> Paid</p>
                    <small>Payment completed</small>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6">
                <div class="stat-box stat-scheduled">
                    <h3><?php echo $scheduled; ?></h3>
                    <p><i class="fa fa-calendar-check-o"></i> Scheduled</p>
                    <small>Surgery date set</small>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- DataTable -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        
                        <?php if (!empty($surgery_appointments)): ?>
                        
                        <h4 class="section-title">
                            <i class="fa fa-list"></i> Surgery Appointments List
                        </h4>
                        
                        <!-- DataTable - Using Perfex's built-in class -->
                        <table class="table dt-table table-surgery-appointments" data-order-col="10" data-order-type="desc">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Visit #</th>
                                    <th>Surgery Type</th>
                                    <th>Counselor</th>
                                    <th>Quoted Amount</th>
                                    <th>Discount</th>
                                    <th>Final Amount</th>
                                    <th>Payment Status</th>
                                    <th>Surgery Status</th>
                                    <th>Surgery Date</th>
                                    <th>Requested Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($surgery_appointments as $request): ?>
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
                                            <strong style="color: #17a2b8;"><?php echo $request['patient_name']; ?></strong><br>
                                            <small class="text-muted">
                                                <?php echo $request['patient_number']; ?> | 
                                                <?php echo $request['patient_age']; ?>Y / <?php echo ucfirst($request['patient_gender']); ?>
                                            </small><br>
                                            <small class="text-muted">
                                                <i class="fa fa-phone"></i> <?php echo $request['patient_mobile']; ?>
                                            </small>
                                        </td>
                                        
                                        <!-- Visit Number -->
                                        <td>
                                            <strong><?php echo $request['visit_number']; ?></strong><br>
                                            <small class="text-muted">
                                                <?php echo date('d M Y', strtotime($request['visit_date'])); ?>
                                            </small>
                                        </td>
                                        
                                        <!-- Surgery Type -->
                                        <td>
                                            <strong><?php echo $request['surgery_name'] ?? 'N/A'; ?></strong><br>
                                            <small class="text-muted"><?php echo $request['surgery_code'] ?? ''; ?></small><br>
                                            <?php if (isset($request['request_type'])): ?>
                                                <?php if ($request['request_type'] == 'simple'): ?>
                                                    <span class="label label-info">Simple</span>
                                                <?php else: ?>
                                                    <span class="label label-primary">Detailed</span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <!-- Counselor -->
                                        <td>
                                            <?php if (!empty($request['counselor_firstname'])): ?>
                                                <small>
                                                    <i class="fa fa-user"></i>
                                                    <?php echo $request['counselor_firstname'] . ' ' . $request['counselor_lastname']; ?>
                                                </small>
                                            <?php else: ?>
                                                <small class="text-muted">
                                                    <i class="fa fa-minus-circle"></i> Not assigned
                                                </small>
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
                                            <?php elseif ($request['payment_status'] == 'partially_paid'): ?>
                                                <span class="label label-info">
                                                    <i class="fa fa-clock-o"></i> Partial
                                                </span>
                                            <?php else: ?>
                                                <span class="label label-warning">
                                                    <i class="fa fa-clock-o"></i> Unpaid
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <!-- Surgery Status -->
                                        <td>
                                            <?php if ($request['surgery_status'] == 'scheduled'): ?>
                                                <span class="label label-success">
                                                    <i class="fa fa-calendar-check-o"></i> Scheduled
                                                </span>
                                            <?php elseif ($request['surgery_status'] == 'completed'): ?>
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
                                                <strong style="color: #17a2b8;">
                                                    <?php echo date('d M Y', strtotime($request['surgery_date'])); ?>
                                                </strong>
                                                <?php if (!empty($request['appointment_time'])): ?>
                                                    <br><small class="text-muted">
                                                        <i class="fa fa-clock-o"></i>
                                                        <?php echo date('h:i A', strtotime($request['appointment_time'])); ?>
                                                    </small>
                                                <?php endif; ?>
                                            <?php elseif (!empty($request['appointment_date'])): ?>
                                                <strong style="color: #17a2b8;">
                                                    <?php echo date('d M Y', strtotime($request['appointment_date'])); ?>
                                                </strong>
                                                <?php if (!empty($request['appointment_time'])): ?>
                                                    <br><small class="text-muted">
                                                        <i class="fa fa-clock-o"></i>
                                                        <?php echo date('h:i A', strtotime($request['appointment_time'])); ?>
                                                    </small>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <small class="text-muted">
                                                    <i class="fa fa-minus-circle"></i> Not scheduled
                                                </small>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <!-- Requested Date -->
                                        <td data-order="<?php echo strtotime($request['requested_at']); ?>">
                                            <small>
                                                <i class="fa fa-calendar"></i>
                                                <?php echo date('d M Y', strtotime($request['requested_at'])); ?>
                                            </small><br>
                                            <small class="text-muted">
                                                <i class="fa fa-clock-o"></i>
                                                <?php echo date('h:i A', strtotime($request['requested_at'])); ?>
                                            </small>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        
                        <?php else: ?>
                        
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> 
                            <strong>No Surgery Appointments Found</strong><br>
                            Surgery appointments you request for your patients will appear here once counseling is accepted by the counselor.
                        </div>
                        
                        <?php endif; ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>