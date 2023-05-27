<?php
include "src/config/connect.php";

$level = $_SESSION['level'];

$row = mysqli_query($conn, "SELECT * FROM masyarakat ORDER BY nama ASC");

if ($level != "Admin") {
    echo "<script>
    alert('Anda tidak berhak mengakses modul ini!');
    document.location='?module=home';
    </script>";
}

// Add
if (isset($_POST['add'])) {
    $nik = htmlspecialchars($_POST['nik']);
    $nama = htmlspecialchars($_POST['nama']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars(md5($_POST['password']));
    $telp = htmlspecialchars($_POST['telp']);

    $query = mysqli_query($conn, "INSERT INTO masyarakat (nik, nama, username, password, telp) VALUES ('$nik', '$nama', '$username', '$password', '$telp')");

    if ($query) {
        echo "<script>
                alert('Data berhasil disimpan!');
                document.location='?module=datamasyarakat';
            </script>";
    } else {
        echo "<script>
                alert('Data gagal disimpan!');
                document.location='?module=datamasyarakat';
            </script>";
    }
}
// Add


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modernize Free</title>
  <link rel="shortcut icon" type="image/png" href="/ukk/src/assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="/ukk/src/assets/css/styles.min.css" />
</head>
<body>
<div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4 text-center">Add Form</h5>
              <div class="card">
              <form method="POST" action="">
                   
                <div class="card-body">
                    <input type="hidden" name="id_masyarakat" value="<?= $result['id_masyarakat'] ?>">
                    <div class="mb-3">
                      <label class="form-label">Nomor Induk Kependudukan</label>
                      <input type="number" class="form-control" name="nik" id="nik">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Nama</label>
                      <input type="text" class="form-control" name="nama" id="nama">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Username</label>
                      <input type="text" class="form-control" name="username" id="username">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Password</label>
                      <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Telepon</label>
                      <input type="number" class="form-control" name="telp" id="telp">
                    </div>
                        
                </div>
                <div class="card-footer">
                    <a type="button" class="btn btn-secondary" href="?module=datamasyarakat">Cancel</a>
                    <button type="submit" class="btn btn-primary" name="add">Submit</button>    
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  <script src="/ukk/src/assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="/ukk/src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/ukk/src/assets/js/sidebarmenu.js"></script>
  <script src="/ukk/src/assets/js/app.min.js"></script>
  <script src="/ukk/src/assets/libs/simplebar/dist/simplebar.js"></script>
</body>
</html>