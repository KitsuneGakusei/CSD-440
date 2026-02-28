<?php
/*
  Name: Crystal Long
  Date: 2026-02-25
  Assignment: Module 9 - MySQLi Index + Query + Form Pages
*/

/* Purpose: Provide a simple index page with navigation links for the Module 9 PHP files. */
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crystal Video Games - Index</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 24px; line-height: 1.4; }
    .card { max-width: 900px; margin: 0 auto; padding: 18px; border: 1px solid #ddd; border-radius: 10px; }
    h1 { margin-top: 0; }
    ul { padding-left: 18px; }
    a { text-decoration: none; }
    a:hover { text-decoration: underline; }
    .note { color: #555; font-size: 0.95rem; }
    .section { margin-top: 18px; padding-top: 12px; border-top: 1px solid #eee; }
  </style>
</head>
<body>
  <div class="card">
    <h1>Crystal Video Games</h1>
    <p class="note">Module 9 pages (includes Module 8 scripts for creating, populating, and testing the table).</p>

    <div class="section">
      <h2>Module 9 Pages</h2>
      <ul>
        <li><a href="CrystalQuery.php">CrystalQuery.php</a> (Search games)</li>
        <li><a href="CrystalForm.php">CrystalForm.php</a> (Add a game)</li>
      </ul>
    </div>

    <div class="section">
      <h2>Module 8 Scripts (Included)</h2>
      <ul>
        <li><a href="CrystalCreateTable.php">CrystalCreateTable.php</a></li>
        <li><a href="CrystalDropTable.php">CrystalDropTable.php</a></li>
        <li><a href="CrystalPopulateTable.php">CrystalPopulateTable.php</a></li>
        <li><a href="CrystalQueryTable.php">CrystalQueryTable.php</a></li>
      </ul>
      <p class="note">Typical run order: Create Table, Populate Table, then use Query/Form pages.</p>
    </div>
  </div>
</body>
</html>