<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<style>
/* ============================================
   AQUA BLUE HOSPITAL THEME
============================================ */
:root {
    --primary-aqua: #00bcd4;
    --secondary-aqua: #0097a7;
    --light-aqua: #b2ebf2;
    --dark-aqua: #006064;
    --white: #ffffff;
    --light-bg: #e0f7fa;
}

/* ============================================
   PATIENT HEADER BAR
============================================ */
.patient-header {
    background: linear-gradient(135deg, #00bcd4 0%, #0097a7 100%);
    color: white;
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.patient-header .info-item {
    display: inline-block;
    margin-right: 25px;
    font-size: 14px;
}

.patient-header .info-item strong {
    font-weight: 600;
}

/* ============================================
   TAB NAVIGATION
============================================ */
.consultation-tabs {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    margin-bottom: 20px;
}

.consultation-tabs .nav-tabs {
    border-bottom: 2px solid #e0e0e0;
    padding: 10px 10px 0;
}

.consultation-tabs .nav-tabs > li > a {
    border-radius: 6px 6px 0 0;
    padding: 12px 20px;
    font-weight: 500;
    color: #666;
    transition: all 0.3s;
    border: none;
}

.consultation-tabs .nav-tabs > li > a:hover {
    background: #e0f7fa;
    border: none;
}

.consultation-tabs .nav-tabs > li.active > a {
    background: #00bcd4;
    color: white;
    border: none;
}

.consultation-tabs .tab-content {
    padding: 25px;
    min-height: 400px;
}

/* ============================================
   FORM SECTIONS
============================================ */
.form-section {
    margin-bottom: 25px;
}

.form-section-title {
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
    padding-bottom: 8px;
    border-bottom: 2px solid #00bcd4;
}

/* ============================================
   EXAMINATION TABLE
============================================ */
.examination-table {
    width: 100%;
    margin-top: 15px;
    border-collapse: collapse;
}

.examination-table th {
    background: #00bcd4;
    color: white;
    padding: 12px;
    text-align: center;
    font-weight: 600;
    border: 1px solid #0097a7;
}

.examination-table td {
    padding: 10px;
    border: 1px solid #ddd;
    vertical-align: middle;
}

.examination-table td:first-child {
    font-weight: 500;
    background: #fafafa;
    width: 200px;
}

.examination-table input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

/* ============================================
   RETINOSCOPY STYLES
============================================ */
.retinoscopy-section {
    margin-bottom: 30px;
}

.eye-header {
    background: #00bcd4;
    color: white;
    text-align: center;
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 20px;
}

.eye-header h4 {
    margin: 0;
    font-weight: 600;
}

.retinoscopy-diagram {
    position: relative;
    width: 100%;
    height: 400px;
    background: #f8f9fa;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    margin-bottom: 20px;
}

.retino-input-box {
    position: absolute;
    background: #fff9c4;
    border: 2px solid #00bcd4;
    border-radius: 6px;
    padding: 10px;
    width: 140px;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.retino-input-box label {
    display: block;
    font-weight: 600;
    font-size: 13px;
    color: #333;
    margin-bottom: 5px;
}

.retino-input-box input {
    width: 100%;
    padding: 8px;
    border: 2px solid #00bcd4;
    border-radius: 4px;
    text-align: center;
    font-weight: 600;
    font-size: 14px;
    background: white;
}

/* Position the boxes */
.retino-top { top: 20px; left: 50%; transform: translateX(-50%); }
.retino-bottom { bottom: 20px; left: 50%; transform: translateX(-50%); }
.retino-left { top: 50%; left: 20px; transform: translateY(-50%); }
.retino-right { top: 50%; right: 20px; transform: translateY(-50%); }

/* Cross lines */
.retino-line-vertical {
    position: absolute;
    width: 3px;
    height: 100%;
    background: #00bcd4;
    left: 50%;
    transform: translateX(-50%);
}

.retino-line-horizontal {
    position: absolute;
    height: 3px;
    width: 100%;
    background: #00bcd4;
    top: 50%;
    transform: translateY(-50%);
}

/* ============================================
   MEDICINE ROWS
============================================ */
.medicine-row {
    background: #e0f7fa;
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 15px;
    border-left: 4px solid #00bcd4;
}

.medicine-row .form-group {
    margin-bottom: 10px;
}

.medicine-price {
    background: #e8f5e9 !important;
    font-weight: bold;
    color: #2e7d32;
}

/* ============================================
   ACTION BUTTONS
============================================ */
.action-buttons {
    background: #e0f7fa;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    margin-top: 30px;
    border: 2px solid #b2ebf2;
}

.action-buttons .btn {
    margin: 0 10px;
    padding: 12px 30px;
    font-size: 15px;
    font-weight: 500;
}

/* ============================================
   HISTORY BUTTON (Fixed)
============================================ */
.history-btn {
    position: fixed;
    right: 30px;
    top: 150px;
    z-index: 999;
    box-shadow: 0 4px 6px rgba(0,0,0,0.2);
    background: #00bcd4 !important;
    border-color: #00bcd4 !important;
}

.history-btn:hover {
    background: #0097a7 !important;
}

/* ============================================
   VISITS BANNER
============================================ */
.visits-banner {
    background: #e0f7fa;
    padding: 10px 15px;
    border-radius: 4px;
    margin-bottom: 15px;
    border-left: 4px solid #00bcd4;
}

.visits-banner strong {
    font-size: 15px;
    color: #006064;
}

/* ============================================
   TOTAL FEE DISPLAY
============================================ */
.total-fee-box {
    background: #e8f5e9;
    border: 2px solid #4caf50;
    padding: 10px 20px;
    border-radius: 6px;
    display: inline-block;
    margin-right: 15px;
}

.total-fee-box strong {
    font-size: 16px;
    color: #2e7d32;
}

/* ============================================
   REQUEST SECTION - IMAGE STYLE LAYOUT
============================================ */
.request-sidebar {
    background: #f5f5f5;
    padding: 15px;
    border-radius: 6px;
    border: 1px solid #ddd;
}

.btn-request-type {
    background: white;
    border: 2px solid #e0e0e0;
    color: #333;
    text-align: left;
    padding: 15px;
    margin-bottom: 10px;
    transition: all 0.3s;
    font-weight: 500;
}

.btn-request-type:hover {
    background: #e0f7fa;
    border-color: #00bcd4;
    color: #00bcd4;
}

.btn-request-type.active {
    background: #00bcd4;
    border-color: #00bcd4;
    color: white;
}

.btn-request-type i {
    margin-right: 10px;
    font-size: 16px;
}

/* Request Form Container */
.request-form-container {
    position: relative;
    min-height: 500px;
}

.request-form-panel {
    display: none;
    background: white;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
}

.request-form-panel.active {
    display: block;
}

.request-form-header {
    background: linear-gradient(135deg, #00bcd4 0%, #0097a7 100%);
    color: white;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.request-form-header h4 {
    margin: 0;
    font-weight: 600;
    font-size: 18px;
}

.request-form-header .btn {
    background: transparent;
    border: 2px solid white;
    color: white;
    padding: 5px 10px;
}

.request-form-header .btn:hover {
    background: white;
    color: #00bcd4;
}

.request-form-body {
    padding: 20px;
    max-height: 500px;
    overflow-y: auto;
}

/* Category Checkboxes Row (Top) */
.category-checkboxes-row {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 20px;
    border: 1px solid #e0e0e0;
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

.category-checkbox-item {
    flex: 0 0 calc(25% - 15px);
}

.category-checkbox-item label {
    display: flex;
    align-items: center;
    margin: 0;
    font-weight: 500;
    cursor: pointer;
}

.category-checkbox-item input[type="checkbox"] {
    width: 18px;
    height: 18px;
    margin-right: 8px;
    cursor: pointer;
}

/* Items Grid Below */
.request-items-grid {
    margin-top: 20px;
}

.category-items-section {
    margin-bottom: 30px;
}

.category-section-title {
    background: #00bcd4;
    color: white;
    padding: 10px 15px;
    margin: 0 0 15px 0;
    border-radius: 4px;
    font-weight: 600;
    font-size: 15px;
}

/* 4 Column Grid for Items */
.items-grid-4col {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
}

/* Compact Item Box */
.request-item-box-compact {
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    padding: 8px 12px;
    transition: all 0.2s;
}

.request-item-box-compact:hover {
    background: #e0f7fa;
    border-color: #00bcd4;
    transform: translateY(-2px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.request-item-box-compact label {
    display: flex;
    align-items: center;
    margin: 0;
    cursor: pointer;
    font-size: 13px;
}

.request-item-box-compact input[type="checkbox"] {
    width: 16px;
    height: 16px;
    margin-right: 8px;
    cursor: pointer;
    flex-shrink: 0;
}

.request-item-box-compact .item-name {
    flex: 1;
    line-height: 1.3;
}

.request-item-box-compact .item-price {
    color: #00bcd4;
    font-weight: 600;
    margin-left: 5px;
    white-space: nowrap;
}

/* Form Footer */
.request-form-footer {
    background: #f8f9fa;
    padding: 15px 20px;
    border-top: 2px solid #e0e0e0;
}

.total-summary {
    display: flex;
    align-items: center;
    padding-top: 8px;
}

.total-summary strong {
    font-size: 15px;
    color: #333;
}
</style>

<div id="wrapper">
    <div class="content">
        <!-- ============================================
             PATIENT HEADER
        ============================================ -->
        
        <div class="patient-header">
            <div class="info-item">
                <strong>Patient ID:</strong> <?php echo $appointment['patient_number']; ?>
            </div>
            <div class="info-item">
                <strong>Name:</strong> <?php echo $appointment['patient_name']; ?>
            </div>
            <div class="info-item">
                <strong>Age:</strong> <?php echo $appointment['patient_age']; ?>
            </div>
            <div class="info-item">
                <strong>Gender:</strong> <?php echo ucfirst($appointment['patient_gender']); ?>
            </div>
            <div class="info-item">
                <strong>Phone:</strong> <?php echo $appointment['patient_mobile']; ?>
            </div>
            <div class="info-item">
                <strong>Type:</strong> <?php echo $appointment['patient_type'] ?? 'N/A'; ?>
            </div>
            <div class="info-item">
                <strong>Visit Date:</strong> <?php echo date('d-m-Y H:i:s'); ?>
            </div>
            <div class="info-item">
                <strong>Total Visits:</strong> <?php echo count($visit_history); ?>
            </div>
            <div class="info-item">
                <strong>Consultant Name:</strong> Dr <?php echo $appointment['consultant_firstname'] . ' ' . $appointment['consultant_lastname']; ?>
            </div>
            <div class="info-item">
                <strong>No. of Surgery:</strong> 0
            </div>
        </div>
        
        <!-- ============================================
             VISIT HISTORY BUTTON (Fixed Position)
        ============================================ -->
        <button class="btn btn-primary history-btn" data-toggle="modal" data-target="#historyModal">
            <i class="fa fa-history"></i> History
        </button>
        
        <!-- ============================================
             VISITS BANNER
        ============================================ -->
        <div class="visits-banner">
            <strong>Visits >> Current</strong>
        </div>
        
        <!-- ============================================
             CONSULTATION TABS
        ============================================ -->
        <div class="consultation-tabs">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#history" data-toggle="tab">History</a>
                </li>
                <li role="presentation">
                    <a href="#examination" data-toggle="tab">Examination</a>
                </li>
                <li role="presentation">
                    <a href="#retinoscopy" data-toggle="tab">Retinoscopy</a>
                </li>
                <li role="presentation">
                    <a href="#diagnosis" data-toggle="tab">Diagnosis and Plan of Care</a>
                </li>
                <li role="presentation">
                    <a href="#medicine" data-toggle="tab">Medicine Prescription</a>
                </li>
                <li role="presentation">
                    <a href="#spectacle" data-toggle="tab">Spectacle Prescription</a>
                </li>
                <li role="presentation">
                    <a href="#pediatric" data-toggle="tab">Pediatric</a>
                </li>
                <li role="presentation">
                    <a href="#request" data-toggle="tab">Request</a>
                </li>
                <li role="presentation">
                    <a href="#images" data-toggle="tab">Images</a>
                </li>
            </ul>
            
            <div class="tab-content">
                <!-- ============================================
                     TAB 1: HISTORY
                ============================================ -->
                <div role="tabpanel" class="tab-pane active" id="history">
                    <button class="btn btn-info pull-right" onclick="saveTab('history')">
                        <i class="fa fa-save"></i> Save History
                    </button>
                    <div class="clearfix"></div>
                    
                    <div class="form-section">
                        <div class="form-group">
                            <label>Allergies</label>
                            <textarea name="allergies" class="form-control" rows="3"><?php echo $visit['allergies'] ?? ''; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Systemic History</label>
                            <textarea name="systemic_history" class="form-control" rows="3"><?php echo $visit['systemic_history'] ?? ''; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Family History</label>
                            <textarea name="family_history" class="form-control" rows="3"><?php echo $visit['family_history'] ?? ''; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Ocular Diseases <span class="text-danger">*</span></label>
                            <textarea name="ocular_diseases" class="form-control" rows="3"><?php echo $visit['ocular_diseases'] ?? ''; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Surgical History <span class="text-danger">*</span></label>
                            <textarea name="surgical_history" class="form-control" rows="3"><?php echo $visit['surgical_history'] ?? ''; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Medication <span class="text-danger">*</span></label>
                            <textarea name="medication" class="form-control" rows="3"><?php echo $visit['medication'] ?? ''; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Present Complaint <span class="text-danger">*</span></label>
                            <textarea name="present_complaint" class="form-control" rows="3"><?php echo $visit['present_complaint'] ?? ''; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Dilating Drops</label>
                            <input type="text" name="dilating_drops" class="form-control" value="<?php echo $visit['dilating_drops'] ?? ''; ?>">
                        </div>
                    </div>
                </div>
                
                <!-- ============================================
                     TAB 2: EXAMINATION
                ============================================ -->
                <div role="tabpanel" class="tab-pane" id="examination">
                    <button class="btn btn-info pull-right" onclick="saveTab('examination')">
                        <i class="fa fa-save"></i> Save Examination
                    </button>
                    <div class="clearfix"></div>
                    
                    <table class="examination-table">
                        <thead>
                            <tr>
                                <th>Examination</th>
                                <th>Right Eye</th>
                                <th>Left Eye</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $exam_data = !empty($visit['examination_data']) ? json_decode($visit['examination_data'], true) : [];
                            $exam_fields = [
                                'visual_acuity_aided' => 'Visual Acuity Aided',
                                'visual_acuity_unaided' => 'Visual Acuity Unaided',
                                'gonioscopy' => 'Gonioscopy',
                                'near_vision' => 'Near Vision',
                                'auto_ref' => 'Auto Ref',
                                'lids_adnexa_orbit' => 'Lids Adnexa Orbit',
                                'anterior_segment' => 'Anterior Segment',
                                'pupil' => 'Pupil',
                                'iop' => 'IOP (mm Hg)',
                                'fundus' => 'Fundus',
                                'ocnm' => 'OCNM',
                                'lacrimal_syringing' => 'Lacrimal Syringing'
                            ];
                            
                            foreach ($exam_fields as $key => $label) {
                                $right_value = $exam_data[$key]['right'] ?? '';
                                $left_value = $exam_data[$key]['left'] ?? '';
                                ?>
                                <tr>
                                    <td><?php echo $label; ?></td>
                                    <td><input type="text" name="<?php echo $key; ?>_right" value="<?php echo $right_value; ?>"></td>
                                    <td><input type="text" name="<?php echo $key; ?>_left" value="<?php echo $left_value; ?>"></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- ============================================
                     TAB 3: RETINOSCOPY
                ============================================ -->
                <div role="tabpanel" class="tab-pane" id="retinoscopy">
                    <button class="btn btn-info pull-right" onclick="saveTab('retinoscopy')">
                        <i class="fa fa-save"></i> Save Retinoscopy
                    </button>
                    <div class="clearfix"></div>
                    
                    <?php
                    $retino_data = !empty($visit['retinoscopy_data']) ? json_decode($visit['retinoscopy_data'], true) : [];
                    ?>
                    
                    <div class="row" style="margin-top: 20px;">
                        <!-- RIGHT EYE -->
                        <div class="col-md-6">
                            <div class="eye-header">
                                <h4>Right Eye</h4>
                            </div>
                            
                            <div class="retinoscopy-diagram">
                                <!-- Cross Lines -->
                                <div class="retino-line-vertical"></div>
                                <div class="retino-line-horizontal"></div>
                                
                                <!-- Top Box - DS -->
                                <div class="retino-input-box retino-top">
                                    <label>DS (Spherical)</label>
                                    <input type="text" name="right_ds" placeholder="+2.00" value="<?php echo $retino_data['right']['ds'] ?? ''; ?>">
                                </div>
                                
                                <!-- Bottom Box - DC -->
                                <div class="retino-input-box retino-bottom">
                                    <label>DC (Cylindrical)</label>
                                    <input type="text" name="right_dc" placeholder="-0.75" value="<?php echo $retino_data['right']['dc'] ?? ''; ?>">
                                </div>
                                
                                <!-- Left Box - Axis -->
                                <div class="retino-input-box retino-left">
                                    <label>Axis</label>
                                    <input type="text" name="right_axis" placeholder="90°" value="<?php echo $retino_data['right']['axis'] ?? ''; ?>">
                                </div>
                                
                                <!-- Right Box - Add -->
                                <div class="retino-input-box retino-right">
                                    <label>Add</label>
                                    <input type="text" name="right_add" placeholder="+2.00" value="<?php echo $retino_data['right']['add'] ?? ''; ?>">
                                </div>
                            </div>
                        </div>
                        
                        <!-- LEFT EYE -->
                        <div class="col-md-6">
                            <div class="eye-header">
                                <h4>Left Eye</h4>
                            </div>
                            
                            <div class="retinoscopy-diagram">
                                <!-- Cross Lines -->
                                <div class="retino-line-vertical"></div>
                                <div class="retino-line-horizontal"></div>
                                
                                <!-- Top Box - DS -->
                                <div class="retino-input-box retino-top">
                                    <label>DS (Spherical)</label>
                                    <input type="text" name="left_ds" placeholder="+2.00" value="<?php echo $retino_data['left']['ds'] ?? ''; ?>">
                                </div>
                                
                                <!-- Bottom Box - DC -->
                                <div class="retino-input-box retino-bottom">
                                    <label>DC (Cylindrical)</label>
                                    <input type="text" name="left_dc" placeholder="-0.75" value="<?php echo $retino_data['left']['dc'] ?? ''; ?>">
                                </div>
                                
                                <!-- Left Box - Axis -->
                                <div class="retino-input-box retino-left">
                                    <label>Axis</label>
                                    <input type="text" name="left_axis" placeholder="90°" value="<?php echo $retino_data['left']['axis'] ?? ''; ?>">
                                </div>
                                
                                <!-- Right Box - Add -->
                                <div class="retino-input-box retino-right">
                                    <label>Add</label>
                                    <input type="text" name="left_add" placeholder="+2.00" value="<?php echo $retino_data['left']['add'] ?? ''; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Type of Dilatation -->
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><strong>Type of Dilatation</strong></label>
                                <input type="text" name="type_of_dilatation" class="form-control" placeholder="Enter type of dilatation used (e.g., Tropicamide 1%, Cyclopentolate 1%)" value="<?php echo $retino_data['type_of_dilatation'] ?? ''; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- ============================================
                     TAB 4: DIAGNOSIS AND PLAN OF CARE
                ============================================ -->
                <div role="tabpanel" class="tab-pane" id="diagnosis">
                    <button class="btn btn-info pull-right" onclick="saveTab('diagnosis')">
                        <i class="fa fa-save"></i> Save Diagnosis
                    </button>
                    <div class="clearfix"></div>
                    
                    <div class="form-section">
                        <div class="form-group">
                            <label>Opinion / Plan of Care</label>
                            <textarea name="opinion_plan_of_care" class="form-control" rows="4"><?php echo $visit['opinion_plan_of_care'] ?? ''; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>ICD Codes <span class="text-danger">*</span></label>
                            <select name="icd_codes[]" class="form-control selectpicker" multiple data-live-search="true">
                                <?php
                                $selected_codes = !empty($visit['icd_codes']) ? explode(',', $visit['icd_codes']) : [];
                                foreach ($icd_codes as $code => $description) {
                                    $selected = in_array($code, $selected_codes) ? 'selected' : '';
                                    echo "<option value=\"$code\" $selected>$code - $description</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Review</label>
                            <div>
                                <label class="radio-inline">
                                    <input type="radio" name="review_required" value="yes" <?php echo ($visit['review_required'] ?? '') == 'yes' ? 'checked' : ''; ?>> Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="review_required" value="no" <?php echo ($visit['review_required'] ?? 'no') == 'no' ? 'checked' : ''; ?>> No
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group" id="review_period_section" style="<?php echo ($visit['review_required'] ?? '') == 'yes' ? '' : 'display:none;'; ?>">
                            <label>Review Period (Date)</label>
                            <input type="date" name="review_period" class="form-control" value="<?php echo $visit['review_period'] ?? ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Systematic Exam Ordered</label>
                            <textarea name="systematic_exam_ordered" class="form-control" rows="3"><?php echo $visit['systematic_exam_ordered'] ?? ''; ?></textarea>
                        </div>
                    </div>
                </div>
                
                <!-- ============================================
                     TAB 5: MEDICINE PRESCRIPTION
                ============================================ -->
                <div role="tabpanel" class="tab-pane" id="medicine">
                    <div class="clearfix" style="margin-bottom: 15px;">
                        <button class="btn btn-success pull-right" onclick="printMedication()" style="margin-left: 10px;">
                            <i class="fa fa-print"></i> Print Medication
                        </button>
                        <button class="btn btn-info pull-right" onclick="saveTab('medicine')">
                            <i class="fa fa-save"></i> Save Prescription
                        </button>
                        
                        <!-- Total Fee Display -->
                        <div class="total-fee-box pull-right">
                            <strong>Total Medicine Fee: ₹<span id="total_medicine_fee">0.00</span></strong>
                        </div>
                    </div>
                    
                <div id="medicines_container">
    <?php
    $medicines_saved = !empty($visit['medicine_prescription_details']) 
        ? json_decode($visit['medicine_prescription_details'], true) 
        : [];
    
    if (!empty($medicines_saved)) {
        foreach ($medicines_saved as $index => $med) {
            ?>
            <div class="medicine-row" data-id="<?php echo $index; ?>" data-price="<?php echo $med['price']; ?>">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control medicine-category" data-row="<?php echo $index; ?>" onchange="loadMedicinesByCategory(<?php echo $index; ?>)">
                                <option value="">All</option>
                                <option value="eye_drop" <?php echo ($med['category'] ?? '') == 'eye_drop' ? 'selected' : ''; ?>>Eye Drops</option>
                                <option value="tablet" <?php echo ($med['category'] ?? '') == 'tablet' ? 'selected' : ''; ?>>Tablets</option>
                                <option value="capsule" <?php echo ($med['category'] ?? '') == 'capsule' ? 'selected' : ''; ?>>Capsules</option>
                                <option value="injection" <?php echo ($med['category'] ?? '') == 'injection' ? 'selected' : ''; ?>>Injections</option>
                                <option value="ointment" <?php echo ($med['category'] ?? '') == 'ointment' ? 'selected' : ''; ?>>Ointments</option>
                                <option value="gel" <?php echo ($med['category'] ?? '') == 'gel' ? 'selected' : ''; ?>>Gels</option>
                                <option value="syrup" <?php echo ($med['category'] ?? '') == 'syrup' ? 'selected' : ''; ?>>Syrups</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Medicine <span class="text-danger">*</span></label>
                            <select name="medicines[<?php echo $index; ?>][medicine_id]" 
                                    class="form-control selectpicker medicine-select" 
                                    data-row="<?php echo $index; ?>" 
                                    data-live-search="true" 
                                    onchange="onMedicineSelect(<?php echo $index; ?>)">
                                <option value="">Select Medicine</option>
                                <?php 
                                $all_medicines = $this->hospital_visits_model->get_medicines();
                                foreach ($all_medicines as $m): 
                                ?>
                                    <option value="<?php echo $m['id']; ?>" 
                                            data-price="<?php echo $m['price']; ?>"
                                            <?php echo $m['id'] == $med['medicine_id'] ? 'selected' : ''; ?>>
                                        <?php echo $m['medicine_name'] . ' (' . $m['strength'] . ') - ₹' . number_format($m['price'], 2); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" class="form-control medicine-price" data-row="<?php echo $index; ?>" 
                                   value="₹<?php echo number_format($med['price'], 2); ?>" readonly>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Eye</label>
                            <select name="medicines[<?php echo $index; ?>][eye]" class="form-control">
                                <option value="both" <?php echo $med['eye'] == 'both' ? 'selected' : ''; ?>>Both Eyes</option>
                                <option value="right" <?php echo $med['eye'] == 'right' ? 'selected' : ''; ?>>Right Eye</option>
                                <option value="left" <?php echo $med['eye'] == 'left' ? 'selected' : ''; ?>>Left Eye</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>Dose</label>
                            <input type="number" name="medicines[<?php echo $index; ?>][dose]" 
                                   class="form-control" value="<?php echo $med['dose']; ?>" min="1">
                        </div>
                    </div>
                    
                    <div class="col-md-1">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-block" onclick="removeMedicineRow(<?php echo $index; ?>)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Unit</label>
                            <select name="medicines[<?php echo $index; ?>][unit]" class="form-control">
                                <option value="drop" <?php echo $med['unit'] == 'drop' ? 'selected' : ''; ?>>drop</option>
                                <option value="drops" <?php echo $med['unit'] == 'drops' ? 'selected' : ''; ?>>drops</option>
                                <option value="mg" <?php echo $med['unit'] == 'mg' ? 'selected' : ''; ?>>mg</option>
                                <option value="ml" <?php echo $med['unit'] == 'ml' ? 'selected' : ''; ?>>ml</option>
                                <option value="tablet" <?php echo $med['unit'] == 'tablet' ? 'selected' : ''; ?>>tablet</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Interval</label>
                            <input type="text" name="medicines[<?php echo $index; ?>][interval]" 
                                   class="form-control" value="<?php echo $med['interval'] ?? ''; ?>" placeholder="8 hours">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Frequency</label>
                            <select name="medicines[<?php echo $index; ?>][frequency]" class="form-control">
                                <option value="day" <?php echo $med['frequency'] == 'day' ? 'selected' : ''; ?>>per day</option>
                                <option value="3_times_a_day" <?php echo $med['frequency'] == '3_times_a_day' ? 'selected' : ''; ?>>3 times a day</option>
                                <option value="4_times_a_day" <?php echo $med['frequency'] == '4_times_a_day' ? 'selected' : ''; ?>>4 times a day</option>
                                <option value="every_2_hours" <?php echo $med['frequency'] == 'every_2_hours' ? 'selected' : ''; ?>>every 2 hours</option>
                                <option value="every_4_hours" <?php echo $med['frequency'] == 'every_4_hours' ? 'selected' : ''; ?>>every 4 hours</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Instructions</label>
                            <input type="text" name="medicines[<?php echo $index; ?>][instructions]" 
                                   class="form-control" value="<?php echo $med['instructions'] ?? ''; ?>" 
                                   placeholder="Before meals, After food">
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>

<button class="btn btn-primary" onclick="addMedicineRow()">
    <i class="fa fa-plus"></i> Add Medicine
</button>

<div class="form-group" style="margin-top: 20px;">
    <label>General Instructions</label>
    <textarea name="medicine_instructions" class="form-control" rows="4" placeholder="Enter general instructions for patient..."><?php echo $visit['medicine_instructions'] ?? ''; ?></textarea>
</div>
</div>
                
                <!-- ============================================
                     TAB 6: SPECTACLE PRESCRIPTION
                ============================================ -->
                <div role="tabpanel" class="tab-pane" id="spectacle">
                    <button class="btn btn-info pull-right" onclick="saveTab('spectacle')">
                        <i class="fa fa-save"></i> Save Spectacle
                    </button>
                    <button class="btn btn-success pull-right" onclick="printSpectacle()" style="margin-right:10px;">
                        <i class="fa fa-print"></i> Print
                    </button>
                    <div class="clearfix"></div>
                    
                    <table class="examination-table" style="margin-top: 20px;">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Right Eye</th>
                                <th>Left Eye</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>SPH</td>
                                <td><input type="text" name="right_sph" value="<?php echo $visit['spectacle_right_sph'] ?? ''; ?>"></td>
                                <td><input type="text" name="left_sph" value="<?php echo $visit['spectacle_left_sph'] ?? ''; ?>"></td>
                            </tr>
                            <tr>
                                <td>CYL</td>
                                <td><input type="text" name="right_cyl" value="<?php echo $visit['spectacle_right_cyl'] ?? ''; ?>"></td>
                                <td><input type="text" name="left_cyl" value="<?php echo $visit['spectacle_left_cyl'] ?? ''; ?>"></td>
                            </tr>
                            <tr>
                                <td>Axis</td>
                                <td><input type="text" name="right_axis" value="<?php echo $visit['spectacle_right_axis'] ?? ''; ?>"></td>
                                <td><input type="text" name="left_axis" value="<?php echo $visit['spectacle_left_axis'] ?? ''; ?>"></td>
                            </tr>
                            <tr>
                                <td>Near Vision</td>
                                <td><input type="text" name="right_near_vision" value="<?php echo $visit['spectacle_right_near_vision'] ?? ''; ?>"></td>
                                <td><input type="text" name="left_near_vision" value="<?php echo $visit['spectacle_left_near_vision'] ?? ''; ?>"></td>
                            </tr>
                            <tr>
                                <td>Distance Vision</td>
                                <td><input type="text" name="right_distance_vision" value="<?php echo $visit['spectacle_right_distance_vision'] ?? ''; ?>"></td>
                                <td><input type="text" name="left_distance_vision" value="<?php echo $visit['spectacle_left_distance_vision'] ?? ''; ?>"></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bifocals</label>
                                <div>
                                    <label class="radio-inline">
                                        <input type="radio" name="bifocals" value="yes" <?php echo ($visit['bifocals'] ?? '') == 'yes' ? 'checked' : ''; ?>> Yes
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="bifocals" value="no" <?php echo ($visit['bifocals'] ?? 'no') == 'no' ? 'checked' : ''; ?>> No
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Back Vertex</label>
                                <input type="text" name="back_vertex" class="form-control" value="<?php echo $visit['back_vertex'] ?? ''; ?>">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>InterPupillary</label>
                                <input type="text" name="interpupillary" class="form-control" value="<?php echo $visit['interpupillary'] ?? ''; ?>">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Lens Type</label>
                                <select name="lens_type" class="form-control selectpicker">
                                    <option value="">Select Lens Type</option>
                                    <?php foreach ($lens_types as $type) {
                                        $selected = ($visit['lens_type'] ?? '') == $type ? 'selected' : '';
                                        echo "<option value=\"$type\" $selected>$type</option>";
                                    } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Spectacle Remarks</label>
                                <textarea name="spectacle_remarks" class="form-control" rows="3"><?php echo $visit['spectacle_remarks'] ?? ''; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- ============================================
                     TAB 7: PEDIATRIC
                ============================================ -->
                <div role="tabpanel" class="tab-pane" id="pediatric">
                    <button class="btn btn-info pull-right" onclick="saveTab('pediatric')">
                        <i class="fa fa-save"></i> Save Pediatric Notes
                    </button>
                    <div class="clearfix"></div>
                    
                    <div class="form-group" style="margin-top: 20px;">
                        <textarea name="pediatric_notes" class="form-control" rows="15" placeholder="Enter pediatric-specific notes and observations..."><?php echo $visit['pediatric_notes'] ?? ''; ?></textarea>
                    </div>
                </div>
                
                <!-- ============================================
                     TAB 8: REQUEST - IMAGE STYLE LAYOUT
                ============================================ -->
                <div role="tabpanel" class="tab-pane" id="request">
                    <div class="row">
                        <!-- LEFT SIDEBAR - REQUEST BUTTONS -->
                        <div class="col-md-3">
                            <div class="request-sidebar">
                                <button class="btn btn-block btn-request-type active" data-request-type="lab_tests" onclick="showRequestForm('lab_tests')">
                                    <i class="fa fa-flask"></i> Lab Tests
                                </button>
                                
                                <button class="btn btn-block btn-request-type" data-request-type="procedure_diagnostics" onclick="showRequestForm('procedure_diagnostics')">
                                    <i class="fa fa-stethoscope"></i> Procedure Diagnostics
                                </button>
                                
                                <button class="btn btn-block btn-request-type" data-request-type="procedure_treatment" onclick="showRequestForm('procedure_treatment')">
                                    <i class="fa fa-medkit"></i> Procedure Treatment
                                </button>
                                
                                <button class="btn btn-block btn-request-type" data-request-type="surgical_counselling" onclick="showRequestForm('surgical_counselling')">
                                    <i class="fa fa-scissors"></i> Surgical Counselling
                                </button>
                            </div>
                        </div>
                        
                        <!-- RIGHT CONTENT AREA - REQUEST FORMS -->
                        <div class="col-md-9">
                            <div class="request-form-container">
                                
                                <!-- ==================== LAB TESTS FORM ==================== -->
                                <div class="request-form-panel active" id="form_lab_tests">
                                    <div class="request-form-header">
                                        <h4><i class="fa fa-flask"></i> Lab Form</h4>
                                        <button class="btn btn-sm btn-default" onclick="closeRequestForm()">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="request-form-body">
                                        <!-- Main Category Checkboxes -->
                                        <div class="category-checkboxes-row">
                                            <?php if (isset($request_items_grouped[1]) && !empty($request_items_grouped[1])): ?>
                                                <?php 
                                                $lab_categories = array_keys($request_items_grouped[1]);
                                                foreach ($lab_categories as $cat_name): 
                                                    $cat_id = 'cat_' . md5($cat_name);
                                                ?>
                                                    <div class="category-checkbox-item">
                                                        <label>
                                                            <input type="checkbox" 
                                                                   class="category-toggle-checkbox" 
                                                                   data-target="<?php echo $cat_id; ?>"
                                                                   onchange="toggleCategoryItems('<?php echo $cat_id; ?>')">
                                                            <?php echo $cat_name; ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <!-- Items Grid Below -->
                                        <div class="request-items-grid">
                                            <?php if (isset($request_items_grouped[1]) && !empty($request_items_grouped[1])): ?>
                                                <?php foreach ($request_items_grouped[1] as $subcategory => $items): 
                                                    $cat_id = 'cat_' . md5($subcategory);
                                                ?>
                                                    <div class="category-items-section" id="<?php echo $cat_id; ?>" style="display: none;">
                                                        <h5 class="category-section-title"><?php echo $subcategory; ?></h5>
                                                        
                                                        <div class="items-grid-4col">
                                                            <?php foreach ($items as $item): ?>
                                                                <div class="request-item-box-compact">
                                                                    <label>
                                                                        <input type="checkbox" 
                                                                               class="request-item-checkbox"
                                                                               data-category-id="1"
                                                                               data-item-id="<?php echo $item['id']; ?>"
                                                                               data-item-name="<?php echo htmlspecialchars($item['item_name']); ?>"
                                                                               data-price="<?php echo $item['price']; ?>"
                                                                               onchange="calculateRequestTotal()">
                                                                        <span class="item-name"><?php echo $item['item_name']; ?></span>
                                                                        <span class="item-price">(<?php echo number_format($item['price'], 0); ?>)</span>
                                                                    </label>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="alert alert-info">
                                                    <i class="fa fa-info-circle"></i> No lab test items available
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Form Footer - Action Buttons -->
                                    <div class="request-form-footer">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="total-summary">
                                                    <strong>Selected: <span id="lab_selected_count">0</span> items</strong>
                                                    <strong style="margin-left: 20px;">Total: ₹<span id="lab_total_amount">0.00</span></strong>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-right">
                                                <button class="btn btn-default" onclick="closeRequestForm()">Cancel</button>
                                                <button class="btn btn-primary" onclick="submitRequestForm('lab_tests')">
                                                    <i class="fa fa-check"></i> Done
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- ==================== PROCEDURE DIAGNOSTICS FORM ==================== -->
                                <div class="request-form-panel" id="form_procedure_diagnostics">
                                    <div class="request-form-header">
                                        <h4><i class="fa fa-stethoscope"></i> Procedure Diagnostics Form</h4>
                                        <button class="btn btn-sm btn-default" onclick="closeRequestForm()">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="request-form-body">
                                        <div class="items-grid-4col">
                                            <?php if (isset($request_items_grouped[2]) && !empty($request_items_grouped[2])): ?>
                                                <?php 
                                                foreach ($request_items_grouped[2] as $subcategory => $items):
                                                    foreach ($items as $item): 
                                                ?>
                                                    <div class="request-item-box-compact">
                                                        <label>
                                                            <input type="checkbox" 
                                                                   class="request-item-checkbox"
                                                                   data-category-id="2"
                                                                   data-item-id="<?php echo $item['id']; ?>"
                                                                   data-item-name="<?php echo htmlspecialchars($item['item_name']); ?>"
                                                                   data-price="<?php echo $item['price']; ?>"
                                                                   onchange="calculateRequestTotal()">
                                                            <span class="item-name"><?php echo $item['item_name']; ?></span>
                                                            <span class="item-price">(<?php echo number_format($item['price'], 0); ?>)</span>
                                                        </label>
                                                    </div>
                                                <?php 
                                                    endforeach;
                                                endforeach; 
                                                ?>
                                            <?php else: ?>
                                                <div class="alert alert-info">
                                                    <i class="fa fa-info-circle"></i> No procedure diagnostic items available
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="request-form-footer">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="total-summary">
                                                    <strong>Selected: <span id="pd_selected_count">0</span> items</strong>
                                                    <strong style="margin-left: 20px;">Total: ₹<span id="pd_total_amount">0.00</span></strong>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-right">
                                                <button class="btn btn-default" onclick="closeRequestForm()">Cancel</button>
                                                <button class="btn btn-primary" onclick="submitRequestForm('procedure_diagnostics')">
                                                    <i class="fa fa-check"></i> Done
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- ==================== PROCEDURE TREATMENT FORM ==================== -->
                                <div class="request-form-panel" id="form_procedure_treatment">
                                    <div class="request-form-header">
                                        <h4><i class="fa fa-medkit"></i> Procedure Treatment Form</h4>
                                        <button class="btn btn-sm btn-default" onclick="closeRequestForm()">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="request-form-body">
                                        <div class="items-grid-4col">
                                            <?php if (isset($request_items_grouped[3]) && !empty($request_items_grouped[3])): ?>
                                                <?php 
                                                foreach ($request_items_grouped[3] as $subcategory => $items):
                                                    foreach ($items as $item): 
                                                ?>
                                                    <div class="request-item-box-compact">
                                                        <label>
                                                            <input type="checkbox" 
                                                                   class="request-item-checkbox"
                                                                   data-category-id="3"
                                                                   data-item-id="<?php echo $item['id']; ?>"
                                                                   data-item-name="<?php echo htmlspecialchars($item['item_name']); ?>"
                                                                   data-price="<?php echo $item['price']; ?>"
                                                                   onchange="calculateRequestTotal()">
                                                            <span class="item-name"><?php echo $item['item_name']; ?></span>
                                                            <span class="item-price">(<?php echo number_format($item['price'], 0); ?>)</span>
                                                        </label>
                                                    </div>
                                                <?php 
                                                    endforeach;
                                                endforeach; 
                                                ?>
                                            <?php else: ?>
                                                <div class="alert alert-info">
                                                    <i class="fa fa-info-circle"></i> No procedure treatment items available
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="request-form-footer">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="total-summary">
                                                    <strong>Selected: <span id="pt_selected_count">0</span> items</strong>
                                                    <strong style="margin-left: 20px;">Total: ₹<span id="pt_total_amount">0.00</span></strong>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-right">
                                                <button class="btn btn-default" onclick="closeRequestForm()">Cancel</button>
                                                <button class="btn btn-primary" onclick="submitRequestForm('procedure_treatment')">
                                                    <i class="fa fa-check"></i> Done
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- ==================== SURGICAL COUNSELLING FORM ==================== -->
                          
<div class="request-form-panel" id="form_surgical_counselling">
    <div class="request-form-header">
        <h4><i class="fa fa-scissors"></i> Surgical Counselling Request</h4>
        <button class="btn btn-sm btn-default" onclick="closeRequestForm()">
            <i class="fa fa-times"></i>
        </button>
    </div>
    
    <div class="request-form-body">
        
        <!-- ========== REQUEST TYPE SELECTION ========== -->
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-6">
                <div class="checkbox-card" onclick="toggleSurgeryForm('simple')">
                    <label style="cursor: pointer; display: block; padding: 15px; background: #f9f9f9; border-radius: 6px; border: 2px solid #ddd;">
                        <input type="checkbox" id="simpleRequestCheck" style="margin-right: 10px;">
                        <strong style="font-size: 16px; color: #00bcd4;">
                            <i class="fa fa-file-text"></i> Simple Surgery Request
                        </strong>
                        <p style="margin: 5px 0 0 25px; color: #666; font-size: 13px;">Quick surgery request with basic details</p>
                    </label>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="checkbox-card" onclick="toggleSurgeryForm('detailed')">
                    <label style="cursor: pointer; display: block; padding: 15px; background: #f9f9f9; border-radius: 6px; border: 2px solid #ddd;">
                        <input type="checkbox" id="detailedRequestCheck" style="margin-right: 10px;">
                        <strong style="font-size: 16px; color: #00bcd4;">
                            <i class="fa fa-list-alt"></i> Detailed Surgery Request
                        </strong>
                        <p style="margin: 5px 0 0 25px; color: #666; font-size: 13px;">Comprehensive request with all surgical details</p>
                    </label>
                </div>
            </div>
        </div>
        
        <!-- ========== SIMPLE REQUEST FORM ========== -->
        <div id="simpleRequestForm" style="display:none; padding: 20px; background: #f0f8ff; border-radius: 8px; border: 2px solid #00bcd4; margin-bottom: 20px;">
            <h4 style="color: #00bcd4; margin-bottom: 20px; border-bottom: 2px solid #00bcd4; padding-bottom: 10px;">
                <i class="fa fa-file-text"></i> Simple Surgery Request
            </h4>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Surgery Type <span class="text-danger">*</span></label>
                        <select name="simple_surgery_type_id" id="simple_surgery_type_id" class="form-control selectpicker" data-live-search="true" required>
                            <option value="">-- Select Surgery Type --</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Surgery Details & Notes</label>
                        <textarea name="simple_surgery_details" id="simple_surgery_details" class="form-control" rows="4" placeholder="Enter surgery details, special notes, patient history, or any other relevant information..."></textarea>
                    </div>
                </div>
            </div>
            
            <div style="border-top: 1px solid #ddd; padding-top: 15px; margin-top: 10px;">
                <button type="button" class="btn btn-success" onclick="submitSurgeryRequest('simple')">
                    <i class="fa fa-paper-plane"></i> Submit Simple Request
                </button>
                <button type="button" class="btn btn-default" onclick="clearSurgeryForm('simple')">
                    <i class="fa fa-refresh"></i> Clear Form
                </button>
            </div>
        </div>
        
        <!-- ========== DETAILED REQUEST FORM ========== -->
        <div id="detailedRequestForm" style="display:none; padding: 20px; background: #fff9e6; border-radius: 8px; border: 2px solid #ff9800; margin-bottom: 20px;">
            <h4 style="color: #ff9800; margin-bottom: 20px; border-bottom: 2px solid #ff9800; padding-bottom: 10px;">
                <i class="fa fa-list-alt"></i> Detailed Surgery Request
            </h4>
            
            <div class="row">
                <!-- Surgery Type -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Surgery Type <span class="text-danger">*</span></label>
                        <select name="detailed_surgery_type_id" id="detailed_surgery_type_id" class="form-control selectpicker" data-live-search="true" required>
                            <option value="">-- Select Surgery Type --</option>
                        </select>
                    </div>
                </div>
                
                <!-- I will be doing -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Will You Perform the Surgery?</label>
                        <select name="doing_surgery" id="doing_surgery" class="form-control">
                            <option value="">-- Select --</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                </div>
                
                <!-- Name of Surgery -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Name of Surgery</label>
                        <input type="text" name="surgery_name" id="surgery_name" class="form-control" placeholder="Enter specific surgery name">
                    </div>
                </div>
                
                <!-- Lens Preference -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Lens Preference</label>
                        <input type="text" name="lens_preference" id="lens_preference" class="form-control" placeholder="Enter preferred lens type">
                    </div>
                </div>
                
                <!-- Stand By Lens -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Stand By Lens (Backup)</label>
                        <input type="text" name="standby_lens" id="standby_lens" class="form-control" placeholder="Enter standby lens if needed">
                    </div>
                </div>
                
                <!-- Lens Power -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Lens Power</label>
                        <input type="text" name="lens_power" id="lens_power" class="form-control" placeholder="Enter lens power (e.g., +20.5D)">
                    </div>
                </div>
                
                <!-- A Constant Used -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>A Constant Used</label>
                        <input type="text" name="a_constant_used" id="a_constant_used" class="form-control" placeholder="Enter A constant value">
                    </div>
                </div>
                
                <!-- Formula Used -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Formula Used</label>
                        <input type="text" name="formula_used" id="formula_used" class="form-control" placeholder="e.g., SRK/T, Hoffer Q, Barrett">
                    </div>
                </div>
                
                <!-- Disposables/Instruments -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Disposables / Instruments to Keep Ready</label>
                        <textarea name="disposables_instruments" id="disposables_instruments" class="form-control" rows="2" placeholder="List any special disposables or instruments needed..."></textarea>
                    </div>
                </div>
                
                <!-- Time of admission -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Admission Time (Hours Before Surgery)</label>
                        <input type="text" name="admission_hours_before" id="admission_hours_before" class="form-control" placeholder="e.g., 2 hours, 4 hours">
                    </div>
                </div>
                
                <!-- Overnight admission -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Overnight Admission Required?</label>
                        <select name="overnight_admission" id="overnight_admission" class="form-control">
                            <option value="">-- Select --</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                </div>
                
                <!-- Preferred day and time -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Preferred Day & Time</label>
                        <input type="datetime-local" name="preferred_datetime" id="preferred_datetime" class="form-control">
                    </div>
                </div>
                
                <!-- Anesthesia -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Anesthesia Type</label>
                        <input type="text" name="anesthesia" id="anesthesia" class="form-control" placeholder="e.g., Local, General, Topical">
                    </div>
                </div>
                
                <!-- Special instructions -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Special Instructions</label>
                        <textarea name="special_instructions" id="special_instructions" class="form-control" rows="3" placeholder="Any special instructions for the surgical team..."></textarea>
                    </div>
                </div>
                
                <!-- Nil oral instructions -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Nil By Mouth (NBM) Instructions</label>
                        <textarea name="nil_oral_instructions" id="nil_oral_instructions" class="form-control" rows="2" placeholder="Enter NBM instructions (e.g., NBM 6 hours before surgery)"></textarea>
                    </div>
                </div>
            </div>
            
            <div style="border-top: 1px solid #ddd; padding-top: 15px; margin-top: 10px;">
                <button type="button" class="btn btn-success" onclick="submitSurgeryRequest('detailed')">
                    <i class="fa fa-paper-plane"></i> Submit Detailed Request
                </button>
                <button type="button" class="btn btn-default" onclick="clearSurgeryForm('detailed')">
                    <i class="fa fa-refresh"></i> Clear Form
                </button>
            </div>
        </div>
        
    </div>
    
    <div class="request-form-footer">
        <button class="btn btn-default" onclick="closeRequestForm()">
            <i class="fa fa-times"></i> Close
        </button>
    </div>
</div>
                    
                    <!-- ==================== EXISTING REQUESTS ==================== -->
                   <div style="margin-top: 30px;">
    <h4 class="form-section-title">
        <i class="fa fa-history"></i> Previous Requests for This Visit (<?php echo count($existing_requests); ?>)
    </h4>
    
    <?php if (!empty($existing_requests)): ?>
        <table class="table table-bordered table-striped">
            <thead style="background: #00bcd4; color: white;">
                <tr>
                    <th>Request #</th>
                    <th>Category</th>
                    <th>Items</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Created</th>
                    <th>Items Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($existing_requests as $req): ?>
                    <tr>
                        <td><strong><?php echo $req['request_number']; ?></strong></td>
                        <td><?php echo $req['category_name']; ?></td>
                        <td><span class="badge"><?php echo $req['items_count']; ?> items</span></td>
                        <td><strong>₹<?php echo number_format($req['final_amount'], 2); ?></strong></td>
                        <td>
                            <span class="label label-<?php 
                                echo $req['status'] == 'completed' ? 'success' : 
                                     ($req['status'] == 'cancelled' ? 'danger' : 'warning'); 
                            ?>">
                                <?php echo ucfirst($req['status']); ?>
                            </span>
                        </td>
                        <td>
                            <span class="label label-<?php 
                                echo $req['priority'] == 'emergency' ? 'danger' : 
                                     ($req['priority'] == 'urgent' ? 'warning' : 'default'); 
                            ?>">
                                <?php echo ucfirst($req['priority']); ?>
                            </span>
                        </td>
                        <td><?php echo date('d M Y, h:i A', strtotime($req['created_at'])); ?></td>
                        <td>
                            <button class="btn btn-xs btn-info" onclick="showRequestItems(<?php echo $req['id']; ?>)">
                                <i class="fa fa-list"></i> View Items
                            </button>
                        </td>
                    </tr>
                    <!-- Items Row (hidden by default) -->
                    <tr id="items_<?php echo $req['id']; ?>" style="display: none;">
                        <td colspan="8">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Subcategory</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($req['items'] as $item): ?>
                                        <tr>
                                            <td><?php echo $item['item_name']; ?></td>
                                            <td><?php echo $item['subcategory_name']; ?></td>
                                            <td><?php echo $item['quantity']; ?></td>
                                            <td>₹<?php echo number_format($item['unit_price'], 2); ?></td>
                                            <td><strong>₹<?php echo number_format($item['total_price'], 2); ?></strong></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="fa fa-info-circle"></i> No previous requests for this visit
        </div>
    <?php endif; ?>
</div>

<script>
function showRequestItems(requestId) {
    jQuery('#items_' + requestId).toggle();
}
</script>
                <!-- ============================================
                     TAB 9: IMAGES
                ============================================ -->
                <div role="tabpanel" class="tab-pane" id="images">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> <strong>Images Section</strong> - Image upload and management will be implemented in the next phase.
                    </div>
                </div>
            </div>
        </div>
        
        <!-- ============================================
             ACTION BUTTONS (Bottom)
        ============================================ -->
        <div class="action-buttons">
            <button class="btn btn-lg btn-success" onclick="saveVisit()">
                <i class="fa fa-save"></i> Save Visit
            </button>
            <button class="btn btn-lg btn-warning">
                <i class="fa fa-question-circle"></i> Seek Opinion
            </button>
            <button class="btn btn-lg btn-info">
                <i class="fa fa-exchange"></i> Transfer Patient
            </button>
            <button class="btn btn-lg btn-primary" onclick="closeVisit()">
                <i class="fa fa-check-circle"></i> Close Visit
            </button>
        </div>
    </div>
</div>

<!-- ============================================
     VISIT HISTORY MODAL
============================================ -->
<div class="modal fade" id="historyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-history"></i> Patient Visit History</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Visit #</th>
                            <th>Date</th>
                            <th>Consultant</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($visit_history)) {
                            foreach ($visit_history as $vh) { ?>
                                <tr>
                                    <td><strong><?php echo $vh['visit_number']; ?></strong></td>
                                    <td><?php echo date('d M Y', strtotime($vh['visit_date'])); ?></td>
                                    <td>Dr <?php echo $vh['firstname'] . ' ' . $vh['lastname']; ?></td>
                                    <td><?php echo ucfirst($vh['reason']); ?></td>
                                    <td>
                                        <span class="label label-<?php echo $vh['status'] == 'completed' ? 'success' : 'warning'; ?>">
                                            <?php echo ucfirst($vh['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?php echo admin_url('hospital_management/view_visit/' . $vh['id']); ?>" class="btn btn-sm btn-info" target="_blank">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">No previous visits found</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ============================================
     JAVASCRIPT
============================================ -->
<script>
// ============================================
// GLOBAL VARIABLES
// ============================================
var visitId = <?php 
    if (!empty($visit['visit_id'])) {
        echo $visit['visit_id'];
    } elseif (!empty($visit['id'])) {
        echo $visit['id'];
    } else {
        echo 'null';
    }
?>;
var appointmentId = <?php echo $appointment['id']; ?>;
var adminUrl = '<?php echo admin_url(); ?>';
var csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';
var csrfTokenHash = '<?php echo $this->security->get_csrf_hash(); ?>';
var allMedicines = <?php echo json_encode($this->hospital_visits_model->get_medicines()); ?>;
var medicineCounter = <?php echo count($medicines_saved); ?>;

// ============================================
// REQUEST SECTION FUNCTIONS
// ============================================

// Show request form by type
function showRequestForm(type) {
    // Hide all forms
    jQuery('.request-form-panel').removeClass('active');
    jQuery('.btn-request-type').removeClass('active');
    
    // Show selected form
    jQuery('#form_' + type).addClass('active');
    jQuery('[data-request-type="' + type + '"]').addClass('active');
}

// Close request form
function closeRequestForm() {
    // Just uncheck everything and reset
    jQuery('.request-item-checkbox').prop('checked', false);
    calculateRequestTotal();
}

// Toggle category items visibility
function toggleCategoryItems(catId) {
    var $section = jQuery('#' + catId);
    var $checkbox = jQuery('[data-target="' + catId + '"]');
    
    if ($checkbox.is(':checked')) {
        $section.slideDown(300);
    } else {
        $section.slideUp(300);
        // Uncheck all items in this category
        $section.find('.request-item-checkbox').prop('checked', false);
        calculateRequestTotal();
    }
}

// Calculate total for request
function calculateRequestTotal() {
    var labTotal = 0, labCount = 0;
    var pdTotal = 0, pdCount = 0;
    var ptTotal = 0, ptCount = 0;
    
    // Lab Tests (category 1)
    jQuery('#form_lab_tests .request-item-checkbox:checked').each(function() {
        var price = parseFloat(jQuery(this).data('price')) || 0;
        labTotal += price;
        labCount++;
    });
    
    // Procedure Diagnostics (category 2)
    jQuery('#form_procedure_diagnostics .request-item-checkbox:checked').each(function() {
        var price = parseFloat(jQuery(this).data('price')) || 0;
        pdTotal += price;
        pdCount++;
    });
    
    // Procedure Treatment (category 3)
    jQuery('#form_procedure_treatment .request-item-checkbox:checked').each(function() {
        var price = parseFloat(jQuery(this).data('price')) || 0;
        ptTotal += price;
        ptCount++;
    });
    
    // Update UI
    jQuery('#lab_selected_count').text(labCount);
    jQuery('#lab_total_amount').text(labTotal.toFixed(2));
    
    jQuery('#pd_selected_count').text(pdCount);
    jQuery('#pd_total_amount').text(pdTotal.toFixed(2));
    
    jQuery('#pt_selected_count').text(ptCount);
    jQuery('#pt_total_amount').text(ptTotal.toFixed(2));
}

// Submit request form
function submitRequestForm(type) {
    var selectedItems = [];
    var categoryId = 0;
    
    if (type === 'lab_tests') categoryId = 1;
    else if (type === 'procedure_diagnostics') categoryId = 2;
    else if (type === 'procedure_treatment') categoryId = 3;
    
    jQuery('#form_' + type + ' .request-item-checkbox:checked').each(function() {
        selectedItems.push({
            item_id: jQuery(this).data('item-id'),
            item_name: jQuery(this).data('item-name'),
            unit_price: jQuery(this).data('price'),
            quantity: 1
        });
    });
    
    if (selectedItems.length === 0) {
        alert_float('warning', 'Please select at least one item');
        return;
    }
    
    // Calculate total
    var totalAmount = 0;
    selectedItems.forEach(function(item) {
        totalAmount += parseFloat(item.unit_price);
    });
    
    if (confirm('Submit this request with ' + selectedItems.length + ' items? Total: ₹' + totalAmount.toFixed(2))) {
        var formData = {
            visit_id: visitId,
            category_id: categoryId,
            selected_items: selectedItems,  // Already an array
            total_amount: totalAmount,
            final_amount: totalAmount,
            priority: 'normal',
            doctor_notes: ''
        };
        formData[csrfTokenName] = csrfTokenHash;
        
        jQuery.ajax({
            url: adminUrl + 'hospital_management/save_visit_request',  // ← FIXED THIS LINE
            type: 'POST',
            data: formData,
            dataType: 'json',
           success: function(response) {
    if (response.success) {
        alert_float('success', response.message);
        
        // Update CSRF tokens
        if (response.csrf_token_name && response.csrf_token_hash) {
            csrfTokenName = response.csrf_token_name;
            csrfTokenHash = response.csrf_token_hash;
        }
        
        // Uncheck all items in the form
        jQuery('#form_' + type + ' .request-item-checkbox').prop('checked', false);
        
        // Hide category sections
        jQuery('.category-items-section').hide();
        jQuery('.category-toggle-checkbox').prop('checked', false);
        
        // Reset totals
        calculateRequestTotal();
        
        // Dynamically add the new request to the table WITHOUT reload
        var newRow = `
            <tr>
                <td><strong>${response.request_number || 'REQ-NEW'}</strong></td>
                <td>${jQuery('#form_' + type + ' .request-form-header h4').text()}</td>
                <td><span class="badge">${selectedItems.length} items</span></td>
                <td><strong>₹${totalAmount.toFixed(2)}</strong></td>
                <td><span class="label label-warning">Pending</span></td>
                <td><span class="label label-default">Normal</span></td>
                <td>Just now</td>
                <td>
                    <button class="btn btn-xs btn-info" disabled>
                        <i class="fa fa-list"></i> View Items
                    </button>
                </td>
            </tr>
        `;
        
        // If table is empty (showing "No requests" message), replace it
        if (jQuery('.alert-info:contains("No previous requests")').length > 0) {
            jQuery('.alert-info:contains("No previous requests")').parent().html(`
                <table class="table table-bordered table-striped">
                    <thead style="background: #00bcd4; color: white;">
                        <tr>
                            <th>Request #</th>
                            <th>Category</th>
                            <th>Items</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Created</th>
                            <th>Items Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${newRow}
                    </tbody>
                </table>
            `);
        } else {
            // Add to existing table
            jQuery('table.table-bordered tbody').prepend(newRow);
        }
        
        // Update count in header
        var currentCount = parseInt(jQuery('.form-section-title').text().match(/\((\d+)\)/)?.[1] || 0);
        jQuery('.form-section-title').html(`
            <i class="fa fa-history"></i> Previous Requests for This Visit (${currentCount + 1})
        `);
        
    } else {
        alert_float('danger', response.message);
    }
},
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                alert_float('danger', 'Error submitting request');
            }
        });
    }
}

// View request details
function viewRequestDetails(requestId) {
    window.open(adminUrl + 'hospital_management/view_request/' + requestId, '_blank');
}

// ============================================
// MEDICINE FUNCTIONS
// ============================================

function calculateTotalFee() {
    var total = 0;
    
    // Loop through each medicine row and get price from row's data-price
    jQuery('.medicine-row').each(function() {
        var price = parseFloat(jQuery(this).attr('data-price')) || 0;
        total += price;
    });
    
    // Update display
    jQuery('#total_medicine_fee').text(total.toFixed(2));
    
    return total;
}

function addMedicineRow() {
    medicineCounter++;
    
    var html = `
        <div class="medicine-row" data-id="${medicineCounter}" data-price="0">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control medicine-category" data-row="${medicineCounter}" onchange="loadMedicinesByCategory(${medicineCounter})">
                            <option value="">All</option>
                            <option value="eye_drop">Eye Drops</option>
                            <option value="tablet">Tablets</option>
                            <option value="capsule">Capsules</option>
                            <option value="injection">Injections</option>
                            <option value="ointment">Ointments</option>
                            <option value="gel">Gels</option>
                            <option value="syrup">Syrups</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Medicine <span class="text-danger">*</span></label>
                        <select name="medicines[${medicineCounter}][medicine_id]" 
                                class="form-control selectpicker medicine-select" 
                                data-row="${medicineCounter}" 
                                data-live-search="true" 
                                onchange="onMedicineSelect(${medicineCounter})" 
                                required>
                            <option value="">Select Medicine</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" class="form-control medicine-price" data-row="${medicineCounter}" readonly>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Eye</label>
                        <select name="medicines[${medicineCounter}][eye]" class="form-control">
                            <option value="both">Both Eyes</option>
                            <option value="right">Right Eye</option>
                            <option value="left">Left Eye</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-1">
                    <div class="form-group">
                        <label>Dose</label>
                        <input type="number" name="medicines[${medicineCounter}][dose]" class="form-control" value="1" min="1">
                    </div>
                </div>
                
                <div class="col-md-1">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-block" onclick="removeMedicineRow(${medicineCounter})">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Unit</label>
                        <select name="medicines[${medicineCounter}][unit]" class="form-control">
                            <option value="drop">drop</option>
                            <option value="drops">drops</option>
                            <option value="mg">mg</option>
                            <option value="ml">ml</option>
                            <option value="tablet">tablet</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Interval</label>
                        <input type="text" name="medicines[${medicineCounter}][interval]" class="form-control" placeholder="8 hours">
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Frequency</label>
                        <select name="medicines[${medicineCounter}][frequency]" class="form-control">
                            <option value="day">per day</option>
                            <option value="3_times_a_day">3 times a day</option>
                            <option value="4_times_a_day">4 times a day</option>
                            <option value="every_2_hours">every 2 hours</option>
                            <option value="every_4_hours">every 4 hours</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Instructions</label>
                        <input type="text" name="medicines[${medicineCounter}][instructions]" class="form-control" placeholder="Before meals, After food">
                    </div>
                </div>
            </div>
        </div>
    `;
    
    jQuery('#medicines_container').append(html);
    jQuery('.selectpicker').selectpicker('refresh');
    loadMedicinesByCategory(medicineCounter);
}

function loadMedicinesByCategory(rowId) {
    var category = jQuery('.medicine-category[data-row="' + rowId + '"]').val();
    var $select = jQuery('.medicine-select[data-row="' + rowId + '"]');
    
    var filtered = category 
        ? allMedicines.filter(function(m) { return m.category === category; })
        : allMedicines;
    
    $select.empty();
    $select.append('<option value="">Select Medicine</option>');
    
    filtered.forEach(function(med) {
        var optionText = med.medicine_name + ' (' + med.strength + ') - ₹' + parseFloat(med.price).toFixed(2);
        $select.append('<option value="' + med.id + '" data-price="' + med.price + '">' + optionText + '</option>');
    });
    
    $select.selectpicker('refresh');
}
function onMedicineSelect(rowId) {
    var $select = jQuery('.medicine-select[data-row="' + rowId + '"]');
    var $priceInput = jQuery('.medicine-price[data-row="' + rowId + '"]');
    var $row = jQuery('.medicine-row[data-id="' + rowId + '"]');
    
    var selectedOption = $select.find('option:selected');
    var price = parseFloat(selectedOption.data('price')) || 0;
    
    // Update UI
    $priceInput.val('₹' + price.toFixed(2));
    $row.attr('data-price', price);
    
    // Recalculate total
    calculateTotalFee();
}
function removeMedicineRow(rowId) {
    if (confirm('Remove this medicine?')) {
        jQuery('.medicine-row[data-id="' + rowId + '"]').remove();
        calculateTotalFee();
    }
}

// ============================================
// SAVE TAB FUNCTION
// ============================================
function saveTab(tab) {
    if (!visitId || visitId === 'null' || visitId === null) {
        alert_float('danger', 'Visit ID is missing. Cannot save.');
        return;
    }
    
    var formData = new FormData();
    formData.append('visit_id', visitId);
    formData.append('tab', tab);
    formData.append(csrfTokenName, csrfTokenHash);
    
    switch(tab) {
        case 'history':
            formData.append('allergies', jQuery('[name="allergies"]').val() || '');
            formData.append('systemic_history', jQuery('[name="systemic_history"]').val() || '');
            formData.append('family_history', jQuery('[name="family_history"]').val() || '');
            formData.append('ocular_diseases', jQuery('[name="ocular_diseases"]').val() || '');
            formData.append('surgical_history', jQuery('[name="surgical_history"]').val() || '');
            formData.append('medication', jQuery('[name="medication"]').val() || '');
            formData.append('present_complaint', jQuery('[name="present_complaint"]').val() || '');
            formData.append('dilating_drops', jQuery('[name="dilating_drops"]').val() || '');
            break;
            
        case 'examination':
            jQuery('input[name*="_right"], input[name*="_left"]').each(function() {
                formData.append(jQuery(this).attr('name'), jQuery(this).val() || '');
            });
            break;
            
        case 'retinoscopy':
            formData.append('right_ds', jQuery('[name="right_ds"]').val() || '');
            formData.append('right_dc', jQuery('[name="right_dc"]').val() || '');
            formData.append('right_axis', jQuery('[name="right_axis"]').val() || '');
            formData.append('right_add', jQuery('[name="right_add"]').val() || '');
            formData.append('left_ds', jQuery('[name="left_ds"]').val() || '');
            formData.append('left_dc', jQuery('[name="left_dc"]').val() || '');
            formData.append('left_axis', jQuery('[name="left_axis"]').val() || '');
            formData.append('left_add', jQuery('[name="left_add"]').val() || '');
            formData.append('type_of_dilatation', jQuery('[name="type_of_dilatation"]').val() || '');
            break;
            
        case 'diagnosis':
            var icdCodes = jQuery('[name="icd_codes[]"]').val();
            formData.append('opinion_plan_of_care', jQuery('[name="opinion_plan_of_care"]').val() || '');
            formData.append('icd_codes', Array.isArray(icdCodes) ? icdCodes.join(',') : '');
            formData.append('review_required', jQuery('[name="review_required"]:checked').val() || 'no');
            formData.append('review_period', jQuery('[name="review_period"]').val() || '');
            formData.append('systematic_exam_ordered', jQuery('[name="systematic_exam_ordered"]').val() || '');
            break;
            
   case 'medicine':
    // Collect all medicine rows properly
    var medicinesData = [];
    jQuery('.medicine-row').each(function() {
        var rowId = jQuery(this).data('id');
        var medicineId = jQuery('[name="medicines[' + rowId + '][medicine_id]"]').val();
        
        if (medicineId) {
            medicinesData.push({
                medicine_id: medicineId,
                eye: jQuery('[name="medicines[' + rowId + '][eye]"]').val(),
                dose: jQuery('[name="medicines[' + rowId + '][dose]"]').val(),
                unit: jQuery('[name="medicines[' + rowId + '][unit]"]').val(),
                interval: jQuery('[name="medicines[' + rowId + '][interval]"]').val(),
                frequency: jQuery('[name="medicines[' + rowId + '][frequency]"]').val(),
                instructions: jQuery('[name="medicines[' + rowId + '][instructions]"]').val()
            });
        }
    });
    
    console.log('Medicines collected:', medicinesData); // DEBUG LINE
    
    // Send as JSON string
    formData.append('medicines', JSON.stringify(medicinesData));
    formData.append('medicine_instructions', jQuery('[name="medicine_instructions"]').val() || '');
    break;
        case 'spectacle':
            formData.append('right_sph', jQuery('[name="right_sph"]').val() || '');
            formData.append('right_cyl', jQuery('[name="right_cyl"]').val() || '');
            formData.append('right_axis', jQuery('[name="right_axis"]').val() || '');
            formData.append('right_near_vision', jQuery('[name="right_near_vision"]').val() || '');
            formData.append('right_distance_vision', jQuery('[name="right_distance_vision"]').val() || '');
            formData.append('left_sph', jQuery('[name="left_sph"]').val() || '');
            formData.append('left_cyl', jQuery('[name="left_cyl"]').val() || '');
            formData.append('left_axis', jQuery('[name="left_axis"]').val() || '');
            formData.append('left_near_vision', jQuery('[name="left_near_vision"]').val() || '');
            formData.append('left_distance_vision', jQuery('[name="left_distance_vision"]').val() || '');
            formData.append('bifocals', jQuery('[name="bifocals"]:checked').val() || 'no');
            formData.append('back_vertex', jQuery('[name="back_vertex"]').val() || '');
            formData.append('interpupillary', jQuery('[name="interpupillary"]').val() || '');
            formData.append('spectacle_remarks', jQuery('[name="spectacle_remarks"]').val() || '');
            formData.append('lens_type', jQuery('[name="lens_type"]').val() || '');
            break;
            
        case 'pediatric':
            formData.append('pediatric_notes', jQuery('[name="pediatric_notes"]').val() || '');
            break;
    }
    
    jQuery.ajax({
        url: adminUrl + 'hospital_management/save_visit_details',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert_float('success', response.message);
                
                if (response.csrf_token_name && response.csrf_token_hash) {
                    csrfTokenName = response.csrf_token_name;
                    csrfTokenHash = response.csrf_token_hash;
                }
                
                if (response.total_fee) {
                    jQuery('#total_medicine_fee').text(parseFloat(response.total_fee).toFixed(2));
                }
            } else {
                alert_float('danger', response.message || 'Failed to save');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            alert_float('danger', 'Error saving data');
        }
    });
}

function saveVisit() {
    if (!visitId || visitId === 'null' || visitId === null) {
        alert_float('danger', 'Visit ID is missing. Cannot save.');
        return;
    }
    
    if (!confirm('Save all visit data at once?')) {
        return;
    }
    
    alert_float('info', 'Saving all tabs...');
    
    // Save all tabs sequentially
    var tabs = ['history', 'examination', 'retinoscopy', 'diagnosis', 'medicine', 'spectacle', 'pediatric'];
    var currentTab = 0;
    var successCount = 0;
    var failCount = 0;
    
    function saveNextTab() {
        if (currentTab >= tabs.length) {
            // All done
            if (failCount === 0) {
                alert_float('success', 'All data saved successfully! (' + successCount + ' tabs)');
            } else {
                alert_float('warning', successCount + ' tabs saved, ' + failCount + ' failed');
            }
            return;
        }
        
        var tab = tabs[currentTab];
        var formData = new FormData();
        formData.append('visit_id', visitId);
        formData.append('tab', tab);
        formData.append(csrfTokenName, csrfTokenHash);
        
        // Collect data based on tab
        switch(tab) {
            case 'history':
                formData.append('allergies', jQuery('[name="allergies"]').val() || '');
                formData.append('systemic_history', jQuery('[name="systemic_history"]').val() || '');
                formData.append('family_history', jQuery('[name="family_history"]').val() || '');
                formData.append('ocular_diseases', jQuery('[name="ocular_diseases"]').val() || '');
                formData.append('surgical_history', jQuery('[name="surgical_history"]').val() || '');
                formData.append('medication', jQuery('[name="medication"]').val() || '');
                formData.append('present_complaint', jQuery('[name="present_complaint"]').val() || '');
                formData.append('dilating_drops', jQuery('[name="dilating_drops"]').val() || '');
                break;
                
            case 'examination':
                jQuery('input[name*="_right"], input[name*="_left"]').each(function() {
                    formData.append(jQuery(this).attr('name'), jQuery(this).val() || '');
                });
                break;
                
            case 'retinoscopy':
                formData.append('right_ds', jQuery('[name="right_ds"]').val() || '');
                formData.append('right_dc', jQuery('[name="right_dc"]').val() || '');
                formData.append('right_axis', jQuery('[name="right_axis"]').val() || '');
                formData.append('right_add', jQuery('[name="right_add"]').val() || '');
                formData.append('left_ds', jQuery('[name="left_ds"]').val() || '');
                formData.append('left_dc', jQuery('[name="left_dc"]').val() || '');
                formData.append('left_axis', jQuery('[name="left_axis"]').val() || '');
                formData.append('left_add', jQuery('[name="left_add"]').val() || '');
                formData.append('type_of_dilatation', jQuery('[name="type_of_dilatation"]').val() || '');
                break;
                
            case 'diagnosis':
                var icdCodes = jQuery('[name="icd_codes[]"]').val();
                formData.append('opinion_plan_of_care', jQuery('[name="opinion_plan_of_care"]').val() || '');
                formData.append('icd_codes', Array.isArray(icdCodes) ? icdCodes.join(',') : '');
                formData.append('review_required', jQuery('[name="review_required"]:checked').val() || 'no');
                formData.append('review_period', jQuery('[name="review_period"]').val() || '');
                formData.append('systematic_exam_ordered', jQuery('[name="systematic_exam_ordered"]').val() || '');
                break;
                
            case 'medicine':
                jQuery('[name^="medicines"]').each(function() {
                    formData.append(jQuery(this).attr('name'), jQuery(this).val() || '');
                });
                break;
                
            case 'spectacle':
                formData.append('right_sph', jQuery('[name="right_sph"]').val() || '');
                formData.append('right_cyl', jQuery('[name="right_cyl"]').val() || '');
                formData.append('right_axis', jQuery('[name="right_axis"]').val() || '');
                formData.append('right_near_vision', jQuery('[name="right_near_vision"]').val() || '');
                formData.append('right_distance_vision', jQuery('[name="right_distance_vision"]').val() || '');
                formData.append('left_sph', jQuery('[name="left_sph"]').val() || '');
                formData.append('left_cyl', jQuery('[name="left_cyl"]').val() || '');
                formData.append('left_axis', jQuery('[name="left_axis"]').val() || '');
                formData.append('left_near_vision', jQuery('[name="left_near_vision"]').val() || '');
                formData.append('left_distance_vision', jQuery('[name="left_distance_vision"]').val() || '');
                formData.append('bifocals', jQuery('[name="bifocals"]:checked').val() || 'no');
                formData.append('back_vertex', jQuery('[name="back_vertex"]').val() || '');
                formData.append('interpupillary', jQuery('[name="interpupillary"]').val() || '');
                formData.append('spectacle_remarks', jQuery('[name="spectacle_remarks"]').val() || '');
                formData.append('lens_type', jQuery('[name="lens_type"]').val() || '');
                break;
                
            case 'pediatric':
                formData.append('pediatric_notes', jQuery('[name="pediatric_notes"]').val() || '');
                break;
        }
        
        // Save this tab
        jQuery.ajax({
            url: adminUrl + 'hospital_management/save_visit_details',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    successCount++;
                    console.log('Saved tab: ' + tab);
                    
                    // Update CSRF tokens
                    if (response.csrf_token_name && response.csrf_token_hash) {
                        csrfTokenName = response.csrf_token_name;
                        csrfTokenHash = response.csrf_token_hash;
                    }
                } else {
                    failCount++;
                    console.error('Failed to save tab: ' + tab, response.message);
                }
                
                // Move to next tab
                currentTab++;
                saveNextTab();
            },
            error: function(xhr, status, error) {
                failCount++;
                console.error('AJAX Error saving tab: ' + tab, error);
                
                // Move to next tab anyway
                currentTab++;
                saveNextTab();
            }
        });
    }
    
    // Start saving
    saveNextTab();
}

function closeVisit() {
    if (!visitId || visitId === 'null') {
        alert_float('danger', 'Visit ID is missing. Cannot close visit.');
        return;
    }
    
    if (confirm('Are you sure you want to close and complete this visit?')) {
        var data = {
            visit_id: visitId,
            appointment_id: appointmentId
        };
        data[csrfTokenName] = csrfTokenHash;
        
        jQuery.ajax({
            url: adminUrl + 'hospital_management/complete_visit',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert_float('success', response.message);
                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 1000);
                } else {
                    alert_float('danger', response.message);
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                alert_float('danger', 'Error closing visit');
            }
        });
    }
}

function printMedication() {
    alert('Print medication prescription - Will implement in next phase');
}

function printSpectacle() {
    alert('Print spectacle prescription - Will implement in next phase');
}

// ============================================
// DOCUMENT READY
// ============================================
jQuery(document).ready(function($) {
    console.log('Page loaded. Visit ID:', visitId);
    
    if (!visitId || visitId === 'null' || visitId === null) {
        console.error('ERROR: Visit ID is null or undefined!');
        alert_float('warning', 'Visit ID not found. Some features may not work.');
    }
    
    // Initialize selectpicker first
    if ($.fn.selectpicker) {
        $('.selectpicker').selectpicker();
    }
    
    // Calculate totals after a small delay to ensure everything is loaded
    setTimeout(function() {
        calculateTotalFee();
        calculateRequestTotal();
    }, 500);
    
    // Review required toggle
    $('[name="review_required"]').on('change', function() {
        if ($(this).val() == 'yes') {
            $('#review_period_section').slideDown();
        } else {
            $('#review_period_section').slideUp();
        }
    });
});

// ============================================
// SURGERY COUNSELLING JAVASCRIPT
// ============================================

// Toggle surgery form based on checkbox click
function toggleSurgeryForm(formType) {
    if (formType === 'simple') {
        var checkbox = $('#simpleRequestCheck');
        checkbox.prop('checked', !checkbox.prop('checked'));
        
        if (checkbox.prop('checked')) {
            // Uncheck detailed and hide its form
            $('#detailedRequestCheck').prop('checked', false);
            $('#detailedRequestForm').slideUp(300);
            
            // Show simple form
            $('#simpleRequestForm').slideDown(300);
            loadSurgeryTypes('simple');
        } else {
            $('#simpleRequestForm').slideUp(300);
        }
    } else {
        var checkbox = $('#detailedRequestCheck');
        checkbox.prop('checked', !checkbox.prop('checked'));
        
        if (checkbox.prop('checked')) {
            // Uncheck simple and hide its form
            $('#simpleRequestCheck').prop('checked', false);
            $('#simpleRequestForm').slideUp(300);
            
            // Show detailed form
            $('#detailedRequestForm').slideDown(300);
            loadSurgeryTypes('detailed');
        } else {
            $('#detailedRequestForm').slideUp(300);
        }
    }
}

// Load surgery types via AJAX
function loadSurgeryTypes(formType) {
    $.ajax({
        url: admin_url + 'hospital_management/get_surgery_types',
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.success && response.surgery_types) {
                var selectId = formType === 'simple' ? '#simple_surgery_type_id' : '#detailed_surgery_type_id';
                var options = '<option value="">-- Select Surgery Type --</option>';
                
                var currentCategory = '';
                $.each(response.surgery_types, function(index, type) {
                    // Group by category
                    if (type.category && type.category !== currentCategory) {
                        if (currentCategory !== '') {
                            options += '</optgroup>';
                        }
                        options += '<optgroup label="' + type.category + '">';
                        currentCategory = type.category;
                    }
                    
                    options += '<option value="' + type.id + '">' + type.surgery_name + '</option>';
                });
                
                if (currentCategory !== '') {
                    options += '</optgroup>';
                }
                
                $(selectId).html(options);
                $(selectId).selectpicker('refresh');
            }
        },
        error: function() {
            alert_float('danger', 'Failed to load surgery types');
        }
    });
}

// Submit surgery request
function submitSurgeryRequest(requestType) {
    var formData = {
        visit_id: <?php echo $visit['id'] ?? 'null'; ?>,
        patient_id: <?php echo $appointment['patient_id'] ?? 0; ?>,
        appointment_id: <?php echo $appointment['id'] ?? 0; ?>, // ← ADD THIS LINE
        request_type: requestType
    };
    
    if (requestType === 'simple') {
        formData.surgery_type_id = $('#simple_surgery_type_id').val();
        formData.surgery_details = $('#simple_surgery_details').val();
        
        if (!formData.surgery_type_id) {
            alert_float('warning', 'Please select a surgery type');
            return;
        }
    } else {
        // Collect all detailed form fields
        formData.surgery_type_id = $('#detailed_surgery_type_id').val();
        formData.doing_surgery = $('#doing_surgery').val();
        formData.surgery_name = $('#surgery_name').val();
        formData.lens_preference = $('#lens_preference').val();
        formData.standby_lens = $('#standby_lens').val();
        formData.disposables_instruments = $('#disposables_instruments').val();
        formData.admission_hours_before = $('#admission_hours_before').val();
        formData.overnight_admission = $('#overnight_admission').val();
        formData.special_instructions = $('#special_instructions').val();
        formData.nil_oral_instructions = $('#nil_oral_instructions').val();
        formData.preferred_datetime = $('#preferred_datetime').val();
        formData.lens_power = $('#lens_power').val();
        formData.a_constant_used = $('#a_constant_used').val();
        formData.formula_used = $('#formula_used').val();
        formData.anesthesia = $('#anesthesia').val();
        
        if (!formData.surgery_type_id) {
            alert_float('warning', 'Please select a surgery type');
            return;
        }
    }
    
    $.ajax({
        url: admin_url + 'hospital_management/save_surgery_request',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert_float('success', response.message);
                
                // Reset form
                if (requestType === 'simple') {
                    $('#simpleRequestForm').find('input, textarea, select').val('');
                    $('#simple_surgery_type_id').selectpicker('refresh');
                } else {
                    $('#detailedRequestForm').find('input, textarea, select').val('');
                    $('#detailed_surgery_type_id').selectpicker('refresh');
                }
                
                // Uncheck checkboxes and hide forms
                $('#simpleRequestCheck, #detailedRequestCheck').prop('checked', false);
                $('#simpleRequestForm, #detailedRequestForm').slideUp();
            } else {
                alert_float('danger', response.message || 'Failed to submit request');
            }
            
            // Update CSRF token
            if (response.csrf_token_name && response.csrf_token_hash) {
                $('input[name="' + response.csrf_token_name + '"]').val(response.csrf_token_hash);
            }
        },
        error: function() {
            alert_float('danger', 'Server error occurred');
        }
    });
}
// Clear surgery form
function clearSurgeryForm(formType) {
    if (formType === 'simple') {
        $('#simple_surgery_type_id').val('').selectpicker('refresh');
        $('#simple_surgery_details').val('');
    } else {
        $('#detailed_surgery_type_id').val('').selectpicker('refresh');
        $('#doing_surgery').val('');
        $('#surgery_name').val('');
        $('#lens_preference').val('');
        $('#standby_lens').val('');
        $('#disposables_instruments').val('');
        $('#admission_hours_before').val('');
        $('#overnight_admission').val('');
        $('#special_instructions').val('');
        $('#nil_oral_instructions').val('');
        $('#preferred_datetime').val('');
        $('#lens_power').val('');
        $('#a_constant_used').val('');
        $('#formula_used').val('');
        $('#anesthesia').val('');
    }
    
    alert_float('info', 'Form cleared');
}

</script>

<?php init_tail(); ?>
<script>
    // ============================================
// DOCUMENT READY
// ============================================
jQuery(document).ready(function($) {
    console.log('Page loaded. Visit ID:', visitId);
    
    if (!visitId || visitId === 'null' || visitId === null) {
        console.error('ERROR: Visit ID is null or undefined!');
        alert_float('warning', 'Visit ID not found. Some features may not work.');
    }
    
    // Initialize selectpicker first
    if ($.fn.selectpicker) {
        $('.selectpicker').selectpicker();
    }
    
    // Calculate totals after a small delay to ensure everything is loaded
    setTimeout(function() {
        calculateTotalFee();
        calculateRequestTotal();
    }, 500);
    
    // Review required toggle
    $('[name="review_required"]').on('change', function() {
        if ($(this).val() == 'yes') {
            $('#review_period_section').slideDown();
        } else {
            $('#review_period_section').slideUp();
        }
    });
    
    // ============================================
    // RECALCULATE MEDICINE FEES ON FULL PAGE LOAD
    // ============================================
    $(window).on('load', function() {
        console.log('Window fully loaded - recalculating medicine fees...');
        
        // Loop through all medicine rows and sync prices
        $('.medicine-row').each(function() {
            var $row = $(this);
            var rowId = $row.data('id');
            var $select = $row.find('.medicine-select');
            var selectedMedicineId = $select.val();
            
            if (selectedMedicineId) {
                var price = 0;
                
                // Method 1: Try to get from option data-price
                var $selectedOption = $select.find('option:selected');
                price = parseFloat($selectedOption.data('price')) || 0;
                
                // Method 2: If no price, find it in allMedicines array
                if (price === 0 && typeof allMedicines !== 'undefined') {
                    var medicine = allMedicines.find(function(m) {
                        return m.id == selectedMedicineId;
                    });
                    if (medicine) {
                        price = parseFloat(medicine.price) || 0;
                    }
                }
                
                console.log('Row ' + rowId + ': Medicine ID=' + selectedMedicineId + ', Price=₹' + price);
                
                // Update row data-price
                $row.attr('data-price', price);
                
                // Update price display
                $row.find('.medicine-price').val('₹' + price.toFixed(2));
            }
        });
        
        // Now calculate total using existing function
        var total = calculateTotalFee();
        console.log('Final Total: ₹' + total);
    });
});

</script>