<?php
/*
  Name: Crystal Long
  Date: 2026-02-25
  Assignment: Module 9 - MySQLi Index + Query + Form Pages
*/

/* Purpose: Provide a form for adding a new game record to the CrystalVideoGames table. */


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
// Handle form submit (POST)
// ----------------------------------------------------
$message = "";
$errorMessage = "";

$title = "";
$platform = "";
$genre = "";
$releaseYear = "";
$userRating = "";
$isCompleted = "0";
$dateAdded = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $title = trim($_POST["title"] ?? "");
  $platform = trim($_POST["platform"] ?? "");
  $genre = trim($_POST["genre"] ?? "");
  $releaseYear = trim($_POST["releaseYear"] ?? "");
  $userRating = trim($_POST["userRating"] ?? "");
  $isCompleted = isset($_POST["isCompleted"]) ? "1" : "0";
  $dateAdded = trim($_POST["dateAdded"] ?? "");

  // Basic validation
  if ($title === "" || $platform === "" || $genre === "" || $releaseYear === "" || $userRating === "" || $dateAdded === "") {
    $errorMessage = "Please fill out all required fields.";
  } elseif (!ctype_digit($releaseYear)) {
    $errorMessage = "Release year must be a whole number.";
  } elseif (!is_numeric($userRating)) {
    $errorMessage = "User rating must be a number (example: 9.2).";
  } else {

    $sql = "
      INSERT INTO CrystalVideoGames (title, platform, genre, releaseYear, userRating, isCompleted, dateAdded)
      VALUES (?, ?, ?, ?, ?, ?, ?)
    ";

    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt) {
      $yearInt = (int)$releaseYear;
      $ratingFloat = (float)$userRating;
      $completedInt = (int)$isCompleted;

      mysqli_stmt_bind_param(
        $stmt,
        "sssidis",
        $title,
        $platform,
        $genre,
        $yearInt,
        $ratingFloat,
        $completedInt,
        $dateAdded
      );

      $executed = mysqli_stmt_execute($stmt);

      if ($executed) {
        $message = "Success: New game record added.";

        // Clear fields after success
        $title = "";
        $platform = "";
        $genre = "";
        $releaseYear = "";
        $userRating = "";
        $isCompleted = "0";
        $dateAdded = "";

      } else {
        $errorMessage = "Insert failed: " . mysqli_stmt_error($stmt);
      }

      mysqli_stmt_close($stmt);

    } else {
      $errorMessage = "Prepare failed: " . mysqli_error($connection);
    }
  }
}

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crystal Video Games - Add Game</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 24px; line-height: 1.4; }
    .wrap { max-width: 900px; margin: 0 auto; }
    .card { padding: 18px; border: 1px solid #ddd; border-radius: 10px; }
    .grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
    label { display: block; font-weight: 600; margin-bottom: 6px; }
    input { width: 100%; padding: 9px; border: 1px solid #ccc; border-radius: 8px; }
    .row { margin-top: 12px; }
    .actions { display: flex; gap: 10px; margin-top: 14px; }
    button, .linkbtn { padding: 10px 14px; border-radius: 8px; border: 1px solid #333; background: #fff; cursor: pointer; }
    .linkbtn { display: inline-block; }
    .msg { padding: 10px; border-radius: 8px; margin-bottom: 12px; }
    .success { border: 1px solid #2e7d32; color: #2e7d32; background: #f3fff3; }
    .error { border: 1px solid #b00020; color: #b00020; background: #fff3f5; }
    .note { color: #555; font-size: 0.95rem; }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="card">
      <h1>Add a Game</h1>
      <p class="note"><a href="CrystalIndex.php">Back to Index</a> | <a href="CrystalQuery.php">Go to Search</a></p>

      <?php if ($message !== ""): ?>
        <div class="msg success"><?php echo htmlspecialchars($message); ?></div>
      <?php endif; ?>

      <?php if ($errorMessage !== ""): ?>
        <div class="msg error"><?php echo htmlspecialchars($errorMessage); ?></div>
      <?php endif; ?>

      <form method="post" action="CrystalForm.php">
        <div class="grid">
          <div>
            <label for="title">Title (required)</label>
            <input id="title" name="title" type="text" value="<?php echo htmlspecialchars($title); ?>">
          </div>

          <div>
            <label for="platform">Platform (required)</label>
            <input id="platform" name="platform" type="text" placeholder="Switch, PC, Nintendo 64" value="<?php echo htmlspecialchars($platform); ?>">
          </div>

          <div>
            <label for="genre">Genre (required)</label>
            <input id="genre" name="genre" type="text" placeholder="RPG, MMORPG, Simulation" value="<?php echo htmlspecialchars($genre); ?>">
          </div>

          <div>
            <label for="releaseYear">Release Year (required)</label>
            <input id="releaseYear" name="releaseYear" type="text" placeholder="2017" value="<?php echo htmlspecialchars($releaseYear); ?>">
          </div>

          <div>
            <label for="userRating">User Rating (required)</label>
            <input id="userRating" name="userRating" type="text" placeholder="9.4" value="<?php echo htmlspecialchars($userRating); ?>">
          </div>

          <div>
            <label for="dateAdded">Date Added (required)</label>
            <input id="dateAdded" name="dateAdded" type="date" value="<?php echo htmlspecialchars($dateAdded); ?>">
          </div>
        </div>

        <div class="row">
          <label>
            <input type="checkbox" name="isCompleted" <?php if ($isCompleted === "1") echo "checked"; ?>>
            Mark as completed
          </label>
        </div>

        <div class="actions">
          <button type="submit">Add Game</button>
          <a class="linkbtn" href="CrystalForm.php">Reset</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
<?php
mysqli_close($connection);
?>