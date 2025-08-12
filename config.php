<?php
// Define the HOME URL dynamically based on the server's host and protocol
$host = $_SERVER['HTTP_HOST']; // Includes port if present

// Determine if the request is secure (HTTPS) or not (HTTP)
// proxy servers may set HTTP_X_FORWARDED_PROTO to 'https' for secure requests for applications running behind load balancers or reverse proxies.
$scheme = (
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
    (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') 
) ? 'https' : 'http';

// Construct the HOME URL
$HOME = $scheme . '://' . $host . '/';


// Get environment variables for Azure SQL Database connection
$AZURE_SQL_DATABASE = getenv('AZURE_SQL_DATABASE');
$AZURE_SQL_PWD = getenv('AZURE_SQL_PWD');
$AZURE_SQL_SERVERNAME = getenv('AZURE_SQL_SERVERNAME');
$AZURE_SQL_UID = getenv('AZURE_SQL_UID');

// SQL Server Extension Sample Code:
$connectionInfo = array(
    "UID" => $AZURE_SQL_UID, 
    "pwd" => $AZURE_SQL_PWD, 
    "Database" => $AZURE_SQL_DATABASE, 
    "LoginTimeout" => 30, 
    "Encrypt" => 1, 
    "TrustServerCertificate" => 0);
$serverName = "tcp:" . $AZURE_SQL_SERVERNAME;

$conn = sqlsrv_connect($serverName, $connectionInfo);
if (!$conn) {
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
}

?>
