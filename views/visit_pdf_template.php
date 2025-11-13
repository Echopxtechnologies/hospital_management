<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 12mm 15mm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9pt;
            line-height: 1.3;
            color: #000000;
        }
        
        /* ============================================
           HEADER
        ============================================ */
        .header-container {
            width: 100%;
            margin-bottom: 8px;
            border-bottom: 2px solid #000000;
            padding-bottom: 8px;
        }
        
        .header-title {
            text-align: center;
            font-size: 16pt;
            font-weight: bold;
            color: #000000;
        }
        
        .document-title {
            text-align: center;
            font-size: 12pt;
            font-weight: normal;
            margin: 10px 0 12px 0;
        }
        
        /* ============================================
           PATIENT INFO - SIDE BY SIDE
        ============================================ */
        .patient-info {
            width: 100%;
            margin-bottom: 12px;
            font-size: 9pt;
        }
        
        .patient-info table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .patient-info td {
            padding: 2px 0;
            vertical-align: top;
        }
        
        .patient-info .left-col {
            width: 50%;
            padding-right: 20px;
        }
        
        .patient-info .right-col {
            width: 50%;
            text-align: right;
        }
        
        .info-label {
            display: inline-block;
            width: 110px;
        }
        
        .info-value {
            display: inline-block;
            font-weight: bold;
        }
        
        /* ============================================
           SECTION HEADERS - RED
        ============================================ */
        .section-header {
            font-size: 10pt;
            font-weight: bold;
            color: #CC0000;
            margin: 10px 0 6px 0;
        }
        
        /* ============================================
           HISTORY TABLE
        ============================================ */
        .history-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        
        .history-table td {
            border: 1px solid #000000;
            padding: 4px 8px;
            font-size: 9pt;
            vertical-align: top;
        }
        
        .history-table td:first-child {
            width: 130px;
            font-weight: normal;
            background-color: #F5F5F5;
        }
        
        /* ============================================
           PRESENT COMPLAINT
        ============================================ */
        .complaint-text {
            padding-left: 20px;
            margin-bottom: 10px;
            font-size: 9pt;
        }
        
        /* ============================================
           EXAMINATION TABLE
        ============================================ */
        .exam-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        
        .exam-table th {
            border: 1px solid #000000;
            padding: 5px 8px;
            font-size: 9pt;
            font-weight: bold;
            text-align: center;
            background-color: #F5F5F5;
        }
        
        .exam-table td {
            border: 1px solid #000000;
            padding: 4px 8px;
            font-size: 9pt;
            vertical-align: top;
        }
        
        .exam-table td:first-child {
            width: 160px;
            font-weight: normal;
            background-color: #FAFAFA;
        }
        
        .exam-table td:nth-child(2),
        .exam-table td:nth-child(3) {
            width: 42%;
        }
        
        /* ============================================
           RETINOSCOPY - CLEAN GRID
        ============================================ */
        .retinoscopy-section {
            margin-bottom: 10px;
        }
        
        .retino-container {
            width: 100%;
        }
        
        .retino-eye {
            display: inline-block;
            width: 48%;
            vertical-align: top;
            text-align: center;
        }
        
        .retino-eye-title {
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 9pt;
        }
        
        .retino-grid {
            display: inline-block;
            margin: 0 auto;
        }
        
        .retino-row {
            text-align: center;
            margin: 2px 0;
        }
        
        .retino-box {
            display: inline-block;
            width: 45px;
            height: 25px;
            border: 1px solid #000000;
            margin: 1px;
            vertical-align: middle;
        }
        
        .retino-center {
            width: 50px;
            height: 28px;
        }
        
        /* ============================================
           SPECTACLE PRESCRIPTION - FIXED LAYOUT
        ============================================ */
        .spectacle-section {
            margin-bottom: 10px;
        }
        
        .spectacle-container {
            width: 100%;
        }
        
        .spectacle-eye {
            display: inline-block;
            width: 48%;
            vertical-align: top;
        }
        
        .spectacle-eye-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 6px;
            font-size: 9pt;
        }
        
        .spectacle-labels {
            text-align: center;
            margin-bottom: 3px;
        }
        
        .spectacle-label {
            display: inline-block;
            width: 60px;
            font-weight: bold;
            font-size: 8pt;
            text-align: center;
        }
        
        .spectacle-values {
            text-align: center;
            margin-bottom: 6px;
        }
        
        .spectacle-box {
            display: inline-block;
            width: 60px;
            border: 1px solid #000000;
            padding: 3px 4px;
            margin: 0 2px;
            text-align: center;
            font-size: 9pt;
            background-color: #FFFFFF;
        }
        
        .vision-info {
            font-size: 8pt;
            text-align: center;
            margin-top: 6px;
        }
        
        /* ============================================
           SPECTACLE DETAILS TABLE
        ============================================ */
        .spectacle-details {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            margin-bottom: 10px;
        }
        
        .spectacle-details td {
            border: 1px solid #000000;
            padding: 4px 8px;
            font-size: 9pt;
        }
        
        .spectacle-details td:first-child {
            width: 130px;
            font-weight: normal;
            background-color: #F5F5F5;
        }
        
        /* ============================================
           CONTENT BOXES
        ============================================ */
        .content-box {
            border: 1px solid #000000;
            padding: 8px;
            margin-bottom: 10px;
            min-height: 50px;
            font-size: 9pt;
        }
        
        .content-box-small {
            min-height: 25px;
        }
        
        /* ============================================
           URGENT CARE - RED
        ============================================ */
        .urgent-care {
            margin-top: 12px;
            font-size: 8.5pt;
        }
        
        .urgent-care-title {
            font-weight: bold;
            color: #CC0000;
            margin-bottom: 4px;
        }
        
        .urgent-care p {
            margin: 2px 0;
            line-height: 1.4;
        }
        
        /* ============================================
           FOOTER - FIXED POSITION
        ============================================ */
        .footer {
            position: fixed;
            bottom: 10mm;
            left: 15mm;
            right: 15mm;
            border-top: 1px solid #000000;
            padding-top: 4px;
            font-size: 8pt;
        }
        
        .footer-content {
            width: 100%;
        }
        
        .footer-left {
            float: left;
            width: 30%;
        }
        
        .footer-center {
            float: left;
            width: 40%;
            text-align: center;
        }
        
        .footer-right {
            float: right;
            width: 30%;
            text-align: right;
        }
        
        .clear {
            clear: both;
        }
    </style>
</head>
<body>

<!-- ============================================
     HEADER
============================================ -->
<div class="header-container">
    <div class="header-title">
        <?php echo get_option('company_name') ?: 'Vittala International Institute of Ophthalmology'; ?>
    </div>
</div>

<div class="document-title">OPD Assessment Summary</div>

<!-- ============================================
     PATIENT INFORMATION
============================================ -->
<div class="patient-info">
    <table>
        <tr>
            <td class="left-col">
                <span class="info-label">Patient ID :</span>
                <span class="info-value"><?php echo $appointment['patient_number']; ?></span>
            </td>
            <td class="right-col">
                <span class="info-label">Visit Date :</span>
                <span class="info-value"><?php echo date('d M Y H:i:s', strtotime($visit['visit_date'] . ' ' . $visit['visit_time'])); ?></span>
            </td>
        </tr>
        <tr>
            <td class="left-col">
                <span class="info-label">Patient Name :</span>
                <span class="info-value"><?php echo $appointment['patient_name']; ?></span>
            </td>
            <td class="right-col">
                <span class="info-label">Consultant Name :</span>
                <span class="info-value">Dr. <?php echo $appointment['consultant_firstname'] . ' ' . $appointment['consultant_lastname']; ?></span>
            </td>
        </tr>
        <tr>
            <td class="left-col">
                <span class="info-label">Age :</span>
                <span class="info-value"><?php echo $appointment['patient_age'] ?: '-'; ?></span>
            </td>
            <td class="right-col"></td>
        </tr>
    </table>
</div>

<!-- ============================================
     HISTORY
============================================ -->
<div class="section-header">History</div>

<table class="history-table">
    <tr>
        <td>Allergies</td>
        <td><?php echo !empty($visit['allergies']) ? nl2br(htmlspecialchars($visit['allergies'])) : '-'; ?></td>
    </tr>
    <tr>
        <td>Systemic</td>
        <td><?php echo !empty($visit['systemic_history']) ? nl2br(htmlspecialchars($visit['systemic_history'])) : '-'; ?></td>
    </tr>
    <tr>
        <td>Family History</td>
        <td><?php echo !empty($visit['family_history']) ? nl2br(htmlspecialchars($visit['family_history'])) : '-'; ?></td>
    </tr>
    <tr>
        <td>Ocular Disease</td>
        <td><?php echo !empty($visit['ocular_disease_history']) ? nl2br(htmlspecialchars($visit['ocular_disease_history'])) : '-'; ?></td>
    </tr>
    <tr>
        <td>Surgical History</td>
        <td><?php echo !empty($visit['surgical_history']) ? nl2br(htmlspecialchars($visit['surgical_history'])) : '-'; ?></td>
    </tr>
    <tr>
        <td>Medication</td>
        <td><?php echo !empty($visit['current_medications']) ? nl2br(htmlspecialchars($visit['current_medications'])) : '-'; ?></td>
    </tr>
    <tr>
        <td>Dilating Drops:</td>
        <td><?php echo !empty($visit['dilating_drops']) ? htmlspecialchars($visit['dilating_drops']) : '-'; ?></td>
    </tr>
</table>

<!-- ============================================
     PRESENT COMPLAINT
============================================ -->
<div class="section-header">Present Complaint</div>
<div class="complaint-text">
    <?php echo !empty($visit['chief_complaint']) ? nl2br(htmlspecialchars($visit['chief_complaint'])) : 'No complaints recorded'; ?>
</div>

<!-- ============================================
     EXAMINATIONS
============================================ -->
<div class="section-header">Examinations</div>

<?php
$exam_data = !empty($visit['examination_data']) ? json_decode($visit['examination_data'], true) : [];
?>

<table class="exam-table">
    <thead>
        <tr>
            <th></th>
            <th>Right Eye</th>
            <th>Left Eye</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Visual Acuity Aided</td>
            <td><?php echo $exam_data['visual_acuity_aided']['right'] ?? '-'; ?></td>
            <td><?php echo $exam_data['visual_acuity_aided']['left'] ?? '-'; ?></td>
        </tr>
        <tr>
            <td>Visual Acuity Unaided</td>
            <td><?php echo $exam_data['visual_acuity_unaided']['right'] ?? '-'; ?></td>
            <td><?php echo $exam_data['visual_acuity_unaided']['left'] ?? '-'; ?></td>
        </tr>
        <tr>
            <td>Gonioscopy</td>
            <td><?php echo $exam_data['gonioscopy']['right'] ?? '-'; ?></td>
            <td><?php echo $exam_data['gonioscopy']['left'] ?? '-'; ?></td>
        </tr>
        <tr>
            <td>Near Vision</td>
            <td><?php echo $exam_data['near_vision']['right'] ?? '-'; ?></td>
            <td><?php echo $exam_data['near_vision']['left'] ?? '-'; ?></td>
        </tr>
        <tr>
            <td>Lids Adnexa Orbit</td>
            <td><?php echo $exam_data['lids_adnexa']['right'] ?? '-'; ?></td>
            <td><?php echo $exam_data['lids_adnexa']['left'] ?? '-'; ?></td>
        </tr>
        <tr>
            <td>Anterior Segment</td>
            <td><?php echo $exam_data['anterior_segment']['right'] ?? '-'; ?></td>
            <td><?php echo $exam_data['anterior_segment']['left'] ?? '-'; ?></td>
        </tr>
        <tr>
            <td>Pupil</td>
            <td><?php echo $exam_data['pupil']['right'] ?? '-'; ?></td>
            <td><?php echo $exam_data['pupil']['left'] ?? '-'; ?></td>
        </tr>
        <tr>
            <td>IOP (mmHg)</td>
            <td><?php echo $exam_data['iop']['right'] ?? '-'; ?></td>
            <td><?php echo $exam_data['iop']['left'] ?? '-'; ?></td>
        </tr>
        <tr>
            <td>Fundus</td>
            <td><?php echo $exam_data['fundus']['right'] ?? '-'; ?></td>
            <td><?php echo $exam_data['fundus']['left'] ?? '-'; ?></td>
        </tr>
        <tr>
            <td>OCNM</td>
            <td><?php echo $exam_data['ocnm']['right'] ?? '-'; ?></td>
            <td><?php echo $exam_data['ocnm']['left'] ?? '-'; ?></td>
        </tr>
        <tr>
            <td>Lacrimal Syringing</td>
            <td><?php echo $exam_data['lacrimal']['right'] ?? '-'; ?></td>
            <td><?php echo $exam_data['lacrimal']['left'] ?? '-'; ?></td>
        </tr>
    </tbody>
</table>

<!-- ============================================
     RETINOSCOPY - CLEAN GRID LAYOUT
============================================ -->
<div class="section-header">Retinoscopy</div>

<div class="retinoscopy-section">
    <div class="retino-container">
        <!-- RIGHT EYE -->
        <div class="retino-eye">
            <div class="retino-eye-title">Right Eye</div>
            <div class="retino-grid">
                <div class="retino-row">
                    <span class="retino-box"></span>
                </div>
                <div class="retino-row">
                    <span class="retino-box retino-center"></span>
                </div>
                <div class="retino-row">
                    <span class="retino-box"></span>
                    <span class="retino-box"></span>
                </div>
            </div>
        </div>
        
        <!-- LEFT EYE -->
        <div class="retino-eye">
            <div class="retino-eye-title">Left Eye</div>
            <div class="retino-grid">
                <div class="retino-row">
                    <span class="retino-box"></span>
                </div>
                <div class="retino-row">
                    <span class="retino-box retino-center"></span>
                </div>
                <div class="retino-row">
                    <span class="retino-box"></span>
                    <span class="retino-box"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================
     SPECTACLE PRESCRIPTION - FIXED ALIGNMENT
============================================ -->
<?php if (!empty($visit['spectacle_right_sph']) || !empty($visit['spectacle_left_sph'])): ?>

<div class="section-header">Spectacle Prescription</div>

<div class="spectacle-section">
    <div class="spectacle-container">
        <!-- RIGHT EYE -->
        <div class="spectacle-eye">
            <div class="spectacle-eye-title">Right Eye</div>
            
            <div class="spectacle-labels">
                <span class="spectacle-label">SPH</span>
                <span class="spectacle-label">CYL</span>
                <span class="spectacle-label">AXIS</span>
            </div>
            
            <div class="spectacle-values">
                <span class="spectacle-box"><?php echo $visit['spectacle_right_sph'] ?? '0.00'; ?></span>
                <span class="spectacle-box"><?php echo $visit['spectacle_right_cyl'] ?? '0.00'; ?></span>
                <span class="spectacle-box"><?php echo $visit['spectacle_right_axis'] ?? '0'; ?></span>
            </div>
            
            <div class="spectacle-values">
                <span class="spectacle-box"><?php echo $visit['spectacle_right_near_sph'] ?? '0.00'; ?></span>
                <span class="spectacle-box"><?php echo $visit['spectacle_right_near_cyl'] ?? '0.00'; ?></span>
                <span class="spectacle-box"><?php echo $visit['spectacle_right_near_axis'] ?? '0'; ?></span>
            </div>
            
            <div class="vision-info">
                Near Vision: <?php echo $visit['spectacle_right_near_vision'] ?? '-'; ?>
                &nbsp;&nbsp;
                Distance Vision: <?php echo $exam_data['visual_acuity_aided']['right'] ?? '-'; ?>
            </div>
        </div>
        
        <!-- LEFT EYE -->
        <div class="spectacle-eye">
            <div class="spectacle-eye-title">Left Eye</div>
            
            <div class="spectacle-labels">
                <span class="spectacle-label">SPH</span>
                <span class="spectacle-label">CYL</span>
                <span class="spectacle-label">AXIS</span>
            </div>
            
            <div class="spectacle-values">
                <span class="spectacle-box"><?php echo $visit['spectacle_left_sph'] ?? '0.00'; ?></span>
                <span class="spectacle-box"><?php echo $visit['spectacle_left_cyl'] ?? '0.00'; ?></span>
                <span class="spectacle-box"><?php echo $visit['spectacle_left_axis'] ?? '0'; ?></span>
            </div>
            
            <div class="spectacle-values">
                <span class="spectacle-box"><?php echo $visit['spectacle_left_near_sph'] ?? '0.00'; ?></span>
                <span class="spectacle-box"><?php echo $visit['spectacle_left_near_cyl'] ?? '0.00'; ?></span>
                <span class="spectacle-box"><?php echo $visit['spectacle_left_near_axis'] ?? '0'; ?></span>
            </div>
            
            <div class="vision-info">
                Near Vision: <?php echo $visit['spectacle_left_near_vision'] ?? '-'; ?>
                &nbsp;&nbsp;
                Distance Vision: <?php echo $exam_data['visual_acuity_aided']['left'] ?? '-'; ?>
            </div>
        </div>
    </div>
</div>

<table class="spectacle-details">
    <tr>
        <td>Bifocals</td>
        <td><?php echo $visit['bifocals'] ?? '-'; ?></td>
    </tr>
    <tr>
        <td>Back Vertex</td>
        <td><?php echo $visit['back_vertex'] ?? '-'; ?></td>
    </tr>
    <tr>
        <td>InterPupillary</td>
        <td><?php echo $visit['interpupillary'] ?? '-'; ?></td>
    </tr>
    <tr>
        <td>Spectacle Remarks</td>
        <td><?php echo $visit['spectacle_remarks'] ?? '-'; ?></td>
    </tr>
</table>

<?php endif; ?>

<!-- ============================================
     DIAGNOSIS/PLAN OF CARE
============================================ -->
<div class="section-header">Diagnosis/Plan of Care</div>
<div class="content-box">
    <?php echo !empty($visit['opinion_plan_of_care']) ? nl2br(htmlspecialchars($visit['opinion_plan_of_care'])) : 'No diagnosis recorded'; ?>
</div>

<!-- ============================================
     ICD CODES
============================================ -->
<div class="section-header">ICD Codes</div>
<div class="content-box content-box-small">
    <?php echo !empty($visit['icd_codes']) ? htmlspecialchars($visit['icd_codes']) : 'No ICD codes recorded'; ?>
</div>

<!-- ============================================
     OPINIONS
============================================ -->
<div class="section-header">Opinions</div>
<div class="content-box content-box-small">
    <?php echo !empty($visit['second_opinion']) ? nl2br(htmlspecialchars($visit['second_opinion'])) : ''; ?>
</div>

<!-- ============================================
     OTHER RECORDINGS
============================================ -->
<div class="section-header">Other Recordings</div>
<div class="content-box content-box-small">
    <?php echo !empty($visit['other_findings']) ? nl2br(htmlspecialchars($visit['other_findings'])) : ''; ?>
</div>

<!-- ============================================
     URGENT CARE DETAILS
============================================ -->
<div class="urgent-care">
    <div class="urgent-care-title">Urgent Care Details:</div>
    <p>Please contact the Hospital/Consultant in case of pain/increasing discomfort, or decrease in vision any time in the post operative period:</p>
    <p>Monday to Saturday: 9.00 a.m to 6.00 p.m, <?php echo get_option('company_name'); ?>, Phone: <?php echo get_option('company_phonenumber'); ?></p>
    <p>Sundays, general holidays and after 6.00 p.m, Emergency Contact: <?php echo get_option('company_phonenumber'); ?></p>
</div>

<!-- ============================================
     FOOTER - APPEARS ON EVERY PAGE
============================================ -->
<div class="footer">
    <div class="footer-content">
        <div class="footer-left">
            Patient ID: <?php echo $appointment['patient_number']; ?>
        </div>
        <div class="footer-center">
            <?php echo get_option('company_address') ?: 'CA Site Number 1, 2nd Main, 2nd Cross, 7th Block, Banashankari III stage, Bangalore 560085.'; ?>
        </div>
        <div class="footer-right">
            Page 1/1
        </div>
        <div class="clear"></div>
    </div>
</div>

</body>
</html>