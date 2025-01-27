<?php
// Assuming transaction data is fetched from a database or passed via GET/POST
$transaction_id = $_GET['transaction_id']; // Example of getting transaction ID from URL
// Fetch transaction details from the database based on the transaction ID
// This is a placeholder for the actual database query
$transaction_details = [
    'block_header' => 'Block #12345',
    'transaction_id' => $transaction_id,
    'sender_details' => 'Sender Name: John Doe, Account No: 123456789',
    'amount' => '100.00',
    'validation_status' => 'Validated'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Details</title>
    <link rel="stylesheet" type="text/css" href="css/transaction_details.css">
</head>
<body>
    <h1>Transaction Details</h1>
    <div>
        <h2><?php echo $transaction_details['block_header']; ?></h2>
        <p><strong>Transaction ID:</strong> <?php echo $transaction_details['transaction_id']; ?></p>
        <p><strong>Sender Details:</strong> <?php echo $transaction_details['sender_details']; ?></p>
        <p><strong>Amount:</strong> $<?php echo $transaction_details['amount']; ?></p>
        <p><strong>Validation Status:</strong> <?php echo $transaction_details['validation_status']; ?></p>
    </div>
</body>
</html>
