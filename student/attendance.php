<?php
session_start();
include('includes/dbconnection.php');

if (empty($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
}

$action = $_GET['action'] ?? '';
$id = intval($_GET['id'] ?? 0);

// ---------------- SAVE ATTENDANCE -------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $student_id = $_POST['student_id'];
    $student_name = mysqli_real_escape_string($con, $_POST['student_name']);
    $subject_name = mysqli_real_escape_string($con, $_POST['subject_name']);
    $date = $_POST['attendance_date'];
    $status = $_POST['status'];

    $sql = "INSERT INTO attendance (student_id, student_name, subject_name, attendance_date, status)
            VALUES ('$student_id', '$student_name', '$subject_name', '$date', '$status')";
    mysqli_query($con, $sql);

    header("Location: attendance.php");
    exit();
}

// ---------------- DELETE ---------------------------
if ($action === 'delete' && $id) {
    mysqli_query($con, "DELETE FROM attendance WHERE id='$id'");
    header("Location: attendance.php");
    exit();
}

// ---------------- LIST -----------------------------
$list = mysqli_query($con,"SELECT * FROM attendance ORDER BY attendance_date DESC");
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Attendance</title>
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('leftbar.php'); ?>

<div class="container mt-4">

<h3 class="mb-3">Attendance</h3>

<!-- Input Form -->
<div class="card p-4 mb-4">

    <form method="post">

        <div class="form-group">
            <label>Student ID</label>
            <input type="text" name="student_id" class="form-control" required placeholder="Enter Student ID">
        </div>

        <div class="form-group">
            <label>Student Name</label>
            <input type="text" name="student_name" class="form-control" required placeholder="Enter Student Name">
        </div>

        <div class="form-group">
            <label>Subject Name</label>
            <input type="text" name="subject_name" class="form-control" required placeholder="Enter Subject Name">
        </div>

        <div class="form-group">
            <label>Date</label>
            <input type="date" name="attendance_date" class="form-control" value="<?=date('Y-m-d')?>">
        </div>

        <div class="form-group">
            <label>Attendance</label>
            <select name="status" class="form-control">
                <option value="Present">Present</option>
                <option value="Absent">Absent</option>
                <option value="Leave">Leave</option>
            </select>
        </div>

        <button class="btn btn-success mt-3">Save Attendance</button>
    </form>

</div>

<!-- Attendance Records -->
<h4>Attendance Records</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Student ID</th>
            <th>Name</th>
            <th>Subject</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
    <?php $i=1; while($r = mysqli_fetch_assoc($list)): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= $r['student_id'] ?></td>
            <td><?= htmlspecialchars($r['student_name']) ?></td>
            <td><?= htmlspecialchars($r['subject_name']) ?></td>
            <td><?= $r['attendance_date'] ?></td>
            <td><?= $r['status'] ?></td>
            <td>
                <a href="attendance.php?action=delete&id=<?= $r['id'] ?>" 
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Delete this record?')">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

</div>

</body>
</html>
