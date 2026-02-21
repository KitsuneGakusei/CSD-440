<?php
/*
  Name: Crystal Long
  Date: 2026-02-20
  Assignment: Module 8 - MySQLi Table Scripts (Create/Drop/Populate/Query)
*/

/* Purpose: Drop the CrystalVideoGames table from the baseball_01 database. */


// ------------------------------
// Database connection
// ------------------------------
$dbHost = "localhost";
$dbUser = "student1";
$dbPass = "pass";
$dbName = "baseball_01";

$connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

if (!$connection) {
  die("Connection failed: " . mysqli_connect_error());
}


// ------------------------------
// SQL statement to drop table
// ------------------------------
$sql = "DROP TABLE IF EXISTS CrystalVideoGames";


// ------------------------------
// Execute and report results
// ------------------------------
$result = mysqli_query($connection, $sql);

if ($result) {
  echo "Success: Table CrystalVideoGames was dropped (if it existed).";
} else {
  echo "Error dropping table: " . mysqli_error($connection);
}


// ------------------------------
// Close connection
// ------------------------------
mysqli_close($connection);
?>