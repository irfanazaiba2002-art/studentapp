<?php
$dbuser = "root";
$dbpass = "";
$host = "db";
$dbname = "studentrecorddb";

$mysqli = new mysqli($host, $dbuser, $dbpass, $dbname);

// Check if "cshort" is not empty
if (!empty($_POST['cshort'])) {
$cshort = $_POST['cshort'];
$stmt = $mysqli->prepare("SELECT COUNT(*) FROM tbl_course WHERE cshort=?");
$stmt->bind_param('s', $cshort);
$stmt->execute();
 $stmt->bind_result($count);
 $stmt->fetch();
 $stmt->close();

 if ($count > 0) {
  echo "<span style='color:red'> Course Short Name Already Exists.</span>";
 } else {
  echo "<span style='color:green'> Available</span>";
 }
}
// Check if "cshort1" is not empty
if (!empty($_POST['cshort1'])) {
    $cshort = $_POST['cshort1'];
    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM subject WHERE cshort=?");
    $stmt->bind_param('s', $cshort); //'s' as it is a string
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
   
    if ($count > 0) {
     echo "<span style='color:red'> Course Short Name Already Exists.</span>";
    } else {
     echo "<span style='color:green'> Available</span>";
    }
   }

// Check if "cfull" is not empty
if (!empty($_POST['cfull'])) {
 $cfull = $_POST['cfull'];
 $stmt = $mysqli->prepare("SELECT COUNT(*) FROM tbl_course WHERE cfull=?");
 $stmt->bind_param('s', $cfull);
 $stmt->execute();
 $stmt->bind_result($count);
 $stmt->fetch();
 $stmt->close();

 if ($count > 0) {
  echo "<span style='color:red'> Course Full Name Already Exists.</span>";
 } else {
  echo "<span style='color:green'> Available</span>";
 }
}
// Check if "cfull1" is not empty
if (!empty($_POST['cfull1'])) {
    $cfull = $_POST['cfull1'];
    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM subject WHERE cfull=?");
    $stmt->bind_param('s', $cfull);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
   
    if ($count > 0) {
     echo "<span style='color:red'> Course Full Name Already Exists.</span>";
    } else {
     echo "<span style='color:green'> Available</span>";
    }
   }
?>