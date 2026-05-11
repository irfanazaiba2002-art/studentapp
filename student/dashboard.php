<?php 
session_start();
include('includes/dbconnection.php');

if (empty($_SESSION['user_id'])) {
    header('location:logout.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard</title>

    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
<form method="post">
<div id="wrapper">

<?php include('leftbar.php'); ?>

<div id="page-wrapper">
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">
        <?php echo strtoupper("WELCOME " . htmlentities($_SESSION['username'])); ?>
        </h4>
    </div>
</div>

<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading">SDMS</div>
<div class="panel-body">
<div class="row">

<!-- COURSES -->
<div class="col-lg-4 col-md-6">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-file fa-5x"></i>
                </div>
                <?php 
                $query = mysqli_query($con, "SELECT cid FROM tbl_course");
                $listedcourses = mysqli_num_rows($query);
                ?>
                <div class="col-xs-9 text-right">
                    <div class="huge"><?php echo htmlentities($listedcourses); ?></div>
                    <div>Listed Courses</div>
                </div>
            </div>
        </div>
        <a href="manage-courses.php">
            <div class="panel-footer">
                <span class="pull-left">View Details</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>

<!-- SUBJECTS -->
<div class="col-lg-4 col-md-6">
    <div class="panel panel-green">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-files-o fa-5x"></i>
                </div>
                <?php 
                $query1 = mysqli_query($con, "SELECT subid FROM subject");
                $tsubjects = mysqli_num_rows($query1);
                ?>
                <div class="col-xs-9 text-right">
                    <div class="huge"><?php echo htmlentities($tsubjects);?></div>
                    <div>Subjects</div>
                </div>
            </div>
        </div>
        <a href="manage-subjects.php">
            <div class="panel-footer">
                <span class="pull-left">Courses Wise Subjects</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>



</div> <!-- row -->
</div> <!-- panel body -->
</div> <!-- panel -->
</div> <!-- col -->
</div> <!-- row -->

</div> <!-- page wrapper -->
</div> <!-- wrapper -->
</form>

<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>
<script src="dist/js/sb-admin-2.js"></script>

</body>
</html> 