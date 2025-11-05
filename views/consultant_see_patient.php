<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<style>
/* ============================================
   PATIENT HEADER BAR
============================================ */
.patient-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
    background: #f5f5f5;
    border: none;
}

.consultation-tabs .nav-tabs > li.active > a {
    background: #667eea;
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
    border-bottom: 2px solid #e0e0e0;
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
    background: #17a2b8;
    color: white;
    padding: 12px;
    text-align: center;
    font-weight: 600;
    border: 1px solid #138496;
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
    background: #17a2b8;
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
    border: 2px solid #f57c00;
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
    border: 2px solid #f57c00;
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
    background: #d81b60;
    left: 50%;
    transform: translateX(-50%);
}

.retino-line-horizontal {
    position: absolute;
    height: 3px;
    width: 100%;
    background: #d81b60;
    top: 50%;
    transform: translateY(-50%);
}

/* ============================================
   MEDICINE ROWS
============================================ */
.medicine-row {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 15px;
    border-left: 4px solid #667eea;
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
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    margin-top: 30px;
    border: 2px solid #e0e0e0;
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
}

/* ============================================
   VISITS BANNER
============================================ */
.visits-banner {
    background: #e8eaf6;
    padding: 10px 15px;
    border-radius: 4px;
    margin-bottom: 15px;
    border-left: 4px solid #667eea;
}

.visits-banner strong {
    font-size: 15px;
    color: #333;
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
                     TAB 3: RETINOSCOPY (WITH EDITABLE YELLOW BOXES)
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
                                            <strong><?php echo $med['medicine_name']; ?></strong>
                                            <small class="text-muted d-block"><?php echo $med['strength']; ?></small>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="label label-info"><?php echo ucfirst($med['eye']); ?></span>
                                        </div>
                                        <div class="col-md-2"><?php echo $med['dose'] . ' ' . $med['unit']; ?></div>
                                        <div class="col-md-2"><?php echo $med['frequency']; ?></div>
                                        <div class="col-md-2"><strong class="text-success">₹<?php echo number_format($med['price'], 2); ?></strong></div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger btn-sm" onclick="removeMedicineRow(<?php echo $index; ?>)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <?php if (!empty($med['instructions'])) { ?>
                                        <div class="row" style="margin-top: 5px;">
                                            <div class="col-md-12">
                                                <small class="text-muted"><i class="fa fa-info-circle"></i> <?php echo $med['instructions']; ?></small>
                                            </div>
                                        </div>
                                    <?php } ?>
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
                        <textarea name="medicine_instructions" class="form-control" rows="4" placeholder="Enter general instructions for patient..."></textarea>
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
                     TAB 8: REQUEST (Lab Tests, Procedures, Surgery)
                ============================================ -->
                <div role="tabpanel" class="tab-pane" id="request">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> <strong>Request Section</strong> - Lab Tests, Procedure Diagnostics, and Surgical Counselling forms will be implemented in the next phase.
                    </div>
                    
                    <p class="text-muted">This section will include:</p>
                    <ul class="text-muted">
                        <li>Lab Tests (Blood Investigation, Biochemistry, Serology, Urine, Microbiology, PCR, Packages, Pathology Biopsy)</li>
                        <li>Procedure Diagnostics (Glaucoma Package, OCT, FDT, Topography, etc.)</li>
                        <li>Procedure Treatment</li>
                        <li>Surgical Counselling (Simple & Detailed Surgery Requests)</li>
                    </ul>
                </div>
                
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
// DEFINE GLOBAL VARIABLES (available immediately)
// ============================================
// Use visit_id first (the actual visit ID), fallback to id
var visitId = <?php 
    if (!empty($visit['visit_id'])) {
        echo $visit['visit_id'];
    } elseif (!empty($visit['id'])) {
        // Check if this is actually a visit ID or details ID
        // Visit IDs should match records in tblhospital_visits
        echo $visit['id'];
    } else {
        echo 'null';
    }
?>;

// Debug output
console.log('Visit data from PHP:', {
    'visit_id': '<?php echo $visit['visit_id'] ?? 'not set'; ?>',
    'id': '<?php echo $visit['id'] ?? 'not set'; ?>',
    'details_id': '<?php echo $visit['details_id'] ?? 'not set'; ?>'
});
var appointmentId = <?php echo $appointment['id']; ?>;
var adminUrl = '<?php echo admin_url(); ?>';
var csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';
var csrfTokenHash = '<?php echo $this->security->get_csrf_hash(); ?>';

// Medicine data
var allMedicines = <?php echo json_encode($this->hospital_visits_model->get_medicines()); ?>;
var medicineCounter = <?php echo count($medicines_saved); ?>;

// ============================================
// GLOBAL FUNCTIONS (for onclick handlers)
// ============================================

// Calculate total medicine fee
function calculateTotalFee() {
    var total = 0;
    jQuery('.medicine-row').each(function() {
        var price = parseFloat(jQuery(this).attr('data-price')) || 0;
        total += price;
    });
    jQuery('#total_medicine_fee').text(total.toFixed(2));
    return total;
}

// Add new medicine row
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

// Load medicines by category
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

// When medicine is selected
function onMedicineSelect(rowId) {
    var $select = jQuery('.medicine-select[data-row="' + rowId + '"]');
    var $priceInput = jQuery('.medicine-price[data-row="' + rowId + '"]');
    var $row = jQuery('.medicine-row[data-id="' + rowId + '"]');
    
    var selectedOption = $select.find('option:selected');
    var price = selectedOption.data('price') || 0;
    
    $priceInput.val('₹' + parseFloat(price).toFixed(2));
    $row.attr('data-price', price);
    
    calculateTotalFee();
}

// Remove medicine row
function removeMedicineRow(rowId) {
    if (confirm('Remove this medicine?')) {
        jQuery('.medicine-row[data-id="' + rowId + '"]').remove();
        calculateTotalFee();
    }
}

// Save tab function
function saveTab(tab) {
    // Validate visit ID
    if (!visitId || visitId === 'null' || visitId === null) {
        alert_float('danger', 'Visit ID is missing. Cannot save.');
        console.error('Visit ID is null or undefined');
        return;
    }
    
    console.log('Saving tab:', tab, 'Visit ID:', visitId);
    
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
    
    // Debug
    console.log('Submitting to:', adminUrl + 'hospital_management/save_visit_details');
    
    jQuery.ajax({
        url: adminUrl + 'hospital_management/save_visit_details',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            console.log('Server response:', response);
            
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
            console.error('Response:', xhr.responseText);
            alert_float('danger', 'Error saving data. Check console for details.');
        }
    });
}

// Save complete visit
function saveVisit() {
    if (confirm('Save all visit data?')) {
        alert_float('info', 'Saving all data...');
    }
}

// Close visit
function closeVisit() {
    if (!visitId || visitId === 'null') {
        alert_float('danger', 'Visit ID is missing. Cannot close visit.');
        return;
    }
    
    if (confirm('Are you sure you want to close and complete this visit?')) {
        jQuery.ajax({
            url: adminUrl + 'hospital_management/complete_visit',
            type: 'POST',
            data: {
                visit_id: visitId,
                appointment_id: appointmentId
            },
            data: function() {
                var data = {
                    visit_id: visitId,
                    appointment_id: appointmentId
                };
                data[csrfTokenName] = csrfTokenHash;
                return data;
            }(),
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

// Print functions
function printMedication() {
    alert('Print medication prescription - Will implement in next phase');
}

function printSpectacle() {
    alert('Print spectacle prescription - Will implement in next phase');
}

// ============================================
// JQUERY READY (runs after jQuery loads)
// ============================================
jQuery(document).ready(function($) {
    console.log('Page loaded. Visit ID:', visitId);
    
    // Validate visit ID
    if (!visitId || visitId === 'null' || visitId === null) {
        console.error('ERROR: Visit ID is null or undefined!');
        alert_float('warning', 'Visit ID not found. Some features may not work.');
    }
    
    // Calculate existing medicine fees
    calculateTotalFee();
    
    // Initialize selectpicker
    if ($.fn.selectpicker) {
        $('.selectpicker').selectpicker();
    }
    
    // Review period toggle
    $('[name="review_required"]').on('change', function() {
        if ($(this).val() == 'yes') {
            $('#review_period_section').slideDown();
        } else {
            $('#review_period_section').slideUp();
        }
    });
});
</script>

<?php init_tail(); ?>