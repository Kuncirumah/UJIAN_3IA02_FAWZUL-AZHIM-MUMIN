<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "ujian_pweb";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Tidak bisa terknoneksi ke database");
}
$nim = "";
$nama = "";
$alamat = "";
$jurusan = "";
$fakultas = ""; 
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "delete from mahasiswa where id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    } else {
        $error = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "select * from mahasiswa where id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $nim = $r1['nim'];
    $nama = $r1['nama'];
    $alamat = $r1['alamat'];
    $jurusan = $r1['jurusan'];
    $fakultas = $r1['fakultas'];

    if ($nim == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jurusan = $_POST['jurusan'];
    $fakultas = $_POST['fakultas'];

    if ($nim && $nama && $alamat && $jurusan && $fakultas) {
        if ($op == 'edit') { //untuk update
            $sql1 = "update mahasiswa set nim = '$nim',nama = '$nama',alamat = '$alamat',jurusan = '$jurusan', fakultas = '$fakultas' where id = '$id'";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1 = "insert into mahasiswa(nim,nama,alamat,jurusan,fakultas) values ('$nim','$nama','$alamat','$jurusan','$fakultas')";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Berhasil memasukkan data baru";
            } else {
                $error = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa Ujian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                    <?php
                    header("refresh:5;url=index.php"); //5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                    ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                    <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat"
                                value="<?php echo $alamat ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jurusan" class="col-sm-2 col-form-label">Jurusan</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="jurusan" id="jurusan">
                                <option value="">- Pilih Jurusan -</option>
                                <option value="Teknologi" <?php if ($jurusan == "Teknologi")
                                    echo "selected" ?>>Teknologi
                                    </option>
                                    <option value="Non-Teknologi" <?php if ($jurusan == "Non-Teknologi")
                                    echo "selected" ?>>
                                        Non-Teknologi</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="fakultas" class="col-sm-2 col-form-label">Fakultas</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="fakultas" id="fakultas">
                                    <option value="">- Pilih Fakultas -</option>
                                    <option value="Saintek" <?php if ($fakultas == "Saintek")
                                    echo "selected" ?>>Saintek  
                                    </option>
                                    <option value="Soshum" <?php if ($fakultas == "Soshum")
                                    echo "selected" ?>>Soshum</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                        </div>
                    </form>
                </div>
            </div>

            <!-- untuk mengeluarkan data -->
            <div class="card">
                <div class="card-header text-white bg-secondary">
                    Data Mahasiswa
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">NIM</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Jurusan</th>
                                <th scope="col">Fakultas</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql2 = "select * from mahasiswa order by id desc";
                                $q2 = mysqli_query($koneksi, $sql2);
                                if (!$q2) {
                                    die("Query error: " . mysqli_error($koneksi));
                                }
                                $urut = 1;
                                while ($r2 = mysqli_fetch_array($q2)) {
                                    $id = $r2['id'];
                                    $nim = $r2['nim'];
                                    $nama = $r2['nama'];
                                    $alamat = $r2['alamat'];
                                    $jurusan = $r2['jurusan'];
                                    $fakultas = $r2['fakultas'];

                                    ?>
                            <tr>
                                <th scope="row">
                                    <?php echo $urut++ ?>
                                </th>
                                <td scope="row">
                                    <?php echo $nim ?>
                                </td>
                                <td scope="row">
                                    <?php echo $nama ?>
                                </td>
                                <td scope="row">
                                    <?php echo $alamat ?>
                                </td>
                                <td scope="row">
                                    <?php echo $jurusan ?>
                                </td>
                                <td scope="row">
                                    <?php echo $fakultas ?>
                                </td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button"
                                            class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id ?>"
                                        onclick="return confirm('Yakin mau delete data?')"><button type="button"
                                            class="btn btn-danger">Delete</button></a>
                                </td>
                            </tr>
                            <?php
                                }
                                ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</body>

</html>