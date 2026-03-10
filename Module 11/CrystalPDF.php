<?php
/*
  Name: Crystal Long
  Date: 2026-03-09
  Assignment: Module 11 Programming Assignment - PDF Output

  Purpose: Generate a PDF report showing general information and all data from the CrystalVideoGames table.

  Source:
  FPDF PHP Library Documentation
  https://www.fpdf.org/
*/

require('fpdf/fpdf.php');


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
// Query to retrieve all database data from Module 8
// ----------------------------------------------------
$sqlAllGames = "
  SELECT gameId, title, platform, genre, releaseYear, userRating, isCompleted, dateAdded
  FROM CrystalVideoGames
  ORDER BY userRating DESC
";

$resultAllGames = mysqli_query($connection, $sqlAllGames);

if (!$resultAllGames) {
  die("Query failed: " . mysqli_error($connection));
}

$totalRecords = mysqli_num_rows($resultAllGames);


// ----------------------------------------------------
// Custom PDF class with page header and footer
// ----------------------------------------------------
class PDF extends FPDF
{
  function Header()
  {
    $this->SetFont('Arial', 'B', 16);
    $this->Cell(0, 10, 'Crystal Video Games Report', 0, 1, 'C');

    $this->SetFont('Arial', '', 11);
    $this->Cell(0, 8, 'Module 11 PDF Output', 0, 1, 'C');

    $this->Ln(4);
  }

  function Footer()
  {
    $this->SetY(-15);
    $this->SetFont('Arial', 'I', 9);
    $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
  }
}


// ----------------------------------------------------
// Create PDF object
// Use landscape orientation so the table fits better
// ----------------------------------------------------
$pdf = new PDF('L', 'mm', 'Letter');
$pdf->SetAutoPageBreak(true, 20);
$pdf->AddPage();


// ----------------------------------------------------
// General information section
// ----------------------------------------------------
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'General Information About the Topic', 0, 1);

$pdf->SetFont('Arial', '', 11);

$generalInformation = "Video games are a popular form of entertainment enjoyed on many platforms, including consoles, PCs, and handheld systems. "
  . "They can belong to many genres such as simulation, action, role-playing, puzzle, and adventure. "
  . "This database stores favorite video games and includes details like the platform, genre, release year, user rating, completion status, and date added. "
  . "Organizing video game data in a database makes it easier to sort, review, and report the information in a clear and structured format.";

$pdf->MultiCell(0, 8, $generalInformation);

$pdf->Ln(5);


// ----------------------------------------------------
// Data table title
// ----------------------------------------------------
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'CrystalVideoGames Data Table', 0, 1);


// ----------------------------------------------------
// Table header row
// ----------------------------------------------------
$pdf->SetFont('Arial', 'B', 9);

$pdf->Cell(15, 10, 'ID', 1, 0, 'C');
$pdf->Cell(60, 10, 'Title', 1, 0, 'C');
$pdf->Cell(30, 10, 'Platform', 1, 0, 'C');
$pdf->Cell(30, 10, 'Genre', 1, 0, 'C');
$pdf->Cell(22, 10, 'Year', 1, 0, 'C');
$pdf->Cell(22, 10, 'Rating', 1, 0, 'C');
$pdf->Cell(28, 10, 'Completed', 1, 0, 'C');
$pdf->Cell(32, 10, 'Date Added', 1, 1, 'C');


// ----------------------------------------------------
// Table data rows
// ----------------------------------------------------
$pdf->SetFont('Arial', '', 9);

while ($row = mysqli_fetch_assoc($resultAllGames)) {
  $completedText = ($row['isCompleted'] == 1) ? 'Yes' : 'No';

  $pdf->Cell(15, 10, $row['gameId'], 1, 0, 'C');
  $pdf->Cell(60, 10, $row['title'], 1, 0, 'L');
  $pdf->Cell(30, 10, $row['platform'], 1, 0, 'L');
  $pdf->Cell(30, 10, $row['genre'], 1, 0, 'L');
  $pdf->Cell(22, 10, $row['releaseYear'], 1, 0, 'C');
  $pdf->Cell(22, 10, $row['userRating'], 1, 0, 'C');
  $pdf->Cell(28, 10, $completedText, 1, 0, 'C');
  $pdf->Cell(32, 10, $row['dateAdded'], 1, 1, 'C');
}


// ----------------------------------------------------
// Table footer row
// ----------------------------------------------------
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(209, 10, 'Total Records', 1, 0, 'R');
$pdf->Cell(30, 10, $totalRecords, 1, 1, 'C');


// ----------------------------------------------------
// Close database connection
// ----------------------------------------------------
mysqli_free_result($resultAllGames);
mysqli_close($connection);


// ----------------------------------------------------
// Output PDF to browser
// ----------------------------------------------------
$pdf->Output('I', 'CrystalVideoGamesReport.pdf');
?>