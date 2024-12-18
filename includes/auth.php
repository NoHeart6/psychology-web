<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /pages/login.php');
        exit;
    }
}

function requireGuest() {
    if (isLoggedIn()) {
        header('Location: /pages/home.php');
        exit;
    }
} 