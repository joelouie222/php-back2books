<?php
// Database configuration
define('DB_HOST', 'ara-webtech-db.mysql.database.azure.com');
define('DB_USER', 'arallia');
define('DB_PASS', 'Tanaka32!!');
define('DB_NAME', 'table');

$db_conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check the database connection
if ($db_conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>