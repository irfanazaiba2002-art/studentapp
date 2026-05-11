<?php
session_start();
include('includes/dbconnection.php');

if (empty($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
}

$uid = intval($_SESSION['user_id']);
$msg = "";

// fetch existing profile
$res = mysqli_query($con, "SELECT * FROM students WHERE user_id='$uid' LIMIT 1");
$profile = mysqli_fetch_assoc($res);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_profile'])) {

    $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
    $parent_number = mysqli_real_escape_string($con, $_POST['parent_number']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $state = mysqli_real_escape_string($con, $_POST['state']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $dob = $_POST['dob'] ?: NULL;
    $course_id = intval($_POST['course_id']);

    // handle photo
    $photo = $profile['profile_photo'] ?? '';
    if (!empty($_FILES['photo']['name'])) {
        $fn = time() . "_" . preg_replace('/[^a-zA-Z0-9\._-]/', '_', $_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], __DIR__ . "/uploads/$fn");
        $photo = $fn;
    }

    if ($profile) {
        // update
        $sql = "UPDATE students SET 
                fullname='$fullname',
                parent_number='$parent_number',
                gender='$gender',
                state='$state',
                city='$city',
                address='$address',
                dob=" . ($dob ? "'$dob'" : "NULL") . ",
                course_id='$course_id',
                profile_photo='$photo'
                WHERE user_id='$uid'";

        mysqli_query($con, $sql);
        $msg = "Profile updated.";

    } else {
        // insert
        $sql = "INSERT INTO students (user_id, fullname, parent_number, gender, state, city, address, dob, course_id, profile_photo)
                VALUES ('$uid', '$fullname', '$parent_number', '$gender', '$state', '$city', '$address', 
                " . ($dob ? "'$dob'" : "NULL") . ", '$course_id', '$photo')";

        mysqli_query($con, $sql);
        $msg = "Profile saved.";
    }

    header("Location: profile.php?msg=" . urlencode($msg));
    exit();
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>My Profile</title>
  <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .profile-img {
        width:140px;
        height:140px;
        border-radius:50%;
        object-fit:cover;
    }
  </style>
</head>
<body>

<?php include('leftbar.php'); ?>

<div class="container mt-4">
  <h3>Student Profile</h3>

  <?php if(!empty($_GET['msg'])): ?>
      <div class="alert alert-success"><?=htmlentities($_GET['msg'])?></div>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data">
    <div class="row">

      <!-- PROFILE PHOTO -->
      <div class="col-md-3 text-center">
        <img src="uploads/<?= htmlspecialchars($profile['profile_photo'] ?? 'default.png') ?>" class="profile-img mb-2">
        <input type="file" name="photo" class="form-control-file">
      </div>

      <!-- FORM FIELDS -->
      <div class="col-md-9">

        <!-- NAME + PARENT NUMBER -->
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Name</label>
            <input name="fullname" class="form-control" value="<?= htmlspecialchars($profile['fullname'] ?? '') ?>">
          </div>

          <div class="form-group col-md-6">
            <label>Parent Number</label>
            <input name="parent_number" class="form-control" value="<?= htmlspecialchars($profile['parent_number'] ?? '') ?>">
          </div>
        </div>

        <!-- GENDER + DOB + COURSE ID -->
        <div class="form-row">
          <div class="form-group col-md-4">
            <label>Gender</label>
            <select name="gender" class="form-control">
              <option value="">Select</option>
              <option <?= ($profile['gender'] ?? '')=='Male' ? 'selected' : '' ?>>Male</option>
              <option <?= ($profile['gender'] ?? '')=='Female' ? 'selected' : '' ?>>Female</option>
              <option <?= ($profile['gender'] ?? '')=='Other' ? 'selected' : '' ?>>Other</option>
            </select>
          </div>

          <div class="form-group col-md-4">
            <label>DOB</label>
            <input name="dob" type="date" class="form-control" value="<?= htmlspecialchars($profile['dob'] ?? '') ?>">
          </div>

          <div class="form-group col-md-4">
            <label>Course ID</label>
            <input name="course_id" class="form-control" value="<?= htmlspecialchars($profile['course_id'] ?? '') ?>">
          </div>
        </div>

        <!-- STATE + CITY -->
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>State</label>
            <input name="state" class="form-control" value="<?= htmlspecialchars($profile['state'] ?? '') ?>">
          </div>

          <div class="form-group col-md-6">
            <label>City</label>
            <input name="city" class="form-control" value="<?= htmlspecialchars($profile['city'] ?? '') ?>">
          </div>
        </div>

        <!-- ADDRESS -->
        <div class="form-group">
          <label>Address</label>
          <textarea name="address" class="form-control" rows="3"><?= htmlspecialchars($profile['address'] ?? '') ?></textarea>
        </div>

        <button name="save_profile" class="btn btn-primary">Save Profile</button>

      </div>
    </div>
  </form>
</div>

</body>
</html>
