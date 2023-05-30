<?php
include "src/config/connect.php";

// Add
if (isset($_POST['submit'])) {
    $nik = htmlspecialchars($_POST['nik']);
    $nama = htmlspecialchars($_POST['nama']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars(md5($_POST['password']));
    $telp = htmlspecialchars($_POST['telp']);

    if (empty($nik) || empty($nama) || empty($username) || empty($password) || empty($telp)) {
        $empty = "Data tidak boleh ada yang kosong!";
    } else {
        $check_query = mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik = '$nik'");
        if (mysqli_num_rows($check_query) > 0) {
            $error = "NIK sudah terdaftar cobalah NIK yang lain!";
        } else {
            if ($_FILES['file']['name'] != '') {
                $direktori = "src/account/img/";
                $file_name = $_FILES['file']['name'];
                $file_size = $_FILES['file']['size'];

                $allowed_extensions = array("jpg", "jpeg", "png","webp");
                $allowed_file_size = 2 * 1024 * 1024; // 2 MB

                // Validasi ekstensi file
                $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                if (!in_array($file_extension, $allowed_extensions)) {
                    echo "<script>
                            alert('Ekstensi file yang diunggah tidak valid. Hanya file dengan ekstensi JPG, JPEG, dan PNG yang diperbolehkan.');
                            document.location='signup.php';
                        </script>";
                    exit;
                }

                // Validasi ukuran file
                if ($file_size > $allowed_file_size) {
                    echo "<script>
                            alert('Ukuran file yang diunggah melebihi batas maksimal 2 MB.');
                            document.location='signup.php';
                        </script>";
                    exit;
                }

                if (file_exists($direktori . $file_name)) {
                    unlink($direktori . $file_name);
                }
                move_uploaded_file($_FILES['file']['tmp_name'], $direktori . $file_name);
            } else {
                $direktori = "src/account/img/";
                $default_image = "src/assets/img/UserImage.png";
                $file_name = "UserImage.png";
                if (!is_dir($direktori)) {
                    mkdir($direktori, 0755, true);
                }
            }


            $query = mysqli_query($conn, "INSERT INTO masyarakat VALUES ('', '$nik', '$nama', '$username', '$password', '$telp', 'masyarakat', '$file_name')");

            if ($query) {
                echo "<script>
                            alert('Register berhasil! silahkan login untuk melanjutkan');
                            document.location='authentication-login.php';
                        </script>";
            } else {
                echo "<script>
                            alert('Register gagal! silahkan coba lagi');
                            document.location='authentication-register.php';
                        </script>";
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modernize</title>
  <link rel="shortcut icon" type="image/png" href="src/assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="src/assets/css/styles.min.css" />
  <style>
    input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
  </style>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="src/assets/images/logos/dark-logo.svg" width="180" alt="">
                </a>
                <p class="text-center">Interested to complaints #TidakAntiKritik</p>
                <form action="" method="POST" enctype="multipart/form-data">
                    <?php if (isset($empty)) : ?>
                        <p class="text-center" style="color: #f9322c; font-style: italic;"><?= $empty; ?></p>
                    <?php endif; ?>
                    <?php if (isset($error)) : ?>
                        <p class="text-center" style="color: #f9322c; font-style: italic;"><?= $error; ?></p>
                    <?php endif; ?>
                  <div class="mb-3">
                    <label for="" class="form-label">Nomor Induk Kependudukan</label>
                    <input type="number" class="form-control" id="nik" name="nik" >
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" >
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Nomor Telepon</label>
                    <input type="number" class="form-control" id="telp" name="telp" >
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" >
                  </div>
                  <div class="mb-4">
                    <label for="" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" >
                  </div>
                  <div class="mb-4">
                    <label for="" class="form-label">Photo Profile</label>
                    <input type="file" class="form-control" id="file" name="file" >
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" name="submit">Sign Up</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Already have an Account?</p>
                    <a class="text-primary fw-bold ms-2" href="./authentication-login.php">Sign In</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="src/assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

