<?php
session_start();
include('includes/dbconnection.php');

if (empty($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
}

$success_message = "";
$error_message = "";

// Form Submission Handling
if (isset($_POST['submit'])) {
    $cshortname = mysqli_real_escape_string($con, $_POST['course-short']);
    $cfullname = mysqli_real_escape_string($con, $_POST['course-full']);
    $cdate = mysqli_real_escape_string($con, $_POST['cdate']);

    // Using Prepared Statement for Security
    $stmt = $con->prepare("INSERT INTO tbl_course (cshort, cfull, cdate) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $cshortname, $cfullname, $cdate);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Course added successfully.";
        header('location: manage-courses.php'); 
        exit();
    } else {
        $error_message = "Something went wrong. Please try again.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Add Course</title>
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
    <form method="post">
        <div id="wrapper">
            <!-- Navigation -->
            <?php include('leftbar.php'); ?>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h4 class="page-header"><?php echo strtoupper("welcome " . htmlentities($_SESSION['username'])); ?></h4>

                        <!-- Displaying Messages -->
                        <?php if (!empty($error_message)): ?>
                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php elseif (!empty($_SESSION['success_message'])): ?>
                            <div class="alert alert-success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
                        <?php endif; ?>

                    </div>
                </div>

                <!-- Form Section -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Add Course</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Course Short Name<span style="font-size:11px;color:red">*</span></label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input class="form-control" name="course-short" id="cshort" required onblur="courseAvailability()">
                                                <span id="course-availability-status" style="font-size:12px;"></span>
                                            </div>
                                        </div>
                                        <br><br>

                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Course Full Name<span style="font-size:11px;color:red">*</span></label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input class="form-control" name="course-full" id="cfull" required onblur="coursefullAvail()">
                                                <span id="course-status" style="font-size:12px;"></span>
                                            </div>
                                        </div>
                                        <br><br>

                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Creation Date</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input class="form-control" value="<?php echo date('d-m-Y'); ?>" readonly name="cdate">
                                            </div>
                                        </div>
                                    </div>
                                    <br><br>

                                    <div class="form-group">
                                        <div class="col-lg-6 col-lg-offset-4"><br><br>
                                            <input type="submit" class="btn btn-primary" name="submit" value="Create Course">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <script src="dist/js/sb-admin-2.js"></script>

    <script>
        function courseAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "course_availability.php",
                data: { cshort: $("#cshort").val() }, 
                type: "POST",
                success: function(data) {
                    $("#course-availability-status").html(data);
                    $("#loaderIcon").hide();
                },
                error: function(xhr, status, error) {
                    alert('Error checking course short name: ' + error);
                }
            });
        }

        function coursefullAvail() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "course_availability.php",
                data: { cfull: $("#cfull").val() },
                type: "POST",
                success: function(data) {
                    $("#course-status").html(data);
                    $("#loaderIcon").hide();
                },
                error: function(xhr, status, error) {
                    alert('Error checking course full name: ' + error);
                }
            });
        }
    </script>
</body>
</html>
