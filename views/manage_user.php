<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<style>
/* Form styling with clean validation */
.form-container {
    background: #ffffff;
    border: 1px solid #e0e0e0;
    border-radius: 6px;
    margin-bottom: 25px;
}

.form-header {
    background: #f8f9fa;
    border-bottom: 1px solid #e0e0e0;
    padding: 20px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.form-header h4 {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
    color: #2c3e50;
}

.form-header h4 i {
    margin-right: 8px;
    color: #7f8c8d;
}

.form-body {
    padding: 30px;
}

.form-control {
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 10px 14px;
    font-size: 14px;
    transition: all 0.2s ease;
    height: 42px;
}

.form-control:focus {
    border-color: #2c3e50;
    box-shadow: 0 0 0 2px rgba(44, 62, 80, 0.1);
    outline: none;
}

textarea.form-control {
    height: auto;
    min-height: 90px;
    resize: vertical;
}

/* Validation States - CLEAN VERSION */
.form-control.is-valid {
    border-color: #28a745;
    padding-right: calc(1.5em + 0.75rem);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3e%3cpath fill='%2328a745' d='M10.97 4.97a.75.75 0 0 1 1.07 1.05l-5 5a.75.75 0 0 1-1.08-.02L3.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 4.49-4.45z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.form-control.is-invalid {
    border-color: #dc3545;
    padding-right: calc(1.5em + 0.75rem);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.invalid-feedback {
    display: none;
    margin-top: 6px;
    font-size: 13px;
    color: #dc3545;
    font-weight: 500;
}

.form-control.is-invalid ~ .invalid-feedback {
    display: block;
}

.valid-feedback {
    display: none;
    margin-top: 6px;
    font-size: 13px;
    color: #28a745;
    font-weight: 500;
}

.form-control.is-valid ~ .valid-feedback {
    display: block;
}

.control-label {
    font-weight: 600;
    color: #2c3e50;
    font-size: 14px;
    margin-bottom: 8px;
}

.text-danger {
    color: #dc3545;
}

.char-counter {
    font-size: 11px;
    color: #6c757d;
    margin-top: 3px;
    display: block;
}

.char-counter.warning {
    color: #dc3545;
    font-weight: 600;
}

.role-select-wrapper {
    display: flex;
    gap: 10px;
}

.role-select-wrapper select {
    flex: 1;
}

.checkbox-wrapper {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 15px;
    display: flex;
    align-items: center;
}

.checkbox-wrapper input[type="checkbox"] {
    width: 18px;
    height: 18px;
    margin-right: 10px;
    cursor: pointer;
}

.checkbox-wrapper label {
    margin: 0;
    font-weight: 500;
    color: #2c3e50;
    cursor: pointer;
    font-size: 14px;
}

.form-actions {
    border-top: 1px solid #e0e0e0;
    padding: 20px 30px;
    background: #f8f9fa;
    text-align: right;
}

.btn-modern {
    padding: 10px 24px;
    font-size: 14px;
    font-weight: 600;
    border-radius: 6px;
    transition: all 0.2s ease;
    border: none;
}

.btn-dark-modern {
    background: #2c3e50;
    color: #ffffff;
}

.btn-dark-modern:hover {
    background: #1a252f;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(44, 62, 80, 0.3);
}

.btn-clean {
    background: #ffffff;
    border: 1px solid #dee2e6;
    color: #6c757d;
    padding: 10px 24px;
    font-size: 14px;
    font-weight: 500;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.btn-clean:hover {
    background: #f8f9fa;
    border-color: #adb5bd;
    color: #495057;
}

.btn-loading {
    position: relative;
    color: transparent !important;
    pointer-events: none;
}

.btn-loading::after {
    content: "";
    position: absolute;
    width: 16px;
    height: 16px;
    top: 50%;
    left: 50%;
    margin-left: -8px;
    margin-top: -8px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spinner 0.6s linear infinite;
}

@keyframes spinner {
    to { transform: rotate(360deg); }
}

.modal-content {
    border-radius: 6px;
    border: 1px solid #e0e0e0;
}

.modal-header {
    background: #f8f9fa;
    border-bottom: 1px solid #e0e0e0;
    padding: 20px 30px;
}

.modal-title {
    font-size: 18px;
    font-weight: 600;
    color: #2c3e50;
}

.modal-body {
    padding: 30px;
}

.modal-footer {
    background: #f8f9fa;
    border-top: 1px solid #e0e0e0;
    padding: 15px 30px;
}

.help-block {
    font-size: 12px;
    color: #6c757d;
    margin-top: 5px;
}

/* Error Summary Box */
.error-summary {
    background: #fff3cd;
    border: 1px solid #ffc107;
    border-radius: 6px;
    padding: 15px 20px;
    margin-bottom: 20px;
    display: none;
}

.error-summary.show {
    display: block;
}

.error-summary-title {
    font-weight: 600;
    color: #856404;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.error-summary-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.error-summary-list li {
    padding: 5px 0;
    color: #856404;
    font-size: 14px;
}

.error-summary-list li i {
    margin-right: 8px;
}
</style>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="form-container">
                    <div class="form-header">
                        <h4>
                            <i class="fa fa-user"></i> 
                            <?php echo isset($user) ? 'Edit User' : 'Create New User'; ?>
                        </h4>
                        <a href="<?php echo admin_url('hospital_management/users'); ?>" class="btn-clean">
                            <i class="fa fa-arrow-left"></i> Back to Users
                        </a>
                    </div>
                    
                    <div class="form-body">
                        <!-- Error Summary Box -->
                        <div class="error-summary" id="errorSummary">
                            <div class="error-summary-title">
                                <i class="fa fa-exclamation-triangle"></i>
                                <span>Please fix the following errors:</span>
                            </div>
                            <ul class="error-summary-list" id="errorList"></ul>
                        </div>
                        
                        <?php echo form_open('', ['id' => 'user_form', 'autocomplete' => 'off']); ?>
                        
                        <?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                        
                        <?php if (isset($user)) { ?>
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?>">
                        <?php } ?>
                        
                        <div class="row">
                            <!-- First Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name" class="control-label">
                                        First Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           id="first_name" 
                                           name="first_name" 
                                           class="form-control" 
                                           value="<?php echo isset($user) ? htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8') : ''; ?>"
                                           placeholder="Enter first name"
                                           maxlength="50"
                                           required>
                                    <span class="char-counter" id="first_name_counter">0/50 characters</span>
                                    <div class="invalid-feedback"></div>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                            </div>
                            
                            <!-- Last Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">
                                        Last Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           id="last_name" 
                                           name="last_name" 
                                           class="form-control" 
                                           value="<?php echo isset($user) ? htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8') : ''; ?>"
                                           placeholder="Enter last name"
                                           maxlength="50"
                                           required>
                                    <span class="char-counter" id="last_name_counter">0/50 characters</span>
                                    <div class="invalid-feedback"></div>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="control-label">
                                        Email Address <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           class="form-control" 
                                           value="<?php echo isset($user) ? htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8') : ''; ?>"
                                           placeholder="example@hospital.com"
                                           maxlength="150"
                                           required>
                                    <div class="invalid-feedback"></div>
                                    <div class="valid-feedback">Email is available!</div>
                                </div>
                            </div>
                            
                            <!-- Password -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="control-label">
                                        Password 
                                        <?php if (!isset($user)) { ?>
                                            <span class="text-danger">*</span>
                                        <?php } ?>
                                    </label>
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           class="form-control" 
                                           placeholder="<?php echo isset($user) ? 'Leave blank to keep current password' : 'Enter password'; ?>"
                                           autocomplete="new-password"
                                           maxlength="255"
                                           <?php echo !isset($user) ? 'required' : ''; ?>>
                                    <div class="invalid-feedback"></div>
                                    <div class="valid-feedback">Password is strong!</div>
                                    <span class="help-block">
                                        <?php echo isset($user) ? 'Leave blank to keep existing password' : 'Minimum 3 characters recommended'; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- Role -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role_id" class="control-label">
                                        User Role <span class="text-danger">*</span>
                                    </label>
                                    <div class="role-select-wrapper">
                                        <select id="role_id" 
                                                name="role_id" 
                                                class="form-control selectpicker" 
                                                data-live-search="true"
                                                required>
                                            <option value="">-- Select Role --</option>
                                            <?php foreach ($roles as $role) { ?>
                                                <option value="<?php echo htmlspecialchars($role['roleid'], ENT_QUOTES, 'UTF-8'); ?>"
                                                        <?php echo (isset($user) && $user->role_id == $role['roleid']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($role['name'], ENT_QUOTES, 'UTF-8'); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <button type="button" 
                                                class="btn btn-default" 
                                                data-toggle="modal" 
                                                data-target="#createRoleModal"
                                                title="Create new role">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                    <div class="valid-feedback">Role selected!</div>
                                </div>
                            </div>
                            
                            <!-- Phone Number -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_number" class="control-label">
                                        Phone Number
                                    </label>
                                    <input type="tel" 
                                           id="phone_number" 
                                           name="phone_number" 
                                           class="form-control" 
                                           value="<?php echo isset($user) ? htmlspecialchars($user->phone_number, ENT_QUOTES, 'UTF-8') : ''; ?>"
                                           placeholder="+91 98765 43210"
                                           maxlength="30">
                                    <div class="invalid-feedback"></div>
                                    <div class="valid-feedback">Valid phone number!</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- Landline Number -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="landline_number" class="control-label">
                                        Landline Number
                                    </label>
                                    <input type="tel" 
                                           id="landline_number" 
                                           name="landline_number" 
                                           class="form-control" 
                                           value="<?php echo isset($user) ? htmlspecialchars($user->landline_number, ENT_QUOTES, 'UTF-8') : ''; ?>"
                                           placeholder="080 1234 5678"
                                           maxlength="30">
                                    <div class="invalid-feedback"></div>
                                    <div class="valid-feedback">Valid landline number!</div>
                                </div>
                            </div>
                            
                            <!-- Active Status -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Account Status</label>
                                    <div class="checkbox-wrapper">
                                        <input type="checkbox" 
                                               id="active" 
                                               name="active" 
                                               value="1"
                                               <?php echo (!isset($user) || $user->active == 1) ? 'checked' : ''; ?>>
                                        <label for="active">Active (User can login)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Address -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address" class="control-label">
                                        Address
                                    </label>
                                    <textarea id="address" 
                                              name="address" 
                                              class="form-control" 
                                              placeholder="Enter complete address"
                                              rows="3"><?php echo isset($user) ? htmlspecialchars($user->address, ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
                                    <div class="invalid-feedback"></div>
                                    <div class="valid-feedback">Address saved!</div>
                                </div>
                            </div>
                        </div>
                        
                        <?php echo form_close(); ?>
                    </div>
                    
                    <div class="form-actions">
                        <a href="<?php echo admin_url('hospital_management/users'); ?>" class="btn-clean">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                        <button type="button" id="saveBtn" class="btn-modern btn-dark-modern">
                            <i class="fa fa-check"></i> <?php echo isset($user) ? 'Update User' : 'Create User'; ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Role Modal -->
<div class="modal fade" id="createRoleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> Create New Role</h4>
            </div>
            <div class="modal-body">
                <form id="createRoleForm">
                    <div class="form-group">
                        <label for="role_name" class="control-label">
                            Role Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               id="role_name" 
                               name="role_name" 
                               class="form-control" 
                               placeholder="e.g., Doctor, Nurse, Receptionist"
                               maxlength="50"
                               required>
                        <span class="char-counter" id="role_name_counter">0/50 characters</span>
                        <span class="help-block">Enter role name (letters and spaces only, 2-50 characters)</span>
                        <div class="invalid-feedback"></div>
                        <div class="valid-feedback">Role name is valid!</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-clean" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="button" id="saveRoleBtn" class="btn-modern btn-dark-modern">
                    <i class="fa fa-check"></i> Create Role
                </button>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>

<script>
(function() {
    'use strict';
    
    try {
        if (typeof $ === 'undefined') {
            throw new Error('jQuery is not loaded');
        }
        
        if (typeof admin_url === 'undefined') {
            throw new Error('Admin URL is not defined');
        }
        
        if (typeof alert_float === 'undefined') {
            console.warn('alert_float function not found, using fallback');
            window.alert_float = function(type, message) {
                alert(message);
            };
        }
        
        $(document).ready(function() {
            // CONFIGURATION
            const CONFIG = {
                EMAIL_CHECK_DELAY: 500,
                AJAX_TIMEOUT: 15000,
                MIN_PASSWORD_LENGTH: 3,
                MAX_NAME_LENGTH: 50,
                MIN_NAME_LENGTH: 2,
                MAX_ROLE_NAME_LENGTH: 50,
                MIN_ROLE_NAME_LENGTH: 2
            };
            
            // STATE MANAGEMENT
            let emailCheckTimeout = null;
            let emailCheckXhr = null;
            const userId = <?php echo isset($user) ? json_encode((int)$user->id, JSON_HEX_TAG | JSON_HEX_AMP) : 'null'; ?>;
            const isEditMode = userId !== null;
            
            // ERROR TRACKING
            let formErrors = {};
            
            // ===================================================
            // VALIDATION HELPER FUNCTIONS
            // ===================================================
            
            function setInvalid($input, message) {
                const fieldName = $input.attr('id');
                formErrors[fieldName] = message;
                
                $input.removeClass('is-valid').addClass('is-invalid');
                $input.siblings('.invalid-feedback').text(message);
                
                updateErrorSummary();
            }
            
            function setValid($input) {
                const fieldName = $input.attr('id');
                delete formErrors[fieldName];
                
                $input.removeClass('is-invalid').addClass('is-valid');
                
                updateErrorSummary();
            }
            
            function setNeutral($input) {
                const fieldName = $input.attr('id');
                delete formErrors[fieldName];
                
                $input.removeClass('is-valid is-invalid');
                
                updateErrorSummary();
            }
            
            function updateErrorSummary() {
                const errorCount = Object.keys(formErrors).length;
                const $summary = $('#errorSummary');
                const $list = $('#errorList');
                
                if (errorCount === 0) {
                    $summary.removeClass('show');
                    return;
                }
                
                $list.empty();
                $.each(formErrors, function(field, message) {
                    $list.append('<li><i class="fa fa-times-circle"></i> ' + escapeHtml(message) + '</li>');
                });
                
                $summary.addClass('show');
                
                $('html, body').animate({
                    scrollTop: $summary.offset().top - 100
                }, 300);
            }
            
            function escapeHtml(text) {
                const map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };
                return text.replace(/[&<>"']/g, function(m) { return map[m]; });
            }
            
            function isValidEmail(email) {
                // Enhanced email validation - prevent multiple dots
                if (/\.{2,}/.test(email)) return false;
                if (/^\.|\.$|@\.|\.@/.test(email)) return false;
                return /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(email);
            }
            
            function isValidPhone(phone) {
                return /^[0-9+\-\s()]+$/.test(phone) && phone.replace(/[^0-9]/g, '').length >= 10;
            }
            
            function getFieldLabel(fieldId) {
                const labels = {
                    'first_name': 'First Name',
                    'last_name': 'Last Name',
                    'email': 'Email Address',
                    'password': 'Password',
                    'role_id': 'User Role',
                    'phone_number': 'Phone Number',
                    'landline_number': 'Landline Number',
                    'address': 'Address',
                    'role_name': 'Role Name'
                };
                return labels[fieldId] || fieldId;
            }
            
            function updateCharCounter(fieldId, currentLength, maxLength) {
                const $counter = $('#' + fieldId + '_counter');
                if ($counter.length) {
                    $counter.text(currentLength + '/' + maxLength + ' characters');
                    
                    if (currentLength >= maxLength) {
                        $counter.addClass('warning');
                    } else {
                        $counter.removeClass('warning');
                    }
                }
            }
            
            // ===================================================
            // FIRST NAME & LAST NAME VALIDATION
            // ===================================================
            
            $('#first_name, #last_name').on('input', function() {
                const $input = $(this);
                const fieldId = $input.attr('id');
                let value = $input.val();
                
                // Real-time sanitization - remove numbers and special characters
                value = value.replace(/[^a-zA-Z\s]/g, '');
                
                // Enforce maximum length
                if (value.length > CONFIG.MAX_NAME_LENGTH) {
                    value = value.substring(0, CONFIG.MAX_NAME_LENGTH);
                }
                
                // Update input if sanitized
                if (value !== $input.val()) {
                    $input.val(value);
                    alert_float('info', 'Special characters and numbers are not allowed in names');
                }
                
                // Update character counter
                updateCharCounter(fieldId, value.length, CONFIG.MAX_NAME_LENGTH);
                
                // Real-time validation feedback
                if ($input.hasClass('is-invalid') && value.trim().length >= CONFIG.MIN_NAME_LENGTH) {
                    setValid($input);
                }
            });
            
            $('#first_name, #last_name').on('blur', function() {
                const $input = $(this);
                const value = $input.val().trim();
                const fieldLabel = getFieldLabel($input.attr('id'));
                
                if (value.length === 0) {
                    setInvalid($input, fieldLabel + ' is required. Please enter a value.');
                } else if (value.length < CONFIG.MIN_NAME_LENGTH) {
                    setInvalid($input, fieldLabel + ' must be at least ' + CONFIG.MIN_NAME_LENGTH + ' characters long.');
                } else if (value.length > CONFIG.MAX_NAME_LENGTH) {
                    setInvalid($input, fieldLabel + ' is too long. Maximum ' + CONFIG.MAX_NAME_LENGTH + ' characters allowed.');
                } else if (!/^[a-zA-Z\s]+$/.test(value)) {
                    setInvalid($input, fieldLabel + ' should only contain letters and spaces.');
                } else {
                    setValid($input);
                }
            });
            
            // Initialize character counters on page load
            $('#first_name, #last_name').each(function() {
                const fieldId = $(this).attr('id');
                const currentLength = $(this).val().length;
                updateCharCounter(fieldId, currentLength, CONFIG.MAX_NAME_LENGTH);
            });
            
            // ===================================================
            // EMAIL VALIDATION WITH AJAX CHECK
            // ===================================================
            
            $('#email').on('blur', function() {
                const $input = $(this);
                const value = $input.val().trim().toLowerCase();
                
                if (emailCheckTimeout) {
                    clearTimeout(emailCheckTimeout);
                }
                
                if (emailCheckXhr && emailCheckXhr.readyState !== 4) {
                    emailCheckXhr.abort();
                }
                
                if (value.length === 0) {
                    setInvalid($input, 'Email address is required. Please enter your email.');
                    return;
                }
                
                if (!isValidEmail(value)) {
                    setInvalid($input, 'Invalid email format. Please enter a valid email (no consecutive dots allowed).');
                    return;
                }
                
                emailCheckTimeout = setTimeout(function() {
                    emailCheckXhr = $.ajax({
                        url: admin_url + 'hospital_management/check_email',
                        type: 'POST',
                        dataType: 'json',
                        timeout: CONFIG.AJAX_TIMEOUT,
                        data: { 
                            email: value, 
                            user_id: userId 
                        },
                        success: function(response) {
                            if (response && typeof response.available !== 'undefined') {
                                if (response.available) {
                                    setValid($input);
                                } else {
                                    setInvalid($input, 'This email address is already registered. Please use a different email.');
                                }
                            } else {
                                setNeutral($input);
                            }
                        },
                        error: function(xhr, status, error) {
                            if (status === 'abort') {
                                return;
                            }
                            
                            if (status === 'timeout') {
                                setInvalid($input, 'Email verification timed out. Please try again.');
                            } else {
                                setNeutral($input);
                            }
                        }
                    });
                }, CONFIG.EMAIL_CHECK_DELAY);
            });
            
            $('#email').on('input', function() {
                const $input = $(this);
                if ($input.hasClass('is-invalid')) {
                    const value = $input.val().trim();
                    if (value.length > 0 && isValidEmail(value)) {
                        $input.trigger('blur');
                    }
                }
            });
            
            // ===================================================
            // PASSWORD VALIDATION
            // ===================================================
            
            $('#password').on('blur', function() {
                const $input = $(this);
                const value = $input.val();
                
                if (!isEditMode && value.length === 0) {
                    setInvalid($input, 'Password is required for new users.');
                    return;
                }
                
                if (value.length > 0) {
                    if (value.length < CONFIG.MIN_PASSWORD_LENGTH) {
                        setInvalid($input, 'Password must be at least ' + CONFIG.MIN_PASSWORD_LENGTH + ' characters long.');
                    } else {
                        setValid($input);
                    }
                } else {
                    setNeutral($input);
                }
            });
            
            $('#password').on('input', function() {
                const $input = $(this);
                if ($input.hasClass('is-invalid')) {
                    const value = $input.val();
                    if (value.length >= CONFIG.MIN_PASSWORD_LENGTH) {
                        setValid($input);
                    }
                }
            });
            
            // ===================================================
            // ROLE VALIDATION
            // ===================================================
            
            $('#role_id').on('change', function() {
                const $input = $(this);
                const value = $input.val();
                
                if (!value || value === '') {
                    setInvalid($input, 'Please select a user role. Role is required.');
                } else {
                    setValid($input);
                }
            });
            
            // ===================================================
            // PHONE & LANDLINE VALIDATION
            // ===================================================
            
            $('#phone_number, #landline_number').on('blur', function() {
                const $input = $(this);
                const value = $input.val().trim();
                const fieldLabel = getFieldLabel($input.attr('id'));
                
                if (value.length > 0) {
                    if (!isValidPhone(value)) {
                        setInvalid($input, fieldLabel + ' format is invalid.');
                    } else if (value.replace(/[^0-9]/g, '').length < 10) {
                        setInvalid($input, fieldLabel + ' must have at least 10 digits.');
                    } else {
                        setValid($input);
                    }
                } else {
                    setNeutral($input);
                }
            });
            
            $('#phone_number, #landline_number').on('input', function() {
                const $input = $(this);
                if ($input.hasClass('is-invalid')) {
                    const value = $input.val().trim();
                    if (value.length > 0 && isValidPhone(value)) {
                        setValid($input);
                    }
                }
            });
            
            // ===================================================
            // ADDRESS VALIDATION
            // ===================================================
            
            $('#address').on('blur', function() {
                const $input = $(this);
                const value = $input.val().trim();
                
                if (value.length > 0) {
                    setValid($input);
                } else {
                    setNeutral($input);
                }
            });
            
            // ===================================================
            // ROLE NAME VALIDATION (IN MODAL)
            // ===================================================
            
            $('#role_name').on('input', function() {
                const $input = $(this);
                let value = $input.val();
                
                // Real-time sanitization - remove numbers and special characters
                value = value.replace(/[^a-zA-Z\s]/g, '');
                
                // Enforce maximum length
                if (value.length > CONFIG.MAX_ROLE_NAME_LENGTH) {
                    value = value.substring(0, CONFIG.MAX_ROLE_NAME_LENGTH);
                }
                
                // Update input if sanitized
                if (value !== $input.val()) {
                    $input.val(value);
                    alert_float('info', 'Role name can only contain letters and spaces');
                }
                
                // Update character counter
                updateCharCounter('role_name', value.length, CONFIG.MAX_ROLE_NAME_LENGTH);
                
                // Real-time validation feedback
                if ($input.hasClass('is-invalid') && value.trim().length >= CONFIG.MIN_ROLE_NAME_LENGTH) {
                    setValid($input);
                }
            });
            
            $('#role_name').on('blur', function() {
                const $input = $(this);
                const value = $input.val().trim();
                
                if (value.length === 0) {
                    setInvalid($input, 'Role name is required.');
                } else if (value.length < CONFIG.MIN_ROLE_NAME_LENGTH) {
                    setInvalid($input, 'Role name must be at least ' + CONFIG.MIN_ROLE_NAME_LENGTH + ' characters.');
                } else if (value.length > CONFIG.MAX_ROLE_NAME_LENGTH) {
                    setInvalid($input, 'Role name is too long. Maximum ' + CONFIG.MAX_ROLE_NAME_LENGTH + ' characters.');
                } else if (!/^[a-zA-Z\s]+$/.test(value)) {
                    setInvalid($input, 'Role name should only contain letters and spaces.');
                } else if (value.toLowerCase() === 'admin' || value.toLowerCase() === 'administrator') {
                    setInvalid($input, 'Cannot use "Admin" or "Administrator" as role name. Reserved.');
                } else {
                    setValid($input);
                }
            });
            
            // ===================================================
            // FORM SUBMISSION
            // ===================================================
            
            $('#saveBtn').on('click', function(e) {
                e.preventDefault();
                
                formErrors = {};
                
                const requiredFields = [
                    { id: 'first_name', label: 'First Name' },
                    { id: 'last_name', label: 'Last Name' },
                    { id: 'email', label: 'Email Address' },
                    { id: 'role_id', label: 'User Role' }
                ];
                
                if (!isEditMode) {
                    requiredFields.push({ id: 'password', label: 'Password' });
                }
                
                requiredFields.forEach(function(field) {
                    $('#' + field.id).trigger('blur');
                });
                
                $('#phone_number, #landline_number').each(function() {
                    if ($(this).val().trim().length > 0) {
                        $(this).trigger('blur');
                    }
                });
                
                setTimeout(function() {
                    const errorCount = $('.is-invalid').length;
                    
                    if (errorCount > 0) {
                        const $firstError = $('.is-invalid').first();
                        const firstErrorLabel = getFieldLabel($firstError.attr('id'));
                        
                        if (errorCount === 1) {
                            alert_float('danger', 'Please fix the error in "' + firstErrorLabel + '" field.');
                        } else {
                            alert_float('danger', 'Please fix ' + errorCount + ' errors in the form.');
                        }
                        
                        $firstError.focus();
                        return;
                    }
                    
                    submitForm();
                }, 600);
            });
            
            // ===================================================
            // AJAX FORM SUBMISSION
            // ===================================================
            
            function submitForm() {
                const $btn = $('#saveBtn');
                $btn.addClass('btn-loading').prop('disabled', true);
                
                $.ajax({
                    url: admin_url + 'hospital_management/save',
                    type: 'POST',
                    dataType: 'json',
                    timeout: CONFIG.AJAX_TIMEOUT,
                    data: $('#user_form').serialize(),
                    success: function(response) {
                        if (response && response.success) {
                            alert_float('success', response.message || 'User saved successfully!');
                            
                            setTimeout(function() {
                                window.location.href = admin_url + 'hospital_management/users';
                            }, 1000);
                        } else {
                            const errorMessage = response.message || 'Failed to save user.';
                            alert_float('danger', errorMessage);
                            
                            $btn.removeClass('btn-loading').prop('disabled', false);
                            
                            if (response.errors && typeof response.errors === 'object') {
                                $.each(response.errors, function(fieldName, message) {
                                    const $field = $('#' + fieldName);
                                    if ($field.length > 0) {
                                        setInvalid($field, message);
                                    }
                                });
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = 'An unexpected error occurred.';
                        
                        if (status === 'timeout') {
                            errorMessage = 'Request timed out. Please try again.';
                        } else if (xhr.status === 403) {
                            errorMessage = 'Access denied.';
                        } else if (xhr.status === 500) {
                            errorMessage = 'Server error. Please contact support.';
                        }
                        
                        alert_float('danger', errorMessage);
                        $btn.removeClass('btn-loading').prop('disabled', false);
                    }
                });
            }
            
            // ===================================================
            // CREATE ROLE MODAL
            // ===================================================
            
            $('#saveRoleBtn').on('click', function() {
                const $btn = $(this);
                const $roleInput = $('#role_name');
                
                // Trigger validation
                $roleInput.trigger('blur');
                
                // Check if validation passed
                if ($roleInput.hasClass('is-invalid')) {
                    alert_float('warning', 'Please fix the error in role name field.');
                    $roleInput.focus();
                    return;
                }
                
                const roleName = $roleInput.val().trim();
                
                if (!roleName || roleName.length === 0) {
                    alert_float('warning', 'Role name is required.');
                    $roleInput.focus();
                    return;
                }
                
                $btn.addClass('btn-loading').prop('disabled', true);
                
                $.ajax({
                    url: admin_url + 'hospital_management/create_role',
                    type: 'POST',
                    dataType: 'json',
                    timeout: CONFIG.AJAX_TIMEOUT,
                    data: { role_name: roleName },
                    success: function(response) {
                        if (response && response.success) {
                            alert_float('success', response.message || 'Role created successfully!');
                            
                            const newOption = $('<option></option>')
                                .val(response.role_id)
                                .text(response.role_name)
                                .prop('selected', true);
                            
                            $('#role_id').append(newOption);
                            
                            if (typeof $.fn.selectpicker !== 'undefined') {
                                $('#role_id').selectpicker('refresh');
                            }
                            
                            $('#createRoleModal').modal('hide');
                            $('#createRoleForm')[0].reset();
                            setNeutral($roleInput);
                            
                            $('#role_id').trigger('change');
                        } else {
                            alert_float('danger', response.message || 'Failed to create role.');
                        }
                        
                        $btn.removeClass('btn-loading').prop('disabled', false);
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = 'Failed to create role.';
                        
                        if (status === 'timeout') {
                            errorMessage = 'Request timed out. Please try again.';
                        }
                        
                        alert_float('danger', errorMessage);
                        $btn.removeClass('btn-loading').prop('disabled', false);
                    }
                });
            });
            
            $('#createRoleModal').on('hidden.bs.modal', function() {
                $('#createRoleForm')[0].reset();
                setNeutral($('#role_name'));
                updateCharCounter('role_name', 0, CONFIG.MAX_ROLE_NAME_LENGTH);
            });
            
            $('#createRoleModal').on('shown.bs.modal', function() {
                $('#role_name').focus();
            });
            
        }); // End document.ready
        
    } catch (error) {
        console.error('Critical error:', error);
        
        if (typeof alert_float !== 'undefined') {
            alert_float('danger', 'Form error. Please refresh the page.');
        } else {
            alert('Form error: ' + error.message);
        }
        
        $('#saveBtn').prop('disabled', true)
                     .removeClass('btn-dark-modern')
                     .addClass('btn-danger')
                     .html('<i class="fa fa-exclamation-triangle"></i> Form Error - Refresh Page');
    }
})();
</script>