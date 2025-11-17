<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<style>
    /* Hospital Aqua Blue Theme */
    :root {
        --hospital-primary: #00BCD4;
        --hospital-secondary: #0097A7;
        --hospital-light: #B2EBF2;
        --hospital-accent: #00ACC1;
        --hospital-dark: #006064;
        --hospital-success: #00C853;
        --hospital-warning: #FFB300;
        --hospital-danger: #D32F2F;
    }
    
    /* Main Header */
    .hospital-header {
        background: linear-gradient(135deg, #00BCD4 0%, #0097A7 100%);
        color: white;
        padding: 30px;
        border-radius: 8px;
        margin-bottom: 25px;
        box-shadow: 0 4px 12px rgba(0, 188, 212, 0.2);
        position: relative;
        overflow: hidden;
    }
    
    .hospital-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    
    .hospital-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }
    
    .hospital-header .header-content {
        position: relative;
        z-index: 1;
    }
    
    .hospital-header h3 {
        margin: 0 0 8px 0;
        font-weight: 600;
        font-size: 26px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .hospital-header p {
        margin: 0;
        font-size: 15px;
        opacity: 0.95;
    }
    
    .hospital-header .header-icon {
        font-size: 42px;
        opacity: 0.2;
        position: absolute;
        right: 30px;
        top: 50%;
        transform: translateY(-50%);
    }
    
    /* Statistics Cards */
    .stats-container {
        margin-bottom: 25px;
    }
    
    .stat-card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        margin-bottom: 20px;
        border-left: 4px solid var(--hospital-primary);
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 80px;
        height: 80px;
        background: var(--hospital-light);
        opacity: 0.3;
        border-radius: 0 0 0 80px;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        box-shadow: 0 6px 20px rgba(0, 188, 212, 0.15);
        transform: translateY(-3px);
    }
    
    .stat-card:hover::before {
        width: 100px;
        height: 100px;
        border-radius: 0 0 0 100px;
    }
    
    .stat-card .stat-icon {
        font-size: 32px;
        color: var(--hospital-primary);
        margin-bottom: 10px;
        opacity: 0.8;
    }
    
    .stat-card h3 {
        color: var(--hospital-dark);
        font-weight: 700;
        font-size: 32px;
        margin: 10px 0;
        line-height: 1;
    }
    
    .stat-card .stat-label {
        color: #546E7A;
        font-weight: 600;
        font-size: 14px;
        margin: 5px 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .stat-card .stat-description {
        color: #78909C;
        font-size: 12px;
        margin: 5px 0 0 0;
    }
    
    /* Stat Card Variants */
    .stat-card.stat-pending {
        border-left-color: #FFB300;
    }
    
    .stat-card.stat-pending .stat-icon {
        color: #FFB300;
    }
    
    .stat-card.stat-paid {
        border-left-color: #00BCD4;
    }
    
    .stat-card.stat-paid .stat-icon {
        color: #00BCD4;
    }
    
    .stat-card.stat-approved {
        border-left-color: #00C853;
    }
    
    .stat-card.stat-approved .stat-icon {
        color: #00C853;
    }
    
    .stat-card.stat-today {
        border-left-color: #0097A7;
    }
    
    .stat-card.stat-today .stat-icon {
        color: #0097A7;
    }
    
    .stat-card.stat-completed {
        border-left-color: #546E7A;
    }
    
    .stat-card.stat-completed .stat-icon {
        color: #546E7A;
    }
    
    /* Panel Styling */
    .panel_s {
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: none;
    }
    
    .panel-body {
        padding: 25px;
    }
    
    /* DataTable Custom Styling */
    .table-surgery-patients {
        font-size: 13px;
        margin-top: 15px;
    }
    
    .table-surgery-patients thead {
        background: linear-gradient(135deg, #E0F7FA 0%, #B2EBF2 100%);
    }
    
    .table-surgery-patients thead th {
        color: var(--hospital-dark);
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 15px 10px;
        border-bottom: 2px solid var(--hospital-primary);
    }
    
    .table-surgery-patients tbody tr {
        transition: all 0.2s ease;
    }
    
    .table-surgery-patients tbody tr:hover {
        background-color: #E0F7FA;
        transform: scale(1.01);
    }
    
    .table-surgery-patients td {
        vertical-align: middle !important;
        padding: 12px 10px;
    }
    
    /* Patient Info Styling */
    .patient-info strong {
        color: var(--hospital-dark);
        font-size: 14px;
    }
    
    .patient-info .text-muted {
        font-size: 12px;
    }
    
    /* Amount Display */
    .amount-display {
        font-weight: 700;
        color: var(--hospital-success);
        font-size: 15px;
    }
    
    .discount-display {
        font-weight: 700;
        color: var(--hospital-danger);
    }
    
    /* Labels & Badges */
    .label {
        padding: 5px 12px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 11px;
        letter-spacing: 0.3px;
    }
    
    .label-warning {
        background-color: #FFB300;
        color: white;
    }
    
    .label-success {
        background-color: #00C853;
        color: white;
    }
    
    .label-info {
        background-color: #00BCD4;
        color: white;
    }
    
    .label-primary {
        background-color: #0097A7;
        color: white;
    }
    
    .label-default {
        background-color: #546E7A;
        color: white;
    }
    
    /* Button Styling */
    .btn-action-group {
        white-space: nowrap;
    }
    
    .btn-action-group .btn {
        margin-right: 5px;
        margin-bottom: 5px;
        border-radius: 4px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    
    .btn-action-group .btn-info {
        background-color: #00BCD4;
        border-color: #00BCD4;
    }
    
    .btn-action-group .btn-info:hover {
        background-color: #0097A7;
        border-color: #0097A7;
        transform: scale(1.05);
    }
    
    .btn-action-group .btn-warning {
        background-color: #FFB300;
        border-color: #FFB300;
        color: white;
    }
    
    .btn-action-group .btn-warning:hover {
        background-color: #FFA000;
        border-color: #FFA000;
        transform: scale(1.05);
    }
    
    .btn-action-group .btn-primary {
        background-color: #0097A7;
        border-color: #0097A7;
    }
    
    .btn-action-group .btn-primary:hover {
        background-color: #006064;
        border-color: #006064;
        transform: scale(1.05);
    }
    
    .btn-action-group .btn-success {
        background-color: #00C853;
        border-color: #00C853;
    }
    
    .btn-action-group .btn-success:hover {
        background-color: #00A845;
        border-color: #00A845;
        transform: scale(1.05);
    }
    
    /* Payment Modal */
    .modal-header {
        background: linear-gradient(135deg, #00BCD4 0%, #0097A7 100%);
        color: white;
        border-radius: 6px 6px 0 0;
        padding: 20px 25px;
    }
    
    .modal-header .modal-title {
        font-weight: 600;
        font-size: 20px;
    }
    
    .modal-header .close {
        color: white;
        opacity: 0.9;
        text-shadow: none;
    }
    
    .modal-header .close:hover {
        opacity: 1;
    }
    
    .modal-body {
        padding: 25px;
    }
    
    .payment-summary {
        background: linear-gradient(135deg, #E0F7FA 0%, #F5F5F5 100%);
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 25px;
        border-left: 4px solid var(--hospital-primary);
    }
    
    .payment-summary h5 {
        color: var(--hospital-dark);
        font-weight: 600;
        margin-bottom: 15px;
        font-size: 16px;
    }
    
    .payment-summary .row {
        margin-bottom: 10px;
    }
    
    .payment-summary strong {
        color: var(--hospital-dark);
        font-size: 13px;
    }
    
    .payment-summary .amount {
        font-size: 20px;
        font-weight: 700;
        color: var(--hospital-success);
    }
    
    .payment-summary hr {
        border-top: 2px solid rgba(0, 188, 212, 0.2);
        margin: 15px 0;
    }
    
    /* Form Styling */
    .form-group label {
        font-weight: 600;
        color: var(--hospital-dark);
        font-size: 13px;
        margin-bottom: 8px;
    }
    
    .form-group label i {
        color: var(--hospital-primary);
        margin-right: 5px;
    }
    
    .form-control:focus {
        border-color: var(--hospital-primary);
        box-shadow: 0 0 0 0.2rem rgba(0, 188, 212, 0.15);
    }
    
    /* Modal Footer */
    .modal-footer {
        padding: 15px 25px;
        background-color: #F5F5F5;
        border-radius: 0 0 6px 6px;
    }
    
    .modal-footer .btn-success {
        background-color: var(--hospital-success);
        border-color: var(--hospital-success);
        padding: 10px 25px;
        font-weight: 600;
    }
    
    .modal-footer .btn-success:hover {
        background-color: #00A845;
        border-color: #00A845;
    }
    
    /* ==========================================
       NEW: Link Appointment Modal Styling
       ========================================== */
    .link-summary {
        background: linear-gradient(135deg, #E0F7FA 0%, #F5F5F5 100%);
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        border-left: 4px solid var(--hospital-primary);
    }
    
    .link-summary strong {
        color: var(--hospital-dark);
        font-size: 14px;
    }
    
    .alert-info {
        background-color: #E1F5FE;
        border-color: #B3E5FC;
        color: #01579B;
    }
    
    /* Appointment Number Badge */
    .appointment-badge {
        display: inline-block;
        background: linear-gradient(135deg, #00BCD4 0%, #0097A7 100%);
        color: white;
        padding: 4px 10px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 11px;
        margin-top: 3px;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .hospital-header {
            padding: 20px;
        }
        
        .hospital-header h3 {
            font-size: 20px;
        }
        
        .hospital-header .header-icon {
            display: none;
        }
        
        .stat-card h3 {
            font-size: 24px;
        }
        
        .table-surgery-patients {
            font-size: 11px;
        }
        
        .btn-action-group .btn {
            font-size: 11px;
            padding: 4px 8px;
        }
    }
    
    /* Custom Scrollbar */
    .dataTables_wrapper {
        overflow-x: auto;
    }
    
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #F5F5F5;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: var(--hospital-primary);
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: var(--hospital-secondary);
    }
</style>

<div id="wrapper">
    <div class="content">
        <!-- Enhanced Header -->
        <div class="hospital-header">
            <div class="header-content">
                <div class="row">
                    <div class="col-md-8">
                        <h3>
                            <i class="fa fa-procedures"></i> Surgery Patients Management
                        </h3>
                        <p>
                            <i class="fa fa-info-circle"></i> Process payments and schedule surgery appointments efficiently
                        </p>
                    </div>
                    <div class="col-md-4 text-right">
                        <h4 style="margin: 0; font-size: 18px; font-weight: 600;">
                            <i class="fa fa-hospital-o"></i> Reception Desk
                        </h4>
                        <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;">
                            <i class="fa fa-calendar"></i> <?php echo date('l, F j, Y'); ?>
                        </p>
                    </div>
                </div>
            </div>
            <i class="fa fa-heartbeat header-icon"></i>
        </div>

        <!-- Enhanced Statistics Cards -->
        <div class="row stats-container">
            <!-- Pending Payment -->
            <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="stat-card stat-pending">
                    <div class="stat-icon">
                        <i class="fa fa-credit-card"></i>
                    </div>
                    <h3><?php echo isset($statistics['pending_payment']) ? (int)$statistics['pending_payment'] : 0; ?></h3>
                    <p class="stat-label">Pending Payment</p>
                    <p class="stat-description">Awaiting payment</p>
                </div>
            </div>
            
            <!-- Paid (Awaiting Scheduling) -->
            <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="stat-card stat-paid">
                    <div class="stat-icon">
                        <i class="fa fa-check-square-o"></i>
                    </div>
                    <h3><?php echo isset($statistics['paid']) ? (int)$statistics['paid'] : 0; ?></h3>
                    <p class="stat-label">Paid</p>
                    <p class="stat-description">Ready to schedule</p>
                </div>
            </div>
            
            <!-- Scheduled -->
            <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="stat-card stat-approved">
                    <div class="stat-icon">
                        <i class="fa fa-calendar-check-o"></i>
                    </div>
                    <h3><?php echo isset($statistics['approved']) ? (int)$statistics['approved'] : 0; ?></h3>
                    <p class="stat-label">Scheduled</p>
                    <p class="stat-description">Appointment created</p>
                </div>
            </div>
            
            <!-- Today's Surgeries -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="stat-card stat-today">
                    <div class="stat-icon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <h3><?php echo isset($statistics['today_surgeries']) ? (int)$statistics['today_surgeries'] : 0; ?></h3>
                    <p class="stat-label">Today's Surgeries</p>
                    <p class="stat-description">Scheduled for today</p>
                </div>
            </div>
            
            <!-- Completed -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="stat-card stat-completed">
                    <div class="stat-icon">
                        <i class="fa fa-check-circle"></i>
                    </div>
                    <h3><?php echo isset($statistics['completed']) ? (int)$statistics['completed'] : 0; ?></h3>
                    <p class="stat-label">Completed</p>
                    <p class="stat-description">All surgeries done</p>
                </div>
            </div>
        </div>

        <!-- Enhanced DataTable -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 style="margin: 0 0 20px 0; color: var(--hospital-dark); font-weight: 600;">
                            <i class="fa fa-list"></i> All Surgery Requests
                        </h4>
                        
                        <div class="table-responsive">
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
                                                <td class="patient-info">
                                                    <strong><?php echo htmlspecialchars($request['patient_name']); ?></strong><br>
                                                    <small class="text-muted">
                                                        <i class="fa fa-id-card-o"></i> <?php echo htmlspecialchars($request['patient_number']); ?> | 
                                                        <?php echo htmlspecialchars($request['patient_age']); ?>Y / <?php echo htmlspecialchars($request['patient_gender']); ?>
                                                    </small><br>
                                                    <small class="text-muted">
                                                        <i class="fa fa-phone"></i> <?php echo htmlspecialchars($request['patient_mobile']); ?>
                                                    </small>
                                                    <br>
<small class="text-muted">
    <i class="fa fa-user"></i> Type: <strong><?php echo htmlspecialchars($request['patient_type']); ?></strong>
</small>
                                                </td>
                                                
                                                <!-- Visit Number -->
                                                <td>
                                                    <strong style="color: var(--hospital-primary);"><?php echo htmlspecialchars($request['visit_number']); ?></strong><br>
                                                    <small class="text-muted">
                                                        <i class="fa fa-calendar-o"></i> <?php echo date('d M Y', strtotime($request['visit_date'])); ?>
                                                    </small>
                                                </td>
                                                
                                                <!-- Surgery Type -->
                                                <td>
                                                    <strong style="color: var(--hospital-dark);"><?php echo htmlspecialchars($request['surgery_name'] ?? 'N/A'); ?></strong><br>
                                                    <small class="text-muted"><?php echo htmlspecialchars($request['surgery_code'] ?? ''); ?></small><br>
                                                    <?php if ($request['request_type'] == 'simple'): ?>
                                                        <span class="label label-info">Simple</span>
                                                    <?php else: ?>
                                                        <span class="label label-primary">Detailed</span>
                                                    <?php endif; ?>
                                                </td>
                                                
                                                <!-- Requested By (Doctor) -->
                                                <td>
                                                    <small style="color: var(--hospital-dark);">
                                                        <i class="fa fa-user-md"></i> Dr. <?php echo htmlspecialchars($request['doctor_firstname'] . ' ' . $request['doctor_lastname']); ?>
                                                    </small>
                                                </td>
                                                
                                                <!-- Counselor -->
                                                <td>
                                                    <?php if (!empty($request['counselor_firstname'])): ?>
                                                        <small style="color: var(--hospital-dark);">
                                                            <i class="fa fa-user"></i> <?php echo htmlspecialchars($request['counselor_firstname'] . ' ' . $request['counselor_lastname']); ?>
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
                                                            <i class="fa fa-tag"></i> -₹<?php echo number_format($discount_amount, 2); ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="text-muted">₹0.00</span>
                                                    <?php endif; ?>
                                                </td>
                                                
                                                <!-- Final Amount -->
                                                <td>
                                                    <strong style="color: var(--hospital-success); font-size: 16px;">
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
                                                    <?php if ($request['status'] == 'scheduled'): ?>
                                                        <span class="label label-success">
                                                            <i class="fa fa-calendar-check-o"></i> Scheduled
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
                                                        <small style="color: var(--hospital-dark);">
                                                            <i class="fa fa-calendar"></i> <?php echo date('d M Y', strtotime($request['surgery_date'])); ?>
                                                        </small>
                                                    <?php else: ?>
                                                        <small class="text-muted">
                                                            <i class="fa fa-calendar-times-o"></i> Not scheduled
                                                        </small>
                                                    <?php endif; ?>
                                                </td>
                                                
                                                <!-- ==========================================
                                                     UPDATED: Actions Column with Appointment Display
                                                     ========================================== -->
                                                <td class="text-center btn-action-group">
                                                    <!-- View Button -->
                                                    <a href="<?php echo admin_url('hospital_management/view_surgery_request/' . $request['id']); ?>" 
                                                       class="btn btn-sm btn-info"
                                                       data-toggle="tooltip" 
                                                       title="View Details">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    
                                                    <!-- Pay Button (if unpaid and counseling accepted) -->
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
                                                    
                                                    <!-- Link Appointment Button (if paid but not scheduled) -->
                                                    <?php if ($request['payment_status'] == 'paid' && $request['status'] == 'pending'): ?>
                                                        <button type="button" 
                                                                class="btn btn-success btn-sm btn-link-appointment" 
                                                                data-id="<?php echo $request['id']; ?>"
                                                                data-patient="<?php echo htmlspecialchars($request['patient_name']); ?>"
                                                                data-surgery="<?php echo htmlspecialchars($request['surgery_name'] ?? 'Surgery'); ?>"
                                                                data-toggle="tooltip" 
                                                                title="Link Appointment & Schedule">
                                                            <i class="fa fa-link"></i> Link Appointment
                                                        </button>
                                                    <?php endif; ?>
                                                    
                                                    <!-- Show Scheduled Status with Appointment Number (if already scheduled) -->
                                                    <?php if ($request['status'] == 'scheduled'): ?>
                                                        <div style="display: inline-block; text-align: left;">
                                                            <span class="label label-success" style="font-size: 11px; padding: 5px 10px; display: block; margin-bottom: 3px;">
                                                                <i class="fa fa-check"></i> Scheduled
                                                            </span>
                                                            <?php if (!empty($request['appointment_number'])): ?>
                                                                <a href="<?php echo admin_url('hospital_management/view_appointment/' . $request['appointment_id']); ?>" 
                                                                   class="appointment-badge"
                                                                   data-toggle="tooltip"
                                                                   title="View Appointment">
                                                                    <i class="fa fa-calendar"></i> <?php echo htmlspecialchars($request['appointment_number']); ?>
                                                                </a>
                                                            <?php endif; ?>
                                                        </div>
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
</div>

<!-- Payment Modal (Existing - No Changes) -->
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
                    <h5>
                        <i class="fa fa-info-circle"></i> Payment Summary
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Patient:</strong> <span id="modal-patient-name" style="color: var(--hospital-dark);"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Surgery:</strong> <span id="modal-surgery-name" style="color: var(--hospital-dark);"></span>
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
                            <span class="amount" id="modal-final-amount"></span>
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

<!-- ==========================================
     NEW: Link Appointment Modal
     ========================================== -->
<div class="modal fade" id="linkAppointmentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <i class="fa fa-link"></i> Link Surgery to Appointment
                </h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="link-surgery-id">
                
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i> 
                    <strong>Instructions:</strong><br>
                    1. Manually create the appointment first in Appointments section<br>
                    2. Copy the Appointment Number (e.g., <strong>APT20250001</strong>)<br>
                    3. Paste it below to link and schedule the surgery
                </div>
                
                <div class="link-summary">
                    <strong><i class="fa fa-user"></i> Patient:</strong> <span id="link-patient-name"></span><br>
                    <strong><i class="fa fa-heartbeat"></i> Surgery:</strong> <span id="link-surgery-name"></span>
                </div>
                
                <div class="form-group">
                    <label for="appointment-number">
                        <i class="fa fa-calendar"></i> Appointment Number <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control" 
                           id="appointment-number" 
                           placeholder="Enter Appointment Number (e.g., APT20250001)"
                           style="font-size: 16px; font-weight: 600; text-transform: uppercase;">
                    <small class="text-muted">Example: APT20250001</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-success" id="btn-confirm-link">
                    <i class="fa fa-check"></i> Link & Schedule
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
        "order": [[10, "desc"]],
        "pageLength": 25,
        "responsive": true,
        "columnDefs": [
            {
                "targets": [11],
                "orderable": false,
                "searchable": false
            }
        ],
        "drawCallback": function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        },
        "language": {
            "search": "Search patients:",
            "lengthMenu": "Show _MENU_ patients per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ patients",
            "infoEmpty": "No patients found",
            "infoFiltered": "(filtered from _MAX_ total patients)",
            "emptyTable": "No surgery requests available",
            "zeroRecords": "No matching patients found"
        }
    });
    
    $('[data-toggle="tooltip"]').tooltip();
    
    // ==========================================
    // PAYMENT PROCESSING
    // ==========================================
    
    $(document).on('click', '.btn-process-payment', function() {
        var requestId = $(this).data('id');
        var patientName = $(this).data('patient');
        var surgeryName = $(this).data('surgery');
        var quotedAmount = parseFloat($(this).data('quoted'));
        var discountAmount = parseFloat($(this).data('discount'));
        var finalAmount = parseFloat($(this).data('final'));
        
        $('#payment-request-id').val(requestId);
        $('#modal-patient-name').text(patientName);
        $('#modal-surgery-name').text(surgeryName);
        $('#modal-quoted-amount').text('₹' + quotedAmount.toFixed(2));
        
        if (discountAmount > 0) {
            $('#modal-discount-amount').text('-₹' + discountAmount.toFixed(2));
        } else {
            $('#modal-discount-amount').text('₹0.00').removeClass('discount-display').addClass('text-muted');
        }
        
        $('#modal-final-amount').text('₹' + finalAmount.toFixed(2));
        $('#payment-final-amount-value').val(finalAmount.toFixed(2));
        
        $('#paymentForm')[0].reset();
        $('.selectpicker').selectpicker('refresh');
        $('#paymentModal').modal('show');
    });
    
    $('#btn-confirm-payment').on('click', function() {
        var $btn = $(this);
        var paymentMethod = $('#payment-method').val();
        
        if (!paymentMethod) {
            alert_float('warning', 'Please select a payment method');
            $('#payment-method').focus();
            return;
        }
        
        if (confirm('Confirm payment processing?\n\nThis will record the payment and enable appointment scheduling.')) {
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
                        if (response.csrf_token_name) csrfTokenName = response.csrf_token_name;
                        if (response.csrf_token_hash) csrfTokenHash = response.csrf_token_hash;
                        
                        alert_float('success', response.message || 'Payment processed successfully');
                        $('#paymentModal').modal('hide');
                        
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
                    console.error('Response:', xhr.responseText);
                    alert_float('danger', 'Network error. Please try again.');
                    $btn.prop('disabled', false).html(originalHtml);
                }
            });
        }
    });
    
    // ==========================================
    // NEW: LINK APPOINTMENT TO SURGERY
    // ==========================================
    
    // Open Link Appointment Modal
    $(document).on('click', '.btn-link-appointment', function() {
        var surgeryId = $(this).data('id');
        var patientName = $(this).data('patient');
        var surgeryName = $(this).data('surgery');
        
        $('#link-surgery-id').val(surgeryId);
        $('#link-patient-name').text(patientName);
        $('#link-surgery-name').text(surgeryName);
        $('#appointment-number').val('');
        
        $('#linkAppointmentModal').modal('show');
    });
    
    // Confirm Link Appointment
    $('#btn-confirm-link').on('click', function() {
        var $btn = $(this);
        var surgeryId = $('#link-surgery-id').val();
        var appointmentNumber = $('#appointment-number').val().trim().toUpperCase();
        
        // Validation
        if (!appointmentNumber) {
            alert_float('warning', 'Please enter an appointment number');
            $('#appointment-number').focus();
            return;
        }
        
        // Validate format (APT followed by digits)
        if (!/^APT\d+$/.test(appointmentNumber)) {
            alert_float('warning', 'Invalid appointment number format. Example: APT20250001');
            $('#appointment-number').focus();
            return;
        }
        
        if (confirm('Link surgery to appointment ' + appointmentNumber + '?\n\nThis will mark the surgery as SCHEDULED.')) {
            var originalHtml = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Linking...');
            
            var formData = {
                surgery_id: surgeryId,
                appointment_number: appointmentNumber
            };
            formData[csrfTokenName] = csrfTokenHash;
            
            $.ajax({
                url: '<?php echo admin_url("hospital_management/link_surgery_appointment"); ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response && response.success) {
                        if (response.csrf_token_name) csrfTokenName = response.csrf_token_name;
                        if (response.csrf_token_hash) csrfTokenHash = response.csrf_token_hash;
                        
                        alert_float('success', response.message || 'Surgery linked successfully');
                        $('#linkAppointmentModal').modal('hide');
                        
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        alert_float('danger', response.message || 'Failed to link appointment');
                        $btn.prop('disabled', false).html(originalHtml);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    console.error('Response:', xhr.responseText);
                    alert_float('danger', 'Network error. Please try again.');
                    $btn.prop('disabled', false).html(originalHtml);
                }
            });
        }
    });
    
    // Auto-uppercase appointment number
    $('#appointment-number').on('input', function() {
        $(this).val($(this).val().toUpperCase());
    });
    
    // ==========================================
    // UI ENHANCEMENTS
    // ==========================================
    
    $('.table-surgery-patients tbody').on('mouseenter', 'tr', function() {
        $(this).addClass('table-hover-active');
    }).on('mouseleave', 'tr', function() {
        $(this).removeClass('table-hover-active');
    });
});
</script>