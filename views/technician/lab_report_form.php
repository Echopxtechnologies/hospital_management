<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<style>
.hospital-header {
    background: linear-gradient(135deg, #17a2b8 0%, #20c9e7 100%);
    color: white;
    padding: 20px;
    border-radius: 5px;
    margin-bottom: 20px;
}
.section-header {
    background: #f8f9fa;
    border-left: 4px solid #17a2b8;
    padding: 12px 15px;
    margin: 20px 0 15px 0;
    font-weight: bold;
    color: #17a2b8;
}
.result-input {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
}
.result-input label {
    flex: 0 0 250px;
    margin-bottom: 0;
    font-weight: 600;
}
.result-input input, .result-input select {
    flex: 1;
    max-width: 300px;
}
.result-input .reference {
    flex: 0 0 250px;
    color: #6c757d;
    font-size: 12px;
}
</style>

<div id="wrapper">
    <div class="content">
        <!-- Header -->
        <div class="hospital-header">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="no-margin">
                        <i class="fa fa-flask"></i> Lab Report Entry
                    </h3>
                    <p class="no-margin" style="opacity: 0.9; margin-top: 5px;">
                        Request: <?php echo $request['request_number']; ?>
                    </p>
                </div>
                <div class="col-md-4 text-right">
                    <a href="<?php echo admin_url('hospital_management/lab_requests'); ?>" class="btn btn-light">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>

        <!-- Patient Info -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="bold" style="color: #17a2b8;">Patient Information</h4>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Name:</strong></td>
                                        <td><?php echo $request['patient_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>ID No:</strong></td>
                                        <td><?php echo $request['patient_number']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Age/Sex:</strong></td>
                                        <td><?php echo $request['patient_age']; ?> Years / <?php echo strtoupper(substr($request['patient_gender'], 0, 1)); ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h4 class="bold" style="color: #17a2b8;">Request Details</h4>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Lab Reg. No:</strong></td>
                                        <td><?php echo $request['request_number']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Ref By:</strong></td>
                                        <td>Dr <?php echo $request['doctor_firstname'] . ' ' . $request['doctor_lastname']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Date:</strong></td>
                                        <td><?php echo date('d/m/Y', strtotime($request['created_at'])); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lab Report Form -->
        <form method="POST" action="<?php echo admin_url('hospital_management/save_lab_report'); ?>">
            <?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
            <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel_s">
                        <div class="panel-body">
                            
                            <!-- BIO-CHEMISTRY -->
                            <div class="section-header"><i class="fa fa-flask"></i> BIO-CHEMISTRY</div>
                            
                            <div class="result-input">
                                <label>Fasting Blood Sugar</label>
                                <input type="text" class="form-control" name="fasting_blood_sugar" value="<?php echo isset($existing_report->fasting_blood_sugar) ? $existing_report->fasting_blood_sugar : ''; ?>">
                                <span class="reference">70 – 110 mg/dL</span>
                            </div>
                            
                            <div class="result-input">
                                <label>PostPrandial Blood Sugar</label>
                                <input type="text" class="form-control" name="postprandial_blood_sugar" value="<?php echo isset($existing_report->postprandial_blood_sugar) ? $existing_report->postprandial_blood_sugar : ''; ?>">
                                <span class="reference">80- 140 mg/dl</span>
                            </div>
                            
                            <div class="result-input">
                                <label>Blood Urea</label>
                                <input type="text" class="form-control" name="blood_urea" value="<?php echo isset($existing_report->blood_urea) ? $existing_report->blood_urea : ''; ?>">
                                <span class="reference">10 – 45 mg/dL</span>
                            </div>
                            
                            <div class="result-input">
                                <label>Serum Creatinine</label>
                                <input type="text" class="form-control" name="serum_creatinine" value="<?php echo isset($existing_report->serum_creatinine) ? $existing_report->serum_creatinine : ''; ?>">
                                <span class="reference">M: 0.7 – 1.4, F: 0.6 – 1.2 mg/dL</span>
                            </div>

                            <!-- SEROLOGY -->
                            <div class="section-header"><i class="fa fa-eyedropper"></i> SEROLOGY</div>
                            
                            <div class="result-input">
                                <label>HIV I & II</label>
                                <select class="form-control" name="hiv_1_2">
                                    <option value="">Select</option>
                                    <option value="Negative" <?php echo (isset($existing_report->hiv_1_2) && $existing_report->hiv_1_2 == 'Negative') ? 'selected' : ''; ?>>Negative</option>
                                    <option value="Positive" <?php echo (isset($existing_report->hiv_1_2) && $existing_report->hiv_1_2 == 'Positive') ? 'selected' : ''; ?>>Positive</option>
                                </select>
                            </div>
                            
                            <div class="result-input">
                                <label>HBsAg</label>
                                <select class="form-control" name="hbsag">
                                    <option value="">Select</option>
                                    <option value="Negative" <?php echo (isset($existing_report->hbsag) && $existing_report->hbsag == 'Negative') ? 'selected' : ''; ?>>Negative</option>
                                    <option value="Positive" <?php echo (isset($existing_report->hbsag) && $existing_report->hbsag == 'Positive') ? 'selected' : ''; ?>>Positive</option>
                                </select>
                            </div>
                            
                            <div class="result-input">
                                <label>HCV</label>
                                <select class="form-control" name="hcv">
                                    <option value="">Select</option>
                                    <option value="Negative" <?php echo (isset($existing_report->hcv) && $existing_report->hcv == 'Negative') ? 'selected' : ''; ?>>Negative</option>
                                    <option value="Positive" <?php echo (isset($existing_report->hcv) && $existing_report->hcv == 'Positive') ? 'selected' : ''; ?>>Positive</option>
                                </select>
                            </div>

                            <!-- HAEMATOLOGY -->
                            <div class="section-header"><i class="fa fa-heartbeat"></i> HAEMATOLOGY</div>
                            
                            <div class="result-input">
                                <label>Haemoglobin</label>
                                <input type="text" class="form-control" name="haemoglobin" value="<?php echo isset($existing_report->haemoglobin) ? $existing_report->haemoglobin : ''; ?>">
                                <span class="reference">M: 12-18, F: 11-16 g/dL</span>
                            </div>
                            
                            <div class="result-input">
                                <label>Total WBC Count</label>
                                <input type="text" class="form-control" name="total_wbc_count" value="<?php echo isset($existing_report->total_wbc_count) ? $existing_report->total_wbc_count : ''; ?>">
                                <span class="reference">4,000 – 11,000 /cmm</span>
                            </div>

                            <!-- DIFF LEUCOCYTE COUNT -->
                            <h5 class="bold mtop20" style="color: #17a2b8;">DIFF.LEUCOCYTE COUNT</h5>
                            
                            <div class="result-input">
                                <label>Neutrophils</label>
                                <input type="text" class="form-control" name="neutrophils" value="<?php echo isset($existing_report->neutrophils) ? $existing_report->neutrophils : ''; ?>">
                                <span class="reference">40 – 70 %</span>
                            </div>
                            
                            <div class="result-input">
                                <label>Lymphocytes</label>
                                <input type="text" class="form-control" name="lymphocytes" value="<?php echo isset($existing_report->lymphocytes) ? $existing_report->lymphocytes : ''; ?>">
                                <span class="reference">20 – 40 %</span>
                            </div>
                            
                            <div class="result-input">
                                <label>Eosinophils</label>
                                <input type="text" class="form-control" name="eosinophils" value="<?php echo isset($existing_report->eosinophils) ? $existing_report->eosinophils : ''; ?>">
                                <span class="reference">01 – 06 %</span>
                            </div>
                            
                            <div class="result-input">
                                <label>Monocytes</label>
                                <input type="text" class="form-control" name="monocytes" value="<?php echo isset($existing_report->monocytes) ? $existing_report->monocytes : ''; ?>">
                                <span class="reference">00 – 04 %</span>
                            </div>
                            
                            <div class="result-input">
                                <label>Basophils</label>
                                <input type="text" class="form-control" name="basophils" value="<?php echo isset($existing_report->basophils) ? $existing_report->basophils : ''; ?>">
                                <span class="reference">00 – 01 %</span>
                            </div>
                            
                            <div class="result-input">
                                <label>RBC</label>
                                <input type="text" class="form-control" name="rbc" value="<?php echo isset($existing_report->rbc) ? $existing_report->rbc : ''; ?>">
                                <span class="reference">M: 4.5-5.5, F: 3.8-4.8 M/cmm</span>
                            </div>
                            
                            <div class="result-input">
                                <label>Platelet Count</label>
                                <input type="text" class="form-control" name="platelet_count" value="<?php echo isset($existing_report->platelet_count) ? $existing_report->platelet_count : ''; ?>">
                                <span class="reference">1.5 – 4.5 lakhs/cmm</span>
                            </div>
                            
                            <div class="result-input">
                                <label>P.C.V</label>
                                <input type="text" class="form-control" name="pcv" value="<?php echo isset($existing_report->pcv) ? $existing_report->pcv : ''; ?>">
                                <span class="reference">M: 40-50%, F: 36-46%</span>
                            </div>
                            
                            <div class="result-input">
                                <label>MCV</label>
                                <input type="text" class="form-control" name="mcv" value="<?php echo isset($existing_report->mcv) ? $existing_report->mcv : ''; ?>">
                                <span class="reference">80 – 96fL</span>
                            </div>
                            
                            <div class="result-input">
                                <label>MCH</label>
                                <input type="text" class="form-control" name="mch" value="<?php echo isset($existing_report->mch) ? $existing_report->mch : ''; ?>">
                                <span class="reference">27 – 32 pg</span>
                            </div>
                            
                            <div class="result-input">
                                <label>MCHC</label>
                                <input type="text" class="form-control" name="mchc" value="<?php echo isset($existing_report->mchc) ? $existing_report->mchc : ''; ?>">
                                <span class="reference">32 – 35 %</span>
                            </div>
                            
                            <div class="result-input">
                                <label>Bleeding Time (B T)</label>
                                <input type="text" class="form-control" name="bleeding_time" value="<?php echo isset($existing_report->bleeding_time) ? $existing_report->bleeding_time : ''; ?>" placeholder="e.g., 2 min 25 sec">
                                <span class="reference">1 – 4 min</span>
                            </div>
                            
                            <div class="result-input">
                                <label>Clotting Time (C T)</label>
                                <input type="text" class="form-control" name="clotting_time" value="<?php echo isset($existing_report->clotting_time) ? $existing_report->clotting_time : ''; ?>" placeholder="e.g., 4 min 05 sec">
                                <span class="reference">3 – 8 min</span>
                            </div>

                            <!-- URINE ANALYSIS -->
                            <div class="section-header"><i class="fa fa-tint"></i> URINE ANALYSIS - PHYSICAL</div>
                            
                            <div class="result-input">
                                <label>Colour</label>
                                <select class="form-control" name="urine_colour">
                                    <option value="">Select</option>
                                    <option value="Pale yellow" <?php echo (isset($existing_report->urine_colour) && $existing_report->urine_colour == 'Pale yellow') ? 'selected' : ''; ?>>Pale yellow</option>
                                    <option value="Yellow" <?php echo (isset($existing_report->urine_colour) && $existing_report->urine_colour == 'Yellow') ? 'selected' : ''; ?>>Yellow</option>
                                    <option value="Dark yellow" <?php echo (isset($existing_report->urine_colour) && $existing_report->urine_colour == 'Dark yellow') ? 'selected' : ''; ?>>Dark yellow</option>
                                </select>
                            </div>
                            
                            <div class="result-input">
                                <label>pH</label>
                                <input type="text" class="form-control" name="urine_ph" value="<?php echo isset($existing_report->urine_ph) ? $existing_report->urine_ph : ''; ?>">
                                <span class="reference">4.5 – 8.0</span>
                            </div>
                            
                            <div class="result-input">
                                <label>Sp Gravity</label>
                                <input type="text" class="form-control" name="urine_sp_gravity" value="<?php echo isset($existing_report->urine_sp_gravity) ? $existing_report->urine_sp_gravity : ''; ?>">
                                <span class="reference">1.005 – 1.030</span>
                            </div>

                            <div class="section-header"><i class="fa fa-flask"></i> URINE ANALYSIS - CHEMICAL</div>
                            
                            <div class="result-input">
                                <label>Protein</label>
                                <select class="form-control" name="urine_protein">
                                    <option value="">Select</option>
                                    <option value="NIL" <?php echo (isset($existing_report->urine_protein) && $existing_report->urine_protein == 'NIL') ? 'selected' : ''; ?>>NIL</option>
                                    <option value="Trace" <?php echo (isset($existing_report->urine_protein) && $existing_report->urine_protein == 'Trace') ? 'selected' : ''; ?>>Trace</option>
                                    <option value="+" <?php echo (isset($existing_report->urine_protein) && $existing_report->urine_protein == '+') ? 'selected' : ''; ?>>+</option>
                                    <option value="++" <?php echo (isset($existing_report->urine_protein) && $existing_report->urine_protein == '++') ? 'selected' : ''; ?>>++</option>
                                </select>
                            </div>
                            
                            <div class="result-input">
                                <label>Glucose</label>
                                <input type="text" class="form-control" name="urine_glucose" value="<?php echo isset($existing_report->urine_glucose) ? $existing_report->urine_glucose : ''; ?>" placeholder="e.g., 2.0%">
                            </div>

                            <div class="section-header"><i class="fa fa-search"></i> MICROSCOPIC (CENTRIFUGED SEDIMENT) - HPF</div>
                            
                            <div class="result-input">
                                <label>Pus cells</label>
                                <input type="text" class="form-control" name="pus_cells" value="<?php echo isset($existing_report->pus_cells) ? $existing_report->pus_cells : ''; ?>" placeholder="e.g., 2-3 / HPF">
                            </div>
                            
                            <div class="result-input">
                                <label>Epithelial cells</label>
                                <input type="text" class="form-control" name="epithelial_cells" value="<?php echo isset($existing_report->epithelial_cells) ? $existing_report->epithelial_cells : ''; ?>" placeholder="e.g., 1-2 / HPF">
                            </div>
                            
                            <div class="result-input">
                                <label>RBC s</label>
                                <input type="text" class="form-control" name="rbc_urine" value="<?php echo isset($existing_report->rbc_urine) ? $existing_report->rbc_urine : ''; ?>" placeholder="e.g., NIL">
                            </div>

                            <!-- NOTES -->
                            <div class="section-header"><i class="fa fa-comment"></i> Technician Notes</div>
                            
                            <div class="form-group">
                                <textarea class="form-control" name="technician_notes" rows="3"><?php echo isset($existing_report->technician_notes) ? $existing_report->technician_notes : ''; ?></textarea>
                            </div>

                            <!-- Buttons -->
                            <hr>
                            <div class="text-right">
                                <a href="<?php echo admin_url('hospital_management/lab_requests'); ?>" class="btn btn-default">
                                    <i class="fa fa-times"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save"></i> Save & Complete Report
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php init_tail(); ?>