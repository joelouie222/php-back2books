<?php
// // Database configuration
// define('DB_HOST', 'ara-webtech-db.mysql.database.azure.com');
// define('DB_USER', 'arallia');
// define('DB_PASS', 'Tanaka32!!');
// define('DB_NAME', 'table');

// $db_conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// // Check the database connection
// if ($db_conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// PHP Data Objects(PDO) Sample Code:
try {
    $AZURE_SQL_DATABASE = getenv('AZURE_SQL_DATABASE');
    $AZURE_SQL_PWD = getenv('AZURE_SQL_PWD');
    $AZURE_SQL_SERVERNAME = getenv('AZURE_SQL_PWD');
    $AZURE_SQL_UID = getenv('AZURE_SQL_UID');

    $echo "<p>
                AZURE_SQL_DATABASE: $AZURE_SQL_DATABASE </br>
                AZURE_SQL_PWD: $AZURE_SQL_PWD </br>
                AZURE_SQL_SERVERNAME: $AZURE_SQL_SERVERNAME </br>
                AZURE_SQL_UID: $AZURE_SQL_UID </br>
            </p>";


    $conn = new PDO("sqlsrv:server = tcp:php-b2b-db-srvr.database.windows.net,1433; Database = php-b2b-db", "phpb2badmin", "{your_password_here}");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}

// SQL Server Extension Sample Code:
$connectionInfo = array("UID" => "phpb2badmin", "pwd" => "{your_password_here}", "Database" => "php-b2b-db", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:php-b2b-db-srvr.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);

?>