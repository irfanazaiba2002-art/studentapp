<?php
$DB_HOST = 'db';        // Service name in docker-compose
$DB_USER = 'root';
$DB_PASS = '';          // Empty password
$DB_NAME = 'studentrecorddb';

// Create connection
$con = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

// Check connection
if ($con->connect_error) {
    die("Database connection failed: " . $con->connect_error);
}
?>
