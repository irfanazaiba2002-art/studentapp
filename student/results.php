<?php
session_start();
include('includes/dbconnection.php');

if (empty($_SESSION['user_id'])) { 
    header('location:login.php'); 
    exit(); 
}

$action = $_GET['action'] ?? '';
$id = intval($_GET['id'] ?? 0);

// ---------------- SAVE RESULT -------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // FIX APPLIED HERE (removed intval for non-numeric IDs)
    $student_id  = mysqli_real_escape_string($con, $_POST['student_id']);
    $subject_id  = mysqli_real_escape_string($con, $_POST['subject_id']);
    $exam_id     = mysqli_real_escape_string($con, $_POST['exam_id']);

    $marks = intval($_POST['marks_obtained']);
    $total = intval($_POST['total_marks']);

    if (!empty($_POST['id'])) {
        $upd = intval($_POST['id']);
        mysqli_query($con,
            "UPDATE results 
             SET student_id='$student_id', subject_id='$subject_id', exam_id='$exam_id',
                 marks_obtained='$marks', total_marks='$total'
             WHERE id='$upd'"
        );
    } else {
        mysqli_query($con,
            "INSERT INTO results(student_id, subject_id, exam_id, marks_obtained, total_marks)
             VALUES('$student_id','$subject_id','$exam_id','$marks','$total')"
        );
    }

    header("Location: results.php");
    exit();
}

// ---------------- DELETE -------------------
if ($action === 'delete' && $id) {
    mysqli_query($con, "DELETE FROM results WHERE id='$id'");
    header("Location: results.php");
    exit();
}

// ---------------- EDIT MODE -------------------
$editing = null;
if ($action === 'edit' && $id) {
    $editing = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM results WHERE id='$id'"));
}

// ---------------- RESULT LIST -------------------
$list = mysqli_query($con, "SELECT * FROM results ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Results</title>
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('leftbar.php'); ?>

<div class="container mt-4">
    <h3>Results Entry</h3>

    <!-- Form -->
    <div class="card p-3 mb-4">
        <form method="post">
            <input type="hidden" name="id" value="<?= $editing['id'] ?? '' ?>">

            <div class="row">

                <div class="col-md-2">
                    <label>Student ID</label>
                    <input type="text" name="student_id" class="form-control"
                           value="<?= $editing['student_id'] ?? '' ?>" required>
                </div>

                <div class="col-md-2">
                    <label>Subject ID</label>
                    <input type="text" name="subject_id" class="form-control"
                           value="<?= $editing['subject_id'] ?? '' ?>" required>
                </div>

                <div class="col-md-2">
                    <label>Exam ID</label>
                    <input type="text" name="exam_id" class="form-control"
                           value="<?= $editing['exam_id'] ?? '' ?>" required>
                </div>

                <div class="col-md-3">
                    <label>Marks Obtained</label>
                    <input type="number" name="marks_obtained" class="form-control"
                           value="<?= $editing['marks_obtained'] ?? '' ?>" required>
                </div>

                <div class="col-md-3">
                    <label>Total Marks</label>
                    <input type="number" name="total_marks" class="form-control"
                           value="<?= $editing['total_marks'] ?? '' ?>" required>
                </div>

            </div>

            <button class="btn btn-success mt-3">Save Result</button>
        </form>
    </div>

    <!-- Records -->
    <h4>Saved Results</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Student ID</th>
                <th>Subject ID</th>
                <th>Exam ID</th>
                <th>Marks</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

            <?php while($row = mysqli_fetch_assoc($list)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['student_id'] ?></td>
                    <td><?= $row['subject_id'] ?></td>
                    <td><?= $row['exam_id'] ?></td>
                    <td><?= $row['marks_obtained'] ?></td>
                    <td><?= $row['total_marks'] ?></td>
                    <td>
                        <a href="results.php?action=edit&id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="results.php?action=delete&id=<?= $row['id'] ?>" 
                           onclick="return confirm('Delete this record?')" 
                           class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>

        </tbody>
    </table>
</div>

</body>
</html>
