<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['customer_logged_in']) || $_SESSION['customer_logged_in'] !== true) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    
    header('Location: login.php');
    exit;
}

function getCustomerName() {
    return isset($_SESSION['customer_name']) ? $_SESSION['customer_name'] : 'User';
}

function getCustomerEmail() {
    return isset($_SESSION['customer_email']) ? $_SESSION['customer_email'] : '';
}

function isCustomerLoggedIn() {
    return isset($_SESSION['customer_logged_in']) && $_SESSION['customer_logged_in'] === true;
}
?>
