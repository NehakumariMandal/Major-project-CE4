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
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            /* background-color: #c5d9e2; */
            background-image: url('img/Background/bank.jpg');
            display: flex;
            /* justify-content: absolute; */
            float: right;
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

        .login-container label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-size: 14px;
            color: #333;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .login-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #017bff;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-container input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .login-container p {
            margin-top: 15px;
            font-size: 14px;
            color: #333;
        }

        .login-container p a {
            color: #017bff;
            text-decoration: none;
            font-weight: bold;
        }

        .login-container p a:hover {
            text-decoration: underline;
        }

        .login-container img {
            margin-top: 20px;
            width: 80px;
            height: 80px;
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
    </div>
</body>
</html>
<?php include 'customer_login_process.php'; ?>
