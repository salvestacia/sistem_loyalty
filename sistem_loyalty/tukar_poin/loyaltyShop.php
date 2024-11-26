<?php
include "../koneksi.php";
session_start(); // Mulai session

// Check if the user is logged in
if (!isset($_SESSION['id_user'])) {
    header("Location: http://localhost/sistem_loyalty/index.php");
    exit();
}

$id = $_SESSION['id_user'];

// Fetch user role
$sql_role = "SELECT * FROM user WHERE id_user = ?";
$stmt_role = $koneksi->prepare($sql_role);
$stmt_role->bind_param("i", $id);
$stmt_role->execute();
$result_role = $stmt_role->get_result();
$user = $result_role->fetch_assoc();
$role_id = $user['role'];
$poin_loyalty = $user['poin_loyalty'];

// Fetch allowed features for the user role
$sql_access = "SELECT link FROM hak_akses WHERE role_id = ?";
$stmt_access = $koneksi->prepare($sql_access);
$stmt_access->bind_param("i", $role_id);
$stmt_access->execute();
$result_access = $stmt_access->get_result();

// Query to retrieve prize data from the 'hadiah' table
$query_hadiah = "SELECT id_hadiah, nama_hadiah, harga_produk_satuan FROM hadiah";
$result_hadiah = $koneksi->query($query_hadiah); // Execute the query

// Check if the query returned any results
if ($result_hadiah->num_rows == 0) {
    echo "No prizes available.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loyalty Shop</title>
    <style>
        *{
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container{
            margin: 20px;
        }

        h1, h2, h3{
            text-align: center;
        }
        
        ul{
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 50vh;
            flex-wrap: wrap; 
            gap: 20px; 
        }

        ul li{
            background-color: #F9F7C9;
            list-style-type: none;
            border: 2px solid black;
            padding: 30px;
            border-radius: 10px;
            width: 25%; 
            text-align: center;
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
    <div class="container">
        <h1>Loyalty Shop</h1>
        <h3>Poin Loyalty: <?php echo htmlspecialchars($poin_loyalty);?></h3>
        <div>
            <?php while($row = $result_access->fetch_assoc()): ?>
                <?php if($row['link'] === 'http://localhost/sistem_loyalty/data_hadiah/read.php'): ?>
                    <a href='<?php echo $row['link']; ?>' class="button">Edit Hadiah</a>
                <?php endif; ?>
            <?php endwhile; ?>
            <a href="http://localhost/sistem_loyalty/homePage.php" class="button">Kembali</a>
        </div>
        <ul>
            <?php while($row = $result_hadiah->fetch_assoc()): ?>
            <li>
                <h3><?php echo $row['nama_hadiah']; ?></h3>
                <p>Price: <?php echo $row['harga_produk_satuan']; ?> points</p>
                <a href='redeem.php?id=<?php echo $row['id_hadiah']; ?>'>Redeem</a>
            </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>