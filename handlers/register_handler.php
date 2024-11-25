<?php
require_once '../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    $errors = [];
    
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    
    if (empty($errors)) {
        if (registerUser($username, $email, $password)) {
            $_SESSION['success'] = "Registration successful! Please login.";
            header("Location: ../resources/Login.php");
            exit();
        } else {
            $_SESSION['error'] = "Registration failed. Email might already be registered.";
            header("Location: ../resources/Login.php");
            exit();
        }
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: ../resources/Login.php");
        exit();
    }
}
?>