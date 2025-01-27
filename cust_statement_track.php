<?php
// Start session and check for customer login

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

// Fetch the customer's name from session (assuming it's stored when logged in)
$customer_name = $_SESSION['Username'];

// Initialize block data
$block_data = null;

// Check if block number is submitted
if (isset($_POST['block_number']) && !empty($_POST['block_number'])) {
    $block_number = $_POST['block_number'];

    // Query to fetch the block data by block number
    $sql = "SELECT * FROM passbook_1011046 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $block_number);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if data exists for the given block number
    if ($result && $result->num_rows > 0) {
        // Fetch the row data if available
        $block_data = $result->fetch_assoc();
    } else {
        $error_message = "No data found for Block Number " . htmlspecialchars($block_number);
    }
} else {
    $error_message = "Please enter a valid Block Number.";
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
    /* body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      margin: 0;
      padding: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      color: #333;
    } */
    
    /* Center the form container */
    .form-container {
      /* display: flex; */
      justify-content: center;
      align-items: center;
    }

    /* Styling for the form */
    .form-container form {
      /* display: flex; */
      flex-direction: column;
      align-items: center;
      background-color: #f9f9f9;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-container input {
      padding: 10px;
      margin: 10px 0;
      font-size: 16px;
      border-radius: 4px;
      border: 1px solid #ccc;
    }

    .form-container button {
      padding: 10px 20px;
      font-size: 16px;
      background-color:#005f7d;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .form-container button:hover {
      background-color:rgba(5, 21, 71,0.9);
    }

    h1 {
      margin-bottom: 20px;
      color: #007bff;
      text-align: center;
    }

    .transaction-container {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 20px;
      margin-top: 20px;
      justify-content: center;
    }

    .block {
      background: #ffffff;
      border: 2px solid #005f7d;
      border-radius: 8px;
      padding: 15px;
      min-width: 200px;
      text-align: center;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      position: relative;
      opacity: 0;
      transform: translateX(20px);
      animation: fadeIn 1s ease-in-out forwards;
    }

    .block:nth-child(1) {
      animation-delay: 0.5s; /* Block Header appears first */
    }

    .block:nth-child(3) {
      animation-delay: 1s; /* Transaction Metadata */
    }

    .block:nth-child(5) {
      animation-delay: 1.5s; /* Participant Details */
    }

    .block:nth-child(7) {
      animation-delay: 2s; /* Transaction Amount */
    }

    .block:nth-child(9) {
      animation-delay: 2.5s; /* Verification Details */
    }

    .block h2 {
      margin: 0 0 10px;
      color: #005f7d;
      font-size: 18px;
    }

    .block ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .block ul li {
      margin: 8px 0;
      font-size: 14px;
    }

    .block ul li span {
      font-weight: bold;
      color: #555;
    }

    .arrow {
      width: 50px;
      height: 2px;
      background: #005f7d;
      position: relative;
      opacity: 0;
      animation: fadeIn 1s ease-in-out forwards;
    }

    .arrow:nth-child(2) {
      animation-delay: 0.75s;
    }

    .arrow:nth-child(4) {
      animation-delay: 1.25s;
    }

    .arrow:nth-child(6) {
      animation-delay: 1.75s;
    }

    .arrow:nth-child(8) {
      animation-delay: 2.25s;
    }

    .arrow::after {
      content: '';
      width: 0;
      height: 0;
      border-left: 10px solid #005f7d;
      border-top: 5px solid transparent;
      border-bottom: 5px solid transparent;
      position: absolute;
      top: -4px;
      right: -10px;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateX(20px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
      .block {
        min-width: 150px;
        padding: 10px;
      }

      .block h2 {
        font-size: 16px;
      }

      .block ul li {
        font-size: 12px;
      }

      .arrow {
        width: 30px;
      }

      .arrow::after {
        border-left: 7px solid #005f7d;
        border-top: 4px solid transparent;
        border-bottom: 4px solid transparent;
        right: -7px;
      }
    }

    @media (max-width: 480px) {
      .transaction-container {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }

      .arrow {
        display: none; /* Hide arrows on very small screens */
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- <h1>Blockchain Transaction Data</h1> -->
    
    <!-- Form for block number input -->
    <div class="form-container">
    <form method="POST" action="">
      <label for="block_number">Enter Block Number:</label>
      <input type="number" id="block_number" name="block_number" min="1" required>
      <button type="submit">Submit</button>
    </form>
</div>

    <!-- Display error message if applicable -->
    <?php if (isset($error_message)) { ?>
        <div class="error-message" style="color: red; font-weight: bold;">
            <?= htmlspecialchars($error_message); ?>
        </div>
    <?php } ?>

    <?php if ($block_data): ?>
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
            <?php if (floatval($block_data["Cr_amount"]) > 0) { ?>
              <li><span>Receiver:</span> <?= htmlspecialchars($customer_name) ?></li>
              <li><span>Sender:</span> <?= htmlspecialchars($block_data["Description"]) ?></li>
            <?php } elseif (floatval($block_data["Dr_amount"]) > 0) { ?>
              <li><span>Sender:</span> <?= htmlspecialchars($customer_name) ?></li>
              <li><span>Receiver:</span> <?= htmlspecialchars($block_data["Description"]) ?></li>
            <?php } else { ?>
              <li><span>Transaction Type:</span> No transaction available.</li>
            <?php } ?>
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
    <?php endif; ?>
  </div>
</body>
<?php include 'footer.php'; ?>
</html>
