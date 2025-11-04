<?php

defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();

// ==========================================
// TABLE 1: hospital_users
// ==========================================
if (!$CI->db->table_exists(db_prefix() . 'hospital_users')) {
    
    $CI->db->query("CREATE TABLE `" . db_prefix() . "hospital_users` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `staff_id` INT(11) DEFAULT NULL,
        `role_id` INT(11) NOT NULL,
        `first_name` VARCHAR(100) NOT NULL,
        `last_name` VARCHAR(100) NOT NULL,
        `email` VARCHAR(150) NOT NULL,
        `password` VARCHAR(255) NOT NULL,
        `phone_number` VARCHAR(30) DEFAULT NULL,
        `landline_number` VARCHAR(30) DEFAULT NULL,
        `address` TEXT DEFAULT NULL,
        `active` TINYINT(1) NOT NULL DEFAULT 1,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `email` (`email`),
        KEY `role_id` (`role_id`),
        KEY `staff_id` (`staff_id`),
        CONSTRAINT `fk_hospital_users_role` FOREIGN KEY (`role_id`) 
            REFERENCES `" . db_prefix() . "roles` (`roleid`) 
            ON DELETE RESTRICT ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ";");
    
    log_activity('Hospital Management Module - Table Created: hospital_users');
}

// ==========================================
// TABLE 2: hospital_patient_types
// ==========================================
if (!$CI->db->table_exists(db_prefix() . 'hospital_patient_types')) {
    
    $CI->db->query("CREATE TABLE `" . db_prefix() . "hospital_patient_types` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `type_name` VARCHAR(100) NOT NULL,
        `type_code` VARCHAR(50) DEFAULT NULL,
        `description` TEXT DEFAULT NULL,
        `is_active` TINYINT(1) NOT NULL DEFAULT 1,
        `display_order` INT(11) DEFAULT 0,
        PRIMARY KEY (`id`),
        UNIQUE KEY `type_name` (`type_name`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ";");
    
    // Insert default patient types
    $patient_types = [
        'Biohazard', 'Concession Cases', 'Contact Lens', 'Donor', 'DRPROJECT',
        'Emergency', 'HELPAGE', 'IGICH', 'IGICH-UVEA', 'KTM', 'Low Vision',
        'Post Operative', 'Regular', 'ROP Cognizant', 'SLS', 'SSVCB', 'SSVCJ',
        'SSVCK', 'SSVCM', 'SSVCN', 'SSVCP', 'SSVCT', 'VCA', 'VCB', 'VCJ',
        'VCK', 'VCKP', 'VCM', 'VCN', 'VCP', 'VCR', 'VCSM MADDUR', 'VCT',
        'VIIO Staff', 'VIP', 'Vision Therapy', 'Vision Therapy Cognizant',
        'Visual Rehabilitation'
    ];
    
    $display_order = 1;
    foreach ($patient_types as $type) {
        $CI->db->insert(db_prefix() . 'hospital_patient_types', [
            'type_name' => $type,
            'type_code' => strtoupper(str_replace(' ', '_', $type)),
            'is_active' => 1,
            'display_order' => $display_order++
        ]);
    }
    
    log_activity('Hospital Management Module - Table Created: hospital_patient_types');
}

// ==========================================
// TABLE 2.5: hospital_memberships (NEW - MASTER TABLE)
// ==========================================
if (!$CI->db->table_exists(db_prefix() . 'hospital_memberships')) {
    
    $CI->db->query("CREATE TABLE `" . db_prefix() . "hospital_memberships` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `membership_name` VARCHAR(100) NOT NULL COMMENT 'e.g., Gold, Silver, Platinum, Corporate',
        `membership_code` VARCHAR(50) DEFAULT NULL,
        `description` TEXT DEFAULT NULL,
        `validity_months` INT(11) DEFAULT 12 COMMENT 'How many months membership is valid',
        `benefits` TEXT DEFAULT NULL,
        `is_active` TINYINT(1) NOT NULL DEFAULT 1,
        `display_order` INT(11) DEFAULT 0,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `membership_name` (`membership_name`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ";");
    
    // Insert sample membership types
    $CI->db->insert_batch(db_prefix() . 'hospital_memberships', [
        ['membership_name' => 'Gold Membership', 'membership_code' => 'GOLD', 'validity_months' => 12, 'is_active' => 1, 'display_order' => 1],
        ['membership_name' => 'Silver Membership', 'membership_code' => 'SILVER', 'validity_months' => 6, 'is_active' => 1, 'display_order' => 2],
        ['membership_name' => 'Platinum Membership', 'membership_code' => 'PLATINUM', 'validity_months' => 24, 'is_active' => 1, 'display_order' => 3],
        ['membership_name' => 'Corporate Membership', 'membership_code' => 'CORPORATE', 'validity_months' => 12, 'is_active' => 1, 'display_order' => 4],
        ['membership_name' => 'Family Membership', 'membership_code' => 'FAMILY', 'validity_months' => 12, 'is_active' => 1, 'display_order' => 5],
    ]);
    
    log_activity('Hospital Management Module - Table Created: hospital_memberships');
}

// ==========================================
// TABLE 3: hospital_patients (UPDATED WITH MEMBERSHIP_ID)
// ==========================================
if (!$CI->db->table_exists(db_prefix() . 'hospital_patients')) {
    
    $CI->db->query("CREATE TABLE `" . db_prefix() . "hospital_patients` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `patient_number` VARCHAR(50) NOT NULL,
        
        -- Basic Patient Details
        `name` VARCHAR(200) NOT NULL,
        `gender` ENUM('male', 'female', 'other') NOT NULL,
        `dob` DATE DEFAULT NULL,
        `age` INT(3) DEFAULT NULL,
        
        -- Contact Details
        `phone` VARCHAR(30) DEFAULT NULL,
        `mobile_number` VARCHAR(30) NOT NULL,
        `email` VARCHAR(150) DEFAULT NULL,
        
        -- Address Details
        `address` TEXT DEFAULT NULL,
        `address_landmark` VARCHAR(200) DEFAULT NULL,
        `city` VARCHAR(100) DEFAULT NULL,
        `state` VARCHAR(100) DEFAULT NULL,
        `pincode` VARCHAR(20) DEFAULT NULL,
        
        -- Patient Classification (STATIC)
        `patient_type` VARCHAR(100) NOT NULL COMMENT 'Regular, VIP, etc',
        
        -- Other Hospital Registration (STATIC)
        `registered_other_hospital` TINYINT(1) DEFAULT 0 COMMENT '0=No, 1=Yes',
        `other_hospital_patient_id` VARCHAR(100) DEFAULT NULL COMMENT 'Patient ID from other hospital',
        
        -- Membership Details (ONLY FK + unique number + dates)
        `membership_id` INT(11) DEFAULT NULL COMMENT 'FK to hospital_memberships table',
        `membership_number` VARCHAR(100) DEFAULT NULL COMMENT 'Unique membership number for this patient',
        `membership_start_date` DATE DEFAULT NULL,
        `membership_expiry_date` DATE DEFAULT NULL,
        
        -- Recommendation (STATIC)
        `recommended_to_hospital` TINYINT(1) DEFAULT 0 COMMENT '0=No, 1=Yes',
        `recommended_by` VARCHAR(200) DEFAULT NULL COMMENT 'Who recommended patient to hospital',
        
        -- Blood Group & Emergency Contact (STATIC)
        `blood_group` VARCHAR(10) DEFAULT NULL COMMENT 'A+, B+, O+, AB+, A-, B-, O-, AB-',
        `emergency_contact_name` VARCHAR(200) DEFAULT NULL,
        `emergency_contact_number` VARCHAR(30) DEFAULT NULL,
        `emergency_contact_relation` VARCHAR(100) DEFAULT NULL,
        
        -- System Fields
        `created_by` INT(11) DEFAULT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        
        PRIMARY KEY (`id`),
        UNIQUE KEY `patient_number` (`patient_number`),
        KEY `mobile_number` (`mobile_number`),
        KEY `email` (`email`),
        KEY `patient_type` (`patient_type`),
        KEY `membership_id` (`membership_id`),
        KEY `created_by` (`created_by`),
        CONSTRAINT `fk_patient_membership` FOREIGN KEY (`membership_id`) 
            REFERENCES `" . db_prefix() . "hospital_memberships` (`id`) 
            ON DELETE SET NULL ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ";");
    
    log_activity('Hospital Management Module - Table Created: hospital_patients');
}
// ==========================================
// TABLE 4: hospital_appointments (CLEANED)
// ==========================================
if (!$CI->db->table_exists(db_prefix() . 'hospital_appointments')) {
    
    $CI->db->query("CREATE TABLE `" . db_prefix() . "hospital_appointments` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `appointment_number` VARCHAR(50) NOT NULL,
        `patient_id` INT(11) NOT NULL,
        
        -- Appointment Details
        `appointment_date` DATE NOT NULL,
        `appointment_time` TIME DEFAULT NULL,
        `consultant_id` INT(11) NOT NULL COMMENT 'Staff ID from staff table',
        
        -- Status
        `status` ENUM('pending', 'confirmed', 'cancelled', 'completed') NOT NULL DEFAULT 'pending',
        `notes` TEXT DEFAULT NULL,
        `cancellation_reason` TEXT DEFAULT NULL,
        
        -- System Fields
        `created_by` INT(11) DEFAULT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        
        PRIMARY KEY (`id`),
        UNIQUE KEY `appointment_number` (`appointment_number`),
        KEY `patient_id` (`patient_id`),
        KEY `consultant_id` (`consultant_id`),
        KEY `appointment_date` (`appointment_date`),
        KEY `status` (`status`),
        CONSTRAINT `fk_appointment_patient` FOREIGN KEY (`patient_id`) 
            REFERENCES `" . db_prefix() . "hospital_patients` (`id`) 
            ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT `fk_appointment_consultant` FOREIGN KEY (`consultant_id`) 
            REFERENCES `" . db_prefix() . "staff` (`staffid`) 
            ON DELETE RESTRICT ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ";");
    
    log_activity('Hospital Management Module - Table Created: hospital_appointments');
}

// ==========================================
// TABLE 5: hospital_patient_documents
// ==========================================
if (!$CI->db->table_exists(db_prefix() . 'hospital_patient_documents')) {
    
    $CI->db->query("CREATE TABLE `" . db_prefix() . "hospital_patient_documents` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `patient_id` INT(11) NOT NULL,
        `document_type` ENUM('recommendation', 'membership', 'medical_report', 'prescription', 'lab_report', 'other') NOT NULL,
        `document_name` VARCHAR(255) NOT NULL COMMENT 'Display name for document',
        `original_filename` VARCHAR(255) NOT NULL COMMENT 'Original uploaded filename',
        `file_type` VARCHAR(100) NOT NULL COMMENT 'MIME type',
        `file_size` INT(11) NOT NULL COMMENT 'File size in bytes',
        `file_data` LONGBLOB NOT NULL COMMENT 'Binary file data',
        `uploaded_by` INT(11) DEFAULT NULL COMMENT 'Staff ID who uploaded',
        `uploaded_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `notes` TEXT DEFAULT NULL,
        
        PRIMARY KEY (`id`),
        KEY `patient_id` (`patient_id`),
        KEY `document_type` (`document_type`),
        KEY `uploaded_by` (`uploaded_by`),
        CONSTRAINT `fk_patient_documents` FOREIGN KEY (`patient_id`) 
            REFERENCES `" . db_prefix() . "hospital_patients` (`id`) 
            ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ";");
    
    log_activity('Hospital Management Module - Table Created: hospital_patient_documents');
}

// ==========================================
// TABLE 6: hospital_visits
// ==========================================
if (!$CI->db->table_exists(db_prefix() . 'hospital_visits')) {
    
    $CI->db->query("CREATE TABLE `" . db_prefix() . "hospital_visits` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `visit_number` VARCHAR(50) NOT NULL,
        `patient_id` INT(11) NOT NULL,
        `appointment_id` INT(11) DEFAULT NULL,
        `consultant_id` INT(11) NOT NULL,
        
        `visit_date` DATE NOT NULL,
        `visit_time` TIME NOT NULL,
        `visit_type` ENUM('appointment', 'walk_in', 'emergency', 'follow_up') NOT NULL DEFAULT 'walk_in',
        `reason` ENUM('consultation', 'procedure', 'surgery', 'follow_up', 'emergency') NOT NULL,
        
        `chief_complaint` TEXT DEFAULT NULL,
        `diagnosis` TEXT DEFAULT NULL,
        `treatment_given` TEXT DEFAULT NULL,
        `prescription` TEXT DEFAULT NULL,
        `notes` TEXT DEFAULT NULL,
        
        `status` ENUM('ongoing', 'completed', 'cancelled') NOT NULL DEFAULT 'ongoing',
        `completed_at` DATETIME DEFAULT NULL,
        
        `created_by` INT(11) DEFAULT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        
        PRIMARY KEY (`id`),
        UNIQUE KEY `visit_number` (`visit_number`),
        KEY `patient_id` (`patient_id`),
        KEY `appointment_id` (`appointment_id`),
        KEY `consultant_id` (`consultant_id`),
        KEY `visit_date` (`visit_date`),
        KEY `status` (`status`),
        CONSTRAINT `fk_visit_patient` FOREIGN KEY (`patient_id`) 
            REFERENCES `" . db_prefix() . "hospital_patients` (`id`) 
            ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT `fk_visit_appointment` FOREIGN KEY (`appointment_id`) 
            REFERENCES `" . db_prefix() . "hospital_appointments` (`id`) 
            ON DELETE SET NULL ON UPDATE CASCADE,
        CONSTRAINT `fk_visit_consultant` FOREIGN KEY (`consultant_id`) 
            REFERENCES `" . db_prefix() . "staff` (`staffid`) 
            ON DELETE RESTRICT ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ";");
    
    log_activity('Hospital Management Module - Table Created: hospital_visits');
}

// ==========================================
// TABLE 7: hospital_visit_details (UPDATED)
// ==========================================
if (!$CI->db->table_exists(db_prefix() . 'hospital_visit_details')) {
    
    $CI->db->query("CREATE TABLE `" . db_prefix() . "hospital_visit_details` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `visit_id` INT(11) NOT NULL,
        
        -- Patient Type FOR THIS VISIT
        `patient_type_for_visit` VARCHAR(100) DEFAULT NULL,
        
        -- Fee Payment FOR THIS VISIT (NEW FIELD)
        `fee_payment` ENUM('yes', 'no', 'not_applicable') DEFAULT 'not_applicable' COMMENT 'Fee payment radio for this visit',
        `fee_payment_status` ENUM('paid', 'pending', 'waived', 'insurance') DEFAULT 'pending',
        `fee_amount` DECIMAL(10,2) DEFAULT NULL,
        `payment_method` VARCHAR(50) DEFAULT NULL,
        `insurance_details` TEXT DEFAULT NULL,
        
        -- Referral FOR THIS VISIT (renamed for clarity)
        `visit_referred_by` VARCHAR(200) DEFAULT NULL COMMENT 'Who referred for THIS specific visit',
        `referral_source` VARCHAR(200) DEFAULT NULL,
        
        -- Medical Info
        `symptoms` TEXT DEFAULT NULL,
        `medical_history` TEXT DEFAULT NULL,
        `allergies` TEXT DEFAULT NULL,
        `current_medications` TEXT DEFAULT NULL,
        
        -- Vitals
        `temperature` VARCHAR(20) DEFAULT NULL,
        `blood_pressure` VARCHAR(20) DEFAULT NULL,
        `pulse_rate` VARCHAR(20) DEFAULT NULL,
        `weight` VARCHAR(20) DEFAULT NULL,
        `height` VARCHAR(20) DEFAULT NULL,
        `spo2` VARCHAR(20) DEFAULT NULL,
        
        -- Tests
        `lab_tests_ordered` TEXT DEFAULT NULL,
        `lab_results` TEXT DEFAULT NULL,
        `imaging_ordered` TEXT DEFAULT NULL,
        `imaging_results` TEXT DEFAULT NULL,
        
        -- Follow-up
        `follow_up_required` TINYINT(1) DEFAULT 0,
        `follow_up_date` DATE DEFAULT NULL,
        `follow_up_notes` TEXT DEFAULT NULL,
        
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        
        PRIMARY KEY (`id`),
        KEY `visit_id` (`visit_id`),
        CONSTRAINT `fk_visit_detail` FOREIGN KEY (`visit_id`) 
            REFERENCES `" . db_prefix() . "hospital_visits` (`id`) 
            ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ";");
    
    log_activity('Hospital Management Module - Table Created: hospital_visit_details');
}