<?php
/*
Name: Crystal Long
Date: January 23, 2026
Assignment: 2.2 Programming Assignment - PHP Nested Loop Table

Purpose: Generate an HTML table filled with random numbers using a PHP nested loop.

*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CrystalTable2</title>
  <style>
    table { border-collapse: collapse; margin-top: 12px; }
    td, th { border: 1px solid #333; padding: 10px; text-align: center; width: 60px; }
    th { background: #f2f2f2; }
  </style>
</head>
<body>

  <h1>Random Number Table</h1>

  <?php
  // Set the table dimensions (rows and columns)
  $rowCount = 5;
  $columnCount = 5;

  // Set the random number range
  $minRandom = 1;
  $maxRandom = 100;
  ?>

  <table>
    <thead>
      <tr>
        <th>Row\Col</th>

        <?php for ($colIndex = 1; $colIndex <= $columnCount; $colIndex++) { ?>
          <th><?php echo $colIndex; ?></th>
        <?php } ?>

      </tr>
    </thead>

    <tbody>

      <?php for ($rowIndex = 1; $rowIndex <= $rowCount; $rowIndex++) { ?>
        <tr>
          <th><?php echo $rowIndex; ?></th>

          <?php for ($colIndex = 1; $colIndex <= $columnCount; $colIndex++) { ?>
            <td>
              <?php
              // Generate and display a random number for the current cell
              $randomValue = rand($minRandom, $maxRandom);
              echo $randomValue;
              ?>
            </td>
          <?php } ?>

        </tr>
      <?php } ?>

    </tbody>
  </table>

  <p>
    <?php
    // Display the configuration so output is easy to verify during testing
    echo "Table size: {$rowCount} rows x {$columnCount} columns. ";
    echo "Random range: {$minRandom} to {$maxRandom}.";
    ?>
  </p>

</body>
</html>
