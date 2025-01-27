<?php
// Start session and check for customer login
session_start();
ob_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include necessary files
include 'header.php';
include 'customer_profile_header.php';
include 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['customer_login']) || $_SESSION['customer_login'] !== true) {
    echo "Session is not set or invalid.";
    header('Location: customer_login.php');
    exit();
}

// Database connection
$sql = "SELECT * FROM passbook_1011046 ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

// Check for query errors
if (!$result) {
    die("Error in SQL query: " . $conn->error);  // Debugging SQL errors
}

// Default mock data in case the database is empty
$block_data = [
    "id" => 1,
    "Transaction_id" => "tx001",
    "Transaction_date" => "2025-01-05T10:30:00Z",
    "Description" => "Supermarket",
    "Cr_amount" => "1500.00",
    "Dr_amount" => "0.00",
    "Net_Balance" => "3500.00",
    "Remark" => "Payment for groceries",
];

if ($result && $result->num_rows > 0) {
    // Fetch the row data if available
    $row = $result->fetch_assoc();
    $block_data = [
        "id" => $row["id"],
        "Transaction_id" => $row["Transaction_id"],
        "Transaction_date" => $row["Transaction_date"],
        "Description" => $row["Description"],
        "Cr_amount" => $row["Cr_amount"],
        "Dr_amount" => $row["Dr_amount"],
        "Net_Balance" => $row["Net_Balance"],
        "Remark" => $row["Remark"],
    ];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Blockchain Transaction</title>
  <style>
    /* Add your CSS styles here */
    /* ... (existing CSS code) */
  </style>
</head>
<body>
  <h1>Blockchain Transaction</h1>
  <div class="transaction-container">
    <!-- Block Header -->
    <div class="block">
      <h2>Block Header</h2>
      <ul>
        <li><span>Block Number:</span> <?= htmlspecialchars($block_data["id"]) ?></li>
        <li><span>Previous Hash:</span> 0000abcdef123456</li>
        <li><span>Hash:</span> abcd1234567890ef</li>
      </ul>
    </div>
    <div class="arrow"></div>

    <!-- Transaction Metadata -->
    <div class="block">
      <h2>Transaction Metadata</h2>
      <ul>
        <li><span>Transaction ID:</span> <?= htmlspecialchars($block_data["Transaction_id"]) ?></li>
        <li><span>Timestamp:</span> <?= htmlspecialchars($block_data["Transaction_date"]) ?></li>
        <li><span>Purpose:</span> <?= htmlspecialchars($block_data["Remark"]) ?></li>
      </ul>
    </div>
    <div class="arrow"></div>

    <!-- Participant Details -->
    <div class="block">
      <h2>Participant Details</h2>
      <ul>
        <li><span>Sender:</span> Alice</li>
        <li><span>Receiver:</span> <?= htmlspecialchars($block_data["Description"]) ?></li>
      </ul>
    </div>
    <div class="arrow"></div>

    <!-- Transaction Amount -->
    <div class="block">
      <h2>Transaction Amount</h2>
      <ul>
        <li><span>Credit Amount:</span> <?= htmlspecialchars($block_data["Cr_amount"]) ?></li>
        <li><span>Debit Amount:</span> <?= htmlspecialchars($block_data["Dr_amount"]) ?></li>
        <li><span>Net Balance:</span> <?= htmlspecialchars($block_data["Net_Balance"]) ?></li>
      </ul>
    </div>
  </div>
</body>
<?php include 'footer.php'; ?>
</html>
