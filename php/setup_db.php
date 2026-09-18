<?php
// php/setup_db.php
// Helper script to ensure the MySQL database exists and import the initial schema.

require_once __DIR__ . '/config.php';

// Create a connection without selecting a database first.
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, '', DB_PORT);
if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

// Check if the database exists.
$dbName = DB_NAME;
$check = $mysqli->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '{$dbName}'");
if ($check && $check->num_rows == 0) {
    // Create database
    if (!$mysqli->query("CREATE DATABASE `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")) {
        die('Failed to create database: ' . $mysqli->error);
    }
    echo "Database `{$dbName}` created successfully.\n";
} else {
    echo "Database `{$dbName}` already exists.\n";
}

// Select the database
$mysqli->select_db($dbName);

// Import the SQL dump if it exists.
$sqlFile = __DIR__ . '/../database.sql';
if (!file_exists($sqlFile)) {
    die('SQL dump file not found at ' . $sqlFile);
}

$sql = file_get_contents($sqlFile);
if ($sql === false) {
    die('Failed to read SQL file.');
}

// Execute multiple queries
if ($mysqli->multi_query($sql)) {
    do {
        // Store result to move to next query
        if ($result = $mysqli->store_result()) {
            $result->free();
        }
    } while ($mysqli->more_results() && $mysqli->next_result());
    echo "Database import completed successfully.\n";
} else {
    die('Error importing database: ' . $mysqli->error);
}

$mysqli->close();
?>
