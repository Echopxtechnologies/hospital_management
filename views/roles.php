<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<style>
.page-header {
    background: #f9fafb;
    border: 1px solid #d5dce2;
    border-radius: 4px;
    padding: 20px 25px;
    margin-bottom: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.page-header h4 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #333333;
}

.role-users {
    max-width: 300px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.role-users .badge {
    margin-right: 5px;
    margin-bottom: 3px;
}

.action-btn {
    padding: 4px 8px;
    font-size: 12px;
}

/* ===================================================== */
/* VALIDATION STYLING - RED/GREEN BORDERS               */
/* ===================================================== */
.form-control.is-valid {
    border-color: #28a745 !important;
    border-width: 2px !important;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
    background-color: #E0F2F1 !important;
    padding-right: calc(1.5em + 0.75rem);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3e%3cpath fill='%2328a745' d='M10.97 4.97a.75.75 0 0 1 1.07 1.05l-5 5a.75.75 0 0 1-1.08-.02L3.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 4.49-4.45z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.form-control.is-invalid {
    border-color: #dc3545 !important;
    border-width: 2px !important;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    background-color: #FFEBEE !important;
    padding-right: calc(1.5em + 0.75rem);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.error-message {
    color: #dc3545;
    font-size: 11px;
    margin-top: 3px;
    display: block;
    font-weight: 500;
}

.success-message {
    color: #28a745;
    font-size: 11px;
    margin-top: 3px;
    display: block;
    font-weight: 500;
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

/* Remove spinner from number inputs */
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type="number"] {
    -moz-appearance: textfield;
}
</style>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h4><i class="fa fa-shield"></i> Role Management</h4>
                    <button class="btn btn-dark" data-toggle="modal" data-target="#createRoleModal">
                        <i class="fa fa-plus"></i> Create New Role
                    </button>
                </div>

                <div class="panel_s">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover dt-table">
                                <thead>
                                    <tr>
                                        <th width="10%">Role ID</th>
                                        <th width="20%">Role Name</th>
                                        <th width="10%">Total Users</th>
                                        <th width="45%">Assigned Users</th>
                                        <th width="15%" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($roles)): ?>
                                        <?php foreach ($roles as $role): ?>
                                            <?php 
                                            // Skip Admin role
                                            if ($role['roleid'] == 1 || strtolower($role['name']) == 'admin') {
                                                continue;
                                            }
                                            ?>
                                            <tr>
                                                <td>
                                                    <strong class="text-primary">#<?php echo $role['roleid']; ?></strong>
                                                </td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($role['name']); ?></strong>
                                                </td>
                                                <td>
                                                    <span class="label label-default">
                                                        <?php echo isset($role['total_users']) ? $role['total_users'] : 0; ?> Users
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="role-users">
                                                        <?php if (!empty($role['users'])): ?>
                                                            <?php foreach ($role['users'] as $user): ?>
                                                                <span class="badge badge-info">
                                                                    <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
                                                                </span>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <span class="text-muted">No users assigned</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?php echo admin_url('hospital_management/users?role=' . $role['roleid']); ?>" 
                                                       class="btn btn-default btn-xs action-btn" 
                                                       title="View Users">
                                                        <i class="fa fa-users"></i> View
                                                    </a>
                                                    
                                                    <?php if ($role['total_users'] == 0): ?>
                                                        <button class="btn btn-danger btn-xs action-btn btn-delete-role" 
                                                                data-id="<?php echo $role['roleid']; ?>"
                                                                data-name="<?php echo htmlspecialchars($role['name']); ?>"
                                                                title="Delete Role">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </button>
                                                    <?php else: ?>
                                                        <button class="btn btn-default btn-xs action-btn" 
                                                                disabled
                                                                title="Cannot delete role with assigned users">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">
                                                <i class="fa fa-info-circle"></i> No roles found
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
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
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
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
                        <span class="feedback-message" id="role_name_feedback"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="button" id="saveRoleBtn" class="btn btn-primary">
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
            
            // ============================================================
            // CONFIGURATION
            // ============================================================
            const CONFIG = {
                MAX_ROLE_NAME_LENGTH: 50,
                MIN_ROLE_NAME_LENGTH: 2,
                RESERVED_NAMES: ['admin', 'administrator', 'superadmin', 'root']
            };
            
            // ============================================================
            // VALIDATION HELPER FUNCTIONS
            // ============================================================
            
            function showValidationFeedback(fieldId, isValid, message = '') {
                const $field = $('#' + fieldId);
                const $feedback = $('#' + fieldId + '_feedback');
                
                $field.removeClass('is-valid is-invalid');
                
                if (isValid) {
                    $field.addClass('is-valid');
                    if (message) {
                        $feedback.removeClass('error-message').addClass('success-message')
                                 .html('<i class="fa fa-check-circle"></i> ' + message);
                    } else {
                        $feedback.empty();
                    }
                } else {
                    $field.addClass('is-invalid');
                    if (message) {
                        $feedback.removeClass('success-message').addClass('error-message')
                                 .html('<i class="fa fa-times-circle"></i> ' + message);
                    } else {
                        $feedback.empty();
                    }
                }
            }
            
            function clearValidationFeedback(fieldId) {
                const $field = $('#' + fieldId);
                const $feedback = $('#' + fieldId + '_feedback');
                
                $field.removeClass('is-valid is-invalid');
                $feedback.empty();
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
            
            function validateRoleName(name) {
                const trimmed = name.trim();
                
                if (trimmed.length === 0) {
                    return { valid: false, message: 'Role name is required' };
                }
                
                if (trimmed.length < CONFIG.MIN_ROLE_NAME_LENGTH) {
                    return { 
                        valid: false, 
                        message: 'Role name must be at least ' + CONFIG.MIN_ROLE_NAME_LENGTH + ' characters' 
                    };
                }
                
                if (trimmed.length > CONFIG.MAX_ROLE_NAME_LENGTH) {
                    return { 
                        valid: false, 
                        message: 'Role name is too long. Maximum ' + CONFIG.MAX_ROLE_NAME_LENGTH + ' characters' 
                    };
                }
                
                // Check for letters and spaces only
                if (!/^[a-zA-Z\s]+$/.test(trimmed)) {
                    return { 
                        valid: false, 
                        message: 'Role name should only contain letters and spaces' 
                    };
                }
                
                // Check for reserved names
                const lowerName = trimmed.toLowerCase();
                if (CONFIG.RESERVED_NAMES.includes(lowerName)) {
                    return { 
                        valid: false, 
                        message: 'Cannot use "' + trimmed + '" as role name. This name is reserved' 
                    };
                }
                
                return { valid: true, message: 'Role name is valid' };
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
            
            // ============================================================
            // ROLE NAME REAL-TIME VALIDATION
            // ============================================================
            
            $('#role_name').on('input', function() {
                const $input = $(this);
                let value = $input.val();
                
                // Real-time sanitization - remove numbers and special characters
                const sanitized = value.replace(/[^a-zA-Z\s]/g, '');
                
                // Enforce maximum length
                let finalValue = sanitized;
                if (finalValue.length > CONFIG.MAX_ROLE_NAME_LENGTH) {
                    finalValue = finalValue.substring(0, CONFIG.MAX_ROLE_NAME_LENGTH);
                }
                
                // Update input if sanitized
                if (finalValue !== value) {
                    $input.val(finalValue);
                    if (sanitized !== value) {
                        alert_float('info', 'Role name can only contain letters and spaces');
                    }
                }
                
                // Update character counter
                updateCharCounter('role_name', finalValue.length, CONFIG.MAX_ROLE_NAME_LENGTH);
                
                // Real-time validation feedback
                if ($input.hasClass('is-invalid') && finalValue.trim().length >= CONFIG.MIN_ROLE_NAME_LENGTH) {
                    const result = validateRoleName(finalValue);
                    if (result.valid) {
                        showValidationFeedback('role_name', true, result.message);
                    }
                }
            });
            
            $('#role_name').on('blur', function() {
                const $input = $(this);
                const value = $input.val().trim();
                
                const result = validateRoleName(value);
                showValidationFeedback('role_name', result.valid, result.message);
            });
            
            // ============================================================
            // MODAL EVENTS
            // ============================================================
            
            $('#createRoleModal').on('shown.bs.modal', function() {
                $('#role_name').focus();
                updateCharCounter('role_name', 0, CONFIG.MAX_ROLE_NAME_LENGTH);
            });
            
            $('#createRoleModal').on('hidden.bs.modal', function() {
                $('#createRoleForm')[0].reset();
                clearValidationFeedback('role_name');
                updateCharCounter('role_name', 0, CONFIG.MAX_ROLE_NAME_LENGTH);
            });
            
            // ============================================================
            // CREATE ROLE SUBMISSION
            // ============================================================
            
            $('#saveRoleBtn').on('click', function() {
                const $btn = $(this);
                const $roleInput = $('#role_name');
                const roleName = $roleInput.val().trim();
                
                // Trigger blur validation
                $roleInput.trigger('blur');
                
                // Check if validation passed
                if ($roleInput.hasClass('is-invalid')) {
                    const errorMsg = $('#role_name_feedback').text().replace(/✖\s*/g, '');
                    alert_float('warning', 'Please fix the error: ' + errorMsg);
                    $roleInput.focus();
                    return;
                }
                
                // Final validation check
                const result = validateRoleName(roleName);
                if (!result.valid) {
                    showValidationFeedback('role_name', false, result.message);
                    alert_float('warning', result.message);
                    $roleInput.focus();
                    return;
                }
                
                // Disable button and show loading
                $btn.addClass('disabled').prop('disabled', true)
                    .html('<i class="fa fa-spinner fa-spin"></i> Creating...');
                
                // Submit AJAX request
                $.ajax({
                    url: admin_url + 'hospital_management/create_role',
                    type: 'POST',
                    dataType: 'json',
                    timeout: 15000,
                    data: { role_name: roleName },
                    success: function(response) {
                        if (response && response.success) {
                            alert_float('success', response.message || 'Role created successfully!');
                            $('#createRoleModal').modal('hide');
                            $('#createRoleForm')[0].reset();
                            clearValidationFeedback('role_name');
                            
                            // Reload page after short delay
                            setTimeout(function() { 
                                location.reload(); 
                            }, 1000);
                        } else {
                            const errorMessage = response.message || 'Failed to create role. Please try again.';
                            alert_float('danger', errorMessage);
                            
                            // Show validation error if provided
                            if (response.error && response.error.includes('already exists')) {
                                showValidationFeedback('role_name', false, 'This role name already exists');
                            }
                            
                            $btn.removeClass('disabled').prop('disabled', false)
                                .html('<i class="fa fa-check"></i> Create Role');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Create Role Error:', {
                            status: status,
                            error: error,
                            response: xhr.responseText
                        });
                        
                        let errorMessage = 'An error occurred while creating role';
                        
                        if (status === 'timeout') {
                            errorMessage = 'Request timed out. Please try again.';
                        } else if (xhr.status === 0) {
                            errorMessage = 'Network error. Please check your connection.';
                        } else if (xhr.status === 403) {
                            errorMessage = 'Access denied. You do not have permission to create roles.';
                        } else if (xhr.status === 500) {
                            errorMessage = 'Server error. Please contact support.';
                        }
                        
                        alert_float('danger', errorMessage);
                        $btn.removeClass('disabled').prop('disabled', false)
                            .html('<i class="fa fa-check"></i> Create Role');
                    }
                });
            });
            
            // Allow Enter key to submit
            $('#role_name').on('keypress', function(e) {
                if (e.which === 13) { // Enter key
                    e.preventDefault();
                    $('#saveRoleBtn').click();
                }
            });
            
            // ============================================================
            // DELETE ROLE
            // ============================================================
            
            $(document).on('click', '.btn-delete-role', function() {
                const roleId = $(this).data('id');
                const roleName = $(this).data('name');
                
                // Sanitize role name for display
                const sanitizedRoleName = escapeHtml(roleName);
                
                // Show confirmation dialog
                if (confirm('⚠️ WARNING: Delete role "' + sanitizedRoleName + '"?\n\nThis action cannot be undone.\n\nAre you sure?')) {
                    
                    // Show loading state
                    const $btn = $(this);
                    const originalHtml = $btn.html();
                    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
                    
                    $.ajax({
                        url: admin_url + 'hospital_management/delete_role/' + roleId,
                        type: 'POST',
                        dataType: 'json',
                        timeout: 15000,
                        success: function(response) {
                            if (response && response.success) {
                                alert_float('success', response.message || 'Role deleted successfully');
                                
                                // Remove row with animation
                                $btn.closest('tr').fadeOut(300, function() {
                                    $(this).remove();
                                });
                                
                                // Reload after delay
                                setTimeout(function() { 
                                    location.reload(); 
                                }, 1000);
                            } else {
                                const errorMessage = response.message || 'Failed to delete role. Please try again.';
                                alert_float('danger', errorMessage);
                                $btn.prop('disabled', false).html(originalHtml);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Delete Role Error:', {
                                status: status,
                                error: error,
                                response: xhr.responseText
                            });
                            
                            let errorMessage = 'An error occurred while deleting role';
                            
                            if (status === 'timeout') {
                                errorMessage = 'Request timed out. Please try again.';
                            } else if (xhr.status === 403) {
                                errorMessage = 'Access denied. You do not have permission to delete roles.';
                            } else if (xhr.status === 404) {
                                errorMessage = 'Role not found. It may have been already deleted.';
                            } else if (xhr.status === 500) {
                                errorMessage = 'Server error. Please contact support.';
                            }
                            
                            alert_float('danger', errorMessage);
                            $btn.prop('disabled', false).html(originalHtml);
                        }
                    });
                }
            });
            
        }); // End document.ready
        
    } catch (error) {
        console.error('Critical error in role management:', error);
        
        if (typeof alert_float !== 'undefined') {
            alert_float('danger', 'Page initialization error. Please refresh the page.');
        } else {
            alert('Error: ' + error.message + '\n\nPlease refresh the page.');
        }
    }
    
})();
</script>