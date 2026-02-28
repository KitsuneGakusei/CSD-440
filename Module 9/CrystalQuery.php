<?php
/*
  Name: Crystal Long
  Date: 2026-02-25
  Assignment: Module 9 - MySQLi Index + Query + Form Pages
*/

/* Purpose: Search the CrystalVideoGames table based on user form input and display results. */


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
// Read user inputs (GET so searches are shareable/bookmarkable)
// ----------------------------------------------------
$titleKeyword = isset($_GET["title"]) ? trim($_GET["title"]) : "";
$platform = isset($_GET["platform"]) ? trim($_GET["platform"]) : "";
$genre = isset($_GET["genre"]) ? trim($_GET["genre"]) : "";
$completedFilter = isset($_GET["completed"]) ? trim($_GET["completed"]) : "all"; // all | 1 | 0
$minRating = isset($_GET["minRating"]) ? trim($_GET["minRating"]) : "";
$minYear = isset($_GET["minYear"]) ? trim($_GET["minYear"]) : "";
$maxYear = isset($_GET["maxYear"]) ? trim($_GET["maxYear"]) : "";


// ----------------------------------------------------
// Build dynamic WHERE clause using prepared statements
// ----------------------------------------------------
$whereParts = [];
$paramTypes = "";
$params = [];

// Title keyword (LIKE)
if ($titleKeyword !== "") {
  $whereParts[] = "title LIKE ?";
  $paramTypes .= "s";
  $params[] = "%" . $titleKeyword . "%";
}

// Platform exact match
if ($platform !== "") {
  $whereParts[] = "platform = ?";
  $paramTypes .= "s";
  $params[] = $platform;
}

// Genre exact match
if ($genre !== "") {
  $whereParts[] = "genre = ?";
  $paramTypes .= "s";
  $params[] = $genre;
}

// Completed filter
if ($completedFilter === "1" || $completedFilter === "0") {
  $whereParts[] = "isCompleted = ?";
  $paramTypes .= "i";
  $params[] = (int)$completedFilter;
}

// Minimum rating
if ($minRating !== "" && is_numeric($minRating)) {
  $whereParts[] = "userRating >= ?";
  $paramTypes .= "d";
  $params[] = (float)$minRating;
}

// Year range
if ($minYear !== "" && ctype_digit($minYear)) {
  $whereParts[] = "releaseYear >= ?";
  $paramTypes .= "i";
  $params[] = (int)$minYear;
}

if ($maxYear !== "" && ctype_digit($maxYear)) {
  $whereParts[] = "releaseYear <= ?";
  $paramTypes .= "i";
  $params[] = (int)$maxYear;
}

$whereSql = "";
if (count($whereParts) > 0) {
  $whereSql = "WHERE " . implode(" AND ", $whereParts);
}

$sql = "
  SELECT gameId, title, platform, genre, releaseYear, userRating, isCompleted, dateAdded
  FROM CrystalVideoGames
  $whereSql
  ORDER BY userRating DESC, title ASC
";

$stmt = mysqli_prepare($connection, $sql);
$results = [];
$errorMessage = "";

if ($stmt) {

  // Bind params if needed
  if (count($params) > 0) {
    mysqli_stmt_bind_param($stmt, $paramTypes, ...$params);
  }

  $executed = mysqli_stmt_execute($stmt);

  if ($executed) {
    $resultSet = mysqli_stmt_get_result($stmt);

    if ($resultSet) {
      while ($row = mysqli_fetch_assoc($resultSet)) {
        $results[] = $row;
      }
    } else {
      $errorMessage = "Unable to retrieve results: " . mysqli_error($connection);
    }

  } else {
    $errorMessage = "Query failed: " . mysqli_stmt_error($stmt);
  }

  mysqli_stmt_close($stmt);

} else {
  $errorMessage = "Prepare failed: " . mysqli_error($connection);
}


// ----------------------------------------------------
// Close connection at the end of page
// ----------------------------------------------------
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crystal Video Games - Search</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 24px; line-height: 1.4; }
    .wrap { max-width: 1100px; margin: 0 auto; }
    .card { padding: 18px; border: 1px solid #ddd; border-radius: 10px; margin-bottom: 16px; }
    .grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 12px; }
    label { display: block; font-weight: 600; margin-bottom: 6px; }
    input, select { width: 100%; padding: 9px; border: 1px solid #ccc; border-radius: 8px; }
    .actions { display: flex; gap: 10px; margin-top: 12px; }
    button, .linkbtn { padding: 10px 14px; border-radius: 8px; border: 1px solid #333; background: #fff; cursor: pointer; }
    .linkbtn { display: inline-block; }
    .note { color: #555; font-size: 0.95rem; margin-top: 6px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
    th { background: #f6f6f6; }
    .badge { padding: 4px 10px; border: 1px solid #999; border-radius: 999px; display: inline-block; font-size: 0.9rem; }
    .error { color: #b00020; font-weight: 600; }
    @media (max-width: 900px) { .grid { grid-template-columns: repeat(2, 1fr); } }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="card">
      <h1>Search Favorite Video Games</h1>
      <p class="note"><a href="CrystalIndex.php">Back to Index</a></p>

      <form method="get" action="CrystalQuery.php">
        <div class="grid">
          <div>
            <label for="title">Title contains</label>
            <input id="title" name="title" type="text" value="<?php echo htmlspecialchars($titleKeyword); ?>">
          </div>

          <div>
            <label for="platform">Platform</label>
            <input id="platform" name="platform" type="text" placeholder="Switch, PC, Nintendo 64" value="<?php echo htmlspecialchars($platform); ?>">
          </div>

          <div>
            <label for="genre">Genre</label>
            <input id="genre" name="genre" type="text" placeholder="RPG, MMORPG, Simulation" value="<?php echo htmlspecialchars($genre); ?>">
          </div>

          <div>
            <label for="completed">Completed?</label>
            <select id="completed" name="completed">
              <option value="all" <?php if ($completedFilter === "all") echo "selected"; ?>>All</option>
              <option value="1" <?php if ($completedFilter === "1") echo "selected"; ?>>Completed</option>
              <option value="0" <?php if ($completedFilter === "0") echo "selected"; ?>>Unfinished</option>
            </select>
          </div>

          <div>
            <label for="minRating">Min rating</label>
            <input id="minRating" name="minRating" type="text" placeholder="8.5" value="<?php echo htmlspecialchars($minRating); ?>">
          </div>

          <div>
            <label for="minYear">Year range</label>
            <input name="minYear" type="text" placeholder="Min" value="<?php echo htmlspecialchars($minYear); ?>">
            <div style="height:8px;"></div>
            <input name="maxYear" type="text" placeholder="Max" value="<?php echo htmlspecialchars($maxYear); ?>">
          </div>
        </div>

        <div class="actions">
          <button type="submit">Search</button>
          <a class="linkbtn" href="CrystalQuery.php">Reset</a>
          <a class="linkbtn" href="CrystalForm.php">Add a Game</a>
        </div>
      </form>
    </div>

    <div class="card">
      <h2>Results</h2>

      <?php if ($errorMessage !== ""): ?>
        <p class="error"><?php echo htmlspecialchars($errorMessage); ?></p>
      <?php endif; ?>

      <p class="note">Matches found: <?php echo count($results); ?></p>

      <table>
        <thead>
          <tr>
            <th>Title</th>
            <th>Platform</th>
            <th>Genre</th>
            <th>Year</th>
            <th>Rating</th>
            <th>Status</th>
            <th>Date Added</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($results) === 0): ?>
            <tr><td colspan="7">No results found.</td></tr>
          <?php else: ?>
            <?php foreach ($results as $row): ?>
              <tr>
                <td><?php echo htmlspecialchars($row["title"]); ?></td>
                <td><?php echo htmlspecialchars($row["platform"]); ?></td>
                <td><?php echo htmlspecialchars($row["genre"]); ?></td>
                <td><?php echo htmlspecialchars($row["releaseYear"]); ?></td>
                <td><?php echo htmlspecialchars($row["userRating"]); ?></td>
                <td>
                  <?php if ((int)$row["isCompleted"] === 1): ?>
                    <span class="badge">Completed</span>
                  <?php else: ?>
                    <span class="badge">Unfinished</span>
                  <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($row["dateAdded"]); ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
<?php
mysqli_close($connection);
?>