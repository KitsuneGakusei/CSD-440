<?php
/*
  Name: Crystal Long
  Date: 2026-02-20
  Assignment: Module 8 - MySQLi Table Scripts (Create/Drop/Populate/Query)
*/

/* Purpose: Run SELECT queries to demonstrate testing of the CrystalVideoGames table. */


// ----------------------------------------------------
// Database connection information
// ----------------------------------------------------
$databaseHost = "localhost";
$databaseUser = "student1";
$databasePassword = "pass";
$databaseName = "baseball_01";

$connection = mysqli_connect($databaseHost, $databaseUser, $databasePassword, $databaseName);

if (!$connection) {
  die("Connection failed: " . mysqli_connect_error());
}


// ----------------------------------------------------
// Query 1: All games sorted by highest rating
// ----------------------------------------------------
$sqlAllGames = "
  SELECT gameId, title, platform, genre, releaseYear, userRating, isCompleted, dateAdded
  FROM CrystalVideoGames
  ORDER BY userRating DESC
";

$resultAllGames = mysqli_query($connection, $sqlAllGames);

echo "<h3>All Games (Sorted by Rating)</h3>";

if ($resultAllGames) {
  while ($row = mysqli_fetch_assoc($resultAllGames)) {
    echo "Title: " . $row["title"] .
         " | Rating: " . $row["userRating"] .
         " | Platform: " . $row["platform"] .
         "<br>";
  }
} else {
  echo "Query failed: " . mysqli_error($connection);
}

echo "<br>";


// ----------------------------------------------------
// Query 2: Completed games
// ----------------------------------------------------
$sqlCompletedGames = "
  SELECT title, platform, userRating
  FROM CrystalVideoGames
  WHERE isCompleted = 1
  ORDER BY title ASC
";

$resultCompletedGames = mysqli_query($connection, $sqlCompletedGames);

echo "<h3>Completed Games</h3>";

if ($resultCompletedGames) {
  while ($row = mysqli_fetch_assoc($resultCompletedGames)) {
    echo "Title: " . $row["title"] .
         " | Platform: " . $row["platform"] .
         " | Rating: " . $row["userRating"] .
         "<br>";
  }
} else {
  echo "Query failed: " . mysqli_error($connection);
}

echo "<br>";


// ----------------------------------------------------
// Query 3: Unfinished games (Polished Addition)
// ----------------------------------------------------
$sqlUnfinishedGames = "
  SELECT title, platform, userRating
  FROM CrystalVideoGames
  WHERE isCompleted = 0
  ORDER BY userRating DESC
";

$resultUnfinishedGames = mysqli_query($connection, $sqlUnfinishedGames);

echo "<h3>Unfinished Games</h3>";

if ($resultUnfinishedGames) {
  while ($row = mysqli_fetch_assoc($resultUnfinishedGames)) {
    echo "Title: " . $row["title"] .
         " | Platform: " . $row["platform"] .
         " | Rating: " . $row["userRating"] .
         "<br>";
  }
} else {
  echo "Query failed: " . mysqli_error($connection);
}


// ----------------------------------------------------
// Close database connection
// ----------------------------------------------------
mysqli_close($connection);

?>