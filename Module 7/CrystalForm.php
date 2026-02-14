<?php
/**
 * Name: Crystal Long
 * Date: 2026-02-13
 * Assignment: Module 7 Programming Assignment - Form Validation (CrystalForm.php)
 *
 * Purpose: Collect seven fields of user input, validate required fields and data formats, then display results or errors.
 *
 * Sources: None (original code written for this assignment).
 */

// -----------------------------
// Helper functions
// -----------------------------

/**
 * Safely escape output for HTML.
 */
function e(string $value): string {
  return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Get a POST value as a trimmed string (or empty string).
 */
function post_value(string $key): string {
  return isset($_POST[$key]) ? trim((string)$_POST[$key]) : '';
}

/**
 * Validate a date string (YYYY-MM-DD) using DateTime.
 */
function is_valid_date(string $dateStr): bool {
  $dt = DateTime::createFromFormat('Y-m-d', $dateStr);
  return $dt && $dt->format('Y-m-d') === $dateStr;
}

// -----------------------------
// Field definitions / allowed values
// -----------------------------

$allowedContactMethods = ['Email', 'Phone', 'Text'];

$isPost = ($_SERVER['REQUEST_METHOD'] === 'POST');
$errors = [];
$data = [
  'fullName'       => '',
  'emailAddress'   => '',
  'age'            => '',
  'monthlyBudget'  => '',
  'startDate'      => '',
  'contactMethod'  => '',
  'agreeTerms'     => false,
];

if ($isPost) {
  // -----------------------------
  // Gather input
  // -----------------------------
  $data['fullName']      = post_value('fullName');
  $data['emailAddress']  = post_value('emailAddress');
  $data['age']           = post_value('age');
  $data['monthlyBudget'] = post_value('monthlyBudget');
  $data['startDate']     = post_value('startDate');
  $data['contactMethod'] = post_value('contactMethod');
  $data['agreeTerms']    = isset($_POST['agreeTerms']); // boolean

  // -----------------------------
  // Validate: required fields populated
  // -----------------------------

  // 1) Full Name (string)
  if ($data['fullName'] === '') {
    $errors[] = "Full Name is required.";
  } else {
    // Letters, spaces, apostrophes, hyphens; at least 2 characters.
    if (!preg_match("/^[a-zA-Z\s'\-]{2,}$/", $data['fullName'])) {
      $errors[] = "Full Name must be at least 2 characters and contain only letters, spaces, apostrophes, or hyphens.";
    }
  }

  // 2) Email Address (string formatted as email)
  if ($data['emailAddress'] === '') {
    $errors[] = "Email Address is required.";
  } else {
    if (!filter_var($data['emailAddress'], FILTER_VALIDATE_EMAIL)) {
      $errors[] = "Email Address must be a valid email (example: name@example.com).";
    }
  }

  // 3) Age (integer)
  if ($data['age'] === '') {
    $errors[] = "Age is required.";
  } else {
    // Ensure it's an integer and within a reasonable range.
    if (filter_var($data['age'], FILTER_VALIDATE_INT) === false) {
      $errors[] = "Age must be a whole number.";
    } else {
      $ageInt = (int)$data['age'];
      if ($ageInt < 1 || $ageInt > 120) {
        $errors[] = "Age must be between 1 and 120.";
      }
    }
  }

  // 4) Monthly Budget (float)
  if ($data['monthlyBudget'] === '') {
    $errors[] = "Monthly Budget is required.";
  } else {
    // FILTER_VALIDATE_FLOAT allows decimals. We'll also require non-negative.
    if (filter_var($data['monthlyBudget'], FILTER_VALIDATE_FLOAT) === false) {
      $errors[] = "Monthly Budget must be a number (example: 1500 or 1500.50).";
    } else {
      $budgetFloat = (float)$data['monthlyBudget'];
      if ($budgetFloat < 0) {
        $errors[] = "Monthly Budget cannot be negative.";
      }
    }
  }

  // 5) Start Date (date)
  if ($data['startDate'] === '') {
    $errors[] = "Start Date is required.";
  } else {
    if (!is_valid_date($data['startDate'])) {
      $errors[] = "Start Date must be a valid date (YYYY-MM-DD).";
    }
  }

  // 6) Preferred Contact Method (select)
  if ($data['contactMethod'] === '') {
    $errors[] = "Preferred Contact Method is required.";
  } else {
    if (!in_array($data['contactMethod'], $allowedContactMethods, true)) {
      $errors[] = "Preferred Contact Method must be one of: " . implode(', ', $allowedContactMethods) . ".";
    }
  }

  // 7) Agree to Terms (boolean/checkbox)
  if ($data['agreeTerms'] !== true) {
    $errors[] = "You must check the box to agree to the terms.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Crystal Form - Module 7</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 0; background: #f6f7fb; color: #222; }
    .wrap { max-width: 900px; margin: 32px auto; padding: 0 16px; }
    .card { background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 6px 18px rgba(0,0,0,0.08); }
    h1 { margin: 0 0 12px; font-size: 24px; }
    p.note { margin-top: 0; color: #555; }
    .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    label { display: block; font-weight: 700; margin-bottom: 6px; }
    input[type="text"], input[type="email"], input[type="number"], input[type="date"], select {
      width: 100%; padding: 10px 12px; border: 1px solid #cfd6e4; border-radius: 10px;
      font-size: 14px; background: #fff;
    }
    .full { grid-column: 1 / -1; }
    .row { margin-top: 6px; }
    .checkbox { display: flex; align-items: center; gap: 10px; padding: 10px 0; }
    .checkbox input { transform: scale(1.1); }
    button {
      padding: 10px 14px; border: 0; border-radius: 10px; cursor: pointer;
      font-weight: 700; font-size: 14px;
    }
    .btn-primary { background: #2a5bd7; color: white; }
    .btn-secondary { background: #e9edf7; color: #222; }
    .actions { display: flex; gap: 10px; margin-top: 10px; }
    .errors {
      border: 1px solid #ffb3b3; background: #fff2f2; padding: 14px; border-radius: 10px;
      margin-bottom: 14px;
    }
    .errors h2 { margin: 0 0 8px; font-size: 18px; }
    .errors ul { margin: 0; padding-left: 18px; }
    .result-grid { display: grid; grid-template-columns: 220px 1fr; gap: 10px; }
    .key { font-weight: 700; color: #333; }
    .val { color: #111; }
    @media (max-width: 700px) {
      .grid { grid-template-columns: 1fr; }
      .result-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>
  <div class="wrap">

<?php if ($isPost && empty($errors)): ?>
    <!-- SUCCESS DISPLAY (well formatted page) -->
    <div class="card">
      <h1>Form Submitted Successfully</h1>
      <p class="note">Here is the data you entered:</p>

      <div class="result-grid">
        <div class="key">Full Name</div>
        <div class="val"><?= e($data['fullName']) ?></div>

        <div class="key">Email Address</div>
        <div class="val"><?= e($data['emailAddress']) ?></div>

        <div class="key">Age</div>
        <div class="val"><?= e($data['age']) ?></div>

        <div class="key">Monthly Budget</div>
        <div class="val">$<?= e(number_format((float)$data['monthlyBudget'], 2)) ?></div>

        <div class="key">Start Date</div>
        <div class="val"><?= e($data['startDate']) ?></div>

        <div class="key">Preferred Contact Method</div>
        <div class="val"><?= e($data['contactMethod']) ?></div>

        <div class="key">Agreed to Terms</div>
        <div class="val"><?= $data['agreeTerms'] ? 'Yes' : 'No' ?></div>
      </div>

      <div class="actions">
        <form method="get" action="">
          <button class="btn-secondary" type="submit">Submit Another Response</button>
        </form>
      </div>
    </div>

<?php else: ?>
    <!-- FORM DISPLAY + ERROR DISPLAY -->
    <div class="card">
      <h1>Module 7 Form</h1>
      <p class="note">Please fill out all fields. Submitting will validate entries and display results.</p>

      <?php if ($isPost && !empty($errors)): ?>
        <div class="errors">
          <h2>There was a problem with your submission:</h2>
          <ul>
            <?php foreach ($errors as $err): ?>
              <li><?= e($err) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="post" action="">
        <div class="grid">
          <div>
            <label for="fullName">Full Name (String)</label>
            <input type="text" id="fullName" name="fullName" value="<?= e($data['fullName']) ?>" placeholder="Example: Crystal Long" />
          </div>

          <div>
            <label for="emailAddress">Email Address (Email)</label>
            <input type="email" id="emailAddress" name="emailAddress" value="<?= e($data['emailAddress']) ?>" placeholder="name@example.com" />
          </div>

          <div>
            <label for="age">Age (Integer)</label>
            <input type="number" id="age" name="age" value="<?= e($data['age']) ?>" min="1" max="120" placeholder="Example: 25" />
          </div>

          <div>
            <label for="monthlyBudget">Monthly Budget (Float)</label>
            <input type="number" step="0.01" id="monthlyBudget" name="monthlyBudget" value="<?= e($data['monthlyBudget']) ?>" min="0" placeholder="Example: 1500.50" />
          </div>

          <div>
            <label for="startDate">Start Date (Date)</label>
            <input type="date" id="startDate" name="startDate" value="<?= e($data['startDate']) ?>" />
          </div>

          <div>
            <label for="contactMethod">Preferred Contact Method (Select)</label>
            <select id="contactMethod" name="contactMethod">
              <option value="">-- Select One --</option>
              <?php foreach ($allowedContactMethods as $method): ?>
                <option value="<?= e($method) ?>" <?= ($data['contactMethod'] === $method) ? 'selected' : '' ?>>
                  <?= e($method) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="full">
            <div class="checkbox">
              <input type="checkbox" id="agreeTerms" name="agreeTerms" <?= $data['agreeTerms'] ? 'checked' : '' ?> />
              <label for="agreeTerms" style="margin:0; font-weight:700;">I agree to the terms</label>
            </div>
          </div>
        </div>

        <div class="actions">
          <button class="btn-primary" type="submit">Submit</button>
          <a href="" style="text-decoration:none;">
            <button class="btn-secondary" type="button" onclick="window.location.href=''">Reset</button>
          </a>
        </div>
      </form>
    </div>
<?php endif; ?>

  </div>
</body>
</html>
