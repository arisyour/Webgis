<?php
require 'auth_check.php';
require 'db.php';
if (!isset($_GET['id'])) { header('Location: dashboard.php'); exit; }
$id = (int)$_GET['id'];
$res = mysqli_query($conn, "SELECT * FROM tb_lokasi WHERE id={$id}");
if (mysqli_num_rows($res)!==1) { header('Location: dashboard.php'); exit; }
$loc = mysqli_fetch_assoc($res);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Ubah Faskes - UTS WebGIS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<style>#map{height:400px; border-radius:8px; box-shadow:0 6px 18px rgba(0,0,0,0.06);}</style>
</head>
<body>
<div class="container my-4">
  <h3>Ubah Fasilitas Kesehatan</h3>
  <form action="process_update.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $loc['id']; ?>">
    <div class="mb-3">
      <label>Nama Faskes</label>
      <input name="nama_faskes" class="form-control" required value="<?php echo htmlspecialchars($loc['nama_faskes']); ?>">
    </div>
    <div class="mb-3">
      <label>Jenis Faskes</label>
      <input name="jenis_faskes" class="form-control" required value="<?php echo htmlspecialchars($loc['jenis_faskes']); ?>">
    </div>
    <div class="mb-3">
      <label>Kapasitas</label>
      <input name="kapasitas" type="number" class="form-control" required value="<?php echo $loc['kapasitas']; ?>">
    </div>
    <div class="mb-3 form-check">
      <input type="checkbox" name="tersedia_vaksin" value="1" class="form-check-input" <?php if($loc['tersedia_vaksin']) echo 'checked'; ?>>
      <label class="form-check-label">Tersedia Vaksin</label>
    </div>

    <div id="map"></div>

    <div class="mb-3 mt-2">
      <label>Latitude</label>
      <input name="latitude" id="latitude" class="form-control" readonly required value="<?php echo htmlspecialchars($loc['latitude']); ?>">
    </div>
    <div class="mb-3">
      <label>Longitude</label>
      <input name="longitude" id="longitude" class="form-control" readonly required value="<?php echo htmlspecialchars($loc['longitude']); ?>">
    </div>

    <div class="mb-3">
      <label>Gambar (unggah untuk menggantikan)</label>
      <input type="file" name="gambar" class="form-control">
      <?php if ($loc['gambar']): ?><div class="mt-2">Gambar saat ini: <a href="uploads/<?php echo $loc['gambar']; ?>" target="_blank"><?php echo $loc['gambar']; ?></a></div><?php endif; ?>
    </div>

    <div class="d-grid"><button class="btn btn-primary">Simpan Perubahan</button></div>
  </form>
  <a class="btn btn-link mt-3" href="dashboard.php">Kembali</a>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
var lat0 = <?php echo $loc['latitude'] ?: -6.2; ?>;
var lng0 = <?php echo $loc['longitude'] ?: 106.816666; ?>;
var map = L.map('map').setView([lat0, lng0], 12);
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19}).addTo(map);
var marker = L.marker([lat0, lng0]).addTo(map);
map.on('click', function(e){
  var lat = e.latlng.lat.toFixed(6);
  var lng = e.latlng.lng.toFixed(6);
  document.getElementById('latitude').value = lat;
  document.getElementById('longitude').value = lng;
  marker.setLatLng(e.latlng);
});
</script>
</body>
</html>
