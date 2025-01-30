<html>
<head>
    <title>Change Password</title>
    <link rel="stylesheet" type="text/css" href="css/customer_pass_change.css"/>

    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js">
    </script>
    <script type="text/javascript">
    (function(){
      emailjs.init({
        publicKey: "8WgtwsEm48YwTRrPw",
      });
    })();
    </script>

    <style>
        #customer_profile .link3 {
            background-color: rgba(5, 21, 71, 0.4);
        }

        .cust_passchng_container {
            max-width: 400px;
            padding: 20px;
            background-color: #c5d9e2;
            width: 35%;
            margin: 5% auto;
            border-radius: 5px;
            box-shadow: 1px 1px 10px rgba(0, 0, 0, 0.6);
        }

        .password-field {
            position: relative;
            margin-bottom: 15px;
        }

        .password-field input {
            width: 100%;
            padding: 10px;
            padding-right: 40px; /* Space for the eye icon */
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .password-field .toggle-visibility {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #555;
        }

        .password-field .toggle-visibility:hover {
            color: #000;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #005cbf;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #004080;
        }

        .password-requirements {
            color: red;
            font-size: 14px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<?php 
    include 'header.php';
    include 'customer_profile_header.php';

    if ($_SESSION['customer_login'] != true) {
        header('location:customer_login.php');
    }
?> 

<div class="cust_passchng_container">
	<br>
    <form method="post" onsubmit="return validateForm()">
        <div class="password-field">
            <input type="password" name="oldpass" id="oldpass" placeholder="Old Password" required>
            <span class="toggle-visibility" onclick="toggleVisibility('oldpass', this)">&#128065;</span>
        </div>
        <div class="password-field">
            <input type="password" name="cnfrm" id="cnfrm" placeholder="Confirm Old Password" required>
            <span class="toggle-visibility" onclick="toggleVisibility('cnfrm', this)">&#128065;</span>
        </div>
        <div class="password-field">
            <input type="password" name="newpass" id="newpass" placeholder="New Password" required>
            <span class="toggle-visibility" onclick="toggleVisibility('newpass', this)">&#128065;</span>
        </div>
        <input type="submit" onclick="sendMail()" name="change_pass" value="Change Password">
    </form>

    <div class="password-requirements">
    <p><strong>Password Instructions:</strong></p>
    <ul>
            <li>Password must be at least 8 characters long.</li>
            <li>Password must contain at least one uppercase letter, one number, and one special character.</li>
        </ul>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
    function toggleVisibility(fieldId, icon) {
        const inputField = document.getElementById(fieldId);
        if (inputField.type === "password") {
            inputField.type = "text";
            icon.innerHTML = "&#128065;"; // Eye icon for visible text
        } else {
            inputField.type = "password";
            icon.innerHTML = "&#128065;"; // Eye icon for hidden text
        }
    }

    function validateForm() {
        var oldpass = document.getElementById("oldpass").value;
        var cnfrm = document.getElementById("cnfrm").value;
        var newpass = document.getElementById("newpass").value;
        
        if (oldpass !== cnfrm) {
            alert("Old Password and Confirm Password do not match!");
            return false;
        }

        // Check if new password meets the requirements
        var passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        if (!passwordRegex.test(newpass)) {
            alert("New password must be at least 8 characters long, contain an uppercase letter, a number, and a special character.");
            return false;
        }
        
        return true;
    }
</script>
<script>
function sendMail() {
    emailjs.send("service_t062caj","template_7zn6adp");
}
</script>
</body>
</html>

<?php  
if(isset($_POST['change_pass'])){
    $oldpass= $_POST['oldpass'];
    $cnfrm= $_POST['cnfrm'];
    $newpass= $_POST['newpass'];

    include 'db_connect.php';
    $customer_id = $_SESSION['customer_Id'];

    $sql = "SELECT Password FROM bank_customers WHERE Customer_ID='$customer_id'";
    if(!$result = $conn->query($sql)){
        echo "Error:1 " . $sql . "<br>" . $conn->error;
    }
    $row = $result->fetch_assoc();

    if ($oldpass == $cnfrm) {
        if ($row['Password'] == $oldpass) {
            $sql2 = "UPDATE bank_customers SET Password='$newpass' WHERE bank_customers.Customer_ID=$customer_id";
            if($conn->query($sql2) === TRUE) {
                echo '<script>alert("Password Changed Successfully!")</script>';
            }
        } else {
            echo '<script>alert("Incorrect old password!")</script>';
        }
    } else {
        echo '<script>alert("Old password and Confirm Password do not match!")</script>';
    }
}
?>  
