<?php
require_once '../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    $errors = [];
    
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    
    if (empty($errors)) {
        if (loginUser($email, $password)) {
            header("Location: ../resources/diagnosis.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid email or password";
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