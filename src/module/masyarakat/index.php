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

// Delete
if (isset($_POST['delete'])) {
    $foto = $_POST['foto'];
    $direktori = "src/account/img/";

    if ($foto == 'UserImage.png') {
        // Hapus entri dari database
        $query = mysqli_query($conn, "DELETE FROM masyarakat WHERE nik = '$_POST[nik]'");

        if ($query) {
            echo "<script>
                document.location='?module=datamasyarakat';
            </script>";
        }
    } else {
        // Hapus file dari direktori
        if (file_exists($direktori . $foto)) {
            if (unlink($direktori . $foto)) {
                echo "File berhasil dihapus.";
            } else {
                echo "Gagal menghapus file.";
            }
        } else {
            echo "File tidak ditemukan.";
        }

        // Hapus entri dari database
        $query = mysqli_query($conn, "DELETE FROM masyarakat WHERE nik = '$_POST[nik]'");

        if ($query) {
            echo "<script>
                document.location='?module=datamasyarakat';
            </script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="src/assets/datatables/datatables.css">
    <script src="src/assets/datatables/datatables.js"></script>
    <title>Petugas</title>
</head>

<script>
    $(document).ready(function() {
        $('#table').dataTable({
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": true
        });
    });
</script>

<body>
    <div class="card">
        <div class="card-header fw-bold text-center">
            Masyarakat
        </div>
        <div class="card-body">
            <table id="table" class="table border table-hover">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">NIK</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Username</th>
                        <th scope="col">Password</th>
                        <th scope="col">Telp</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php while ($result = mysqli_fetch_array($row)) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $result["nik"] ?></td>
                            <td><?= $result["nama"] ?></td>
                            <td><?= $result["username"] ?></td>
                            <td><?= $result["password"] ?></td>
                            <td><?= $result["telp"] ?></td>
                            <td>
                                <div class='text-center'>
                                    <a href="?module=edit-datamasyarakat&id_masyarakat=<?= $result["id_masyarakat"] ?>" class="btn btn-warning btn-sm"><i class="material-icons">&#xE254;</i></a> 
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $no ?>" class="btn btn-danger btn-sm"><i class="material-icons">&#xE872;</i></a>
                                </div>
                            </td>
                        </tr>
                        

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal<?= $no ?>" tabindex="-1">
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
                        <!-- Delete Modal -->

                    <?php endwhile; ?>
                </tbody>
            </table>
            <a class='btn btn-success px-4' href="?module=add-datamasyarakat"><i class="fa-solid fa-plus"></i></a>
        </div>
    </div>
</body>

</html>