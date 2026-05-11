<?php
session_start();
include('includes/dbconnection.php');

if (empty($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
} else {

    $success_message = "";
    $error_message = "";

    if (isset($_GET['del'])) {
        $courseid = $_GET['del'];
        $query = mysqli_query($con, "DELETE FROM tbl_course WHERE cid='$courseid'");
        
        if ($query) {
            $_SESSION['success_message'] = "Course deleted successfully!";
        }
        header('location: manage-courses.php');
        exit();
    }

    if (isset($_SESSION['success_message'])) {
        $success_message = $_SESSION['success_message'];
        unset($_SESSION['success_message']);
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Manage Courses</title>
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
    <link href="bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="wrapper">
        <?php include('leftbar.php'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header"><?php echo strtoupper("welcome " . htmlentities($_SESSION['username'])); ?></h4>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Manage Courses</div>

                        <div class="panel-body">
                            <!-- Success Message Display -->
                            <?php if (!empty($success_message)): ?>
                                <div class="alert alert-success"><?php echo $success_message; ?></div>
                            <?php endif; ?>

                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S No</th>
                                            <th>Short Name</th>
                                            <th>Full Name</th>
                                            <th>Created Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysqli_query($con, "SELECT * FROM tbl_course");
                                        $sn = 1;
                                        while ($res = mysqli_fetch_array($query)) { ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $sn; ?></td>
                                                <td><?php echo htmlentities(strtoupper($res['cshort'])); ?></td>
                                                <td><?php echo htmlentities(strtoupper($res['cfull'])); ?></td>
                                                <td><?php echo htmlentities($res['cdate']); ?></td>
                                                <td>
                                                    <a href="edit-course.php?cid=<?php echo htmlentities($res['cid']); ?>" class="btn btn-primary">Edit</a>
                                                    <a href="manage-courses.php?del=<?php echo htmlentities($res['cid']); ?>" class="btn btn-danger" onclick="return confirm('Do you really want to delete?');">Delete</a>
                                                </td>
                                            </tr>
                                        <?php $sn++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <script src="bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    <script src="dist/js/sb-admin-2.js"></script>

    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>
</body>

</html>
<?php } ?>
