<?php
/**
 * Input validation and sanitization helper (equivalent to Zod)
 */

/**
 * Sanitizes a string field by stripping tags and applying htmlspecialchars.
 */
function sanitize_string($value) {
    if (is_array($value)) {
        return array_map('sanitize_string', $value);
    }
    if ($value === null) {
        return '';
    }
    return htmlspecialchars(strip_tags((string)$value), ENT_QUOTES, 'UTF-8');
}

/**
 * Validates form inputs based on the specified rules.
 * 
 * Rules format:
 * [
 *     'field_name' => [
 *         'blood_type' => true,
 *         'urgency' => true,
 *         'hospital_id' => true,
 *         'email' => true,
 *         'password' => true
 *     ]
 * ]
 */
function validate_input($data, $rules) {
    $errors = [];
    $sanitized = [];

    // 1. Sanitize all string fields first
    foreach ($data as $key => $value) {
        if (is_string($value)) {
            $sanitized[$key] = sanitize_string($value);
        } else {
            $sanitized[$key] = $value;
        }
    }

    // 2. Validate rules
    foreach ($rules as $field => $field_rules) {
        // Get both raw and sanitized values for validation checks
        $raw_value = isset($data[$field]) ? $data[$field] : null;
        $value = isset($sanitized[$field]) ? $sanitized[$field] : null;

        // blood_type validation
        if (!empty($field_rules['blood_type'])) {
            $valid_blood_types = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
            if (!in_array($value, $valid_blood_types, true)) {
                $errors[$field] = "فصيلة الدم غير صالحة.";
            }
        }

        // urgency validation
        if (!empty($field_rules['urgency'])) {
            $valid_urgencies = ['low', 'medium', 'high', 'critical'];
            if (!in_array($value, $valid_urgencies, true)) {
                $errors[$field] = "درجة الأهمية غير صالحة.";
            }
        }

        // hospital_id validation
        if (!empty($field_rules['hospital_id'])) {
            $int_val = filter_var($value, FILTER_VALIDATE_INT);
            if ($int_val === false || $int_val <= 0) {
                $errors[$field] = "يجب اختيار مستشفى صالح.";
            } else {
                $sanitized[$field] = $int_val;
            }
        }

        // email validation
        if (!empty($field_rules['email'])) {
            // Check raw value so sanitization doesn't interfere with standard email parsing
            $trimmed_email = is_string($raw_value) ? trim($raw_value) : '';
            if (!filter_var($trimmed_email, FILTER_VALIDATE_EMAIL)) {
                $errors[$field] = "البريد الإلكتروني غير صالح.";
            }
        }

        // password validation (minimum 8 characters)
        if (!empty($field_rules['password'])) {
            $pass_str = is_string($raw_value) ? $raw_value : '';
            if (strlen($pass_str) < 8) {
                $errors[$field] = "يجب أن تكون كلمة المرور 8 أحرف على الأقل.";
            }
        }
    }

    return [
        'success' => empty($errors),
        'errors' => $errors,
        'data' => $sanitized
    ];
}
