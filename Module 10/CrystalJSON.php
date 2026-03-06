<?php
/*
Name: Crystal Long
Date: 2026-03-04
Assignment: JSON Form Program
*/

/*
Purpose: Prompt a user to enter gaming-related data and display the
submitted information encoded into JSON format using json_encode().
*/


// ----------------------------------------------------
// Initialize variables
// ----------------------------------------------------
$errorMessage = "";
$jsonOutput = "";


// ----------------------------------------------------
// Process the form when submitted
// ----------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect form data
    $favoriteGame = trim($_POST["favoriteGame"]);
    $genre = trim($_POST["genre"]);
    $platform = trim($_POST["platform"]);
    $hoursPlayed = trim($_POST["hoursPlayed"]);
    $favoriteCharacter = trim($_POST["favoriteCharacter"]);
    $favoritePokemon = trim($_POST["favoritePokemon"]);
    $favoriteBoardGame = trim($_POST["favoriteBoardGame"]);
    $gamingSnack = trim($_POST["gamingSnack"]);


    // ----------------------------------------------------
    // Basic validation
    // ----------------------------------------------------
    if (
        empty($favoriteGame) ||
        empty($genre) ||
        empty($platform) ||
        empty($hoursPlayed) ||
        empty($favoriteCharacter) ||
        empty($favoritePokemon) ||
        empty($favoriteBoardGame) ||
        empty($gamingSnack)
    ) {
        $errorMessage = "Error: All fields must be filled out.";
    } else {

        // ----------------------------------------------------
        // Store the form data in an associative array
        // ----------------------------------------------------
        $formData = array(
            "favoriteGame" => $favoriteGame,
            "genre" => $genre,
            "platform" => $platform,
            "hoursPlayedPerWeek" => $hoursPlayed,
            "favoriteCharacter" => $favoriteCharacter,
            "favoritePokemon" => $favoritePokemon,
            "favoriteBoardGame" => $favoriteBoardGame,
            "gamingSnack" => $gamingSnack
        );


        // ----------------------------------------------------
        // Convert the array to JSON format
        // ----------------------------------------------------
        $jsonOutput = json_encode($formData, JSON_PRETTY_PRINT);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Crystal JSON Form</title>

<style>

body{
    font-family: Arial;
    margin: 30px;
}

form{
    border:1px solid #ccc;
    padding:20px;
    width:420px;
}

label{
    display:block;
    margin-top:10px;
}

input{
    width:100%;
    padding:6px;
}

button{
    margin-top:15px;
    padding:8px 12px;
}

.outputBox{
    margin-top:25px;
    border:1px solid #333;
    padding:15px;
    width:420px;
    background:#f4f4f4;
}

.errorBox{
    margin-top:25px;
    border:1px solid red;
    padding:15px;
    width:420px;
    background:#ffe6e6;
}

</style>

</head>

<body>

<h2>Gaming Preferences Form</h2>

<form method="post" action="CrystalJSON.php">

<label>Favorite Video Game</label>
<input type="text" name="favoriteGame">

<label>Favorite Game Genre</label>
<input type="text" name="genre">

<label>Favorite Console / Platform</label>
<input type="text" name="platform">

<label>Hours Played Per Week</label>
<input type="number" name="hoursPlayed">

<label>Favorite Game Character</label>
<input type="text" name="favoriteCharacter">

<label>Favorite Pokémon</label>
<input type="text" name="favoritePokemon">

<label>Favorite Board Game</label>
<input type="text" name="favoriteBoardGame">

<label>Favorite Gaming Snack</label>
<input type="text" name="gamingSnack">

<button type="submit">Submit</button>

</form>


<?php

// ----------------------------------------------------
// Display error message if validation failed
// ----------------------------------------------------
if (!empty($errorMessage)) {

    echo "<div class='errorBox'>";
    echo "<strong>Error Display</strong><br>";
    echo $errorMessage;
    echo "</div>";

}


// ----------------------------------------------------
// Display JSON output if successful
// ----------------------------------------------------
if (!empty($jsonOutput)) {

    echo "<div class='outputBox'>";
    echo "<strong>JSON Output</strong>";
    echo "<pre>$jsonOutput</pre>";
    echo "</div>";

}

?>

</body>
</html>