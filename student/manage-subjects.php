<?php
session_start();
include('includes/dbconnection.php');

// Redirect if user is not logged in
if (empty($_SESSION['user_id'])) {
    header('location:login.php');
    exit;
}

// Delete subject logic
if (isset($_GET['del'])) {
    $courseid = intval($_GET['del']);
    $stmt = $con->prepare("DELETE FROM subject WHERE subid = ?");
    $stmt->bind_param("i", $courseid);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Subject deleted successfully.";
    } else {
        $_SESSION['error_message'] = "Failed to delete subject.";
    }

    $stmt->close();
    header("Location: manage-subjects.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>view subject</title>
    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
    <link href="bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    

</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->
        <?php include('leftbar.php'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header">
                        <?php echo strtoupper("Welcome " . htmlentities($_SESSION['username'])); ?>
                    </h4>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            View Subjects
                        </div>
                        <div class="panel-body">
                            <!-- Display messages -->
                            <?php if (!empty($_SESSION['success_message'])): ?>
                                <div class="alert alert-success">
                                    <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                                </div>
                            <?php elseif (!empty($_SESSION['error_message'])): ?>
                                <div class="alert alert-danger">
                                    <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                                </div>
                            <?php endif; ?>

                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S No</th>
                                            <th>Course</th>
                                            <th>Subject 1</th>
                                            <th>Subject 2</th>
                                            <th>Subject 3</th>
                                            <th>Subject 4</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $stmt = $con->prepare("SELECT * FROM subject");
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $sn = 1;

                                        while ($res = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>{$sn}</td>";
                                            echo "<td>" . htmlentities(strtoupper($res['cfull'])) . "</td>";
                                            echo "<td>" . htmlentities(strtoupper($res['sub1'])) . "</td>";
                                            echo "<td>" . htmlentities(strtoupper($res['sub2'])) . "</td>";
                                            echo "<td>" . htmlentities(strtoupper($res['sub3'])) . "</td>";
                                            echo "<td>" . htmlentities(strtoupper($res['sub4'])) . "</td>";
                                            echo "<td width='100'>
                                                <a href='edit-subject.php?sid=" . htmlentities($res['subid']) . "' class='btn btn-primary btn-xs'>Edit</a>
                                                <a href='manage-subjects.php?del=" . htmlentities($res['subid']) . "' class='btn btn-danger btn-xs' onclick='return confirm(\"Are you sure you want to delete this subject?\")'>Delete</a>
                                              </td>";
                                            echo "</tr>";
                                            $sn++;
                                        }

                                        $stmt->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 <!-- jQuery -->
 <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <!-- DataTables JavaScript -->
    <script src="bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>
</body>

</html>
