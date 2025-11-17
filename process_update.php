<?php
require 'auth_check.php';
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: dashboard.php'); exit; }
$id = (int)$_POST['id'];
$nama = mysqli_real_escape_string($conn, $_POST['nama_faskes']);
$jenis = mysqli_real_escape_string($conn, $_POST['jenis_faskes']);
$kap = (int)$_POST['kapasitas'];
$lat = mysqli_real_escape_string($conn, $_POST['latitude']);
$lng = mysqli_real_escape_string($conn, $_POST['longitude']);
$tersedia = isset($_POST['tersedia_vaksin']) ? 1 : 0;
$img_sql = '';
if (!empty($_FILES['gambar']) && $_FILES['gambar']['error']==0) {
    $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
    $img = uniqid().'.'.$ext;
    move_uploaded_file($_FILES['gambar']['tmp_name'], __DIR__.'/uploads/'.$img);
    $old = mysqli_fetch_assoc(mysqli_query($conn, "SELECT gambar FROM tb_lokasi WHERE id={$id}"))['gambar'];
    if ($old) @unlink(__DIR__.'/uploads/'.$old);
    $img_sql = ", gambar='{$img}'";
}
$sql = "UPDATE tb_lokasi SET nama_faskes='{$nama}', jenis_faskes='{$jenis}', kapasitas={$kap}, latitude='{$lat}', longitude='{$lng}', tersedia_vaksin={$tersedia} {$img_sql} WHERE id={$id}";
mysqli_query($conn, $sql);
header('Location: dashboard.php');
exit;
?>