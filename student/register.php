<?php
session_start();
include 'includes/dbconnection.php';

$user_exists = false;
$success = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username   = trim($_POST['username']);
    $email      = trim($_POST['email']);
    $user_type  = $_POST['user_type'];
    $password   = trim($_POST['password']);
    $confirm    = trim($_POST['confirm_password']);

    if ($username == "" || strlen($username) < 3) $errors[] = "Username must be at least 3 characters.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Enter a valid email.";
    if (strlen($password) < 3) $errors[] = "Password must be at least 3 characters.";
    if ($password !== $confirm) $errors[] = "Passwords do not match.";

    if (empty($errors)) {
        // check existing user
        $stmt = $con->prepare("SELECT id FROM registration WHERE email=? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $user_exists = true;
        } else {

            // ❌ NO HASHING — storing plain text password
            $insert = $con->prepare("INSERT INTO registration (username,email,user_type,password) VALUES (?,?,?,?)");
            $insert->bind_param("ssss", $username, $email, $user_type, $password);

            if ($insert->execute()) {
                $success = true;
                header("Refresh: 2; url=login.php");
            } else {
                $errors[] = "Failed to register user.";
            }
        }
    }
}
?>

<!doctype html>
<html>
<head>
<title>Register</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<style>
body {
  min-height: 100vh;
  background: linear-gradient(90deg,#cfe8ff 0%, #e5d7f6 50%, #efe2ff 100%);
  font-family: "Segoe UI", sans-serif;
}
.center-card {
  width: 440px;
  margin: 5vh auto;
  background: #fff;
  border-radius: 14px;
  box-shadow: 0 6px 25px rgba(0,0,0,0.15);
  padding: 35px;
}
.title {
  text-align: center;
  font-size: 26px;
  color: #6b2f79;
  font-weight: bold;
}
.btn-brand {
  background: #6b2f79;
  color: white;
  padding: 10px;
  border-radius: 8px;
}
</style>
</head>

<body>

<div class="center-card">
    <div class="title mb-4">Student Data Management System</div>

    <?php if($user_exists): ?>
    <div class="alert alert-danger">User already exists!</div>
    <?php endif; ?>

    <?php if($success): ?>
    <div class="alert alert-success">Registration successful! Redirecting...</div>
    <?php endif; ?>

    <?php if(!empty($errors)): ?>
    <div class="alert alert-warning">
        <?php foreach($errors as $e) echo "<div>$e</div>"; ?>
    </div>
    <?php endif; ?>

    <form method="POST">

        <label>Full Name</label>
        <input type="text" class="form-control mb-2" name="username" required>

        <label>Email</label>
        <input type="email" class="form-control mb-2" name="email" required>

        <label>User Type</label>
        <select name="user_type" class="form-control mb-2">
            <option>User</option>
            <option>Admin</option>
        </select>

        <label>Password</label>
        <input type="password" class="form-control mb-2" name="password" required>

        <label>Confirm Password</label>
        <input type="password" class="form-control mb-3" name="confirm_password" required>

        <button class="btn btn-brand w-100">Register Now</button>

        <p class="text-center mt-3">Already have an account?  
           <a href="login.php">Login</a>
        </p>
    </form>
</div>

</body>
</html>
