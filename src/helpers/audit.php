<?php
function log_audit_action($conn, $user_uid, $action, $target_table, $record_id = null, $details = '') {
    $stmt = $conn->prepare("INSERT INTO audit_logs (user_uid, action, target_table, record_id, details) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sssis", $user_uid, $action, $target_table, $record_id, $details);
        return $stmt->execute();
    }
    return false;
}