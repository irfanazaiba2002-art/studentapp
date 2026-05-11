<?php
session_start();

// If not logged in → redirect to login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$username  = $_SESSION['username'];
$user_type = $_SESSION['user_type'];  // Admin or User
?>

<!DOCTYPE html>
<html>
<head>
<title>Welcome</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<style>
body {
    height: 100vh;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #8E2DE2, #4A00E0);
    font-family: "Segoe UI", sans-serif;
    color: white;
    overflow: hidden;
}

.card-box {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(12px);
    border-radius: 20px;
    padding: 40px;
    text-align: center;
    width: 450px;
    box-shadow: 0 10px 35px rgba(0,0,0,0.25);
    animation: fadeIn 1.3s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9); }
    to   { opacity: 1; transform: scale(1); }
}

h1 {
    font-size: 32px;
    font-weight: bold;
}

.role-badge {
    background: #ffffff;
    color: #4A00E0;
    padding: 7px 18px;
    border-radius: 20px;
    display: inline-block;
    font-weight: bold;
    margin-bottom: 15px;
}

.redirect-msg {
    margin-top: 20px;
    opacity: 0.9;
    font-size: 14px;
}
</style>

<script>
// AUTO REDIRECT AFTER 3 SECONDS
setTimeout(() => {
    window.location.href = "form.php";
}, 3000);
</script>

</head>
<body>

<div class="card-box">
    <div class="role-badge">
        <?= htmlspecialchars($user_type); ?>
    </div>

    <h1>Welcome, <?= htmlspecialchars($username); ?> 👋</h1>

    <p style="margin-top:10px; font-size:18px; opacity:0.9;">
        You are successfully logged in.
    </p>

    <div class="redirect-msg">
        Redirecting to dashboard...
    </div>
    <a href="form.php" class="btn btn-light mt-3" style="font-weight:bold;">
    Go to Dashboard Now
</a>
</div>

</body>
</html>
