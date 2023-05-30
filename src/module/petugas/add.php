<?php
include "src/config/connect.php";

$level = $_SESSION['level'];

if ($level != "Admin") {
    echo "<script>
    alert('Anda tidak berhak mengakses modul ini!');
    document.location='?module=home';
    </script>";
}

$row = mysqli_query($conn, "SELECT * FROM petugas ORDER BY nama_petugas ASC");

// Add
if (isset($_POST['add'])) {
    $nama_petugas = htmlspecialchars($_POST['nama_petugas']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars(md5($_POST['password']));
    $telp = htmlspecialchars($_POST['telp']);
    $level = htmlspecialchars($_POST['level']);

    if (empty($nama_petugas) || empty($username) || empty($password) || empty($telp) || empty($level)) {
        $empty = "Data tidak boleh ada yang kosong!";
    } else {
        $check_query = mysqli_query($conn, "SELECT * FROM petugas WHERE nama_petugas = '$nama_petugas'");
        if (mysqli_num_rows($check_query) > 0) {
            $error = "NIK sudah terdaftar cobalah NIK yang lain!";
        } else {
            if ($_FILES['file']['name'] != '') {
                $direktori = "src/account/img/";
                $file_name = $_FILES['file']['name'];
                $file_size = $_FILES['file']['size'];

                $allowed_extensions = array("jpg", "jpeg", "png", "webp");
                $allowed_file_size = 2 * 1024 * 1024; // 2 MB

                // Validasi ekstensi file
                $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                if (!in_array($file_extension, $allowed_extensions)) {
                    echo "<script>
                            alert('Ekstensi file yang diunggah tidak valid. Hanya file dengan ekstensi JPG, JPEG, dan PNG yang diperbolehkan.');
                            document.location='?module=add-datapetugas';
                        </script>";
                    exit;
                }

                // Validasi ukuran file
                if ($file_size > $allowed_file_size) {
                    echo "<script>
                            alert('Ukuran file yang diunggah melebihi batas maksimal 2 MB.');
                            document.location='?module=add-datapetugas';
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


            $query = mysqli_query($conn, "INSERT INTO petugas VALUES ('', '$nama_petugas', '$username', '$password', '$telp', '$level', '$file_name')");

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
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modernize Free</title>
    <link rel="shortcut icon" type="image/png" href="/ukk/src/assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="/ukk/src/assets/css/styles.min.css" />
    <style>
        body {
            background-color: #f9f9fa
        }

        .padding {
            padding: 3rem !important
        }

        .user-card-full {
            overflow: hidden;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .card {
            border-radius: 5px;
            -webkit-box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
            box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
            border: none;
            margin-bottom: 30px;
        }

        .m-r-0 {
            margin-right: 0px;
        }

        .m-l-0 {
            margin-left: 0px;
        }

        .user-card-full .user-profile {
            border-radius: 5px 0 0 5px;
        }

        .bg-c-lite-green {
            background: -webkit-gradient(linear, left top, right top, from(#f29263), to(#ee5a6f));
            background: linear-gradient(to right, #ee5a6f, #f29263);
        }

        .user-profile {
            padding: 20px 0;
        }

        .card-block {
            padding: 1.25rem;
        }

        .m-b-25 {
            margin-bottom: 25px;
        }

        .img-radius {
            border-radius: 5px;
        }



        h6 {
            font-size: 14px;
        }

        .card .card-block p {
            line-height: 25px;
        }

        @media only screen and (min-width: 1400px) {
            p {
                font-size: 14px;
            }
        }

        .card-block {
            padding: 1.25rem;
        }

        .b-b-default {
            border-bottom: 1px solid #e0e0e0;
        }

        .m-b-20 {
            margin-bottom: 20px;
        }

        .p-b-5 {
            padding-bottom: 5px !important;
        }

        .card .card-block p {
            line-height: 25px;
        }

        .m-b-10 {
            margin-bottom: 10px;
        }

        .text-muted {
            color: #919aa3 !important;
        }

        .b-b-default {
            border-bottom: 1px solid #e0e0e0;
        }

        .f-w-600 {
            font-weight: 600;
        }

        .m-b-20 {
            margin-bottom: 20px;
        }

        .m-t-40 {
            margin-top: 20px;
        }

        .p-b-5 {
            padding-bottom: 5px !important;
        }

        .m-b-10 {
            margin-bottom: 10px;
        }

        .m-t-40 {
            margin-top: 20px;
        }

        .user-card-full .social-link li {
            display: inline-block;
        }

        .user-card-full .social-link li a {
            font-size: 20px;
            margin: 0 10px 0 0;
            -webkit-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }

        .row .c-font p {
            margin: 9px 0 2px 5px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img id="photo" src="src/account/img/UserImage.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px; height: 150px;">
                            <h5 class="my-3" id="outputText">NULL</h5>
                            <div class="d-flex justify-content-center mb-2">
                                <input type="file" class="mb-0 form-control form-control-sm" id="file" name="file" onchange="readURL(this);" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Nama Petugas</p>
                                </div>
                                <div class="col-sm-9 d-flex align-items-center">
                                    <input type="text" class="mb-0 form-control form-control-sm" name="nama_petugas" id="nama_petugas" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Username</p>
                                </div>
                                <div class="col-sm-9 d-flex align-items-center">
                                    <input type="text" class="mb-0 form-control form-control-sm" name="username" id="inputText" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Password</p>
                                </div>
                                <div class="col-sm-9 d-flex align-items-center">
                                    <input type="password" class="mb-0 form-control form-control-sm" name="password" id="password" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Nomor Handphone</p>
                                </div>
                                <div class="col-sm-9 d-flex align-items-center">
                                    <input type="number" class="mb-0 form-control form-control-sm" name="telp" id="telp" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Level</p>
                                </div>
                                <div class="col-sm-9 d-flex align-items-center">
                                    <select class="form-select" name="level" required>
                                        <option value="Admin">Admin</option>
                                        <option value="Petugas">Petugas</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col d-flex justify-content-end">
                                    <a type="button" class="btn btn-outline-danger btn-sm mx-1" href="?module=datapetugas">Cancel</a>
                                    <button type="submit" class="btn btn-outline-success btn-sm" name="add">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
        // Mendapatkan referensi ke elemen input dan paragraf
        var input = document.getElementById('inputText');
        var output = document.getElementById('outputText');

        // Menambahkan event listener untuk input berubah
        input.addEventListener('input', function() {
            // Mengubah teks dalam paragraf sesuai dengan nilai input
            output.textContent = input.value;
        });
    </script>
    <script src="/ukk/src/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="/ukk/src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/ukk/src/assets/js/sidebarmenu.js"></script>
    <script src="/ukk/src/assets/js/app.min.js"></script>
    <script src="/ukk/src/assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>