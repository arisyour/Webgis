<?php
require 'auth_check.php';
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: dashboard.php'); exit; }
$nama = mysqli_real_escape_string($conn, $_POST['nama_faskes']);
$jenis = mysqli_real_escape_string($conn, $_POST['jenis_faskes']);
$kap = (int)$_POST['kapasitas'];
$lat = mysqli_real_escape_string($conn, $_POST['latitude']);
$lng = mysqli_real_escape_string($conn, $_POST['longitude']);
$tersedia = isset($_POST['tersedia_vaksin']) ? 1 : 0;
$img = null;
if (!empty($_FILES['gambar']) && $_FILES['gambar']['error']==0) {
    $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
    $img = uniqid().'.'.$ext;
    move_uploaded_file($_FILES['gambar']['tmp_name'], __DIR__.'/uploads/'.$img);
}
$sql = "INSERT INTO tb_lokasi (nama_faskes, jenis_faskes, kapasitas, latitude, longitude, tersedia_vaksin, gambar) VALUES ('{$nama}','{$jenis}',{$kap},'{$lat}','{$lng}',{$tersedia},'{$img}')";
mysqli_query($conn, $sql);
header('Location: dashboard.php');
exit;
?>