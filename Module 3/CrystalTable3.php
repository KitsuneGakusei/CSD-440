<?php
/*
Name: Crystal Long
Date: January 23, 2026
Assignment: 3.2 Programming Assignment - PHP Table with Function

Purpose: Display an HTML table of values generated using a function that returns the sum of two random numbers.

*/

// Include the external function file
require_once "randomSumFunction.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CrystalTable3</title>
  <style>
    table {
      border-collapse: collapse;
      margin-top: 15px;
    }
    td, th {
      border: 1px solid #333;
      padding: 10px;
      text-align: center;
      width: 70px;
    }
    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>

<h1>Random Number Sum Table</h1>

<?php
// Define table size
$rowCount = 5;
$columnCount = 5;

// Define random number range
$minRandom = 1;
$maxRandom = 50;
?>

<table>
  <tbody>

    <?php for ($rowIndex = 1; $rowIndex <= $rowCount; $rowIndex++) { ?>
      <tr>

        <?php for ($colIndex = 1; $colIndex <= $columnCount; $colIndex++) { ?>
          <td>
            <?php
            // Generate two random numbers
            $randomNumberOne = rand($minRandom, $maxRandom);
            $randomNumberTwo = rand($minRandom, $maxRandom);

            // Call the external function to get the sum
            $cellValue = generateCellValue($randomNumberOne, $randomNumberTwo);

            // Display the result in the table cell
            echo $cellValue;
            ?>
          </td>
        <?php } ?>

      </tr>
    <?php } ?>

  </tbody>
</table>

<p>
  <?php
  // Output configuration details for testing verification
  echo "Each cell displays the sum of two random numbers between {$minRandom} and {$maxRandom}.";
  ?>
</p>

</body>
</html>
