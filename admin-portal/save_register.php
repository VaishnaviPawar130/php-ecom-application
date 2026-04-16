<?php
session_start();
include "config/db.php";

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');
$confirm_password = trim($_POST['confirm_password'] ?? '');

if ($name === '' || $email === '' || $password === '' || $confirm_password === '') {
    $_SESSION['register_error'] = "All fields are required.";
    header("Location: register.php");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['register_error'] = "Please enter a valid email address.";
    header("Location: register.php");
    exit();
}

if ($password !== $confirm_password) {
    $_SESSION['register_error'] = "Password and confirm password do not match.";
    header("Location: register.php");
    exit();
}

$check_sql = "SELECT id FROM admins WHERE email = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    $_SESSION['register_error'] = "Email already registered.";
    header("Location: register.php");
    exit();
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$insert_sql = "INSERT INTO admins (name, email, password) VALUES (?, ?, ?)";
$insert_stmt = $conn->prepare($insert_sql);
$insert_stmt->bind_param("sss", $name, $email, $hashed_password);

if ($insert_stmt->execute()) {
    $_SESSION['register_success'] = "Registration successful. Please login.";
    header("Location: register.php");
    exit();
} else {
    $_SESSION['register_error'] = "Something went wrong. Please try again.";
    header("Location: register.php");
    exit();
}
?>