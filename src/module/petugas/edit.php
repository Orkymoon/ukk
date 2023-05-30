<?php

include "src/config/connect.php";

$level = $_SESSION['level'];


$id = $_GET['id_petugas'];
$row = mysqli_query($conn, "SELECT * FROM petugas WHERE id_petugas=$id");


if ($level != "Admin") {
    echo "<script>
    alert('Anda tidak berhak mengakses modul ini!');
    document.location='?module=home';
    </script>";
}

// Edit
// Menyimpan foto profil baru
if (isset($_POST['edit'])) {
    $id_petugas = htmlspecialchars($_POST['id_petugas']);
    $nama_petugas = htmlspecialchars($_POST['nama_petugas']);
    $username = htmlspecialchars($_POST['username']);
    $telp = htmlspecialchars($_POST['telp']);
    $level = htmlspecialchars($_POST['level']);
    $fotoProfil = $_FILES['foto_profil'];


    if (empty($_FILES['foto_profil']['name'])) {
        $query = mysqli_query($conn, "UPDATE petugas SET nama_petugas = '$nama_petugas', username = '$username', telp = '$telp', level = '$level' WHERE id_petugas = '$id_petugas'");
        if ($query) {
            echo "<script>
                alert('Data berhasil diubah!');
                document.location='?module=datapetugas';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal diubah!');
                document.location='?module=datapetugas';
            </script>";
        }
    } else {
        // Mendapatkan informasi foto
        $namaFoto = $fotoProfil['name'];
        $ukuranFoto = $fotoProfil['size'];
        $tmpFoto = $fotoProfil['tmp_name'];
        $errorFoto = $fotoProfil['error'];

        // Mengambil ekstensi file foto
        $ekstensiFoto = pathinfo($namaFoto, PATHINFO_EXTENSION);

        // Lokasi penyimpanan foto profil baru
        $lokasiSimpan = "src/account/img/" . $namaFoto;

        // Memeriksa apakah file yang diunggah adalah gambar
        $isImage = getimagesize($tmpFoto);
        if ($isImage !== false) {
            // Memeriksa ukuran file foto
            if ($ukuranFoto <= 5000000) { // Maksimum ukuran file 5MB
                // Memeriksa ekstensi file foto yang diperbolehkan
                $allowedExtensions = array("jpg", "jpeg", "png");
                if (in_array($ekstensiFoto, $allowedExtensions)) {
                    // Pindahkan file foto ke lokasi penyimpanan
                    if (move_uploaded_file($tmpFoto, $lokasiSimpan)) {
                        echo "Foto profil berhasil diunggah dan disimpan.";
                        // Update data profil pengguna di database
                        // ...
                    } else {
                        echo "Gagal mengunggah foto profil.";
                    }
                } else {
                    echo "Ekstensi file yang diperbolehkan adalah JPG, JPEG, dan PNG.";
                }
            } else {
                echo "Ukuran file foto maksimum adalah 5MB.";
            }
        } else {
            echo "File yang diunggah bukan merupakan gambar.";
        }
        $query = mysqli_query($conn, "UPDATE petugas SET nama_petugas = '$nama_petugas', username = '$username', telp = '$telp', level = '$level', foto_petugas = '$namaFoto' WHERE id_petugas = '$id_petugas'");

        if ($query) {
            echo "<script>
            alert('Data berhasil diubah!');
            document.location='?module=datapetugas';
        </script>";
        } else {
            echo "<script>
            alert('Data gagal diubah!');
            document.location='?module=datapetugas';
        </script>";
        }
    }
}

// Edit
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
        <?php while ($result = mysqli_fetch_array($row)) : ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                <img id="photo" src="src/account/img/<?= $result['foto_petugas'] ?>" alt="avatar" class="rounded-circle img-fluid" style="width: 150px; height: 150px;">
                                <h5 class="my-3"><?= $result['nama_petugas'] ?></h5>
                                <div class="d-flex justify-content-center mb-2">
                                    <input type="file" class="mb-0 form-control form-control-sm" id="foto_profil" name="foto_profil" onchange="readURL(this);" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <input type="hidden" name="id_petugas" id="id_petugas" value="<?= $result['id_petugas'] ?>">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Nama Petugas</p>
                                    </div>
                                    <div class="col-sm-9 d-flex align-items-center">
                                        <input type="text" class="mb-0 form-control form-control-sm" name="nama_petugas" id="nama_petugas" value="<?= $result['nama_petugas'] ?>" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Username</p>
                                    </div>
                                    <div class="col-sm-9 d-flex align-items-center">
                                        <input type="text" class="mb-0 form-control form-control-sm" name="username" id="username" value="<?= $result['username'] ?>" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Password</p>
                                    </div>
                                    <div class="col-sm-9 d-flex align-items-center">
                                        <input type="password" class="mb-0 form-control form-control-sm" name="password" id="password" value="<?= $result['password'] ?>" disabled>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Nomor Handphone</p>
                                    </div>
                                    <div class="col-sm-9 d-flex align-items-center">
                                        <input type="number" class="mb-0 form-control form-control-sm" name="telp" id="telp" value="<?= $result['telp'] ?>" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Level</p>
                                    </div>
                                    <div class="col-sm-9 d-flex align-items-center">
                                        <select class="form-select" name="level" id="level" value="<?= $result['level'] ?>" required>
                                            <option value="Admin">Admin</option>
                                            <option value="Petugas">Petugas</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col d-flex justify-content-end">
                                        <a type="button" class="btn btn-outline-danger btn-sm mx-1" href="?module=datamasyarakat">Cancel</a>
                                        <button type="submit" class="btn btn-outline-success btn-sm" name="edit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php endwhile; ?>
    </div>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#photo')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script src="/ukk/src/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="/ukk/src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/ukk/src/assets/js/sidebarmenu.js"></script>
    <script src="/ukk/src/assets/js/app.min.js"></script>
    <script src="/ukk/src/assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>