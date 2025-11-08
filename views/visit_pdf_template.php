<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 10mm 12mm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, Helvetica, sans-serif;
            font-size: 9pt;
            line-height: 1.5;
            color: #1a1a1a;
        }
        
        /* ============================================
           HEADER SECTION - Professional Hospital Branding
           ============================================ */
        
        .header-outer {
            border: 3px solid #00A9CE;
            margin-bottom: 8mm;
            background: #fff;
        }
        
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .logo-cell {
            width: 90px;
            vertical-align: middle;
            padding: 15px;
            background: #E5F6FA;
            border-right: 3px solid #00A9CE;
            text-align: center;
        }
        
        .logo-cell img {
            max-width: 75px;
            max-height: 75px;
        }
        
        .logo-placeholder {
            font-size: 14pt;
            font-weight: bold;
            color: #00A9CE;
            padding: 20px 0;
        }
        
        .info-cell {
            vertical-align: middle;
            padding: 12px 18px;
        }
        
        .hospital-name {
            font-size: 18pt;
            font-weight: bold;
            color: #00A9CE;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }
        
        .hospital-tagline {
            font-size: 9pt;
            color: #007A99;
            font-style: italic;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .hospital-contact {
            font-size: 8pt;
            line-height: 1.8;
            color: #666;
            border-top: 1px solid #B3E5F0;
            padding-top: 6px;
        }
        
        .icon {
            color: #00A9CE;
            font-weight: bold;
            font-size: 9pt;
        }
        
        .title-banner {
            background: #00A9CE;
            color: #fff;
            text-align: center;
            padding: 12px;
            font-size: 15pt;
            font-weight: bold;
            letter-spacing: 3px;
        }
        
        .title-subtitle {
            font-size: 8.5pt;
            font-weight: normal;
            letter-spacing: 1.5px;
            margin-top: 3px;
            opacity: 0.95;
        }
        
        /* ============================================
           PATIENT INFO CARD - Highlighted Demographics
           ============================================ */
        
        .patient-card {
            background: #F0FAFE;
            border: 2px solid #00A9CE;
            border-left: 6px solid #00A9CE;
            padding: 12px 15px;
            margin-bottom: 6mm;
        }
        
        .patient-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4mm;
        }
        
        .patient-table:last-child {
            margin-bottom: 0;
        }
        
        .patient-cell {
            padding: 5px 10px 5px 0;
            vertical-align: middle;
        }
        
        .w-25 { width: 25%; }
        .w-33 { width: 33.33%; }
        .w-50 { width: 50%; }
        .w-100 { width: 100%; }
        
        .label {
            font-size: 8pt;
            font-weight: bold;
            color: #007A99;
            margin-right: 6px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .value {
            font-size: 10pt;
            font-weight: bold;
            color: #000;
            padding: 3px 10px;
            background: #fff;
            border-bottom: 2px solid #00A9CE;
            display: inline-block;
        }
        
        /* CHECKBOXES */
        .checkbox-group {
            display: inline-block;
        }
        
        .checkbox-item {
            font-size: 9pt;
            font-weight: bold;
            margin-right: 15px;
            display: inline-block;
        }
        
        .checkbox {
            width: 13px;
            height: 13px;
            border: 2px solid #00A9CE;
            background: #fff;
            display: inline-block;
            vertical-align: middle;
            text-align: center;
            line-height: 11px;
            margin-right: 5px;
            font-size: 9pt;
        }
        
        .checkbox.checked {
            background: #00A9CE;
            color: #fff;
            font-weight: bold;
        }
        
        /* ============================================
           SECTION HEADERS - Color-Coded Categories
           ============================================ */
        
        .section-title {
            background: #00A9CE;
            color: #fff;
            padding: 8px 15px;
            font-weight: bold;
            font-size: 10.5pt;
            margin: 6mm 0 4mm 0;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        
        .section-title:before {
            content: "● ";
            margin-right: 8px;
        }
        
        /* ============================================
           CONTENT BOXES - Clinical Information
           ============================================ */
        
        .content-box {
            border: 2px solid #B3E5F0;
            border-left: 5px solid #00A9CE;
            padding: 10px 12px;
            margin-bottom: 4mm;
            background: #fff;
            min-height: 40px;
        }
        
        .box-label {
            font-size: 8.5pt;
            font-weight: bold;
            color: #007A99;
            display: block;
            margin-bottom: 6px;
            text-transform: uppercase;
            border-bottom: 1px solid #E5F6FA;
            padding-bottom: 3px;
            letter-spacing: 0.3px;
        }
        
        .box-content {
            font-size: 9pt;
            line-height: 1.7;
            color: #1a1a1a;
        }
        
        /* ALERT BOX - Allergies Warning */
        .alert-box {
            background: #FFF9E6;
            border: 2px solid #FFA726;
            border-left: 5px solid #F57C00;
            padding: 10px 12px;
            margin-bottom: 4mm;
        }
        
        .alert-label {
            font-size: 8.5pt;
            font-weight: bold;
            color: #E65100;
            display: block;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .alert-content {
            font-size: 9pt;
            line-height: 1.7;
            color: #333;
        }
        
        /* TWO COLUMN LAYOUT */
        .two-col-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4mm;
        }
        
        .col-cell {
            width: 48%;
            padding: 0 6px;
            vertical-align: top;
        }
        
        .col-cell:first-child {
            padding-left: 0;
        }
        
        .col-cell:last-child {
            padding-right: 0;
        }
        
        /* ============================================
           DATA TABLES - Clinical Examination Results
           ============================================ */
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 4mm 0;
            border: 2px solid #B3E5F0;
        }
        
        .data-table thead tr {
            background: #00A9CE;
        }
        
        .data-table th {
            padding: 10px 12px;
            font-size: 9pt;
            font-weight: bold;
            text-align: left;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-right: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .data-table th:last-child {
            border-right: none;
        }
        
        .data-table td {
            border: 1px solid #E5F6FA;
            padding: 10px 12px;
            font-size: 9pt;
            color: #1a1a1a;
            line-height: 1.5;
        }
        
        .data-table tbody tr:nth-child(even) {
            background: #F8FCFD;
        }
        
        .data-table tbody tr:nth-child(odd) {
            background: #fff;
        }
        
        .table-bold {
            font-weight: bold;
            color: #007A99;
        }
        
        /* ============================================
           PRESCRIPTION SECTION - Medication Details
           ============================================ */
        
        .rx-container {
            background: #fff;
            border: 3px solid #00A9CE;
            padding: 12px 15px;
            margin: 5mm 0;
        }
        
        .rx-title {
            font-size: 22pt;
            font-weight: bold;
            color: #00A9CE;
            border-bottom: 3px solid #00A9CE;
            padding-bottom: 8px;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }
        
        .medicine-row {
            padding: 10px 12px;
            border-bottom: 1px solid #E5F6FA;
            margin-bottom: 6px;
            background: #F8FCFD;
            border-left: 4px solid #4DD0E1;
        }
        
        .medicine-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .med-number {
            background: #00A9CE;
            color: #fff;
            font-weight: bold;
            width: 26px;
            height: 26px;
            display: inline-block;
            text-align: center;
            line-height: 26px;
            border-radius: 50%;
            margin-right: 10px;
            font-size: 9pt;
            vertical-align: middle;
        }
        
        .med-name {
            font-weight: bold;
            font-size: 11pt;
            color: #007A99;
            display: inline-block;
            vertical-align: middle;
        }
        
        .med-details {
            font-size: 8.5pt;
            color: #555;
            padding-left: 36px;
            line-height: 1.8;
            margin-top: 4px;
        }
        
        .med-instructions {
            font-size: 8.5pt;
            color: #1a1a1a;
            padding-left: 36px;
            margin-top: 4px;
            font-style: italic;
        }
        
        .detail-bold {
            font-weight: bold;
            color: #333;
        }
        
        /* FOLLOW-UP BOX */
        .followup-box {
            background: #F0FAFE;
            border: 2px solid #00A9CE;
            padding: 10px 15px;
            margin: 4mm 0;
        }
        
        /* ============================================
           SIGNATURE SECTION - Authentication
           ============================================ */
        
        .signature-area {
            margin-top: 12mm;
            border-top: 2px solid #B3E5F0;
            padding-top: 10mm;
        }
        
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .sig-patient {
            width: 45%;
            vertical-align: bottom;
            padding-right: 20px;
        }
        
        .sig-doctor {
            width: 45%;
            text-align: right;
            vertical-align: bottom;
            padding-left: 20px;
        }
        
        .sig-patient-title {
            font-size: 8.5pt;
            font-weight: bold;
            color: #007A99;
            margin-bottom: 5px;
        }
        
        .sig-patient-line {
            border-top: 2px solid #00A9CE;
            width: 190px;
            margin-top: 40px;
            padding-top: 8px;
            font-size: 8pt;
            font-weight: bold;
            color: #007A99;
        }
        
        .sig-doctor-line {
            border-top: 2px solid #00A9CE;
            width: 210px;
            margin: 40px 0 10px auto;
            padding-top: 8px;
        }
        
        .doctor-name {
            font-size: 12pt;
            font-weight: bold;
            color: #007A99;
            margin-bottom: 4px;
        }
        
        .doctor-details {
            font-size: 8.5pt;
            color: #555;
            line-height: 1.7;
        }
        
        /* ============================================
           FOOTER - Document Metadata
           ============================================ */
        
        .footer {
            margin-top: 10mm;
            padding: 10px 15px;
            background: #F0FAFE;
            border: 2px solid #B3E5F0;
            text-align: center;
        }
        
        .footer-title {
            font-weight: bold;
            font-size: 10pt;
            color: #007A99;
            letter-spacing: 1.5px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        
        .footer-text {
            font-size: 7.5pt;
            color: #555;
            line-height: 1.8;
        }
        
        .footer-meta {
            font-size: 7.5pt;
            color: #007A99;
            margin-top: 6px;
            border-top: 1px solid #B3E5F0;
            padding-top: 6px;
            font-weight: 600;
        }
        
        .meta-bold {
            font-weight: bold;
            color: #007A99;
        }
        
        /* UTILITY */
        .spacer-sm { margin-bottom: 3mm; }
        .spacer-md { margin-bottom: 5mm; }
        .spacer-lg { margin-bottom: 8mm; }
    </style>
</head>
<body>

<!-- ============================================
     HEADER - Hospital Branding & Title
     ============================================ -->
<div class="header-outer">
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                <?php 
                $company_logo = get_option('company_logo');
                if (!empty($company_logo) && file_exists(FCPATH . 'uploads/company/' . $company_logo)) {
                    echo '<img src="' . FCPATH . 'uploads/company/' . $company_logo . '" alt="Logo" />';
                } else {
                    echo '<div class="logo-placeholder">LOGO</div>';
                }
                ?>
            </td>
            <td class="info-cell">
                <div class="hospital-name"><?php echo strtoupper(get_option('company_name') ?: 'MEDICAL CENTER'); ?></div>
                <div class="hospital-tagline">Excellence in Healthcare | Committed to Your Wellbeing</div>
                <div class="hospital-contact">
                    <span class="icon">📍</span> <?php echo get_option('company_address') ?: 'Hospital Address'; ?>
                    <span style="margin: 0 6px;">|</span>
                    <span class="icon">📞</span> <?php echo get_option('company_phonenumber') ?: 'Phone Number'; ?>
                    <span style="margin: 0 6px;">|</span>
                    <span class="icon">✉</span> <?php echo get_option('company_email') ?: 'email@hospital.com'; ?>
                    <?php if (get_option('company_website')) { ?>
                    <span style="margin: 0 6px;">|</span>
                    <span class="icon">🌐</span> <?php echo get_option('company_website'); ?>
                    <?php } ?>
                </div>
            </td>
        </tr>
    </table>
    <div class="title-banner">
        PATIENT VISIT REPORT
        <div class="title-subtitle">Confidential Medical Record</div>
    </div>
</div>

<!-- ============================================
     PATIENT INFORMATION CARD
     ============================================ -->
<div class="patient-card">
    <table class="patient-table">
        <tr>
            <td class="patient-cell w-50">
                <span class="label">Patient Name:</span>
                <span class="value"><?php echo strtoupper($appointment['patient_name']); ?></span>
            </td>
            <td class="patient-cell w-25">
                <span class="label">Patient ID:</span>
                <span class="value"><?php echo $appointment['patient_number']; ?></span>
            </td>
            <td class="patient-cell w-25">
                <span class="label">Report Date:</span>
                <span class="value"><?php echo date('d M Y'); ?></span>
            </td>
        </tr>
    </table>
    
    <table class="patient-table">
        <tr>
            <td class="patient-cell w-25">
                <span class="label">Age:</span>
                <span class="value"><?php echo $appointment['patient_age']; ?> years</span>
            </td>
            <td class="patient-cell w-25">
                <span class="label">Gender:</span>
                <span class="checkbox-group">
                    <span class="checkbox-item">
                        <span class="checkbox <?php echo $appointment['patient_gender'] == 'male' ? 'checked' : ''; ?>"><?php echo $appointment['patient_gender'] == 'male' ? '✓' : ''; ?></span> Male
                    </span>
                    <span class="checkbox-item">
                        <span class="checkbox <?php echo $appointment['patient_gender'] == 'female' ? 'checked' : ''; ?>"><?php echo $appointment['patient_gender'] == 'female' ? '✓' : ''; ?></span> Female
                    </span>
                </span>
            </td>
            <td class="patient-cell w-50">
                <span class="label">Contact:</span>
                <span class="value"><?php echo $appointment['patient_mobile']; ?></span>
            </td>
        </tr>
    </table>
    
    <table class="patient-table">
        <tr>
            <td class="patient-cell w-100">
                <span class="label">Consulting Physician:</span>
                <span class="value">Dr. <?php echo $appointment['consultant_firstname'] . ' ' . $appointment['consultant_lastname']; ?></span>
                <span class="label" style="margin-left: 25px;">Department:</span>
                <span class="value">Ophthalmology</span>
            </td>
        </tr>
    </table>
</div>

<!-- ============================================
     MEDICAL HISTORY
     ============================================ -->
<div class="section-title">Personal Health History</div>

<?php if (!empty($visit['present_complaint'])) { ?>
<div class="content-box">
    <span class="box-label">Chief Complaint</span>
    <div class="box-content"><?php echo nl2br(htmlspecialchars($visit['present_complaint'])); ?></div>
</div>
<?php } ?>

<?php if (!empty($visit['allergies'])) { ?>
<div class="alert-box">
    <span class="alert-label">⚠ Allergies to Medications</span>
    <div class="alert-content"><?php echo nl2br(htmlspecialchars($visit['allergies'])); ?></div>
</div>
<?php } ?>

<table class="two-col-table">
    <tr>
        <td class="col-cell">
            <?php if (!empty($visit['systemic_history'])) { ?>
            <div class="content-box">
                <span class="box-label">Systemic History</span>
                <div class="box-content"><?php echo nl2br(htmlspecialchars($visit['systemic_history'])); ?></div>
            </div>
            <?php } ?>
            
            <?php if (!empty($visit['ocular_diseases'])) { ?>
            <div class="content-box">
                <span class="box-label">Ocular Diseases</span>
                <div class="box-content"><?php echo nl2br(htmlspecialchars($visit['ocular_diseases'])); ?></div>
            </div>
            <?php } ?>
        </td>
        
        <td class="col-cell">
            <?php if (!empty($visit['family_history'])) { ?>
            <div class="content-box">
                <span class="box-label">Family History</span>
                <div class="box-content"><?php echo nl2br(htmlspecialchars($visit['family_history'])); ?></div>
            </div>
            <?php } ?>
            
            <?php if (!empty($visit['surgical_history'])) { ?>
            <div class="content-box">
                <span class="box-label">Previous Surgeries</span>
                <div class="box-content"><?php echo nl2br(htmlspecialchars($visit['surgical_history'])); ?></div>
            </div>
            <?php } ?>
        </td>
    </tr>
</table>

<?php if (!empty($visit['medication'])) { ?>
<div class="content-box">
    <span class="box-label">Current Medications</span>
    <div class="box-content"><?php echo nl2br(htmlspecialchars($visit['medication'])); ?></div>
</div>
<?php } ?>

<!-- ============================================
     CLINICAL EXAMINATION
     ============================================ -->
<?php 
$exam_data = !empty($visit['examination_data']) ? json_decode($visit['examination_data'], true) : [];
if (!empty($exam_data)) { 
?>
<div class="section-title">Clinical Examination</div>

<table class="data-table">
    <thead>
        <tr>
            <th style="width: 40%;">Examination Parameter</th>
            <th style="width: 30%;">Right Eye (OD)</th>
            <th style="width: 30%;">Left Eye (OS)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $exam_fields = [
            'visual_acuity_aided' => 'Visual Acuity (Aided)',
            'visual_acuity_unaided' => 'Visual Acuity (Unaided)',
            'near_vision' => 'Near Vision',
            'iop' => 'Intraocular Pressure (mmHg)',
            'pupil' => 'Pupil Examination',
            'anterior_segment' => 'Anterior Segment',
            'fundus' => 'Fundus Examination',
            'gonioscopy' => 'Gonioscopy',
            'auto_ref' => 'Auto Refraction'
        ];
        
        foreach ($exam_fields as $key => $label) {
            $right = $exam_data[$key]['right'] ?? '';
            $left = $exam_data[$key]['left'] ?? '';
            if ($right != '' || $left != '') {
                ?>
                <tr>
                    <td><span class="table-bold"><?php echo $label; ?></span></td>
                    <td><?php echo htmlspecialchars($right); ?></td>
                    <td><?php echo htmlspecialchars($left); ?></td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>
<?php } ?>

<!-- ============================================
     RETINOSCOPY
     ============================================ -->
<?php 
$retino_data = !empty($visit['retinoscopy_data']) ? json_decode($visit['retinoscopy_data'], true) : [];
if (!empty($retino_data)) { 
?>
<div class="section-title">Retinoscopy Findings</div>

<table class="data-table">
    <thead>
        <tr>
            <th style="width: 20%;">Eye</th>
            <th style="width: 20%;">Sphere (DS)</th>
            <th style="width: 20%;">Cylinder (DC)</th>
            <th style="width: 20%;">Axis</th>
            <th style="width: 20%;">Addition</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><span class="table-bold">Right Eye (OD)</span></td>
            <td><?php echo $retino_data['right']['ds'] ?? '-'; ?></td>
            <td><?php echo $retino_data['right']['dc'] ?? '-'; ?></td>
            <td><?php echo $retino_data['right']['axis'] ?? '-'; ?>°</td>
            <td><?php echo $retino_data['right']['add'] ?? '-'; ?></td>
        </tr>
        <tr>
            <td><span class="table-bold">Left Eye (OS)</span></td>
            <td><?php echo $retino_data['left']['ds'] ?? '-'; ?></td>
            <td><?php echo $retino_data['left']['dc'] ?? '-'; ?></td>
            <td><?php echo $retino_data['left']['axis'] ?? '-'; ?>°</td>
            <td><?php echo $retino_data['left']['add'] ?? '-'; ?></td>
        </tr>
    </tbody>
</table>
<?php } ?>

<!-- ============================================
     DIAGNOSIS & TREATMENT PLAN
     ============================================ -->
<?php if (!empty($visit['opinion_plan_of_care']) || !empty($visit['icd_codes'])) { ?>
<div class="section-title">Diagnosis & Treatment Plan</div>

<?php if (!empty($visit['opinion_plan_of_care'])) { ?>
<div class="content-box">
    <span class="box-label">Clinical Opinion & Plan of Care</span>
    <div class="box-content"><?php echo nl2br(htmlspecialchars($visit['opinion_plan_of_care'])); ?></div>
</div>
<?php } ?>

<?php if (!empty($visit['icd_codes'])) { ?>
<div class="content-box">
    <span class="box-label">ICD-10 Diagnostic Codes</span>
    <div class="box-content"><?php echo htmlspecialchars($visit['icd_codes']); ?></div>
</div>
<?php } ?>

<div class="followup-box">
    <span class="label">Follow-up Required:</span>
    <span class="checkbox-group">
        <span class="checkbox-item">
            <span class="checkbox <?php echo !empty($visit['review_required']) ? 'checked' : ''; ?>"><?php echo !empty($visit['review_required']) ? '✓' : ''; ?></span> Yes
        </span>
        <span class="checkbox-item">
            <span class="checkbox <?php echo empty($visit['review_required']) ? 'checked' : ''; ?>"><?php echo empty($visit['review_required']) ? '✓' : ''; ?></span> No
        </span>
    </span>
    <?php if (!empty($visit['review_required'])) { ?>
    <span class="label" style="margin-left: 20px;">Review Period:</span>
    <span class="value"><?php echo $visit['review_period'] ?? 'As advised'; ?></span>
    <?php } ?>
</div>
<?php } ?>

<!-- ============================================
     PRESCRIPTION
     ============================================ -->
<?php if (!empty($medicines_saved)) { ?>
<div class="section-title">Prescription</div>

<div class="rx-container">
    <div class="rx-title">℞ PRESCRIPTION</div>
    
    <?php foreach ($medicines_saved as $index => $med) { ?>
    <div class="medicine-row">
        <span class="med-number"><?php echo ($index + 1); ?></span>
        <span class="med-name"><?php echo htmlspecialchars($med['medicine_name'] ?? 'Medicine'); ?></span>
        <div class="med-details">
            <?php 
            $details = [];
            if (!empty($med['category'])) $details[] = '<span class="detail-bold">Type:</span> ' . ucfirst($med['category']);
            if (!empty($med['eye'])) $details[] = '<span class="detail-bold">Eye:</span> ' . ucfirst($med['eye']);
            if (!empty($med['dose'])) $details[] = '<span class="detail-bold">Dosage:</span> ' . $med['dose'];
            if (!empty($med['frequency'])) $details[] = '<span class="detail-bold">Frequency:</span> ' . $med['frequency'];
            if (!empty($med['duration'])) $details[] = '<span class="detail-bold">Duration:</span> ' . $med['duration'];
            echo implode(' • ', $details);
            ?>
        </div>
        <?php if (!empty($med['instructions'])) { ?>
        <div class="med-instructions">
            <span class="detail-bold">Special Instructions:</span> <?php echo htmlspecialchars($med['instructions']); ?>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
</div>
<?php } ?>

<!-- ============================================
     SPECTACLE PRESCRIPTION
     ============================================ -->
<?php if (!empty($visit['spectacle_right_sph']) || !empty($visit['spectacle_left_sph'])) { ?>
<div class="section-title">Spectacle Prescription</div>

<table class="data-table">
    <thead>
        <tr>
            <th style="width: 20%;">Eye</th>
            <th style="width: 20%;">Sphere (SPH)</th>
            <th style="width: 20%;">Cylinder (CYL)</th>
            <th style="width: 20%;">Axis</th>
            <th style="width: 20%;">Near Addition</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><span class="table-bold">Right Eye (OD)</span></td>
            <td><?php echo $visit['spectacle_right_sph'] ?? '-'; ?></td>
            <td><?php echo $visit['spectacle_right_cyl'] ?? '-'; ?></td>
            <td><?php echo $visit['spectacle_right_axis'] ?? '-'; ?>°</td>
            <td><?php echo $visit['spectacle_right_near_vision'] ?? '-'; ?></td>
        </tr>
        <tr>
            <td><span class="table-bold">Left Eye (OS)</span></td>
            <td><?php echo $visit['spectacle_left_sph'] ?? '-'; ?></td>
            <td><?php echo $visit['spectacle_left_cyl'] ?? '-'; ?></td>
            <td><?php echo $visit['spectacle_left_axis'] ?? '-'; ?>°</td>
            <td><?php echo $visit['spectacle_left_near_vision'] ?? '-'; ?></td>
        </tr>
    </tbody>
</table>

<?php if (!empty($visit['interpupillary']) || !empty($visit['lens_type'])) { ?>
<div class="content-box">
    <?php if (!empty($visit['interpupillary'])) { ?>
    <span class="label">Interpupillary Distance (PD):</span>
    <span class="value"><?php echo $visit['interpupillary']; ?> mm</span>
    <?php } ?>
    <?php if (!empty($visit['lens_type'])) { ?>
    <span class="label" style="margin-left: 25px;">Recommended Lens Type:</span>
    <span class="value"><?php echo $visit['lens_type']; ?></span>
    <?php } ?>
</div>
<?php } ?>
<?php } ?>

<!-- ============================================
     SIGNATURE SECTION
     ============================================ -->
<div class="signature-area">
    <table class="signature-table">
        <tr>
            <td class="sig-patient">
                <div class="sig-patient-title">Patient / Guardian Signature</div>
                <div class="sig-patient-line">Acknowledged & Received</div>
            </td>
            <td class="sig-doctor">
                <div class="sig-doctor-line">
                    <div class="doctor-name">Dr. <?php echo $appointment['consultant_firstname'] . ' ' . $appointment['consultant_lastname']; ?></div>
                    <div class="doctor-details">
                        Consultant Ophthalmologist<br>
                        <?php if (!empty($appointment['consultant_staffid'])) { ?>
                        Registration No: <?php echo $appointment['consultant_staffid']; ?><br>
                        <?php } ?>
                        Date: <?php echo date('d/m/Y'); ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>

<!-- ============================================
     FOOTER - Document Metadata
     ============================================ -->
<div class="footer">
    <div class="footer-title">⚕ Confidential Medical Record ⚕</div>
    <div class="footer-text">
        This document contains confidential patient health information protected under applicable medical privacy laws.<br>
        Unauthorized disclosure or reproduction is strictly prohibited.
    </div>
    <div class="footer-meta">
        <span class="meta-bold">Visit No:</span> <?php echo $visit_number; ?> | 
        <span class="meta-bold">Generated:</span> <?php echo date('d/m/Y h:i A'); ?> | 
        <span class="meta-bold">Document ID:</span> <?php echo $visit_number . '-' . date('YmdHis'); ?>
    </div>
</div>

</body>
</html>