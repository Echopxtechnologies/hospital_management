<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<style>
/* Modern Professional Styling */
.patient-consultation-page {
    background: #f5f7fa;
    padding: 20px;
}

/* Patient Header Card */
.patient-header-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.patient-header-card h2 {
    margin: 0 0 5px 0;
    font-size: 28px;
    font-weight: 700;
}

.patient-id-badge {
    display: inline-block;
    background: rgba(255, 255, 255, 0.2);
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 14px;
    margin-left: 10px;
}

.patient-quick-info {
    display: flex;
    gap: 30px;
    margin-top: 15px;
    flex-wrap: wrap;
}

.quick-info-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.quick-info-item i {
    font-size: 16px;
    opacity: 0.9;
}

/* Info Cards Grid */
.info-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.info-card {
    background: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.info-card-title {
    font-size: 14px;
    font-weight: 600;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f0f0f0;
}

.info-card-title i {
    margin-right: 8px;
    color: #667eea;
}

.info-row {
    display: flex;
    padding: 10px 0;
    border-bottom: 1px solid #f5f5f5;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    flex: 0 0 40%;
    font-weight: 500;
    color: #666;
    font-size: 13px;
}

.info-value {
    flex: 1;
    color: #333;
    font-size: 14px;
}

/* Consultation Form Card */
.consultation-form-card {
    background: white;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 20px;
}

.form-section-header {
    background: #f8f9fa;
    margin: 0 -30px 25px -30px;
    padding: 15px 30px;
    border-bottom: 3px solid #667eea;
}

.form-section-header h4 {
    margin: 0;
    color: #333;
    font-size: 18px;
    font-weight: 600;
}

.form-section-divider {
    border-top: 2px solid #e0e0e0;
    margin: 30px 0 25px 0;
    position: relative;
}

.form-section-divider span {
    position: absolute;
    top: -12px;
    left: 20px;
    background: white;
    padding: 0 15px;
    color: #667eea;
    font-weight: 600;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Form Groups */
.form-group label {
    font-weight: 600;
    color: #444;
    margin-bottom: 8px;
    display: block;
}

.form-control {
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 10px 14px;
    font-size: 14px;
    transition: all 0.2s;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

textarea.form-control {
    min-height: 100px;
    resize: vertical;
}

/* Vitals Grid */
.vitals-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
}

.vital-input-group {
    position: relative;
}

.vital-input-group .input-unit {
    position: absolute;
    right: 12px;
    top: 38px;
    color: #999;
    font-size: 12px;
    pointer-events: none;
}

/* Action Buttons */
.form-actions {
    background: #f8f9fa;
    margin: 30px -30px -30px -30px;
    padding: 20px 30px;
    border-top: 1px solid #e0e0e0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.btn-consultation-save {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 12px 30px;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-consultation-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.btn-consultation-complete {
    background: #10b981;
    color: white;
    padding: 12px 30px;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
}

/* Previous Visits */
.previous-visits-card {
    background: white;
    border-radius: 8px;
    padding: 25px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.visit-history-item {
    padding: 15px;
    background: #f8f9fa;
    border-radius: 6px;
    margin-bottom: 12px;
    border-left: 4px solid #667eea;
}

.visit-date {
    font-weight: 600;
    color: #667eea;
    margin-bottom: 8px;
}

.visit-diagnosis {
    color: #555;
    font-size: 14px;
}

/* Responsive */
@media (max-width: 768px) {
    .info-cards-grid {
        grid-template-columns: 1fr;
    }
    
    .patient-quick-info {
        flex-direction: column;
        gap: 10px;
    }
}
</style>

<div id="wrapper">
    <div class="content patient-consultation-page">
        
        <!-- PATIENT HEADER -->
        <div class="patient-header-card">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <h2>
                        <?php echo $patient->name; ?>
                        <span class="patient-id-badge"><?php echo $patient->patient_number; ?></span>
                    </h2>
                    <div class="patient-quick-info">
                        <div class="quick-info-item">
                            <i class="fa fa-<?php echo $patient->gender === 'male' ? 'mars' : 'venus'; ?>"></i>
                            <span><?php echo ucfirst($patient->gender); ?>, <?php echo $patient->age; ?> years</span>
                        </div>
                        <div class="quick-info-item">
                            <i class="fa fa-phone"></i>
                            <span><?php echo $patient->mobile_number; ?></span>
                        </div>
                        <?php if ($patient->email): ?>
                        <div class="quick-info-item">
                            <i class="fa fa-envelope"></i>
                            <span><?php echo $patient->email; ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div>
                    <a href="<?php echo admin_url('hospital_management/consultant_appointments'); ?>" 
                       class="btn btn-default" style="background: rgba(255,255,255,0.2); border: none; color: white;">
                        <i class="fa fa-arrow-left"></i> Back to Appointments
                    </a>
                </div>
            </div>
        </div>

        <!-- PATIENT DETAILS CARDS -->
        <div class="info-cards-grid">
            
            <!-- Demographics -->
            <div class="info-card">
                <div class="info-card-title">
                    <i class="fa fa-user"></i> Demographics
                </div>
                <div class="info-row">
                    <div class="info-label">Date of Birth</div>
                    <div class="info-value"><?php echo $patient->dob ? date('d M Y', strtotime($patient->dob)) : '—'; ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Blood Group</div>
                    <div class="info-value"><?php echo $patient->blood_group ?: '—'; ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Patient Type</div>
                    <div class="info-value">
                        <span class="label label-default"><?php echo $patient->patient_type; ?></span>
                    </div>
                </div>
            </div>

            <!-- Contact & Address -->
            <div class="info-card">
                <div class="info-card-title">
                    <i class="fa fa-map-marker"></i> Contact & Address
                </div>
                <div class="info-row">
                    <div class="info-label">Address</div>
                    <div class="info-value"><?php echo $patient->address ?: '—'; ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">City, State</div>
                    <div class="info-value">
                        <?php echo $patient->city ? $patient->city : '—'; ?><?php echo $patient->state ? ', ' . $patient->state : ''; ?>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Pincode</div>
                    <div class="info-value"><?php echo $patient->pincode ?: '—'; ?></div>
                </div>
            </div>

            <!-- Appointment Info -->
            <div class="info-card">
                <div class="info-card-title">
                    <i class="fa fa-calendar"></i> Current Appointment
                </div>
                <div class="info-row">
                    <div class="info-label">Appointment #</div>
                    <div class="info-value"><strong><?php echo $appointment->appointment_number; ?></strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Date & Time</div>
                    <div class="info-value">
                        <?php echo date('d M Y', strtotime($appointment->appointment_date)); ?> 
                        at <?php echo date('h:i A', strtotime($appointment->appointment_time)); ?>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Reason</div>
                    <div class="info-value">
                        <span class="label label-primary"><?php echo ucfirst($appointment->reason_for_appointment); ?></span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        <span class="label label-<?php echo $appointment->status === 'confirmed' ? 'success' : 'warning'; ?>">
                            <?php echo ucfirst($appointment->status); ?>
                        </span>
                    </div>
                </div>
            </div>

        </div>

        <!-- CONSULTATION FORM -->
        <div class="consultation-form-card">
            <div class="form-section-header">
                <h4><i class="fa fa-stethoscope"></i> Consultation & Examination</h4>
            </div>

            <?php echo form_open(admin_url('hospital_management/save_consultation'), ['id' => 'consultation-form']); ?>
            
            <input type="hidden" name="appointment_id" value="<?php echo $appointment->id; ?>">
            <input type="hidden" name="patient_id" value="<?php echo $patient->id; ?>">
            <input type="hidden" name="visit_id" value="<?php echo isset($visit) ? $visit['id'] : ''; ?>">

            <!-- SECTION 1: VITAL SIGNS -->
            <div class="form-section-divider">
                <span><i class="fa fa-heartbeat"></i> Vital Signs</span>
            </div>

            <div class="vitals-grid">
                <div class="vital-input-group">
                    <label>Temperature</label>
                    <input type="text" name="temperature" class="form-control" 
                           value="<?php echo isset($visit) ? $visit['temperature'] : ''; ?>" 
                           placeholder="98.6">
                    <span class="input-unit">°F</span>
                </div>

                <div class="vital-input-group">
                    <label>Blood Pressure</label>
                    <input type="text" name="blood_pressure" class="form-control" 
                           value="<?php echo isset($visit) ? $visit['blood_pressure'] : ''; ?>" 
                           placeholder="120/80">
                    <span class="input-unit">mmHg</span>
                </div>

                <div class="vital-input-group">
                    <label>Pulse Rate</label>
                    <input type="text" name="pulse_rate" class="form-control" 
                           value="<?php echo isset($visit) ? $visit['pulse_rate'] : ''; ?>" 
                           placeholder="72">
                    <span class="input-unit">bpm</span>
                </div>

                <div class="vital-input-group">
                    <label>Weight</label>
                    <input type="text" name="weight" class="form-control" 
                           value="<?php echo isset($visit) ? $visit['weight'] : ''; ?>" 
                           placeholder="70">
                    <span class="input-unit">kg</span>
                </div>

                <div class="vital-input-group">
                    <label>Height</label>
                    <input type="text" name="height" class="form-control" 
                           value="<?php echo isset($visit) ? $visit['height'] : ''; ?>" 
                           placeholder="170">
                    <span class="input-unit">cm</span>
                </div>

                <div class="vital-input-group">
                    <label>SPO2</label>
                    <input type="text" name="spo2" class="form-control" 
                           value="<?php echo isset($visit) ? $visit['spo2'] : ''; ?>" 
                           placeholder="98">
                    <span class="input-unit">%</span>
                </div>
            </div>

            <!-- SECTION 2: SYMPTOMS & COMPLAINTS -->
            <div class="form-section-divider">
                <span><i class="fa fa-clipboard"></i> Chief Complaints</span>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Chief Complaint / Symptoms <span class="text-danger">*</span></label>
                        <textarea name="chief_complaint" class="form-control" required 
                                  placeholder="Enter main complaints and symptoms..."><?php echo isset($visit) ? $visit['chief_complaint'] : ''; ?></textarea>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: EXAMINATION & DIAGNOSIS -->
            <div class="form-section-divider">
                <span><i class="fa fa-user-md"></i> Examination & Diagnosis</span>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Physical Examination</label>
                        <textarea name="examination_notes" class="form-control" 
                                  placeholder="Document physical examination findings..."><?php echo isset($visit) ? $visit['examination_notes'] : ''; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Diagnosis <span class="text-danger">*</span></label>
                        <textarea name="diagnosis" class="form-control" required 
                                  placeholder="Enter diagnosis..."><?php echo isset($visit) ? $visit['diagnosis'] : ''; ?></textarea>
                    </div>
                </div>
            </div>

            <!-- SECTION 4: TREATMENT & PRESCRIPTION -->
            <div class="form-section-divider">
                <span><i class="fa fa-medkit"></i> Treatment & Prescription</span>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Treatment Given</label>
                        <textarea name="treatment_given" class="form-control" 
                                  placeholder="Describe treatment provided during this visit..."><?php echo isset($visit) ? $visit['treatment_given'] : ''; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Prescription / Medications</label>
                        <textarea name="prescription" class="form-control" 
                                  placeholder="List prescribed medications with dosage and duration..."><?php echo isset($visit) ? $visit['prescription'] : ''; ?></textarea>
                    </div>
                </div>
            </div>

            <!-- SECTION 5: INVESTIGATIONS -->
            <div class="form-section-divider">
                <span><i class="fa fa-flask"></i> Investigations & Tests</span>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Lab Tests / Investigations Required</label>
                        <textarea name="investigations" class="form-control" 
                                  placeholder="List required lab tests, X-rays, scans, etc..."><?php echo isset($visit) ? $visit['investigations'] : ''; ?></textarea>
                    </div>
                </div>
            </div>

            <!-- SECTION 6: ADVICE & FOLLOW-UP -->
            <div class="form-section-divider">
                <span><i class="fa fa-info-circle"></i> Medical Advice & Follow-up</span>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Medical Advice / Instructions</label>
                        <textarea name="medical_advice" class="form-control" 
                                  placeholder="Diet, rest, precautions, do's and don'ts..."><?php echo isset($visit) ? $visit['medical_advice'] : ''; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Follow-up Required?</label>
                        <div>
                            <label class="radio-inline">
                                <input type="radio" name="follow_up_required" value="1" 
                                       <?php echo (isset($visit) && $visit['follow_up_required']) ? 'checked' : ''; ?>> Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="follow_up_required" value="0" 
                                       <?php echo (!isset($visit) || !$visit['follow_up_required']) ? 'checked' : ''; ?>> No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Follow-up Date</label>
                        <input type="date" name="follow_up_date" class="form-control" 
                               value="<?php echo isset($visit) ? $visit['follow_up_date'] : ''; ?>">
                    </div>
                </div>
            </div>

            <!-- SECTION 7: ADDITIONAL NOTES -->
            <div class="form-section-divider">
                <span><i class="fa fa-pencil"></i> Additional Notes</span>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Consultation Notes</label>
                        <textarea name="notes" class="form-control" rows="4" 
                                  placeholder="Any additional notes or observations..."><?php echo isset($visit) ? $visit['notes'] : ''; ?></textarea>
                    </div>
                </div>
            </div>

            <!-- FORM ACTIONS -->
            <div class="form-actions">
                <div>
                    <a href="<?php echo admin_url('hospital_management/consultant_appointments'); ?>" class="btn btn-default">
                        <i class="fa fa-times"></i> Cancel
                    </a>
                </div>
                <div>
                    <button type="submit" name="action" value="save" class="btn btn-primary" style="margin-right: 10px;">
                        <i class="fa fa-save"></i> Save Progress
                    </button>
                    <button type="submit" name="action" value="complete" class="btn-consultation-complete">
                        <i class="fa fa-check-circle"></i> Save & Mark Complete
                    </button>
                </div>
            </div>

            <?php echo form_close(); ?>
        </div>

        <!-- PREVIOUS VISITS -->
        <?php if (!empty($previous_visits)): ?>
        <div class="previous-visits-card">
            <h4 style="margin-bottom: 20px; color: #333;">
                <i class="fa fa-history"></i> Previous Visit History
            </h4>
            
            <?php foreach ($previous_visits as $prev_visit): ?>
            <div class="visit-history-item">
                <div class="visit-date">
                    <i class="fa fa-calendar-o"></i> 
                    <?php echo date('d M Y', strtotime($prev_visit['visit_date'])); ?> at 
                    <?php echo date('h:i A', strtotime($prev_visit['visit_time'])); ?>
                </div>
                <div class="visit-diagnosis">
                    <strong>Diagnosis:</strong> <?php echo $prev_visit['diagnosis'] ?: 'Not recorded'; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</div>

<?php init_tail(); ?>

<script>
$(function() {
    'use strict';
    
    // Form submission
    $('#consultation-form').on('submit', function(e) {
        var action = $('button[type="submit"]:focus').val();
        
        // Validate required fields
        var chiefComplaint = $('textarea[name="chief_complaint"]').val().trim();
        var diagnosis = $('textarea[name="diagnosis"]').val().trim();
        
        if (!chiefComplaint || !diagnosis) {
            e.preventDefault();
            alert_float('warning', 'Chief Complaint and Diagnosis are required');
            return false;
        }
        
        // Show loading
        var $btn = $('button[type="submit"]:focus');
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
    });
    
    // Auto-save draft every 2 minutes
    setInterval(function() {
        var formData = $('#consultation-form').serialize() + '&action=autosave';
        
        $.ajax({
            url: admin_url + 'hospital_management/autosave_consultation',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    console.log('Auto-saved at ' + new Date().toLocaleTimeString());
                }
            }
        });
    }, 120000); // Every 2 minutes
});
</script>