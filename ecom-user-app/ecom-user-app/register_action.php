<?php
session_start();
include 'config/db.php';

$full_name = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($full_name === '' || $email === '' || $password === '') {
    $_SESSION['auth_error'] = "please fill all required fields";
    header("Location: index.php");
    exit();
}

$check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    $_SESSION['auth_error'] = "Email already registered.";
    $_SESSION['auth_tab'] = "register";
    header("Location: index.php?auth=open");
    exit();
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $full_name, $email, $phone, $hashed_password);

if ($stmt->execute()) {
    $_SESSION['auth_success'] = "User registered successfully.";
    $_SESSION['auth_tab'] = "login";
    header("Location: index.php?auth=open");
    exit();
} else {
    $_SESSION['auth_error'] = "Registration failed. Please try again.";
    header("Location: index.php");
    exit();
}
?>