<?php
require 'auth_check.php';
require 'db.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tambah Faskes - UTS WebGIS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<style>
body { background:#f4fbfa; }
#map{height:400px; border-radius:8px; box-shadow:0 6px 18px rgba(0,0,0,0.06);}
.btn-primary { background:linear-gradient(90deg,#06b6d4,#0ea5a1); border:none; }
</style>
</head>
<body>
<div class="container my-4">
  <h3>Tambah Fasilitas Kesehatan</h3>
  <form action="process_create.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Nama Faskes</label>
      <input name="nama_faskes" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Jenis Faskes</label>
      <select name="jenis_faskes" class="form-control">
        <option>Rumah Sakit</option>
        <option>Puskesmas</option>
        <option>Klinik</option>
        <option>Laboratorium</option>
      </select>
    </div>
    <div class="mb-3">
      <label>Kapasitas (jumlah tempat tidur)</label>
      <input name="kapasitas" type="number" class="form-control" value="0" required>
    </div>
    <div class="mb-3 form-check">
      <input type="checkbox" name="tersedia_vaksin" value="1" class="form-check-input" checked>
      <label class="form-check-label">Tersedia Vaksin</label>
    </div>

    <div id="map"></div>

    <div class="mb-3 mt-2">
      <label>Latitude</label>
      <input name="latitude" id="latitude" class="form-control" readonly required>
    </div>
    <div class="mb-3">
      <label>Longitude</label>
      <input name="longitude" id="longitude" class="form-control" readonly required>
    </div>

    <div class="mb-3">
      <label>Gambar (opsional)</label>
      <input type="file" name="gambar" class="form-control">
    </div>

    <div class="d-grid">
      <button class="btn btn-primary">Simpan</button>
    </div>
  </form>
  <a class="btn btn-link mt-3" href="dashboard.php">Kembali</a>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
var map = L.map('map').setView([-6.200000,106.816666],11);
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19}).addTo(map);
var marker;
map.on('click', function(e){
  var lat = e.latlng.lat.toFixed(6);
  var lng = e.latlng.lng.toFixed(6);
  document.getElementById('latitude').value = lat;
  document.getElementById('longitude').value = lng;
  if (marker) marker.setLatLng(e.latlng); else marker = L.marker(e.latlng).addTo(map);
});
</script>
</body>
</html>
