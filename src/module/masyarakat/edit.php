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

// Edit
if (isset($_POST['edit'])) {
    $nik = htmlspecialchars($_POST['nik']);
    $nama = htmlspecialchars($_POST['nama']);
    $username = htmlspecialchars($_POST['username']);
    $telp = htmlspecialchars($_POST['telp']);

    $query = mysqli_query($conn, "UPDATE masyarakat SET nama = '$nama', username = '$username', telp = '$telp' WHERE nik = '$nik'");

    if ($query) {
        echo "<script>
                alert('Data berhasil diubah!');
                document.location='?module=datamasyarakat';
            </script>";
    } else {
        echo "<script>
                alert('Data gagal diubah!');
                document.location='?module=datamasyarakat';
            </script>";
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
        <?php while ($result = mysqli_fetch_array($row)) : ?>
            <div class="card user-card-full">
                <form action="" method="POST">
                    <div class="row m-l-0 m-r-0">
                        <div class="col-sm-4 bg-c-lite-green user-profile">
                            <div class="card-block text-center text-white">
                                <div class="m-b-25">
                                    <a class="overlay" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        <img src="src/account/img/<?= $result['foto_masyarakat'] ?>" class="img-radius" width="200" height="200" alt="User-Profile-Image">

                                    </a>
                                </div>
                                <h6 class="f-w-600"><?= $result['nama'] ?></h6>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="card-block">
                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 text-center">Edit Form</h6>
                                <div class="row c-font">
                                    <input type="hidden" name="id_masyarakat" value="<?= $result['id_masyarakat'] ?>">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Nomor Induk Kependudukan</p>
                                        <!-- <label class="form-label">Nomor Induk Kependudukan</label> -->
                                        <input type="number" class="form-control" name="nik" id="nik" value="<?= $result['nik'] ?>" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Nama</p>
                                        <!-- <label class="form-label">Nama</label> -->
                                        <input type="text" class="form-control" name="nama" id="nama" value="<?= $result['nama'] ?>" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Username</p>
                                        <!-- <label class="form-label">Username</label> -->
                                        <input type="text" class="form-control" name="username" id="username" value="<?= $result['username'] ?>" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Password</p>
                                        <!-- <label class="form-label">Password</label> -->
                                        <input type="password" class="form-control" name="password" id="password" value="<?= $result['password'] ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <p class="m-b-10 f-w-600">Telepon</p>
                                        <!-- <label class="form-label">Telepon</label> -->
                                        <input type="number" class="form-control" name="telp" id="telp" value="<?= $result['telp'] ?>" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col d-flex justify-content-end">
                                        <a type="button" class="btn btn-secondary mx-1" href="?module=datamasyarakat">Cancel</a>
                                        <button type="submit" class="btn btn-primary mx-1" name="edit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="">
                    <input type="hidden" name="nik" value="<?= $result['nik'] ?>">
                    <input type="hidden" name="foto" value="<?= $result['foto_masyarakat'] ?>">
                    <div class="modal-body text-center">
                        <p>Apakah anda yakin ingin menghapus data ini? <br>
                            <span class="fw-bold text-danger"><?= $result['nama'] ?></span>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="delete">Delete</button>
                    </div>
                </form>
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