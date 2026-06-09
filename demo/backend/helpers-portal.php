<?php
// For STUDENT / TEACHER / PARENT Portal Only
require_once __DIR__ . '/conn.php';

function esc($v) {
  return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}

/* CSRF helpers */
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field() {
    $t = csrf_token();
    return '<input type="hidden" name="csrf_token" value="' . $t . '">';
}

function verify_csrf($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
