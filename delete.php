<?php
require 'auth_check.php';
require 'db.php';
if (!isset($_GET['id'])) { header('Location: dashboard.php'); exit; }
$id = (int)$_GET['id'];
$old = mysqli_fetch_assoc(mysqli_query($conn, "SELECT gambar FROM tb_lokasi WHERE id={$id}"))['gambar'];
if ($old) @unlink(__DIR__.'/uploads/'.$old);
mysqli_query($conn, "DELETE FROM tb_lokasi WHERE id={$id}");
header('Location: dashboard.php');
exit;
?>