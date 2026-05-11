<?php
session_start();
include 'includes/dbconnection.php';

$invalid = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $con->prepare("SELECT id, username, password, user_type FROM registration WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $row = $result->fetch_assoc();

        if ($password === $row['password']) {

            $_SESSION['user_id']   = $row['id'];
            $_SESSION['username']  = $row['username'];
            $_SESSION['email']     = $email;
            $_SESSION['user_type'] = $row['user_type'];

            // redirect both to same dashboard
            header("Location: welcome.php");
            exit;
        } 
        else {
            $invalid = true;
        }

    } else {
        $invalid = true;
    }
}
?>
<!doctype html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<style>
body {
  min-height: 100vh;
  background: linear-gradient(90deg,#cfe8ff 0%, #e5d7f6 50%, #efe2ff 100%);
  font-family: "Segoe UI", sans-serif;
}
.center-card {
  width: 440px;
  margin: 6vh auto;
  background: #fff;
  border-radius: 16px;
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

    <?php if($invalid): ?>
    <div class="alert alert-danger">Invalid email or password.</div>
    <?php endif; ?>

    <form method="POST">
        <label>Email</label>
        <input type="email" name="email" class="form-control mb-2" required>

        <label>Password</label>
        <input type="password" name="password" class="form-control mb-3" required>

        <button class="btn btn-brand w-100">Login</button>

        <p class="text-center mt-3">Don't have an account?
            <a href="register.php">Register</a>
        </p>
        <p class="text-center mt-2">
            <a href="recovery.php">Forgot Password?</a>
        </p>
    </form>
</div>

</body>
</html>
