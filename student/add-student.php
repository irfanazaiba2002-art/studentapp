<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['user_id']) == 0) {
    header('location:login.php');
}

// Insert student
$msg = "";

if (isset($_POST['submit'])) {

    $fullname = $_POST['fullname'];
    $rollno = $_POST['rollno'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $subject = $_POST['subject'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $regdate = date("Y-m-d");

    // Check duplicate roll number
    $check1 = mysqli_query($con, "SELECT RollNumber FROM tblstudent WHERE RollNumber='$rollno'");
    if (mysqli_num_rows($check1) > 0) {
        $msg = "Roll number already exists!";
    }

    // Check duplicate email
    $check2 = mysqli_query($con, "SELECT Email FROM tblstudent WHERE Email='$email'");
    if (mysqli_num_rows($check2) > 0) {
        $msg = "Email already exists!";
    }

    // Insert
    if ($msg == "") {
        $query = mysqli_query($con, "INSERT INTO tblstudent
        (FullName, RollNumber, Email, CourseID, SubjectID, StateID, CityID, RegistrationDate)
        VALUES ('$fullname','$rollno','$email','$course','$subject','$state','$city','$regdate')");

        if ($query) {
            $msg = "Student added successfully!";
        } else {
            $msg = "Something went wrong!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        label { font-weight: bold; }
    </style>
</head>

<body>
<?php include('leftbar.php'); ?>

<div class="container" style="margin-left:260px;">
    <h3 class="page-header">Add New Student</h3>

    <?php if ($msg != "") { ?>
        <div class="alert alert-info"><?php echo $msg; ?></div>
    <?php } ?>

    <form method="post">

        <!-- Full Name -->
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="fullname" class="form-control" required>
        </div>

        <!-- Roll Number -->
        <div class="form-group">
            <label>Roll Number</label>
            <input type="text" name="rollno" class="form-control" required>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <!-- Course -->
        <div class="form-group">
            <label>Select Course</label>
            <select name="course" id="course" class="form-control" required>
                <option value="">Select Course</option>
                <?php
                $courses = mysqli_query($con, "SELECT * FROM tbl_course");
                while ($row = mysqli_fetch_array($courses)) {
                    echo "<option value='".$row['cid']."'>".$row['cfull']."</option>";
                }
                ?>
            </select>
        </div>

        <!-- Subject (Auto-loaded) -->
        <div class="form-group">
            <label>Select Subject</label>
            <select name="subject" id="subject" class="form-control" required>
                <option value="">Select Course First</option>
            </select>
        </div>

        <!-- State -->
        <div class="form-group">
            <label>Select State</label>
            <select name="state" id="state" class="form-control" required>
                <option value="">Select State</option>
                <?php
                $state = mysqli_query($con, "SELECT * FROM state");
                while ($row = mysqli_fetch_array($state)) {
                    echo "<option value='".$row['id']."'>".$row['StateName']."</option>";
                }
                ?>
            </select>
        </div>

        <!-- City (Auto-loaded) -->
        <div class="form-group">
            <label>Select City</label>
            <select name="city" id="city" class="form-control" required>
                <option value="">Select State First</option>
            </select>
        </div>

        <br>

        <!-- Submit -->
        <button type="submit" name="submit" class="btn btn-primary">Add Student</button>

    </form>
</div>

<script src="bower_components/jquery/dist/jquery.min.js"></script>

<script>
// Load subjects when course changes
$(document).on("change", "#course", function() {
    var courseid = $(this).val();

    $.ajax({
        url: "fetch_subjects.php",
        type: "POST",
        data: {courseid: courseid},
        success: function(data) {
            $("#subject").html(data);
        }
    });
});

// Load cities when state changes
$(document).on("change", "#state", function() {
    var stateid = $(this).val();

    $.ajax({
        url: "fetch_cities.php",
        type: "POST",
        data: {stateid: stateid},
        success: function(data) {
            $("#city").html(data);
        }
    });
});
</script>

</body>
</html>