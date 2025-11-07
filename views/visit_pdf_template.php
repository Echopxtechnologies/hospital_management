<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 15mm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, Helvetica, sans-serif;
            font-size: 9pt;
            line-height: 1.3;
            color: #000;
        }
        
        /* HEADER WITH LOGO */
        .header-container {
            border: 2px solid #000;
            padding: 0;
            margin-bottom: 5mm;
        }
        
        .header-row {
            display: table;
            width: 100%;
            border-bottom: 2px solid #000;
        }
        
        .logo-cell {
            display: table-cell;
            width: 80px;
            vertical-align: middle;
            padding: 8px;
            border-right: 2px solid #000;
            text-align: center;
        }
        
        .logo-cell img {
            max-width: 70px;
            max-height: 70px;
        }
        
        .header-info-cell {
            display: table-cell;
            vertical-align: middle;
            padding: 5px 10px;
        }
        
        .hospital-name {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 2px;
            color: #000;
        }
        
        .hospital-tagline {
            font-size: 8pt;
            font-style: italic;
            color: #333;
            margin-bottom: 3px;
        }
        
        .hospital-contact {
            font-size: 7.5pt;
            line-height: 1.4;
            color: #000;
        }
        
        .form-title-row {
            background: #000;
            color: #fff;
            text-align: center;
            padding: 8px;
            font-size: 13pt;
            font-weight: bold;
            letter-spacing: 1px;
        }
        
        /* FORM FIELDS */
        .form-section {
            margin-bottom: 4mm;
        }
        
        .field-row {
            display: table;
            width: 100%;
            margin-bottom: 2mm;
        }
        
        .field-cell {
            display: table-cell;
            padding: 2px 5px 2px 0;
        }
        
        .field-cell.w-25 { width: 25%; }
        .field-cell.w-33 { width: 33.33%; }
        .field-cell.w-50 { width: 50%; }
        .field-cell.w-100 { width: 100%; }
        
        .field-label {
            font-size: 7.5pt;
            font-weight: bold;
            display: inline-block;
            margin-right: 3px;
        }
        
        .field-underline {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 150px;
            padding: 0 3px;
            font-size: 9pt;
        }
        
        .field-underline.full {
            width: calc(100% - 100px);
        }
        
        /* SECTION HEADERS */
        .section-title {
            background: #e8e8e8;
            border: 1px solid #000;
            padding: 4px 8px;
            font-weight: bold;
            font-size: 9pt;
            text-transform: uppercase;
            margin: 3mm 0 2mm 0;
        }
        
        /* CHECKBOXES */
        .checkbox-group {
            margin: 2mm 0;
        }
        
        .checkbox-item {
            display: inline-block;
            margin-right: 10px;
            font-size: 8.5pt;
        }
        
        .checkbox {
            display: inline-block;
            width: 10px;
            height: 10px;
            border: 1.5px solid #000;
            margin-right: 3px;
            vertical-align: middle;
            position: relative;
        }
        
        .checkbox.checked::after {
            content: "✓";
            position: absolute;
            left: 1px;
            top: -3px;
            font-size: 10pt;
            font-weight: bold;
        }
        
        /* TABLES */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 2mm 0;
        }
        
        .data-table th {
            background: #d0d0d0;
            border: 1px solid #000;
            padding: 4px 6px;
            font-size: 8pt;
            font-weight: bold;
            text-align: left;
        }
        
        .data-table td {
            border: 1px solid #000;
            padding: 4px 6px;
            font-size: 8.5pt;
            min-height: 15px;
        }
        
        .data-table tr:nth-child(even) {
            background: #f5f5f5;
        }
        
        /* CONTENT BOXES */
        .content-box {
            border: 1px solid #000;
            padding: 5px;
            margin-bottom: 2mm;
            min-height: 40px;
            background: #fff;
        }
        
        .content-box-label {
            font-size: 7.5pt;
            font-weight: bold;
            display: block;
            margin-bottom: 3px;
            text-decoration: underline;
        }
        
        .content-text {
            font-size: 8.5pt;
            line-height: 1.5;
            white-space: pre-wrap;
        }
        
        /* TWO COLUMN */
        .two-col {
            display: table;
            width: 100%;
        }
        
        .col-left {
            display: table-cell;
            width: 49%;
            padding-right: 5px;
            vertical-align: top;
        }
        
        .col-right {
            display: table-cell;
            width: 49%;
            padding-left: 5px;
            vertical-align: top;
        }
        
        /* PRESCRIPTION BOX */
        .rx-box {
            border: 2px solid #000;
            padding: 6px;
            margin: 3mm 0;
            background: #fff;
        }
        
        .rx-header {
            font-size: 16pt;
            font-weight: bold;
            border-bottom: 2px solid #000;
            padding-bottom: 3px;
            margin-bottom: 5px;
        }
        
        .rx-item {
            padding: 4px 0;
            border-bottom: 1px dotted #ccc;
            font-size: 8.5pt;
        }
        
        .rx-item:last-child {
            border-bottom: none;
        }
        
        .rx-number {
            display: inline-block;
            font-weight: bold;
            min-width: 20px;
        }
        
        .rx-name {
            font-weight: bold;
            font-size: 9pt;
            display: block;
            margin-bottom: 2px;
        }
        
        .rx-details {
            font-size: 8pt;
            color: #333;
            padding-left: 20px;
        }
        
        /* SIGNATURE */
        .signature-area {
            margin-top: 10mm;
            page-break-inside: avoid;
        }
        
        .sig-row {
            display: table;
            width: 100%;
        }
        
        .sig-left {
            display: table-cell;
            width: 50%;
        }
        
        .sig-right {
            display: table-cell;
            width: 50%;
            text-align: right;
        }
        
        .sig-line {
            border-top: 1.5px solid #000;
            width: 200px;
            margin: 30px 0 5px auto;
            padding-top: 5px;
            font-size: 9pt;
            font-weight: bold;
        }
        
        .sig-info {
            font-size: 7.5pt;
            color: #555;
        }
        
        /* FOOTER */
        .document-footer {
            margin-top: 8mm;
            padding-top: 5px;
            border-top: 2px solid #000;
            text-align: center;
            font-size: 7pt;
            color: #666;
        }
        
        .footer-bold {
            font-weight: bold;
            font-size: 8pt;
            color: #000;
            margin-bottom: 2px;
        }
        
        /* SHADED BOX */
        .shaded-box {
            background: #f0f0f0;
            border: 1px solid #000;
            padding: 6px;
            margin: 2mm 0;
        }
        
        /* PAGE BREAK */
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

<!-- PROFESSIONAL HEADER -->
<div class="header-container">
    <div class="header-row">
        <div class="logo-cell">
            <?php 
            $company_logo = get_option('company_logo');
            if (!empty($company_logo) && file_exists(FCPATH . 'uploads/company/' . $company_logo)) {
                echo '<img src="' . FCPATH . 'uploads/company/' . $company_logo . '" alt="Logo" />';
            } else {
                echo '<div style="font-size:10pt; font-weight:bold;">LOGO</div>';
            }
            ?>
        </div>
        <div class="header-info-cell">
            <div class="hospital-name"><?php echo strtoupper(get_option('company_name') ?: 'MEDICAL CENTER'); ?></div>
            <div class="hospital-tagline">Excellence in Healthcare Services</div>
            <div class="hospital-contact">
                <?php echo get_option('company_address') ?: 'Hospital Address'; ?> | 
                Phone: <?php echo get_option('company_phonenumber') ?: 'Phone Number'; ?> | 
                Email: <?php echo get_option('company_email') ?: 'email@hospital.com'; ?>
                <?php if (get_option('company_website')) { ?>
                | Web: <?php echo get_option('company_website'); ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="form-title-row">
        PATIENT VISIT REPORT
    </div>
</div>

<!-- PATIENT DEMOGRAPHICS -->
<div class="form-section">
    <div class="field-row">
        <div class="field-cell w-50">
            <span class="field-label">Patient Name:</span>
            <span class="field-underline"><?php echo strtoupper($appointment['patient_name']); ?></span>
        </div>
        <div class="field-cell w-25">
            <span class="field-label">Patient ID:</span>
            <span class="field-underline"><?php echo $appointment['patient_number']; ?></span>
        </div>
        <div class="field-cell w-25">
            <span class="field-label">Date:</span>
            <span class="field-underline"><?php echo date('d/m/Y'); ?></span>
        </div>
    </div>
    
    <div class="field-row">
        <div class="field-cell w-25">
            <span class="field-label">Age:</span>
            <span class="field-underline"><?php echo $appointment['patient_age']; ?> yrs</span>
        </div>
        <div class="field-cell w-25">
            <span class="field-label">Gender:</span>
            <span class="checkbox-item">
                <span class="checkbox <?php echo $appointment['patient_gender'] == 'male' ? 'checked' : ''; ?>"></span> M
            </span>
            <span class="checkbox-item">
                <span class="checkbox <?php echo $appointment['patient_gender'] == 'female' ? 'checked' : ''; ?>"></span> F
            </span>
        </div>
        <div class="field-cell w-50">
            <span class="field-label">Contact:</span>
            <span class="field-underline"><?php echo $appointment['patient_mobile']; ?></span>
        </div>
    </div>
    
    <div class="field-row">
        <div class="field-cell w-100">
            <span class="field-label">Consulting Physician:</span>
            <span class="field-underline">Dr <?php echo $appointment['consultant_firstname'] . ' ' . $appointment['consultant_lastname']; ?></span>
            <span class="field-label" style="margin-left: 20px;">Department:</span>
            <span class="field-underline">Ophthalmology</span>
        </div>
    </div>
</div>

<!-- PERSONAL HEALTH HISTORY -->
<div class="section-title">PERSONAL HEALTH HISTORY</div>

<?php if (!empty($visit['present_complaint'])) { ?>
<div class="content-box">
    <span class="content-box-label">Chief Complaint:</span>
    <div class="content-text"><?php echo nl2br(htmlspecialchars($visit['present_complaint'])); ?></div>
</div>
<?php } ?>

<?php if (!empty($visit['allergies'])) { ?>
<div class="shaded-box">
    <span class="content-box-label">⚠ ALLERGIES TO MEDICATIONS:</span>
    <div class="content-text"><?php echo nl2br(htmlspecialchars($visit['allergies'])); ?></div>
</div>
<?php } ?>

<div class="two-col">
    <div class="col-left">
        <?php if (!empty($visit['systemic_history'])) { ?>
        <div class="content-box">
            <span class="content-box-label">Systemic History:</span>
            <div class="content-text"><?php echo nl2br(htmlspecialchars($visit['systemic_history'])); ?></div>
        </div>
        <?php } ?>
        
        <?php if (!empty($visit['ocular_diseases'])) { ?>
        <div class="content-box">
            <span class="content-box-label">Ocular Diseases:</span>
            <div class="content-text"><?php echo nl2br(htmlspecialchars($visit['ocular_diseases'])); ?></div>
        </div>
        <?php } ?>
    </div>
    
    <div class="col-right">
        <?php if (!empty($visit['family_history'])) { ?>
        <div class="content-box">
            <span class="content-box-label">Family History:</span>
            <div class="content-text"><?php echo nl2br(htmlspecialchars($visit['family_history'])); ?></div>
        </div>
        <?php } ?>
        
        <?php if (!empty($visit['surgical_history'])) { ?>
        <div class="content-box">
            <span class="content-box-label">Previous Surgeries:</span>
            <div class="content-text"><?php echo nl2br(htmlspecialchars($visit['surgical_history'])); ?></div>
        </div>
        <?php } ?>
    </div>
</div>

<?php if (!empty($visit['medication'])) { ?>
<div class="content-box">
    <span class="content-box-label">Current Medications:</span>
    <div class="content-text"><?php echo nl2br(htmlspecialchars($visit['medication'])); ?></div>
</div>
<?php } ?>

<!-- CLINICAL EXAMINATION -->
<?php 
$exam_data = !empty($visit['examination_data']) ? json_decode($visit['examination_data'], true) : [];
if (!empty($exam_data)) { 
?>
<div class="section-title">CLINICAL EXAMINATION</div>

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
            'iop' => 'Intraocular Pressure (mm Hg)',
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
                    <td><strong><?php echo $label; ?></strong></td>
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

<!-- RETINOSCOPY -->
<?php 
$retino_data = !empty($visit['retinoscopy_data']) ? json_decode($visit['retinoscopy_data'], true) : [];
if (!empty($retino_data)) { 
?>
<div class="section-title">RETINOSCOPY FINDINGS</div>

<table class="data-table">
    <thead>
        <tr>
            <th style="width: 20%;">Eye</th>
            <th style="width: 20%;">DS (Sph)</th>
            <th style="width: 20%;">DC (Cyl)</th>
            <th style="width: 20%;">Axis</th>
            <th style="width: 20%;">Add</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Right Eye (OD)</strong></td>
            <td><?php echo $retino_data['right']['ds'] ?? '-'; ?></td>
            <td><?php echo $retino_data['right']['dc'] ?? '-'; ?></td>
            <td><?php echo $retino_data['right']['axis'] ?? '-'; ?>°</td>
            <td><?php echo $retino_data['right']['add'] ?? '-'; ?></td>
        </tr>
        <tr>
            <td><strong>Left Eye (OS)</strong></td>
            <td><?php echo $retino_data['left']['ds'] ?? '-'; ?></td>
            <td><?php echo $retino_data['left']['dc'] ?? '-'; ?></td>
            <td><?php echo $retino_data['left']['axis'] ?? '-'; ?>°</td>
            <td><?php echo $retino_data['left']['add'] ?? '-'; ?></td>
        </tr>
    </tbody>
</table>
<?php } ?>

<!-- DIAGNOSIS & TREATMENT -->
<?php if (!empty($visit['opinion_plan_of_care']) || !empty($visit['icd_codes'])) { ?>
<div class="section-title">DIAGNOSIS & TREATMENT PLAN</div>

<?php if (!empty($visit['opinion_plan_of_care'])) { ?>
<div class="content-box">
    <span class="content-box-label">Clinical Opinion & Plan of Care:</span>
    <div class="content-text"><?php echo nl2br(htmlspecialchars($visit['opinion_plan_of_care'])); ?></div>
</div>
<?php } ?>

<?php if (!empty($visit['icd_codes'])) { ?>
<div class="content-box">
    <span class="content-box-label">ICD-10 Diagnostic Codes:</span>
    <div class="content-text"><?php echo htmlspecialchars($visit['icd_codes']); ?></div>
</div>
<?php } ?>

<div class="field-row">
    <div class="field-cell w-50">
        <span class="field-label">Follow-up Required:</span>
        <span class="checkbox-item">
            <span class="checkbox <?php echo !empty($visit['review_required']) ? 'checked' : ''; ?>"></span> Yes
        </span>
        <span class="checkbox-item">
            <span class="checkbox <?php echo empty($visit['review_required']) ? 'checked' : ''; ?>"></span> No
        </span>
        <?php if (!empty($visit['review_required'])) { ?>
        <span class="field-label" style="margin-left: 10px;">Period:</span>
        <span class="field-underline"><?php echo $visit['review_period'] ?? 'As advised'; ?></span>
        <?php } ?>
    </div>
</div>
<?php } ?>

<!-- PRESCRIPTION -->
<?php if (!empty($medicines_saved)) { ?>
<div class="section-title">℞ PRESCRIPTION</div>

<div class="rx-box">
    <div class="rx-header">℞</div>
    
    <?php foreach ($medicines_saved as $index => $med) { ?>
    <div class="rx-item">
        <span class="rx-number"><?php echo ($index + 1); ?>.</span>
        <span class="rx-name"><?php echo htmlspecialchars($med['medicine_name'] ?? 'Medicine'); ?></span>
        <div class="rx-details">
            <?php 
            $details = [];
            if (!empty($med['category'])) $details[] = ucfirst($med['category']);
            if (!empty($med['eye'])) $details[] = ucfirst($med['eye']) . ' eye';
            if (!empty($med['dose'])) $details[] = 'Dose: ' . $med['dose'];
            if (!empty($med['frequency'])) $details[] = $med['frequency'];
            if (!empty($med['duration'])) $details[] = 'for ' . $med['duration'];
            echo implode(' | ', $details);
            ?>
            <?php if (!empty($med['instructions'])) { ?>
                <br><strong>Instructions:</strong> <?php echo htmlspecialchars($med['instructions']); ?>
            <?php } ?>
        </div>
    </div>
    <?php } ?>
</div>
<?php } ?>

<!-- SPECTACLE PRESCRIPTION -->
<?php if (!empty($visit['spectacle_right_sph']) || !empty($visit['spectacle_left_sph'])) { ?>
<div class="section-title">SPECTACLE PRESCRIPTION</div>

<table class="data-table">
    <thead>
        <tr>
            <th style="width: 20%;">Eye</th>
            <th style="width: 20%;">SPH</th>
            <th style="width: 20%;">CYL</th>
            <th style="width: 20%;">Axis</th>
            <th style="width: 20%;">Near Add</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Right (OD)</strong></td>
            <td><?php echo $visit['spectacle_right_sph'] ?? '-'; ?></td>
            <td><?php echo $visit['spectacle_right_cyl'] ?? '-'; ?></td>
            <td><?php echo $visit['spectacle_right_axis'] ?? '-'; ?></td>
            <td><?php echo $visit['spectacle_right_near_vision'] ?? '-'; ?></td>
        </tr>
        <tr>
            <td><strong>Left (OS)</strong></td>
            <td><?php echo $visit['spectacle_left_sph'] ?? '-'; ?></td>
            <td><?php echo $visit['spectacle_left_cyl'] ?? '-'; ?></td>
            <td><?php echo $visit['spectacle_left_axis'] ?? '-'; ?></td>
            <td><?php echo $visit['spectacle_left_near_vision'] ?? '-'; ?></td>
        </tr>
    </tbody>
</table>

<?php if (!empty($visit['interpupillary']) || !empty($visit['lens_type'])) { ?>
<div class="field-row">
    <?php if (!empty($visit['interpupillary'])) { ?>
    <div class="field-cell w-50">
        <span class="field-label">Interpupillary Distance (PD):</span>
        <span class="field-underline"><?php echo $visit['interpupillary']; ?> mm</span>
    </div>
    <?php } ?>
    <?php if (!empty($visit['lens_type'])) { ?>
    <div class="field-cell w-50">
        <span class="field-label">Lens Type:</span>
        <span class="field-underline"><?php echo $visit['lens_type']; ?></span>
    </div>
    <?php } ?>
</div>
<?php } ?>
<?php } ?>

<!-- SIGNATURE AREA -->
<div class="signature-area">
    <div class="sig-row">
        <div class="sig-left">
            <div style="font-size: 8pt; margin-top: 20px;">
                <strong>Patient/Guardian Signature:</strong><br>
                <div style="border-top: 1px solid #000; width: 180px; margin-top: 30px;"></div>
            </div>
        </div>
        <div class="sig-right">
            <div class="sig-line">
                Dr <?php echo $appointment['consultant_firstname'] . ' ' . $appointment['consultant_lastname']; ?>
            </div>
            <div class="sig-info">
                Consultant Ophthalmologist<br>
                <?php if (!empty($appointment['consultant_staffid'])) { ?>
                Registration No: <?php echo $appointment['consultant_staffid']; ?><br>
                <?php } ?>
                Date: <?php echo date('d/m/Y'); ?>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<div class="document-footer">
    <div class="footer-bold">CONFIDENTIAL MEDICAL RECORD</div>
    This document contains confidential patient information protected under applicable privacy laws.<br>
    Visit No: <strong><?php echo $visit_number; ?></strong> | 
    Generated: <?php echo date('d/m/Y h:i A'); ?> | 
    Document ID: <?php echo $visit_number . '-' . date('YmdHis'); ?>
</div>

</body>
</html>