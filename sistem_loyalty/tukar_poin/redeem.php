<?php
include '../koneksi.php';
session_start(); // Start session

// Get the prize ID from the URL
$id_hadiah = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the prize details from the 'hadiah' table
$query_hadiah = "SELECT nama_hadiah, harga_produk_satuan FROM hadiah WHERE id_hadiah = ?";
$stmt = $koneksi->prepare($query_hadiah);
$stmt->bind_param("i", $id_hadiah);
$stmt->execute();
$result_hadiah = $stmt->get_result();

if ($result_hadiah->num_rows == 0) {
    echo "Invalid prize.";
    exit();
}

$hadiah = $result_hadiah->fetch_assoc();
$harga_hadiah = $hadiah['harga_produk_satuan'];

// Fetch the user's loyalty points from the 'users' table
$id_user = $_SESSION['id_user'];
$query_user = "SELECT poin_loyalty FROM user WHERE id_user = ?";
$stmt_user = $koneksi->prepare($query_user);
$stmt_user->bind_param("i", $id_user);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();
$user_points = $user['poin_loyalty'];

// Check if the user has enough points
if ($user_points >= $harga_hadiah) {
    // Deduct the prize price from the user's points
    $new_points = $user_points - $harga_hadiah;
    $update_points = "UPDATE user SET poin_loyalty = ? WHERE id_user = ?";
    $stmt_update = $koneksi->prepare($update_points);
    $stmt_update->bind_param("ii", $new_points, $id_user);
    $stmt_update->execute();

    // Optionally, record the redemption in a 'redemptions' table
    $query_redeem = "INSERT INTO transaksi_poin_loyalty (tgl, user, item) VALUES (NOW(), ?, ?)";
    $stmt_redeem = $koneksi->prepare($query_redeem);
    $stmt_redeem->bind_param("ii", $id_user, $id_hadiah);
    $stmt_redeem->execute();

    // Show success alert and redirect to the loyalty shop
    echo "<script>
        alert('Congratulations! You have successfully redeemed \"{$hadiah['nama_hadiah']}\". Your remaining points: {$new_points}');
        window.location.href = 'http://localhost/sistem_loyalty/tukar_poin/loyaltyShop.php';
    </script>";
} else {
    echo "<script>
        alert('Sorry, you do not have enough points to redeem \"{$hadiah['nama_hadiah']}\".');
        window.location.href = 'http://localhost/sistem_loyalty/tukar_poin/loyaltyShop.php';
    </script>";
}

?>
