<?php
$id = $_POST['id'];
$kecamatan = $_POST['kecamatan'];
$longitude = $_POST['longitude'];
$latitude = $_POST['latitude'];
$luas = $_POST['luas'];
$jumlah_penduduk = $_POST['jumlah_penduduk'];

// Koneksi database
$conn = new mysqli("localhost", "root", "", "lat8");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query update
$sql = "UPDATE data_kecamatan 
        SET kecamatan='$kecamatan', longitude='$longitude', latitude='$latitude', luas='$luas', jumlah_penduduk='$jumlah_penduduk' 
        WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    // Jika berhasil, redirect dengan pesan sukses
    header("Location: ../index.php?status=success");
} else {
    // Jika gagal, redirect dengan pesan error
    header("Location: ../index.php?status=error");
}

$conn->close();
exit();
?>
