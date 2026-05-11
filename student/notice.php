<?php
session_start();
include('includes/dbconnection.php');
if (empty($_SESSION['user_id'])) { header('location:login.php'); exit(); }

$action = $_GET['action'] ?? '';
$id = intval($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $desc = mysqli_real_escape_string($con, $_POST['description']);

    if (!empty($_POST['id'])) {
        $nid = intval($_POST['id']);
        mysqli_query($con, "UPDATE notices SET title='$title', description='$desc' WHERE id='$nid'");
    } else {
        mysqli_query($con, "INSERT INTO notices (title, description) VALUES ('$title','$desc')");
    }
    header("Location: notice.php");
    exit();
}

if ($action === 'delete' && $id) {
    mysqli_query($con, "DELETE FROM notices WHERE id='$id'");
    header("Location: notice.php");
    exit();
}

$editing = null;
if ($action === 'edit' && $id) {
    $editing = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM notices WHERE id='$id' LIMIT 1"));
}

$list = mysqli_query($con, "SELECT * FROM notices ORDER BY created_at DESC");
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Notices</title>
  <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('leftbar.php'); ?>
<div class="container mt-3">
  <h3>Notice Board</h3>

  <div class="card mb-3">
    <div class="card-body">
      <form method="post">
        <input type="hidden" name="id" value="<?= $editing['id'] ?? '' ?>">
        <div class="form-group">
          <label>Title</label>
          <input name="title" class="form-control" value="<?= htmlspecialchars($editing['title'] ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($editing['description'] ?? '') ?></textarea>
        </div>
        <button class="btn btn-success">Save Notice</button>
      </form>
    </div>
  </div>

  <ul class="list-group">
    <?php while($n = mysqli_fetch_assoc($list)): ?>
      <li class="list-group-item">
        <h5><?=htmlspecialchars($n['title'])?> <small class="text-muted"><?= $n['created_at'] ?></small></h5>
        <p><?=nl2br(htmlspecialchars($n['description']))?></p>
        <p>
          <a href="notice.php?action=edit&id=<?=$n['id']?>" class="btn btn-sm btn-primary">Edit</a>
          <a href="notice.php?action=delete&id=<?=$n['id']?>" onclick="return confirm('Delete?')" class="btn btn-sm btn-danger">Delete</a>
        </p>
      </li>
    <?php endwhile; ?>
  </ul>
</div>
</body>
</html>
