<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<style>
/* Same styles as before */
:root {
    --primary-aqua: #00bcd4;
    --secondary-aqua: #0097a7;
}

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

.patient-header .info-item strong { font-weight: 600; }

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

.consultation-tabs .nav-tabs > li > a:hover { background: #e0f7fa; border: none; }
.consultation-tabs .nav-tabs > li.active > a { background: #00bcd4; color: white; border: none; }
.consultation-tabs .tab-content { padding: 25px; }

.data-row {
    background: #f9f9f9;
    padding: 15px;
    border-radius: 6px;
    border-left: 4px solid #00bcd4;
    margin-bottom: 15px;
}

.data-row label {
    font-weight: 600;
    color: #555;
    margin-bottom: 8px;
    display: block;
    font-size: 13px;
}

.data-row .value {
    color: #333;
    line-height: 1.6;
    white-space: pre-wrap;
}

.data-row .value.empty { color: #999; font-style: italic; }

.examination-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
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
    padding: 12px;
    border: 1px solid #ddd;
    text-align: center;
}

.examination-table td:first-child {
    font-weight: 500;
    background: #fafafa;
    text-align: left;
    width: 200px;
}

.eye-header {
    background: #00bcd4;
    color: white;
    text-align: center;
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 20px;
}

.eye-header h4 { margin: 0; font-weight: 600; }

.retino-display {
    background: #f8f9fa;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    padding: 30px;
    text-align: center;
}

.retino-display .retino-box {
    display: inline-block;
    background: #fff;
    border: 2px solid #00bcd4;
    border-radius: 6px;
    padding: 15px 20px;
    margin: 10px;
    min-width: 120px;
}

.retino-display .retino-box label {
    display: block;
    font-weight: 600;
    font-size: 12px;
    color: #666;
    margin-bottom: 5px;
}

.retino-display .retino-box .value {
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.medicine-item {
    background: #f9f9f9;
    border-left: 4px solid #4caf50;
    padding: 15px;
    margin-bottom: 12px;
    border-radius: 6px;
}

.medicine-item .med-name {
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
}

.medicine-item .med-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 10px;
    font-size: 14px;
    color: #666;
}

.action-buttons {
    position: fixed;
    top: 80px;
    right: 20px;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

@media print {
    .action-buttons, .content-header { display: none !important; }
    body { background: white; }
}
</style>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                
                <!-- Action Buttons WITH PDF DOWNLOAD -->
                <div class="action-buttons">
                    <a href="<?php echo admin_url('hospital_management/download_visit_pdf/' . $visit_id); ?>" class="btn btn-success">
                        <i class="fa fa-file-pdf-o"></i> Download PDF
                    </a>
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fa fa-print"></i> Browser Print
                    </button>
                    <a href="<?php echo admin_url('hospital_management/consultant_appointments'); ?>" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
                
                <!-- PATIENT HEADER -->
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
                        <strong>Visit Date:</strong> <?php echo !empty($visit['visit_date']) ? date('d-m-Y', strtotime($visit['visit_date'])) : date('d-m-Y'); ?>
                    </div>
                    <div class="info-item">
                        <strong>Total Visits:</strong> <?php echo count($visit_history); ?>
                    </div>
                    <div class="info-item">
                        <strong>Consultant:</strong> Dr <?php echo $appointment['consultant_firstname'] . ' ' . $appointment['consultant_lastname']; ?>
                    </div>
                </div>
                
                <!-- TABS -->
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
                    </ul>
                    
                    <div class="tab-content">
                        
                        <!-- TAB 1: HISTORY -->
                        <div role="tabpanel" class="tab-pane active" id="history">
                            <div class="data-row">
                                <label>Allergies</label>
                                <div class="value"><?php echo !empty($visit['allergies']) ? nl2br(htmlspecialchars($visit['allergies'])) : '<span class="empty">Not recorded</span>'; ?></div>
                            </div>
                            
                            <div class="data-row">
                                <label>Systemic History</label>
                                <div class="value"><?php echo !empty($visit['systemic_history']) ? nl2br(htmlspecialchars($visit['systemic_history'])) : '<span class="empty">Not recorded</span>'; ?></div>
                            </div>
                            
                            <div class="data-row">
                                <label>Family History</label>
                                <div class="value"><?php echo !empty($visit['family_history']) ? nl2br(htmlspecialchars($visit['family_history'])) : '<span class="empty">Not recorded</span>'; ?></div>
                            </div>
                            
                            <div class="data-row">
                                <label>Ocular Diseases</label>
                                <div class="value"><?php echo !empty($visit['ocular_diseases']) ? nl2br(htmlspecialchars($visit['ocular_diseases'])) : '<span class="empty">Not recorded</span>'; ?></div>
                            </div>
                            
                            <div class="data-row">
                                <label>Surgical History</label>
                                <div class="value"><?php echo !empty($visit['surgical_history']) ? nl2br(htmlspecialchars($visit['surgical_history'])) : '<span class="empty">Not recorded</span>'; ?></div>
                            </div>
                            
                            <div class="data-row">
                                <label>Medication</label>
                                <div class="value"><?php echo !empty($visit['medication']) ? nl2br(htmlspecialchars($visit['medication'])) : '<span class="empty">Not recorded</span>'; ?></div>
                            </div>
                            
                            <div class="data-row">
                                <label>Present Complaint</label>
                                <div class="value"><?php echo !empty($visit['present_complaint']) ? nl2br(htmlspecialchars($visit['present_complaint'])) : '<span class="empty">Not recorded</span>'; ?></div>
                            </div>
                            
                            <div class="data-row">
                                <label>Dilating Drops</label>
                                <div class="value"><?php echo !empty($visit['dilating_drops']) ? htmlspecialchars($visit['dilating_drops']) : '<span class="empty">Not recorded</span>'; ?></div>
                            </div>
                        </div>
                        
                        <!-- TAB 2: EXAMINATION -->
                        <div role="tabpanel" class="tab-pane" id="examination">
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
                                        $right = $exam_data[$key]['right'] ?? '-';
                                        $left = $exam_data[$key]['left'] ?? '-';
                                        ?>
                                        <tr>
                                            <td><?php echo $label; ?></td>
                                            <td><?php echo htmlspecialchars($right); ?></td>
                                            <td><?php echo htmlspecialchars($left); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- TAB 3: RETINOSCOPY -->
                        <div role="tabpanel" class="tab-pane" id="retinoscopy">
                            <?php $retino_data = !empty($visit['retinoscopy_data']) ? json_decode($visit['retinoscopy_data'], true) : []; ?>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="eye-header"><h4>Right Eye</h4></div>
                                    <div class="retino-display">
                                        <div class="retino-box">
                                            <label>DS (Spherical)</label>
                                            <div class="value"><?php echo $retino_data['right']['ds'] ?? '-'; ?></div>
                                        </div>
                                        <div class="retino-box">
                                            <label>DC (Cylindrical)</label>
                                            <div class="value"><?php echo $retino_data['right']['dc'] ?? '-'; ?></div>
                                        </div>
                                        <div class="retino-box">
                                            <label>Axis</label>
                                            <div class="value"><?php echo $retino_data['right']['axis'] ?? '-'; ?></div>
                                        </div>
                                        <div class="retino-box">
                                            <label>Add</label>
                                            <div class="value"><?php echo $retino_data['right']['add'] ?? '-'; ?></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="eye-header"><h4>Left Eye</h4></div>
                                    <div class="retino-display">
                                        <div class="retino-box">
                                            <label>DS (Spherical)</label>
                                            <div class="value"><?php echo $retino_data['left']['ds'] ?? '-'; ?></div>
                                        </div>
                                        <div class="retino-box">
                                            <label>DC (Cylindrical)</label>
                                            <div class="value"><?php echo $retino_data['left']['dc'] ?? '-'; ?></div>
                                        </div>
                                        <div class="retino-box">
                                            <label>Axis</label>
                                            <div class="value"><?php echo $retino_data['left']['axis'] ?? '-'; ?></div>
                                        </div>
                                        <div class="retino-box">
                                            <label>Add</label>
                                            <div class="value"><?php echo $retino_data['left']['add'] ?? '-'; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="data-row" style="margin-top: 20px;">
                                <label>Type of Dilatation</label>
                                <div class="value"><?php echo $retino_data['type_of_dilatation'] ?? '<span class="empty">Not specified</span>'; ?></div>
                            </div>
                        </div>
                        
                        <!-- TAB 4: DIAGNOSIS -->
                        <div role="tabpanel" class="tab-pane" id="diagnosis">
                            <div class="data-row">
                                <label>Opinion / Plan of Care</label>
                                <div class="value"><?php echo !empty($visit['opinion_plan_of_care']) ? nl2br(htmlspecialchars($visit['opinion_plan_of_care'])) : '<span class="empty">Not recorded</span>'; ?></div>
                            </div>
                            
                            <div class="data-row">
                                <label>ICD Codes</label>
                                <div class="value"><?php echo !empty($visit['icd_codes']) ? htmlspecialchars($visit['icd_codes']) : '<span class="empty">Not recorded</span>'; ?></div>
                            </div>
                            
                            <div class="data-row">
                                <label>Review Required</label>
                                <div class="value"><?php echo !empty($visit['review_required']) ? 'Yes' : 'No'; ?></div>
                            </div>
                            
                            <?php if (!empty($visit['review_required'])) { ?>
                            <div class="data-row">
                                <label>Review Period</label>
                                <div class="value"><?php echo $visit['review_period'] ?? '<span class="empty">Not specified</span>'; ?></div>
                            </div>
                            <?php } ?>
                            
                            <div class="data-row">
                                <label>Systematic Exam Ordered</label>
                                <div class="value"><?php echo !empty($visit['systematic_exam_ordered']) ? htmlspecialchars($visit['systematic_exam_ordered']) : '<span class="empty">Not recorded</span>'; ?></div>
                            </div>
                        </div>
                        
                        <!-- TAB 5: MEDICINE -->
                        <div role="tabpanel" class="tab-pane" id="medicine">
                            <?php if (!empty($medicines_saved)) { ?>
                                <?php foreach ($medicines_saved as $med) { ?>
                                    <div class="medicine-item">
                                        <div class="med-name"><?php echo htmlspecialchars($med['medicine_name'] ?? 'Medicine'); ?></div>
                                        <div class="med-info">
                                            <?php if (!empty($med['category'])) { ?>
                                                <div><strong>Category:</strong> <?php echo ucfirst($med['category']); ?></div>
                                            <?php } ?>
                                            <?php if (!empty($med['eye'])) { ?>
                                                <div><strong>Eye:</strong> <?php echo ucfirst($med['eye']); ?></div>
                                            <?php } ?>
                                            <?php if (!empty($med['dose'])) { ?>
                                                <div><strong>Dose:</strong> <?php echo $med['dose']; ?></div>
                                            <?php } ?>
                                            <?php if (!empty($med['frequency'])) { ?>
                                                <div><strong>Frequency:</strong> <?php echo $med['frequency']; ?></div>
                                            <?php } ?>
                                            <?php if (!empty($med['duration'])) { ?>
                                                <div><strong>Duration:</strong> <?php echo $med['duration']; ?></div>
                                            <?php } ?>
                                            <?php if (!empty($med['instructions'])) { ?>
                                                <div style="grid-column: 1 / -1;"><strong>Instructions:</strong> <?php echo htmlspecialchars($med['instructions']); ?></div>
                                            <?php } ?>
                                            <?php if (!empty($med['price'])) { ?>
                                                <div><strong>Price:</strong> ₹<?php echo number_format($med['price'], 2); ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <p style="text-align: center; color: #999; padding: 50px;">No medicines prescribed</p>
                            <?php } ?>
                        </div>
                        
                        <!-- TAB 6: SPECTACLE -->
                        <div role="tabpanel" class="tab-pane" id="spectacle">
                            <h4 style="margin-bottom: 20px;">Right Eye</h4>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="data-row">
                                        <label>SPH</label>
                                        <div class="value"><?php echo $visit['spectacle_right_sph'] ?? '-'; ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="data-row">
                                        <label>CYL</label>
                                        <div class="value"><?php echo $visit['spectacle_right_cyl'] ?? '-'; ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="data-row">
                                        <label>Axis</label>
                                        <div class="value"><?php echo $visit['spectacle_right_axis'] ?? '-'; ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="data-row">
                                        <label>Near Vision</label>
                                        <div class="value"><?php echo $visit['spectacle_right_near_vision'] ?? '-'; ?></div>
                                    </div>
                                </div>
                            </div>
                            
                            <h4 style="margin: 30px 0 20px;">Left Eye</h4>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="data-row">
                                        <label>SPH</label>
                                        <div class="value"><?php echo $visit['spectacle_left_sph'] ?? '-'; ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="data-row">
                                        <label>CYL</label>
                                        <div class="value"><?php echo $visit['spectacle_left_cyl'] ?? '-'; ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="data-row">
                                        <label>Axis</label>
                                        <div class="value"><?php echo $visit['spectacle_left_axis'] ?? '-'; ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="data-row">
                                        <label>Near Vision</label>
                                        <div class="value"><?php echo $visit['spectacle_left_near_vision'] ?? '-'; ?></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="data-row" style="margin-top: 20px;">
                                <label>Bifocals</label>
                                <div class="value"><?php echo $visit['bifocals'] ?? '-'; ?></div>
                            </div>
                            
                            <div class="data-row">
                                <label>Back Vertex</label>
                                <div class="value"><?php echo $visit['back_vertex'] ?? '-'; ?></div>
                            </div>
                            
                            <div class="data-row">
                                <label>Interpupillary Distance</label>
                                <div class="value"><?php echo $visit['interpupillary'] ?? '-'; ?></div>
                            </div>
                            
                            <div class="data-row">
                                <label>Lens Type</label>
                                <div class="value"><?php echo $visit['lens_type'] ?? '<span class="empty">Not specified</span>'; ?></div>
                            </div>
                            
                            <div class="data-row">
                                <label>Remarks</label>
                                <div class="value"><?php echo !empty($visit['spectacle_remarks']) ? nl2br(htmlspecialchars($visit['spectacle_remarks'])) : '<span class="empty">No remarks</span>'; ?></div>
                            </div>
                        </div>
                        
                        <!-- TAB 7: PEDIATRIC -->
                        <div role="tabpanel" class="tab-pane" id="pediatric">
                            <div class="data-row">
                                <label>Pediatric Notes</label>
                                <div class="value"><?php echo !empty($visit['pediatric_notes']) ? nl2br(htmlspecialchars($visit['pediatric_notes'])) : '<span class="empty">No pediatric notes</span>'; ?></div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>
