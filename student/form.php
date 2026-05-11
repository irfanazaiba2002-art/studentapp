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

    
    <style>
        #side-menu {
    background: linear-gradient(180deg, #dbe9ff, #f2f6ff);
    padding-top: 10px;
    border-right: 1px solid #c5d8ff;
}

#side-menu li a {
    color: #003366 !important;
    font-size: 16px;
    font-weight: 600;
    padding: 12px 20px;
    border-radius: 8px;
    margin: 4px 10px;
    display: block;
    transition: 0.3s ease;
}

/* ICON COLOR */
#side-menu li a i {
    color: #0055aa;
    margin-right: 8px;
}

/* HOVER EFFECT */
#side-menu li a:hover {
    background: #b7d4ff !important;
    color: #00284d !important;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

/* ACTIVE MENU */
#side-menu li.active > a {
    background: #6aa9ff !important;
    color: #ffffff !important;
}

#side-menu li.active > a i {
    color: white !important;
}
    /* DASHBOARD CARD STYLE */
    .dash-card {
        border-radius: 15px;
        padding: 30px;
        color: #fff;
        margin-bottom: 30px;
        text-align: center;
        transition: 0.3s ease;
        box-shadow: 0 8px 18px rgba(0,0,0,0.15);
        position: relative;
    }

    .dash-card i {
        margin-bottom: 15px;
    }

    .dash-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.25);
        opacity: 0.95;
    }

    .dash-title {
        font-size: 22px;
        font-weight: 600;
        margin-top: 10px;
        margin-bottom: 5px;
    }

    /* MODIFY PANEL COLORS */
    .panel {
        border-radius: 15px !important;
        overflow: hidden;
        box-shadow: 0 8px 18px rgba(0,0,0,0.12);
        transition: 0.3s ease;
    }

    .panel:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 26px rgba(0,0,0,0.2);
    }

    .panel-heading {
        border-radius: 15px 15px 0 0 !important;
    }

    /* HEADER TITLE */
    .page-header {
        font-weight: bold;
        font-size: 26px;
        margin-bottom: 25px;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* ICON COLORS */
    .fa {
        opacity: 0.9;
    }

    /* LINKS INSIDE CARDS */
    .dash-card a {
        display: block;
        margin-top: 8px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: underline;
    }
</style>

</head>

<body>
<form method="post">
<div id="wrapper">

<?php include('leftbar.php'); ?>

<div id="page-wrapper">
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <?php echo strtoupper("WELCOME " . htmlentities($_SESSION['username'])); ?>
        </h3>
    </div>
</div>


<!-- ==========================================
     FIRST ROW → PROFILE | COURSES | SUBJECTS
=========================================== -->
<div class="row">

    <!-- PROFILE -->
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3"><i class="fa fa-user fa-5x"></i></div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">My Profile</div>
                        <div>View Details</div>
                    </div>
                </div>
            </div>
            <a href="profile.php">
                <div class="panel-footer">
                    <span class="pull-left">Open</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <!-- COURSES -->
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3"><i class="fa fa-file fa-5x"></i></div>
                    <?php 
                    $qc = mysqli_query($con, "SELECT cid FROM tbl_course");
                    $count_course = mysqli_num_rows($qc);
                    ?>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $count_course; ?></div>
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
                    <div class="col-xs-3"><i class="fa fa-files-o fa-5x"></i></div>
                    <?php 
                    $qs = mysqli_query($con, "SELECT subid FROM subject");
                    $count_sub = mysqli_num_rows($qs);
                    ?>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $count_sub; ?></div>
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

</div> <!-- end row -->


<!-- ==========================================
     SECOND ROW → ATTENDANCE | EXAMS | RESULTS | NOTICE
=========================================== -->
<div class="row">

    <div class="col-lg-3 col-md-6">
        <div class="dash-card" style="background:#6A5ACD;">
            <i class="fa fa-calendar-check-o fa-3x"></i>
            <div class="dash-title">Attendance</div>
            <a href="attendance.php" style="color:white;text-decoration:none;">Open →</a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="dash-card" style="background:#FF5722;">
            <i class="fa fa-pencil-square-o fa-3x"></i>
            <div class="dash-title">Exams</div>
            <a href="exams.php" style="color:white;text-decoration:none;">Open →</a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="dash-card" style="background:#009688;">
            <i class="fa fa-graduation-cap fa-3x"></i>
            <div class="dash-title">Results</div>
            <a href="results.php" style="color:white;text-decoration:none;">Open →</a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="dash-card" style="background:#E91E63;">
            <i class="fa fa-bullhorn fa-3x"></i>
            <div class="dash-title">Notice Board</div>
            <a href="notice.php" style="color:white;text-decoration:none;">Open →</a>
        </div>
    </div>

</div>


</div> <!-- page wrapper -->
</div> <!-- wrapper -->
</form>

<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>
<script src="dist/js/sb-admin-2.js"></script>

</body>
</html>
