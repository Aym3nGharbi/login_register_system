<?php 
session_start();
$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];

$isactiveform = $_SESSION['active_form'] ?? 'login';

session_unset();

function show_error($error){
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveform($formname, $isactiveform){
    return $formname == $isactiveform ? "active" : '';
}


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login System</title>
</head>
<body>
    <div class="container">
        <div class="form-box <?= isActiveform('login', $isactiveform); ?>" id="login-form">
            <form action="login-register.php" method="POST">
                <h2>Login</h2>
                <?= show_error($errors['login']); ?>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="password" required>
                <button type="submit" name="Login">Login</button>
                <p>Don't have an account? <a href="#" onclick="showForm('register-form')">Register</a></p>
            </form>
        </div>

        <div class="form-box <?= isActiveform('register', $isactiveform); ?>" id="register-form">
            <form action="login-register.php" method="POST">
                <h2>Register</h2>
                <?= show_error($errors['register']); ?>
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role">
                    <option value="">--Select a Role--</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit" name="register">Register</button>
                <p>Already have an account? <a href="#" onclick="showForm('login-form')">Login</a></p>
            </form>
        </div>
    </div>
    
    <script src="index.js"></script>
</body>
</html>