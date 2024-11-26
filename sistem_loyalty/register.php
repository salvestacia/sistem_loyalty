<?php
include 'koneksi.php';

session_start(); // Start session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data from the registration form
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Check if the username already exists
    $check_query = "SELECT id_user FROM user WHERE username=?";
    $check_stmt = $koneksi->prepare($check_query);
    $check_stmt->bind_param('s', $username);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows == 0) {
        // If the username doesn't exist, insert the new user into the database
        $insert_query = "INSERT INTO user (username, password, email, role) VALUES (?, ?, ?, 1)";
        $insert_stmt = $koneksi->prepare($insert_query);
        $insert_stmt->bind_param('sss', $username, $password, $email);

        if ($insert_stmt->execute()) {
            // Successful registration, redirect to login page
            echo "Registration successful. Redirecting to login page...";
            header("Refresh: 2; URL=http://localhost/sistem_loyalty/index.php");
        } else {
            // Handle query failure
            echo "Error: Could not register user. Please try again.";
        }

        $insert_stmt->close();
    } else {
        // If username already exists, show error message
        echo "Username already exists. Please choose a different username.";
    }

    $check_stmt->close();
    mysqli_close($koneksi);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        input{
            width: 250px;
        }
        input[type="submit"]{
            background-color: #80BCBD;
            color: white;
            border-radius: 5px;
            padding: 8px 16px;
        }
        input[type="submit"]:hover{
            background-color: #AAD9BB;
        }

        body{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container{
            background-color: #F9F7C9;
            padding: 20px 30px;
            border: 2px solid black;
            border-radius: 10px;
        }
        #login {
            cursor: pointer;
            color: #007bff;
            font-size: 14px;
        }
        #login:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <p style="font-size:30px; font-weight:bold;">Register</p>
        <p>Sistem Loyalty</p>
        <form method="POST">
            <label for="username">Username</label><br/>
            <input type="text" name="username" id="username" placeholder="Username" required><br/>
            <label for="email">Email</label><br/>
            <input type="email" name="email" id="email" placeholder="Email" required><br/>
            <label for="password">Password</label><br/>
            <input type="password" name="password" id="password" placeholder="Password" required><br/><br/>
            <input type="submit" name="submit" value="Register">
            <span id="login">Login</span> 
        </form>
    </div>
    <script>
        // Redirect to the login page when the "Login" text is clicked
        document.getElementById("login").addEventListener("click", function() {
            window.location.href = "http://localhost/sistem_loyalty/index.php";
        });
    </script>
</body>
</html>
