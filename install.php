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
// TABLE 3: hospital_patients (WITH MEMBERSHIP_ID)
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
        `membership_id` VARCHAR(100) DEFAULT NULL COMMENT 'Patient membership ID - simple text field',

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
        KEY `created_by` (`created_by`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    
    log_activity('Hospital Management Module - Table Created: hospital_patients');
}

// ==========================================
// TABLE 4: hospital_appointments (FIXED - Added updated_at)
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
        `time_reported` DATETIME NULL DEFAULT NULL,
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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    
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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;");
    
    log_activity('Hospital Management Module - Table Created: hospital_visits');
}

// ==========================================
// TABLE 7: hospital_visit_details (COMPLETELY REWRITTEN - ALL 58 COLUMNS)
// ==========================================
if (!$CI->db->table_exists(db_prefix() . 'hospital_visit_details')) {
    
    $CI->db->query("CREATE TABLE `" . db_prefix() . "hospital_visit_details` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `visit_id` INT(11) NOT NULL,
        
        -- Patient Type FOR THIS VISIT
        `patient_type_for_visit` VARCHAR(100) DEFAULT NULL,
        
        -- Fee Payment FOR THIS VISIT
        `fee_payment` ENUM('yes', 'no', 'not_applicable') DEFAULT 'not_applicable' COMMENT 'Fee payment status for this visit',
        `fee_payment_status` ENUM('paid', 'pending', 'waived', 'insurance') DEFAULT 'pending',
        `fee_amount` DECIMAL(10,2) DEFAULT NULL,
        `additional_fee` DECIMAL(10,2) DEFAULT 0.00 COMMENT 'Additional consultation/procedure fee',
        `total_fee` DECIMAL(10,2) DEFAULT 0.00 COMMENT 'Total = fee_amount + additional_fee',
        `payment_method` VARCHAR(50) DEFAULT NULL,
        `insurance_details` TEXT DEFAULT NULL,
        
        -- Referral FOR THIS VISIT
        `visit_referred_by` VARCHAR(200) DEFAULT NULL COMMENT 'Who referred for THIS specific visit',
        `referral_source` VARCHAR(200) DEFAULT NULL,
        
        -- Medical History Info
        `symptoms` TEXT DEFAULT NULL,
        `medical_history` TEXT DEFAULT NULL,
        `allergies` TEXT DEFAULT NULL,
        
        -- Follow-up
        `follow_up_required` TINYINT(1) DEFAULT 0,
        `follow_up_date` DATE DEFAULT NULL,
        `follow_up_notes` TEXT DEFAULT NULL,
        
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        
        -- Additional Ophthalmology History Fields
        `systemic_history` TEXT DEFAULT NULL,
        `family_history` TEXT DEFAULT NULL,
        `ocular_diseases` TEXT DEFAULT NULL,
        `surgical_history` TEXT DEFAULT NULL,
        `medication` TEXT DEFAULT NULL,
        `present_complaint` TEXT DEFAULT NULL,
        `dilating_drops` VARCHAR(255) DEFAULT NULL,
        
        -- Examination Data (JSON)
        `examination_data` LONGTEXT DEFAULT NULL COMMENT 'JSON: {visual_acuity_aided: {right: \"\", left: \"\"}, visual_acuity_unaided: {...}, ...}',
        `retinoscopy_data` LONGTEXT DEFAULT NULL COMMENT 'JSON: {right: {ds, dc, axis, add}, left: {...}, type_of_dilatation}',
        
        -- Opinion & Diagnosis
        `opinion_plan_of_care` TEXT DEFAULT NULL,
        `icd_codes` TEXT DEFAULT NULL COMMENT 'Comma-separated ICD codes',
        `review_required` ENUM('yes', 'no') DEFAULT 'no',
        `review_period` DATE DEFAULT NULL,
        `systematic_exam_ordered` TEXT DEFAULT NULL,
        
        -- Medicine Prescription (JSON)
        `medicine_prescription` LONGTEXT DEFAULT NULL COMMENT 'JSON array of medicines',
        `medicine_prescription_details` LONGTEXT DEFAULT NULL COMMENT 'JSON array: [{medicine_id, medicine_name, category, price, eye, dose, unit, frequency, instructions}]',
        
        -- Spectacle Prescription - Right Eye
        `spectacle_right_sph` VARCHAR(20) DEFAULT NULL,
        `spectacle_right_cyl` VARCHAR(20) DEFAULT NULL,
        `spectacle_right_axis` VARCHAR(20) DEFAULT NULL,
        `spectacle_right_near_vision` VARCHAR(20) DEFAULT NULL,
        `spectacle_right_distance_vision` VARCHAR(20) DEFAULT NULL,
        
        -- Spectacle Prescription - Left Eye
        `spectacle_left_sph` VARCHAR(20) DEFAULT NULL,
        `spectacle_left_cyl` VARCHAR(20) DEFAULT NULL,
        `spectacle_left_axis` VARCHAR(20) DEFAULT NULL,
        `spectacle_left_near_vision` VARCHAR(20) DEFAULT NULL,
        `spectacle_left_distance_vision` VARCHAR(20) DEFAULT NULL,
        
        -- Spectacle Additional Details
        `bifocals` ENUM('yes', 'no') DEFAULT 'no',
        `back_vertex` VARCHAR(50) DEFAULT NULL,
        `interpupillary` VARCHAR(50) DEFAULT NULL,
        `spectacle_remarks` TEXT DEFAULT NULL,
        `lens_type` VARCHAR(100) DEFAULT NULL,
        
        -- Pediatric Notes
        `pediatric_notes` TEXT DEFAULT NULL,
        
        -- Lab Tests & Procedures (JSON)
        `lab_tests` LONGTEXT DEFAULT NULL COMMENT 'JSON: {blood_investigation: [], biochemistry: [], ...}',
        `procedure_diagnostics` LONGTEXT DEFAULT NULL COMMENT 'JSON array of selected procedures',
        `procedure_treatment` LONGTEXT DEFAULT NULL COMMENT 'JSON array',
        `surgical_counselling` LONGTEXT DEFAULT NULL COMMENT 'JSON: {simple: {...}, detailed: {...}}',
        
        -- Visit Completion Status
        `is_completed` TINYINT(1) DEFAULT 0 COMMENT '1 = Visit completed and saved',
        `completed_by` INT(11) DEFAULT NULL,
        
        PRIMARY KEY (`id`),
        KEY `visit_id` (`visit_id`),
        CONSTRAINT `fk_visit_detail` FOREIGN KEY (`visit_id`) 
            REFERENCES `" . db_prefix() . "hospital_visits` (`id`) 
            ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;");
    
    log_activity('Hospital Management Module - Table Created: hospital_visit_details');
}

// ==========================================
// TABLE 8: hospital_request_categories
// ==========================================
if (!$CI->db->table_exists(db_prefix() . 'hospital_request_categories')) {
    
    $CI->db->query("CREATE TABLE `" . db_prefix() . "hospital_request_categories` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `category_name` VARCHAR(100) NOT NULL,
        `category_code` VARCHAR(50) NOT NULL,
        `description` TEXT DEFAULT NULL,
        `display_order` INT(11) DEFAULT 0,
        `is_active` TINYINT(1) NOT NULL DEFAULT 1,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `category_code` (`category_code`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;");
    
    $CI->db->insert_batch(db_prefix() . 'hospital_request_categories', [
        ['category_name' => 'Lab Tests', 'category_code' => 'LAB_TESTS', 'display_order' => 1, 'is_active' => 1],
        ['category_name' => 'Procedure Diagnostics', 'category_code' => 'PROCEDURE_DIAGNOSTICS', 'display_order' => 2, 'is_active' => 1],
        ['category_name' => 'Procedure Treatment', 'category_code' => 'PROCEDURE_TREATMENT', 'display_order' => 3, 'is_active' => 1],
        ['category_name' => 'Surgical Counselling', 'category_code' => 'SURGICAL_COUNSELLING', 'display_order' => 4, 'is_active' => 1]
    ]);
    
    log_activity('Hospital Management - Table Created: hospital_request_categories');
}

// ==========================================
// TABLE 9: hospital_request_items
// ==========================================
if (!$CI->db->table_exists(db_prefix() . 'hospital_request_items')) {
    
    $CI->db->query("CREATE TABLE `" . db_prefix() . "hospital_request_items` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `category_id` INT(11) NOT NULL,
        `subcategory_name` VARCHAR(150) DEFAULT NULL,
        `item_name` VARCHAR(255) NOT NULL,
        `item_code` VARCHAR(100) DEFAULT NULL,
        `price` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        `description` TEXT DEFAULT NULL,
        `display_order` INT(11) DEFAULT 0,
        `is_active` TINYINT(1) NOT NULL DEFAULT 1,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `category_id` (`category_id`),
        KEY `subcategory_name` (`subcategory_name`),
        KEY `item_code` (`item_code`),
        CONSTRAINT `fk_request_item_category` FOREIGN KEY (`category_id`) 
            REFERENCES `" . db_prefix() . "hospital_request_categories` (`id`) 
            ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;");
    
    log_activity('Hospital Management - Table Created: hospital_request_items');
}

// ==========================================
// TABLE 10: hospital_visit_requests
// ==========================================
if (!$CI->db->table_exists(db_prefix() . 'hospital_visit_requests')) {
    
    $CI->db->query("CREATE TABLE `" . db_prefix() . "hospital_visit_requests` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `visit_id` INT(11) NOT NULL,
        `request_number` VARCHAR(50) NOT NULL,
        `category_id` INT(11) NOT NULL,
        `total_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        `discount_amount` DECIMAL(10,2) DEFAULT 0.00,
        `final_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        `status` ENUM('pending', 'approved', 'in_progress', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
        `priority` ENUM('normal', 'urgent', 'emergency') DEFAULT 'normal',
        `doctor_notes` TEXT DEFAULT NULL,
        `lab_notes` TEXT DEFAULT NULL,
        `surgery_type` VARCHAR(100) DEFAULT NULL,
        `surgery_details` TEXT DEFAULT NULL,
        `requested_by` INT(11) DEFAULT NULL,
        `approved_by` INT(11) DEFAULT NULL,
        `approved_at` DATETIME DEFAULT NULL,
        `completed_at` DATETIME DEFAULT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `request_number` (`request_number`),
        KEY `visit_id` (`visit_id`),
        KEY `category_id` (`category_id`),
        KEY `status` (`status`),
        CONSTRAINT `fk_visit_request_visit` FOREIGN KEY (`visit_id`) 
            REFERENCES `" . db_prefix() . "hospital_visits` (`id`) 
            ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT `fk_visit_request_category` FOREIGN KEY (`category_id`) 
            REFERENCES `" . db_prefix() . "hospital_request_categories` (`id`) 
            ON DELETE RESTRICT ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;");
    
    log_activity('Hospital Management - Table Created: hospital_visit_requests');
}

// ==========================================
// TABLE 11: hospital_visit_request_items
// ==========================================
if (!$CI->db->table_exists(db_prefix() . 'hospital_visit_request_items')) {
    
    $CI->db->query("CREATE TABLE `" . db_prefix() . "hospital_visit_request_items` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `request_id` INT(11) NOT NULL,
        `item_id` INT(11) NOT NULL,
        `quantity` INT(11) NOT NULL DEFAULT 1,
        `unit_price` DECIMAL(10,2) NOT NULL,
        `total_price` DECIMAL(10,2) NOT NULL,
        `notes` TEXT DEFAULT NULL,
        `result` TEXT DEFAULT NULL,
        `result_date` DATETIME DEFAULT NULL,
        `result_by` INT(11) DEFAULT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `request_id` (`request_id`),
        KEY `item_id` (`item_id`),
        CONSTRAINT `fk_request_item_request` FOREIGN KEY (`request_id`) 
            REFERENCES `" . db_prefix() . "hospital_visit_requests` (`id`) 
            ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT `fk_request_item_item` FOREIGN KEY (`item_id`) 
            REFERENCES `" . db_prefix() . "hospital_request_items` (`id`) 
            ON DELETE RESTRICT ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;");
    
    log_activity('Hospital Management - Table Created: hospital_visit_request_items');
}

// ==========================================
// TABLE 12: hospital_medicines (If you have this table)
// ==========================================
if (!$CI->db->table_exists(db_prefix() . 'hospital_medicines')) {
    
    $CI->db->query("CREATE TABLE `" . db_prefix() . "hospital_medicines` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `medicine_name` VARCHAR(255) NOT NULL,
        `generic_name` VARCHAR(255) DEFAULT NULL,
        `category` ENUM('eye_drop', 'tablet', 'capsule', 'injection', 'ointment', 'syrup', 'other') NOT NULL DEFAULT 'eye_drop',
        `strength` VARCHAR(100) DEFAULT NULL COMMENT 'e.g., 0.5%, 500mg',
        `unit` VARCHAR(50) DEFAULT NULL COMMENT 'e.g., ml, mg, drops',
        `manufacturer` VARCHAR(255) DEFAULT NULL,
        `price` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        `description` TEXT DEFAULT NULL,
        `side_effects` TEXT DEFAULT NULL,
        `is_active` TINYINT(1) NOT NULL DEFAULT 1,
        `display_order` INT(11) DEFAULT 0,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `medicine_name` (`medicine_name`),
        KEY `category` (`category`),
        KEY `is_active` (`is_active`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;");
    
    log_activity('Hospital Management - Table Created: hospital_medicines');
}



// -- Only update the main requests table
// ALTER TABLE `tblhospital_visit_requests` 
// ADD COLUMN `assigned_technician_id` INT(11) NULL AFTER `requested_by`,
// ADD COLUMN `assigned_at` DATETIME NULL AFTER `assigned_technician_id`,
// ADD COLUMN `assigned_by` INT(11) NULL COMMENT 'Receptionist who assigned' AFTER `assigned_at`;

// -- Also add a cancellation reason field
// ALTER TABLE `tblhospital_visit_requests`
// ADD COLUMN `cancellation_reason` TEXT NULL AFTER `status`,
// ADD COLUMN `cancelled_by` INT(11) NULL AFTER `cancellation_reason`,
// ADD COLUMN `cancelled_at` DATETIME NULL AFTER `cancelled_by`;

// CREATE TABLE `tblhospital_surgery_types` (
//     `id` INT(11) NOT NULL AUTO_INCREMENT,
//     `surgery_name` VARCHAR(255) NOT NULL,
//     `surgery_code` VARCHAR(100) DEFAULT NULL,
//     `category` VARCHAR(100) DEFAULT NULL COMMENT 'Cataract, Glaucoma, Retina, etc',
//     `description` TEXT DEFAULT NULL,
//     `is_active` TINYINT(1) NOT NULL DEFAULT 1,
//     `display_order` INT(11) DEFAULT 0,
//     `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
//     PRIMARY KEY (`id`)
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


// -- Remove foreign key constraint
// ALTER TABLE `tblhospital_surgery_requests` 
// DROP FOREIGN KEY `fk_surgery_request_visit`;

// -- Make visit_id nullable
// ALTER TABLE `tblhospital_surgery_requests` 
// MODIFY `visit_id` INT(11) NULL;

// -- Add it back as optional (ON DELETE SET NULL instead of CASCADE)
// ALTER TABLE `tblhospital_surgery_requests`
// ADD CONSTRAINT `fk_surgery_request_visit` 
// FOREIGN KEY (`visit_id`) REFERENCES `tblhospital_visits` (`id`) 
// ON DELETE SET NULL ON UPDATE CASCADE;