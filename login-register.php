<?php
session_start();
include 'config.php';

if (isset($_POST["register"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role = $_POST["role"];

    if (empty($role)) {
        $_SESSION["register_error"] = "Please select an account type";
        $_SESSION["active_form"] = "register";
        header("Location: index.php");
        exit;
    }

    $checkemail = $conn->query("SELECT email FROM users WHERE email = '$email'");
    if ($checkemail->num_rows > 0) {
        $_SESSION["register_error"] = "Email already registered";
        $_SESSION["active_form"] = "register";
    } else {
        $conn->query("INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')");
    }

    header("Location: index.php");
    exit;
}

if (isset($_POST["Login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $result = $conn->query("SELECT name, email, password, role FROM users WHERE email = '$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION["name"] = $user['name'];
            $_SESSION["email"] = $user['email'];
            $_SESSION["role"] = $user['role'];

            if ($user['role'] === 'superadmin') {
                header("Location: admin_page.php");
            } else {
                header("Location: user_page.php");
            }

            exit;
        }
    }

    $_SESSION["login_error"] = "Email or Password is Incorrect";
    $_SESSION["active_form"] = "login";
    header("Location: index.php");
    exit;
}
?>