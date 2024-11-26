<?php
include "../koneksi.php";
session_start(); // Mulai session

// Check if the user is logged in
if (!isset($_SESSION['id_user'])) {
    header("Location: http://localhost/sistem_loyalty/index.php");
    exit();
}

// Function to calculate and update loyalty points for all users
function calculateLoyaltyPoints($koneksi) {
    // Fetch all users from the database
    $query_users = "SELECT id_user FROM user";
    $result_users = mysqli_query($koneksi, $query_users);

    if ($result_users && mysqli_num_rows($result_users) > 0) {
        while ($user = mysqli_fetch_assoc($result_users)) {
            $id_user = $user['id_user'];
            
            // Fetch the total spending of each user from the transaksi_sales table
            $query_spending = "SELECT SUM(produk.harga_produk_satuan * transaksi_sales.qty) AS total_spending 
                              FROM transaksi_sales 
                              JOIN produk ON transaksi_sales.item = produk.id_produk
                              WHERE transaksi_sales.user = $id_user";
            $result_spending = mysqli_query($koneksi, $query_spending);
            
            if ($result_spending && mysqli_num_rows($result_spending) > 0) {
                $row = mysqli_fetch_assoc($result_spending);
                $total_spending = $row['total_spending'];

                // Check if user has any transactions
                if ($total_spending > 0) {
                    // Calculate loyalty points: 10 points for every 100,000 Rupiah
                    $loyalty_points = floor($total_spending / 100000) * 10;

                    // Calculate membership level based on total spending
                    if ($total_spending >= 4000000) {
                        $membership_level = 'Platinum';
                    } elseif ($total_spending >= 3000000) {
                        $membership_level = 'Gold';
                    } elseif ($total_spending >= 2000000) {
                        $membership_level = 'Silver';
                    } elseif ($total_spending >= 1000000) {
                        $membership_level = 'Bronze';
                    } else {
                        $membership_level = 'None';
                    }

                    // Update the user's loyalty points and membership in the database
                    $update_query = "UPDATE user 
                                    SET poin_loyalty = $loyalty_points, 
                                        membership = '$membership_level' 
                                    WHERE id_user = $id_user";
                    mysqli_query($koneksi, $update_query);
                }
            }
        }
    }
}

// Trigger loyalty points calculation if the button is clicked
if (isset($_GET['calculate_loyalty'])) {
    calculateLoyaltyPoints($koneksi);
    echo "<script>
            alert('Loyalty points for all users have been calculated successfully!');
            window.location.href = 'http://localhost/sistem_loyalty/crm/halaman_crm.php';
          </script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman CRM</title>
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

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background-color: #f2f2f2;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }
    
        a.button {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            background-color: #80BCBD;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        a.button:hover {
            background-color: #AAD9BB;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Halaman CRM</h2>
    <a href="http://localhost/sistem_loyalty/homePage.php" class="button">Kembali</a>
    <a href="http://localhost/sistem_loyalty/crm/halaman_crm.php?calculate_loyalty=true" class="button">Hitung Poin untuk Semua Users</a> 
    <table border='1'>
        <tr>
            <th>Username</th>
            <th>Item</th>
            <th>Total Transaksi</th>
            <th>Poin Loyalty</th>
            <th>Action</th>
        </tr>
        <?php
        $query = "SELECT user.id_user, user.username, user.poin_loyalty, 
        GROUP_CONCAT(produk.nama_produk) AS purchased_items, 
        COUNT(ts.item) AS purchase_count, 
        SUM(produk.harga_produk_satuan * ts.qty) AS total_spending
        FROM user 
        JOIN transaksi_sales ts ON user.id_user = ts.user
        JOIN produk ON produk.id_produk = ts.item 
        GROUP BY user.id_user
        ORDER BY purchase_count DESC";
        $result = mysqli_query($koneksi, $query);

        if(!$result){
            echo "query gagal!";
        } 
        else{
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>
                        <td>".$row['username']."</td>
                        <td>".$row['purchased_items']."</td>
                        <td>".$row['total_spending']."</td>
                        <td>".$row['poin_loyalty']." points</td>
                        <td>
                            <a href='http://localhost/sistem_loyalty/crm/send_mail.php?id_user=".$row['id_user']."' class='button'>Mail</a>
                        </td>
                      </tr>";
            }
        }
        ?>
    </table>
</div>
</body>
</html>
