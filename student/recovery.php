<?php
session_start();
include('includes/dbconnection.php');

$success_message = '';
$error_message = '';

if (isset($_POST['submit_recovery'])) {

    $email = trim($_POST['email']);
    $newpass = trim($_POST['new_password']);

    $query = $con->prepare("SELECT id FROM registration WHERE email=?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 1) {

        // Update plain text password
        $update = $con->prepare("UPDATE registration SET password=? WHERE email=?");
        $update->bind_param("ss", $newpass, $email);
        $update->execute();

        $success_message = "Password successfully changed!";
    } else {
        $error_message = "Email not found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Recover Password</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<style>
body {
    background: #f1f1ff;
    font-family: "Segoe UI";
}
.recovery-box {
    width: 450px;
    margin: 8vh auto;
    background: #fff;
    padding: 30px;
    border-radius: 14px;
    box-shadow: 0 6px 25px rgba(0,0,0,0.15);
}
.btn-brand {
  background: #6b2f79;
  color: white;
}
</style>
</head>

<body>
<div class="recovery-box">
    <h3 class="text-center mb-4">Password Recovery</h3>

    <?php if($success_message): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <?php if($error_message): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Email</label>
        <input type="email" name="email" class="form-control mb-2" required>

        <label>New Password</label>
        <input type="password" name="new_password" class="form-control mb-3" required>

        <button type="submit" name="submit_recovery" class="btn btn-brand w-100">Change Password</button>
    </form>

    <p class="text-center mt-3">
        <a href="login.php">Back to Login</a>
    </p>
</div>
</body>
</html>
