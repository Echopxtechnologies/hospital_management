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
// TABLE 3: hospital_patients
// ==========================================
if (!$CI->db->table_exists(db_prefix() . 'hospital_patients')) {
    
    $CI->db->query("CREATE TABLE `" . db_prefix() . "hospital_patients` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `patient_number` VARCHAR(50) NOT NULL,
        `name` VARCHAR(200) NOT NULL,
        `gender` ENUM('male', 'female', 'other') NOT NULL,
        `dob` DATE DEFAULT NULL,
        `age` INT(3) DEFAULT NULL,
        `phone` VARCHAR(30) DEFAULT NULL,
        `mobile_number` VARCHAR(30) NOT NULL,
        `email` VARCHAR(150) DEFAULT NULL,
        `address` TEXT DEFAULT NULL,
        `address_landmark` VARCHAR(200) DEFAULT NULL,
        `city` VARCHAR(100) DEFAULT NULL,
        `state` VARCHAR(100) DEFAULT NULL,
        `pincode` VARCHAR(20) DEFAULT NULL,
        `patient_type` VARCHAR(100) NOT NULL,
        `registered_other_hospital` TINYINT(1) DEFAULT 0,
        `other_hospital_patient_id` VARCHAR(100) DEFAULT NULL,
        `membership_id` VARCHAR(100) DEFAULT NULL,
        `recommended_to_hospital` TINYINT(1) DEFAULT 0,
        `recommended_by` VARCHAR(200) DEFAULT NULL,
        `blood_group` VARCHAR(10) DEFAULT NULL,
        `emergency_contact_name` VARCHAR(200) DEFAULT NULL,
        `emergency_contact_number` VARCHAR(30) DEFAULT NULL,
        `emergency_contact_relation` VARCHAR(100) DEFAULT NULL,
        `created_by` INT(11) DEFAULT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `patient_number` (`patient_number`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    
    log_activity('Hospital Management Module - Table Created: hospital_patients');
}

// ==========================================
// TABLE 4: hospital_patient_documents
// ==========================================
if (!$CI->db->table_exists(db_prefix() . 'hospital_patient_documents')) {
    
    $CI->db->query("CREATE TABLE `" . db_prefix() . "hospital_patient_documents` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `patient_id` INT(11) NOT NULL,
        `document_type` ENUM('recommendation', 'membership', 'medical_report', 'prescription', 'lab_report', 'other') NOT NULL,
        `document_name` VARCHAR(255) NOT NULL,
        `original_filename` VARCHAR(255) NOT NULL,
        `file_type` VARCHAR(100) NOT NULL,
        `file_size` INT(11) NOT NULL,
        `file_data` LONGBLOB NOT NULL,
        `uploaded_by` INT(11) DEFAULT NULL,
        `uploaded_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `notes` TEXT DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `patient_id` (`patient_id`),
        CONSTRAINT `fk_patient_documents` FOREIGN KEY (`patient_id`) 
            REFERENCES `" . db_prefix() . "hospital_patients` (`id`) 
            ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ";");
    
    log_activity('Hospital Management Module - Table Created: hospital_patient_documents');
}

// ==========================================
// TABLE 5: hospital_appointments
// ==========================================
if (!$CI->db->table_exists(db_prefix() . 'hospital_appointments')) {
    
    $CI->db->query("CREATE TABLE `" . db_prefix() . "hospital_appointments` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `appointment_number` VARCHAR(50) NOT NULL,
        `patient_id` INT(11) NOT NULL,
        `appointment_date` DATE NOT NULL,
        `appointment_time` TIME DEFAULT NULL,
        `consultant_id` INT(11) NOT NULL,
        `status` ENUM('pending', 'confirmed', 'cancelled', 'completed') NOT NULL DEFAULT 'pending',
        `time_reported` DATETIME NULL DEFAULT NULL,
        `notes` TEXT DEFAULT NULL,
        `cancellation_reason` TEXT DEFAULT NULL,
        `created_by` INT(11) DEFAULT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `appointment_number` (`appointment_number`),
        KEY `patient_id` (`patient_id`),
        KEY `consultant_id` (`consultant_id`),
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
        CONSTRAINT `fk_visit_patient` FOREIGN KEY (`patient_id`) 
            REFERENCES `" . db_prefix() . "hospital_patients` (`id`) 
            ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT `fk_visit_consultant` FOREIGN KEY (`consultant_id`) 
            REFERENCES `" . db_prefix() . "staff` (`staffid`) 
            ON DELETE RESTRICT ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;");
    
    log_activity('Hospital Management Module - Table Created: hospital_visits');
}

// ==========================================
// TABLE 7: hospital_visit_details
// ==========================================
if (!$CI->db->table_exists(db_prefix() . 'hospital_visit_details')) {
    
    $CI->db->query("CREATE TABLE `" . db_prefix() . "hospital_visit_details` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `visit_id` INT(11) NOT NULL,
        `patient_type_for_visit` VARCHAR(100) DEFAULT NULL,
        `fee_payment` ENUM('yes', 'no', 'not_applicable') DEFAULT 'not_applicable',
        `fee_payment_status` ENUM('paid', 'pending', 'waived', 'insurance') DEFAULT 'pending',
        `fee_amount` DECIMAL(10,2) DEFAULT NULL,
        `additional_fee` DECIMAL(10,2) DEFAULT 0.00,
        `total_fee` DECIMAL(10,2) DEFAULT 0.00,
        `payment_method` VARCHAR(50) DEFAULT NULL,
        `insurance_details` TEXT DEFAULT NULL,
        `visit_referred_by` VARCHAR(200) DEFAULT NULL,
        `referral_source` VARCHAR(200) DEFAULT NULL,
        `symptoms` TEXT DEFAULT NULL,
        `medical_history` TEXT DEFAULT NULL,
        `allergies` TEXT DEFAULT NULL,
        `follow_up_required` TINYINT(1) DEFAULT 0,
        `follow_up_date` DATE DEFAULT NULL,
        `follow_up_notes` TEXT DEFAULT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `systemic_history` TEXT DEFAULT NULL,
        `family_history` TEXT DEFAULT NULL,
        `ocular_diseases` TEXT DEFAULT NULL,
        `surgical_history` TEXT DEFAULT NULL,
        `medication` TEXT DEFAULT NULL,
        `present_complaint` TEXT DEFAULT NULL,
        `dilating_drops` VARCHAR(255) DEFAULT NULL,
        `examination_data` LONGTEXT DEFAULT NULL,
        `retinoscopy_data` LONGTEXT DEFAULT NULL,
        `opinion_plan_of_care` TEXT DEFAULT NULL,
        `icd_codes` TEXT DEFAULT NULL,
        `review_required` ENUM('yes', 'no') DEFAULT 'no',
        `review_period` DATE DEFAULT NULL,
        `systematic_exam_ordered` TEXT DEFAULT NULL,
        `medicine_prescription` LONGTEXT DEFAULT NULL,
        `medicine_prescription_details` LONGTEXT DEFAULT NULL,
        `medicine_instructions` TEXT DEFAULT NULL,
        `spectacle_right_sph` VARCHAR(20) DEFAULT NULL,
        `spectacle_right_cyl` VARCHAR(20) DEFAULT NULL,
        `spectacle_right_axis` VARCHAR(20) DEFAULT NULL,
        `spectacle_right_near_vision` VARCHAR(20) DEFAULT NULL,
        `spectacle_right_distance_vision` VARCHAR(20) DEFAULT NULL,
        `spectacle_left_sph` VARCHAR(20) DEFAULT NULL,
        `spectacle_left_cyl` VARCHAR(20) DEFAULT NULL,
        `spectacle_left_axis` VARCHAR(20) DEFAULT NULL,
        `spectacle_left_near_vision` VARCHAR(20) DEFAULT NULL,
        `spectacle_left_distance_vision` VARCHAR(20) DEFAULT NULL,
        `bifocals` ENUM('yes', 'no') DEFAULT 'no',
        `back_vertex` VARCHAR(50) DEFAULT NULL,
        `interpupillary` VARCHAR(50) DEFAULT NULL,
        `spectacle_remarks` TEXT DEFAULT NULL,
        `lens_type` VARCHAR(100) DEFAULT NULL,
        `pediatric_notes` TEXT DEFAULT NULL,
        `lab_tests` LONGTEXT DEFAULT NULL,
        `procedure_diagnostics` LONGTEXT DEFAULT NULL,
        `procedure_treatment` LONGTEXT DEFAULT NULL,
        `surgical_counselling` LONGTEXT DEFAULT NULL,
        `is_completed` TINYINT(1) DEFAULT 0,
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
        `category_name` VARCHAR(150) NOT NULL,
        `category_code` VARCHAR(100) DEFAULT NULL,
        `description` TEXT DEFAULT NULL,
        `display_order` INT(11) DEFAULT 0,
        `is_active` TINYINT(1) NOT NULL DEFAULT 1,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `category_name` (`category_name`)
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
        `cancellation_reason` TEXT NULL,
        `cancelled_by` INT(11) NULL,
        `cancelled_at` DATETIME NULL,
        `priority` ENUM('normal', 'urgent', 'emergency') DEFAULT 'normal',
        `doctor_notes` TEXT DEFAULT NULL,
        `lab_notes` TEXT DEFAULT NULL,
        `surgery_type` VARCHAR(100) DEFAULT NULL,
        `surgery_details` TEXT DEFAULT NULL,
        `requested_by` INT(11) DEFAULT NULL,
        `assigned_technician_id` INT(11) NULL,
        `assigned_at` DATETIME NULL,
        `assigned_by` INT(11) NULL,
        `approved_by` INT(11) DEFAULT NULL,
        `approved_at` DATETIME DEFAULT NULL,
        `completed_at` DATETIME DEFAULT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `request_number` (`request_number`),
        KEY `visit_id` (`visit_id`),
        KEY `category_id` (`category_id`),
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
// TABLE 12: hospital_payments (NEW)
// ==========================================
if (!$CI->db->table_exists(db_prefix() . 'hospital_payments')) {
    
    $CI->db->query("CREATE TABLE `" . db_prefix() . "hospital_payments` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `payment_number` VARCHAR(50) NOT NULL,
        `patient_id` INT(11) NOT NULL,
        `visit_id` INT(11) DEFAULT NULL,
        `visit_request_id` INT(11) DEFAULT NULL,
        `subtotal_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        `discount_percentage` DECIMAL(5,2) DEFAULT 0.00,
        `discount_amount` DECIMAL(10,2) DEFAULT 0.00,
        `tax_amount` DECIMAL(10,2) DEFAULT 0.00,
        `final_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        `paid_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        `balance_amount` DECIMAL(10,2) DEFAULT 0.00,
        `payment_status` ENUM('unpaid', 'partial', 'paid', 'refunded', 'cancelled') NOT NULL DEFAULT 'unpaid',
        `payment_method` ENUM('cash', 'card', 'upi', 'netbanking', 'cheque', 'insurance', 'other') DEFAULT NULL,
        `payment_date` DATETIME DEFAULT NULL,
        `transaction_id` VARCHAR(100) DEFAULT NULL,
        `payment_reference` VARCHAR(255) DEFAULT NULL,
        `patient_type` VARCHAR(100) DEFAULT NULL,
        `discount_reason` TEXT DEFAULT NULL,
        `request_category` VARCHAR(150) DEFAULT NULL,
        `request_description` TEXT DEFAULT NULL,
        `refund_amount` DECIMAL(10,2) DEFAULT 0.00,
        `refund_reason` TEXT DEFAULT NULL,
        `refunded_by` INT(11) DEFAULT NULL,
        `refunded_at` DATETIME DEFAULT NULL,
        `notes` TEXT DEFAULT NULL,
        `internal_notes` TEXT DEFAULT NULL,
        `collected_by` INT(11) DEFAULT NULL,
        `approved_by` INT(11) DEFAULT NULL,
        `created_by` INT(11) DEFAULT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `payment_number` (`payment_number`),
        KEY `patient_id` (`patient_id`),
        KEY `visit_id` (`visit_id`),
        KEY `visit_request_id` (`visit_request_id`),
        CONSTRAINT `fk_payment_patient` FOREIGN KEY (`patient_id`) 
            REFERENCES `" . db_prefix() . "hospital_patients` (`id`) 
            ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT `fk_payment_visit` FOREIGN KEY (`visit_id`) 
            REFERENCES `" . db_prefix() . "hospital_visits` (`id`) 
            ON DELETE SET NULL ON UPDATE CASCADE,
        CONSTRAINT `fk_payment_visit_request` FOREIGN KEY (`visit_request_id`) 
            REFERENCES `" . db_prefix() . "hospital_visit_requests` (`id`) 
            ON DELETE SET NULL ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;");
    
    log_activity('Hospital Management - Table Created: hospital_payments');
}

// ==========================================
// TABLE 13: hospital_medicines
// ==========================================
if (!$CI->db->table_exists(db_prefix() . 'hospital_medicines')) {
    
    $CI->db->query("CREATE TABLE `" . db_prefix() . "hospital_medicines` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `medicine_name` VARCHAR(255) NOT NULL,
        `generic_name` VARCHAR(255) DEFAULT NULL,
        `category` ENUM('eye_drop', 'tablet', 'capsule', 'injection', 'ointment', 'syrup', 'other') NOT NULL DEFAULT 'eye_drop',
        `strength` VARCHAR(100) DEFAULT NULL,
        `unit` VARCHAR(50) DEFAULT NULL,
        `manufacturer` VARCHAR(255) DEFAULT NULL,
        `price` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        `description` TEXT DEFAULT NULL,
        `side_effects` TEXT DEFAULT NULL,
        `is_active` TINYINT(1) NOT NULL DEFAULT 1,
        `display_order` INT(11) DEFAULT 0,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;");
    
    log_activity('Hospital Management - Table Created: hospital_medicines');
}

// ==========================================
// TABLE 14: hospital_surgery_types (NEW)
// ==========================================
if (!$CI->db->table_exists(db_prefix() . 'hospital_surgery_types')) {
    
    $CI->db->query("CREATE TABLE `" . db_prefix() . "hospital_surgery_types` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `surgery_name` VARCHAR(255) NOT NULL,
        `surgery_code` VARCHAR(100) DEFAULT NULL,
        `category` VARCHAR(100) DEFAULT NULL,
        `description` TEXT DEFAULT NULL,
        `is_active` TINYINT(1) NOT NULL DEFAULT 1,
        `display_order` INT(11) DEFAULT 0,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    
    log_activity('Hospital Management - Table Created: hospital_surgery_types');
}

// ==========================================
// TABLE 15: hospital_surgery_requests (NEW)
// ==========================================
if (!$CI->db->table_exists(db_prefix() . 'hospital_surgery_requests')) {
    
    $CI->db->query("CREATE TABLE `" . db_prefix() . "hospital_surgery_requests` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `visit_id` INT(11) DEFAULT NULL,
        `patient_id` INT(11) NOT NULL,
        `request_type` ENUM('simple', 'detailed') NOT NULL DEFAULT 'simple',
        `surgery_type_id` INT(11) DEFAULT NULL,
        `surgery_details` TEXT DEFAULT NULL,
        `doing_surgery` VARCHAR(255) DEFAULT NULL,
        `surgery_name` VARCHAR(255) DEFAULT NULL,
        `lens_preference` VARCHAR(255) DEFAULT NULL,
        `standby_lens` VARCHAR(255) DEFAULT NULL,
        `disposables_instruments` TEXT DEFAULT NULL,
        `admission_hours_before` INT(11) DEFAULT NULL,
        `overnight_admission` TINYINT(1) DEFAULT 0,
        `special_instructions` TEXT DEFAULT NULL,
        `nil_oral_instructions` TEXT DEFAULT NULL,
        `preferred_datetime` DATETIME DEFAULT NULL,
        `lens_power` VARCHAR(100) DEFAULT NULL,
        `a_constant_used` VARCHAR(100) DEFAULT NULL,
        `formula_used` VARCHAR(100) DEFAULT NULL,
        `anesthesia` VARCHAR(100) DEFAULT NULL,
        `status` ENUM('pending', 'scheduled', 'completed', 'cancelled') DEFAULT 'pending',
        `requested_by` INT(11) DEFAULT NULL,
        `requested_at` DATETIME DEFAULT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `visit_id` (`visit_id`),
        KEY `patient_id` (`patient_id`),
        KEY `surgery_type_id` (`surgery_type_id`),
        CONSTRAINT `fk_surgery_request_visit` FOREIGN KEY (`visit_id`) 
            REFERENCES `" . db_prefix() . "hospital_visits` (`id`) 
            ON DELETE SET NULL ON UPDATE CASCADE,
        CONSTRAINT `fk_surgery_request_patient` FOREIGN KEY (`patient_id`) 
            REFERENCES `" . db_prefix() . "hospital_patients` (`id`) 
            ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT `fk_surgery_request_type` FOREIGN KEY (`surgery_type_id`) 
            REFERENCES `" . db_prefix() . "hospital_surgery_types` (`id`) 
            ON DELETE SET NULL ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    
    log_activity('Hospital Management - Table Created: hospital_surgery_requests');
}

log_activity('Hospital Management Module - Installation Complete');