<?php
session_start();
include 'koneksi.php';

// Check if the user is logged in
if (!isset($_SESSION['id_user'])) {
    header("Location: http://localhost/sistem_loyalty/index.php");
    exit();
}

$id = $_SESSION['id_user'];

// Fetch user profile data from the database
$query = "SELECT username, email, poin_loyalty, membership FROM user WHERE id_user = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($username, $email, $poin_loyalty, $membership);
    $stmt->fetch();
} else {
    echo "User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .profile-container {
            background-color: #F9F7C9;
            padding: 30px;
            border: 2px solid black;
            border-radius: 10px;
            width: 500px;
            text-align: center;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            margin: 10px 0;
        }
        a {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            background-color: #80BCBD;
            color: white;
            border-radius: 5px;
        }
        a:hover {
            background-color: #AAD9BB;
        }

    </style>
</head>
<body>
    <div class="profile-container">
        <h1>Profile Information</h1>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Poin Loyalty:</strong> <?php echo htmlspecialchars($poin_loyalty); ?></p>
        <p><strong>Membership:</strong> <?php echo htmlspecialchars($membership); ?></p>

        <a href="http://localhost/sistem_loyalty/logout.php">Logout</a>
        <a href="http://localhost/sistem_loyalty/homePage.php" class="button">Kembali</a>
    </div>
</body>
</html>
