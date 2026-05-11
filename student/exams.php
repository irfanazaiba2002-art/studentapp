<?php
session_start();
include('includes/dbconnection.php');
if (empty($_SESSION['user_id'])) { header('location:logout.php'); exit(); }

$action = $_GET['action'] ?? '';
$id = intval($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $exam_name = mysqli_real_escape_string($con, $_POST['exam_name']);
    $exam_date = $_POST['exam_date'];
    $course_id = intval($_POST['course_id']);

    if (!empty($_POST['id'])) {
        $eid = intval($_POST['id']);
        mysqli_query($con, "UPDATE exams SET exam_name='$exam_name', exam_date='$exam_date', course_id='$course_id' WHERE id='$eid'");
    } else {
        mysqli_query($con, "INSERT INTO exams (exam_name, exam_date, course_id) VALUES ('$exam_name','$exam_date','$course_id')");
    }
    header("Location: exams.php");
    exit();
}

if ($action === 'delete' && $id) {
    mysqli_query($con, "DELETE FROM exams WHERE id='$id'");
    header("Location: exams.php");
    exit();
}

$editing = null;
if ($action === 'edit' && $id) {
    $editing = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM exams WHERE id='$id' LIMIT 1"));
}

$exams = mysqli_query($con, "SELECT e.*, (SELECT cfull FROM tbl_course WHERE cid = e.course_id) as course_name FROM exams e ORDER BY exam_date DESC");
$courses = mysqli_query($con, "SELECT cid, cfull FROM tbl_course ORDER BY cfull");
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Exams</title>
  <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('leftbar.php'); ?>
<div class="container mt-3">
  <h3>Exams</h3>

  <div class="card mb-3">
    <div class="card-body">
      <form method="post">
        <input type="hidden" name="id" value="<?= $editing['id'] ?? '' ?>">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Exam Name</label>
            <input name="exam_name" class="form-control" value="<?= htmlspecialchars($editing['exam_name'] ?? '') ?>" required>
          </div>
          <div class="form-group col-md-3">
            <label>Date</label>
            <input name="exam_date" type="date" class="form-control" value="<?= htmlspecialchars($editing['exam_date'] ?? '') ?>" required>
          </div>
          <div class="form-group col-md-3">
            <label>Course</label>
            <select name="course_id" class="form-control">
              <option value="">Select course</option>
              <?php while($c = mysqli_fetch_assoc($courses)): ?>
                <option value="<?=$c['cid']?>" <?= (isset($editing['course_id']) && $editing['course_id']==$c['cid'])? 'selected':'' ?>><?=htmlspecialchars($c['cfull'])?></option>
              <?php endwhile; ?>
            </select>
          </div>
        </div>
        <button class="btn btn-success">Save Exam</button>
      </form>
    </div>
  </div>

  <table class="table table-bordered">
    <thead><tr><th>#</th><th>Exam</th><th>Date</th><th>Course</th><th>Action</th></tr></thead>
    <tbody>
    <?php $i=1; while($r = mysqli_fetch_assoc($exams)): ?>
      <tr>
        <td><?=$i++?></td>
        <td><?=htmlspecialchars($r['exam_name'])?></td>
        <td><?=$r['exam_date']?></td>
        <td><?=htmlspecialchars($r['course_name'])?></td>
        <td>
          <a href="exams.php?action=edit&id=<?=$r['id']?>" class="btn btn-sm btn-primary">Edit</a>
          <a href="exams.php?action=delete&id=<?=$r['id']?>" onclick="return confirm('Delete?')" class="btn btn-sm btn-danger">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
