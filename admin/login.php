<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <style>
        /* General Styles */
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            height: 100vh; /* Full viewport height */
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            overflow: hidden; /* Prevent scrolling */
            background: linear-gradient(135deg, #a2c2e0, #ffffff, #e0f7fa, #a2c2e0); /* Soft blue and white gradient */
            background-size: 400% 400%; /* For animation */
            animation: gradient 15s ease infinite; /* Animation for background */
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .login-container {
            width: 400px; /* Fixed width for the form */
            padding: 20px;
            background: rgba(255, 255, 255, 0.9); /* Semi-transparent white */
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .login-form h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .btnSubmit {
            font-weight: 600;
            width: 100%;
            color: #282726;
            background-color: #007bff; /* Bootstrap primary color */
            border: none;
            border-radius: 5px;
            padding: 10px;
            transition: background-color 0.3s;
        }

        .btnSubmit:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }

        .btnForgetPwd {
            color: #007bff; /* Bootstrap primary color */
            font-weight: 600;
            text-decoration: none;
        }

        .btnForgetPwd:hover {
            text-decoration: underline;
        }

        .message {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h3>Login Form</h3>
        <?php 
            if(isset($_SESSION['login'])) {
                echo '<div class="message success">' . $_SESSION['login'] . '</div>';
                unset($_SESSION['login']);
            }

            if(isset($_SESSION['no-login-message'])) {
                echo '<div class="message error">' . $_SESSION['no-login-message'] . '</div>';
                unset($_SESSION['no-login-message']);
            }
        ?>
        <form action="" method="POST">
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Your Email *" required />
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Your Password *" required />
            </div>
            <div class="form-group">
                <input type="submit" class="btnSubmit" name="submit" value="Login" />
            </div>
            <div class="form-group">
                <a href="#" class="btnForgetPwd">Forget Password?</a>
            </div>
        </form>
    </div>

    <script>
        // JavaScript for falling stars (if needed)
        // You can add any additional JavaScript here if required
    </script>
</body>
</html>

<?php 
    // Check whether the Submit Button is Clicked or Not
    if(isset($_POST['submit'])) {
        // Process for Login
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $raw_password = md5($_POST['password']);
        $password = mysqli_real_escape_string($conn, $raw_password);

        // SQL to check whether the user with username and password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        // Execute the Query
        $res = mysqli_query($conn, $sql);

        // Count rows to check whether the user exists or not
        $count = mysqli_num_rows($res);

        if($count == 1) {
            // User Available and Login Success
            $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
            $_SESSION['user'] = $username; // To check whether the user is logged in or not

            // Redirect to Home Page/Dashboard
            header('location:' . SITEURL . 'admin/');
        } else {
            // User not Available and Login Fail
            $_SESSION['login'] = "<div class='error'>Username or Password did not match.</div>";
            // Redirect to Login Page
            header('location:' . SITEURL . 'admin/login.php');
        }
    }
?>