<?php
session_start();
include('includes/dbconnection.php');

// ✅ CHECK: use user_id (what your login.php sets) instead of aid
if (empty($_SESSION['user_id'])) {
    header('location:login.php');
    exit;
}

if (isset($_POST['submit'])) {
    $cdata = $_POST['course-short'];

    // ✅ DELIMITER changed to '|' to match option value below
    $coursedata = explode('|', $cdata);

    if (count($coursedata) === 2) {
        $cshortname = $coursedata[0];
        $cfullname = $coursedata[1];

        $sub1 = $_POST['sub1'];
        $sub2 = $_POST['sub2'];
        $sub3 = $_POST['sub3'];
        $sub4 = $_POST['sub4'];

        // Use prepared statements for database insertion
        $stmt = $con->prepare("INSERT INTO subject (cshort, cfull, sub1, sub2, sub3, sub4) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $cshortname, $cfullname, $sub1, $sub2, $sub3, $sub4);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Subject added successfully.";
            $stmt->close();
            header("Location: manage-subjects.php");
            exit;
        } else {
            $error_message = "Something went wrong. Please try again.";
        }
    } else {
        $error_message = "Invalid course data. Please try again.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add Subject</title>
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body>
    <form method="post">
        <div id="wrapper">

            <!-- Navigation -->
            <?php include('leftbar.php'); ?>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- ✅ show username (what login.php sets) -->
                        <h4 class="page-header"> <?php echo strtoupper("WELCOME " . " " . htmlentities($_SESSION['username'])); ?></h4>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->

                <!-- show any error/success messages -->
                <div class="row">
                    <div class="col-lg-12">
                        <?php if (!empty($error_message)): ?>
                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php elseif (!empty($_SESSION['success_message'])): ?>
                            <div class="alert alert-success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Add Subject</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-10">

                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Course Short Name<span id="" style="font-size:11px;color:Red">*</span> </label>
                                            </div>

                                            <div class="col-lg-6">
                                                <!--
                                                    ✅ FIXED: option value now contains "cshort|cfull"
                                                    (we split on '|' in PHP above)
                                                -->
                                                <select class="form-control" name="course-short" id="cshort" onchange="courseAvailability()" required="required">
                                                    <option value="">SELECT</option>
                                                    <?php
                                                    $query = mysqli_query($con, "SELECT * FROM tbl_course");
                                                    while ($res = mysqli_fetch_array($query)) {
                                                    ?>
                                                        <option value="<?php echo htmlentities($res['cshort'] . '|' . $res['cfull']); ?>">
                                                            <?php echo htmlentities($res['cshort']) ?> (<?php echo htmlentities($res['cfull']) ?>)
                                                        </option>
                                                    <?php } ?>
                                                </select>

                                                <span id="course-availability-status" style="font-size:12px;"></span>
                                            </div>

                                        </div>
                                    </div>

                                    <br><br>

                                    <div class="form-group">
                                        <div class="col-lg-4">
                                            <label>Subject 1</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input class="form-control" name="sub1" required>
                                        </div>
                                    </div>
                                    <br><br>

                                    <div class="form-group">
                                        <div class="col-lg-4">
                                            <label>Subject 2</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input class="form-control" name="sub2" required>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="form-group">
                                        <div class="col-lg-4">
                                            <label>Subject 3</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input class="form-control" name="sub3" required>

                                        </div>
                                    </div>

                                    <br><br>
                                    <div class="form-group">
                                        <div class="col-lg-4">
                                            <label>Subject 4</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input class="form-control" name="sub4">
                                        </div>
                                    </div>

                                </div>
                                <br><br><br>

                                <div class="form-group">
                                    <div class="col-lg-4">

                                    </div>
                                    <div class="col-lg-6"><br><br>
                                        <input type="submit" class="btn btn-primary" name="submit" value="Add Subject">
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </form>

    <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js" type="text/javascript"></script>

    <script>
        function courseAvailability() {
            var val = $("#cshort").val();
            if (!val) {
                $("#course-availability-status").html('');
                return;
            }
            // ✅ get only short name before the '|' delimiter
            var parts = val.split('|');
            var cshort = parts[0];

            $("#loaderIcon") && $("#loaderIcon").show();

            jQuery.ajax({
                url: "course_availability.php",
                data: { cshort1: cshort },
                type: "POST",
                success: function(data) {
                    $("#course-availability-status").html(data);
                    $("#loaderIcon") && $("#loaderIcon").hide();
                },
                error: function(xhr, status, err) {
                    console.error('AJAX error:', err);
                    $("#loaderIcon") && $("#loaderIcon").hide();
                }
            });
        }
    </script>
</body>

</html>
