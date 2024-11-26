<?php
include "../koneksi.php";
$id = $_GET['id'];

try {
    $query = "DELETE FROM hadiah WHERE id_hadiah = '$id'";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        throw new Exception("Data gagal dihapus!");
    } else {
        echo "Data berhasil dihapus!";
        header("Location: http://localhost/sistem_loyalty/data_hadiah/read.php");
    }
} catch (Exception $e) {
    echo "Invalid operation! Ada data di tabel child yang terhubung!";
}
?>
