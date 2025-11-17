<?php
require 'auth_check.php';
require 'db.php';
$sql = "SELECT * FROM tb_lokasi ORDER BY id DESC";
$res = mysqli_query($conn, $sql);
$locations = [];
while ($r = mysqli_fetch_assoc($res)) $locations[] = $r;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard - UTS WebGIS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<style>
body { background:#f4fbfa; }
.navbar { background: linear-gradient(90deg,#06b6d4,#0ea5a1); }
#map{height:450px; border-radius:8px; box-shadow:0 6px 18px rgba(0,0,0,0.08);}
.card { border-radius:10px; }
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#" style="font-weight:700;">UTS WebGIS - Kesehatan</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="create.php">Tambah Lokasi</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['user']); ?>)</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container my-4">
  <div class="row g-4">
    <div class="col-md-8">
      <div id="map"></div>
    </div>
    <div class="col-md-4">
      <div class="card p-3">
        <h5>Ringkasan</h5>
        <p>Total lokasi: <strong><?php echo count($locations); ?></strong></p>
        <a href="create.php" class="btn btn-success w-100" style="background:linear-gradient(90deg,#10b981,#06b6d4); border:none;">Tambah Faskes</a>
      </div>
      <div class="card p-3 mt-3">
        <h6>Daftar Lokasi</h6>
        <ul class="list-group">
        <?php foreach($locations as $loc): ?>
          <li class="list-group-item d-flex justify-content-between align-items-start">
            <div>
              <div class="fw-bold"><?php echo htmlspecialchars($loc['nama_faskes']); ?></div>
              <small><?php echo htmlspecialchars($loc['jenis_faskes']); ?> — Kapasitas: <?php echo $loc['kapasitas']; ?></small>
            </div>
            <div>
              <a class="btn btn-sm btn-primary" href="update.php?id=<?php echo $loc['id']; ?>">Ubah</a>
              <a class="btn btn-sm btn-danger" href="delete.php?id=<?php echo $loc['id']; ?>" onclick="return confirm('Hapus?')">Hapus</a>
            </div>
          </li>
        <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>

  <div class="card mt-4 p-3">
    <h5>Semua Data</h5>
    <table class="table table-striped">
      <thead><tr><th>#</th><th>Nama</th><th>Jenis</th><th>Kapasitas</th><th>Vaksin</th><th>Aksi</th></tr></thead>
      <tbody>
      <?php foreach ($locations as $loc): ?>
        <tr>
          <td><?php echo $loc['id']; ?></td>
          <td><?php echo htmlspecialchars($loc['nama_faskes']); ?></td>
          <td><?php echo htmlspecialchars($loc['jenis_faskes']); ?></td>
          <td><?php echo $loc['kapasitas']; ?></td>
          <td><?php echo $loc['tersedia_vaksin'] ? 'Ya' : 'Tidak'; ?></td>
          <td>
            <a class="btn btn-sm btn-primary" href="update.php?id=<?php echo $loc['id']; ?>">Ubah</a>
            <a class="btn btn-sm btn-danger" href="delete.php?id=<?php echo $loc['id']; ?>" onclick="return confirm('Hapus?')">Hapus</a>
            <?php if ($loc['gambar']): ?><a class="btn btn-sm btn-secondary" href="uploads/<?php echo $loc['gambar']; ?>" target="_blank">Lihat Gambar</a><?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
var map = L.map('map').setView([-6.200000,106.816666],11);
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19}).addTo(map);
var locations = <?php echo json_encode($locations); ?>;
locations.forEach(function(l){
  if (l.latitude && l.longitude) {
    var m = L.marker([parseFloat(l.latitude), parseFloat(l.longitude)]).addTo(map);
    var popup = '<b>'+l.nama_faskes+'</b><br/>'+l.jenis_faskes;
    if (l.gambar) popup += '<br/><img src="uploads/'+l.gambar+'" style="width:140px;">';
    m.bindPopup(popup);
  }
});
</script>
</body>
</html>
