<?php
include "../koneksi.php";
session_start(); // Mulai session

// Check if the user is logged in
if (!isset($_SESSION['id_user'])) {
    header("Location: http://localhost/sistem_loyalty/index.php");
    exit();
}

$id = $_GET['id'];
$query = "SELECT * FROM hadiah WHERE id_hadiah= '$id'";
$result = mysqli_query($koneksi, $query);
if(!$result){
    echo "Query gagal!";
}
else{
    $data = mysqli_fetch_assoc($result);
}
if(isset($_POST["submit"])){
    $nama_hadiah = $_POST['nama_hadiah'];
    $harga_produk_satuan = $_POST['harga_produk_satuan'];

    $query = "UPDATE hadiah SET nama_hadiah ='$nama_hadiah', harga_produk_satuan = '$harga_produk_satuan' WHERE id_hadiah ='$id' ";
    $result = mysqli_query($koneksi, $query);
    if(!$result){
        echo "Data gagal diubah!";
    }
    else{
        echo "Data berhasil diubah!";
        header("Location: http://localhost/sistem_loyalty/data_hadiah/read.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Hadiah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1{
            color: #333;
            text-align: center;    
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            max-width: 500px;
            margin: 0 auto;
            border: 2px solid black;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"] {
            width: 95%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
        }

        button[type="submit"]{
            padding: 8px 16px;
            background-color: #80BCBD;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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

        button[type="submit"]:hover, a.button:hover {
            background-color: #AAD9BB;
        }
    </style>
</head>
<body>
    <h1>Ubah Data User</h1>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $data['id_hadiah']; ?>">
        <label for="nama_hadiah">Nama Hadiah:</label>
        <input type="text" name="nama_hadiah" id="nama_hadiah" value="<?php echo $data['nama_hadiah']; ?>">
        <br>
        <label for="harga_produk_satuan">password:</label>
        <input type="text" name="harga_produk_satuan" id="harga_produk_satuan" value="<?php echo $data['harga_produk_satuan']; ?>">
        <br>
        <br>
        <button type="submit" name="submit">Ubah</button>
        <a href="http://localhost/sistem_loyalty/data_hadiah/read.php" class="button">Kembali</a>
    </form>
</body>
</html>