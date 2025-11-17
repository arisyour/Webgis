<?php
session_start();
require 'db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = mysqli_real_escape_string($conn, $_POST['username']);
    $p = mysqli_real_escape_string($conn, $_POST['password']);
    $res = mysqli_query($conn, "SELECT * FROM users WHERE username='$u' AND password=MD5('$p')");
    if (mysqli_num_rows($res) === 1) {
        $_SESSION['user'] = $u;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Login gagal: username atau password salah.';
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login - UTS WebGIS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background: linear-gradient(135deg, #e6f7f1 0%, #e9f5ff 100%); }
.card { border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
.btn-primary { background: linear-gradient(90deg,#0ea5a1,#06b6d4); border: none; }
</style>
</head>
<body class="d-flex align-items-center" style="min-height:100vh;">
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card p-4">
        <h4 class="mb-3" style="color:#0b8273;"> Login WebGis Kesehatan</h4>
        <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
        <form method="post">
          <div class="mb-3">
            <label>Username</label>
            <input name="username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Password</label>
            <input name="password" type="password" class="form-control" required>
          </div>
          <div class="d-grid">
            <button class="btn btn-primary">Masuk</button>
          </div>
        </form>
        <div class="mt-3 text-muted small"></div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
