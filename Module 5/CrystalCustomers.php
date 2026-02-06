<?php
/*
  Name: Crystal Long
  Date: February 6, 2026
  Assignment: Module 5.2 Programming Assignment - Customers Array
*/

/*
  Purpose: Create and display an array of customers, then search/display records using array methods.
*/

// ---------------------------
// 1) Customer data (10+ records)
// ---------------------------
$customers = [
  ["firstName" => "Ava",     "lastName" => "Reed",     "age" => 22, "phone" => "402-555-0111"],
  ["firstName" => "Mason",   "lastName" => "Clark",    "age" => 35, "phone" => "402-555-0112"],
  ["firstName" => "Olivia",  "lastName" => "Nguyen",   "age" => 28, "phone" => "402-555-0113"],
  ["firstName" => "Ethan",   "lastName" => "Bennett",  "age" => 41, "phone" => "402-555-0114"],
  ["firstName" => "Sophia",  "lastName" => "Patel",    "age" => 19, "phone" => "402-555-0115"],
  ["firstName" => "Liam",    "lastName" => "Johnson",  "age" => 52, "phone" => "402-555-0116"],
  ["firstName" => "Isabella","lastName" => "Lopez",    "age" => 31, "phone" => "402-555-0117"],
  ["firstName" => "Noah",    "lastName" => "Martin",   "age" => 26, "phone" => "402-555-0118"],
  ["firstName" => "Mia",     "lastName" => "Kim",      "age" => 44, "phone" => "402-555-0119"],
  ["firstName" => "James",   "lastName" => "Walker",   "age" => 23, "phone" => "402-555-0120"],
];

// ---------------------------
// Helper functions
// ---------------------------

/**
 * Safely prints a single customer record.
 */
function printCustomer(array $customer): void
{
  echo "First Name: " . htmlspecialchars($customer["firstName"]) . "<br>";
  echo "Last Name: " . htmlspecialchars($customer["lastName"]) . "<br>";
  echo "Age: " . (int)$customer["age"] . "<br>";
  echo "Phone: " . htmlspecialchars($customer["phone"]) . "<br>";
}

/**
 * Prints a heading + a list of customer records.
 */
function printCustomerList(string $title, array $customerList): void
{
  echo "<h2>" . htmlspecialchars($title) . "</h2>";

  if (count($customerList) === 0) {
    echo "<p><em>No matching customers found.</em></p>";
    return;
  }

  foreach ($customerList as $customer) {
    echo "<div style='padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:6px;'>";
    printCustomer($customer);
    echo "</div>";
  }
}

// ---------------------------
// 2) Display all customers
// ---------------------------
echo "<h1>Customer List</h1>";
printCustomerList("All Customers", $customers);

// ---------------------------
// 3) Find several records using array methods
// ---------------------------

// A) Find all customers age 35 or older (array_filter)
$age35Plus = array_filter($customers, function ($customer) {
  return $customer["age"] >= 35;
});
printCustomerList("Customers Age 35+", array_values($age35Plus));

// B) Find all customers with last name "Johnson" (array_filter)
$lastNameJohnson = array_filter($customers, function ($customer) {
  return strcasecmp($customer["lastName"], "Johnson") === 0;
});
printCustomerList("Customers With Last Name: Johnson", array_values($lastNameJohnson));

// C) Find the first customer with phone number "402-555-0118" (array_filter + first result)
$phoneToFind = "402-555-0118";
$matchesByPhone = array_values(array_filter($customers, function ($customer) use ($phoneToFind) {
  return $customer["phone"] === $phoneToFind;
}));

echo "<h2>Customer With Phone: " . htmlspecialchars($phoneToFind) . "</h2>";
if (count($matchesByPhone) > 0) {
  echo "<div style='padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:6px;'>";
  printCustomer($matchesByPhone[0]);
  echo "</div>";
} else {
  echo "<p><em>No matching customer found.</em></p>";
}

// D) Find all customers with first name starting with "M" (array_filter)
$startsWithM = array_filter($customers, function ($customer) {
  return stripos($customer["firstName"], "M") === 0;
});
printCustomerList("Customers Whose First Name Starts With 'M'", array_values($startsWithM));

// E) Sort by age (array_multisort) and show the sorted list
$customersSortedByAge = $customers; // copy so original list stays unchanged
$ageColumn = array_column($customersSortedByAge, "age");
array_multisort($ageColumn, SORT_ASC, $customersSortedByAge);
printCustomerList("Customers Sorted By Age (Ascending)", $customersSortedByAge);

?>
