<?php
/*
  Name: Crystal Long
  Date: 2026-02-20
  Assignment: Module 8 - MySQLi Table Scripts (Create/Drop/Populate/Query)
*/

/* Purpose: Create the CrystalVideoGames table in the baseball_01 database. */


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
// SQL statement to create table
// ------------------------------
$sql = "
  CREATE TABLE IF NOT EXISTS CrystalVideoGames (
    gameId INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(120) NOT NULL,
    platform VARCHAR(60) NOT NULL,
    genre VARCHAR(40) NOT NULL,
    releaseYear INT NOT NULL,
    userRating DECIMAL(3,1) NOT NULL,
    isCompleted TINYINT(1) NOT NULL DEFAULT 0,
    dateAdded DATE NOT NULL
  )
";


// ------------------------------
// Execute and report results
// ------------------------------
$result = mysqli_query($connection, $sql);

if ($result) {
  echo "Success: Table CrystalVideoGames was created (or already exists).";
} else {
  echo "Error creating table: " . mysqli_error($connection);
}


// ------------------------------
// Close connection
// ------------------------------
mysqli_close($connection);
?>