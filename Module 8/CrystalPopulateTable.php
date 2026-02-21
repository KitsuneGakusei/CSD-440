<?php
/*
  Name: Crystal Long
  Date: 2026-02-20
  Assignment: Module 8 - MySQLi Table Scripts (Create/Drop/Populate/Query)
*/

/* Purpose: Insert sample favorite video game data into the CrystalVideoGames table. */


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
// SQL INSERT statements for favorite video games
// ----------------------------------------------------
$insertStatements = [

  "INSERT INTO CrystalVideoGames (title, platform, genre, releaseYear, userRating, isCompleted, dateAdded)
   VALUES ('Animal Crossing New Horizons', 'Switch', 'Simulation', 2020, 9.3, 1, '2026-02-20')",

  "INSERT INTO CrystalVideoGames (title, platform, genre, releaseYear, userRating, isCompleted, dateAdded)
   VALUES ('Pokemon Lets Go Eevee', 'Switch', 'RPG', 2018, 8.6, 1, '2026-02-20')",

  "INSERT INTO CrystalVideoGames (title, platform, genre, releaseYear, userRating, isCompleted, dateAdded)
   VALUES ('AI The Somnium Files', 'Switch', 'Visual Novel', 2019, 9.1, 1, '2026-02-20')",

  "INSERT INTO CrystalVideoGames (title, platform, genre, releaseYear, userRating, isCompleted, dateAdded)
   VALUES ('The Legend of Zelda Ocarina of Time', 'Nintendo 64', 'Action-Adventure', 1998, 9.9, 1, '2026-02-20')",

  "INSERT INTO CrystalVideoGames (title, platform, genre, releaseYear, userRating, isCompleted, dateAdded)
   VALUES ('Diablo 3', 'PC', 'Action RPG', 2012, 8.8, 1, '2026-02-20')",

  "INSERT INTO CrystalVideoGames (title, platform, genre, releaseYear, userRating, isCompleted, dateAdded)
   VALUES ('World of Warcraft', 'PC', 'MMORPG', 2004, 9.0, 0, '2026-02-20')",

  "INSERT INTO CrystalVideoGames (title, platform, genre, releaseYear, userRating, isCompleted, dateAdded)
   VALUES ('Final Fantasy XIV', 'PC', 'MMORPG', 2013, 9.4, 0, '2026-02-20')",

  "INSERT INTO CrystalVideoGames (title, platform, genre, releaseYear, userRating, isCompleted, dateAdded)
   VALUES ('Infinity Nikki', 'PC', 'Adventure', 2024, 8.9, 0, '2026-02-20')"
];


// ----------------------------------------------------
// Execute INSERT statements
// ----------------------------------------------------
$successfulInserts = 0;

foreach ($insertStatements as $sqlStatement) {

  $result = mysqli_query($connection, $sqlStatement);

  if ($result) {
    $successfulInserts++;
  } else {
    echo "Insert failed: " . mysqli_error($connection) . "<br>";
  }
}


// ----------------------------------------------------
// Display summary message
// ----------------------------------------------------
echo "Populate script complete. Successful inserts: " . $successfulInserts;


// ----------------------------------------------------
// Close database connection
// ----------------------------------------------------
mysqli_close($connection);

?>