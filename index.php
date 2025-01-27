<?php
ob_start();
session_start();
if (isset($_SESSION['customer_login'])) {
    header('location:customer_profile.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="css/transaction_details.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('img/Background/bank.jpg');
            display: flex;
            align-items: center;
            height: 100vh;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
        }

        .login-container {
            margin-right: 200px;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #053f67; /* Dark blue */
        }

        .transaction-link {
            margin-top: 20px;
            display: block;
            text-decoration: none;
            color: #017bff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="post">
            <label for="customer_id">Customer ID</label>
            <input type="text" id="customer_id" name="customer_id" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" name="login-btn" value="LOGIN">
            <p>
                Don't have an account? 
                <a href="customer_reg_form.php">Register</a>
            </p>
            <img src="img/home-logo-hi.png" alt="Login Logo">
        </form>
        <a href="transaction_details.php?transaction_id=12345" class="transaction-link">View Transaction Details</a>
    </div>
</body>
</html>
<?php include 'customer_login_process.php'; ?>
