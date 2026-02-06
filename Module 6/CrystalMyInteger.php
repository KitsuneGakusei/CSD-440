<?php
/*
  Name: Crystal Long
  Date: February 6, 2026
  Assignment: Module 6.2 Programming Assignment - MyInteger Class
*/

/*
  Purpose: Define a MyInteger class with even/odd checks, prime check, getter/setter, and test with two instances.
*/

// ---------------------------
// Class: CrystalMyInteger
// ---------------------------
class CrystalMyInteger
{
  // Holds a single integer value
  private int $value;

  // Constructor sets the integer using a parameter
  public function __construct(int $value)
  {
    $this->value = $value;
  }

  // Getter
  public function getValue(): int
  {
    return $this->value;
  }

  // Setter
  public function setValue(int $value): void
  {
    $this->value = $value;
  }

  // Returns true if the provided integer is even
  public function isEven(int $number): bool
  {
    return $number % 2 === 0;
  }

  // Returns true if the provided integer is odd
  public function isOdd(int $number): bool
  {
    return $number % 2 !== 0;
  }

  // Returns true if THIS object's value is prime
  public function isPrime(): bool
  {
    $n = $this->value;

    // Prime numbers are greater than 1
    if ($n <= 1) {
      return false;
    }

    // 2 is prime
    if ($n === 2) {
      return true;
    }

    // Even numbers greater than 2 are not prime
    if ($n % 2 === 0) {
      return false;
    }

    // Check odd divisors up to sqrt(n)
    for ($i = 3; $i * $i <= $n; $i += 2) {
      if ($n % $i === 0) {
        return false;
      }
    }

    return true;
  }
}

// ---------------------------
// Helper: Display test results
// ---------------------------
function displayTestResults(CrystalMyInteger $obj, int $testNumber): void
{
  $value = $obj->getValue();

  echo "<h2>Testing Instance: Value = " . htmlspecialchars((string)$value) . "</h2>";

  echo "<p><strong>isEven($testNumber):</strong> " . ($obj->isEven($testNumber) ? "True" : "False") . "</p>";
  echo "<p><strong>isOdd($testNumber):</strong> " . ($obj->isOdd($testNumber) ? "True" : "False") . "</p>";
  echo "<p><strong>isPrime() (checks the object's value):</strong> " . ($obj->isPrime() ? "True" : "False") . "</p>";
}

// ---------------------------
// Create two instances + test
// ---------------------------

echo "<h1>CrystalMyInteger - Method Tests</h1>";

// Instance 1
$myInt1 = new CrystalMyInteger(29); // prime, odd
displayTestResults($myInt1, $myInt1->getValue());

// Instance 2
$myInt2 = new CrystalMyInteger(40); // not prime, even
displayTestResults($myInt2, $myInt2->getValue());

// ---------------------------
// Test getter/setter
// ---------------------------
echo "<h2>Testing Getter/Setter</h2>";

// Show original value
echo "<p><strong>Instance 2 original value:</strong> " . $myInt2->getValue() . "</p>";

// Change value using setter
$myInt2->setValue(41); // prime, odd

// Show updated value + re-test prime
echo "<p><strong>Instance 2 updated value (after setValue):</strong> " . $myInt2->getValue() . "</p>";
echo "<p><strong>Instance 2 isPrime() after update:</strong> " . ($myInt2->isPrime() ? "True" : "False") . "</p>";

// Extra: show even/odd checks for updated value
echo "<p><strong>Instance 2 isEven(updated value):</strong> " . ($myInt2->isEven($myInt2->getValue()) ? "True" : "False") . "</p>";
echo "<p><strong>Instance 2 isOdd(updated value):</strong> " . ($myInt2->isOdd($myInt2->getValue()) ? "True" : "False") . "</p>";

?>

