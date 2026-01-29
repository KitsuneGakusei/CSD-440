<?php
/*
Name: Crystal Long
Date: January 27, 2026
Assignment: Module 4 Programming Assignment – Palindrome Checker
Purpose: Program that checks whether a string is a palindrome.
*/

// --------------------------------------------------
// Function to determine if a string is a palindrome
// --------------------------------------------------
function isPalindrome($inputString)
{
    // Remove spaces and convert to lowercase for comparison
    $normalizedString = strtolower(str_replace(" ", "", $inputString));

    // Reverse the normalized string
    $reversedString = strrev($normalizedString);

    // Compare the original normalized string with the reversed version
    return $normalizedString === $reversedString;
}

// --------------------------------------------------
// Array of test strings (3 palindromes, 3 not)
// --------------------------------------------------
$testStrings = array(
    "racecar",
    "level",
    "never odd or even",
    "hello",
    "php programming",
    "openai"
);

// --------------------------------------------------
// Display results for each test string
// --------------------------------------------------
echo "<h2>Palindrome Test Results</h2>";

foreach ($testStrings as $currentString) {

    // Reverse the original string for display purposes
    $displayReversed = strrev($currentString);

    // Call the palindrome test function
    $result = isPalindrome($currentString);

    // Display the original string
    echo "<p><strong>Original String:</strong> $currentString<br>";

    // Display the reversed string
    echo "<strong>Reversed String:</strong> $displayReversed<br>";

    // Display whether the string is a palindrome
    if ($result) {
        echo "<strong>Result:</strong> This string IS a palindrome.</p>";
    } else {
        echo "<strong>Result:</strong> This string is NOT a palindrome.</p>";
    }
}
?>
