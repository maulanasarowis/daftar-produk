<?php
//koneksi
$server = "localhost";
$user = "root";
$pass = "";
$database = "arkademy";

$koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));

//tombol simpan
if (isset($_POST['bsimpan'])) {

    //data di edit atau disimpan
    if ($_GET['hal'] == "edit") {

        $edit = mysqli_query($koneksi, "UPDATE produk set nama_produk = '$_POST[tproduk]', keterangan = '$_POST[tketerangan]', harga = '$_POST[tharga]',jumlah = '$_POST[tjumlah]' WHERE id_produk = '$_GET[id]' ");


        if ($edit) {
            echo "<script>alert('Edit data sukses!'); document.location='index.php'; </script>";
        } else {
            echo "<script>alert('Edit data gagal!'); document.location='index.php'; </script>";
        }
    } else {

        $simpan = mysqli_query($koneksi, "INSERT INTO produk (nama_produk, keterangan, harga, jumlah) VALUES ('$_POST[tproduk]','$_POST[tketerangan]','$_POST[tharga]','$_POST[tjumlah]')");

        if ($simpan) {
            echo "<script>alert('Simpan data sukses!');document.location='index.php'; </script>";
        } else {
            echo "<script>alert('Simpan data gagal!'); document.location='index.php'; </script>";
        }
    }
}


if (isset($_GET['hal'])) {
    if ($_GET['hal'] == "edit") {
        $tampil = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = '$_GET[id]'");
        $data = mysqli_fetch_array($tampil);
        if ($data) {
            $vproduk = $data['nama_produk'];
            $vketerangan = $data['keterangan'];
            $vharga = $data['harga'];
            $vjumlah = $data['jumlah'];
        }
    } elseif ($_GET['hal'] == "hapus") {
        $hapus = mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk = '$_GET[id]'");
        if ($hapus) {
            echo "<script>alert('Hapus data sukses!'); document.location='index.php'; </script>";
        }
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Arkademy</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center">DAFTAR PRODUK</h1>


        <div class="card mt-3">
            <div class="card-header bg-primary text-white">
                Input data produk
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" name="tproduk" value="<?= @$vproduk ?>" class="form-control" placeholder="Input Nama Produk" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="form-control" name="tketerangan" placeholder="Keterangan" required><?= @$vketerangan ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" name="tharga" value="<?= @$vharga ?>" class="form-control" placeholder="Input Harga" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" name="tjumlah" value="<?= @$vjumlah ?>" class="form-control" placeholder="Input Jumlah" required>
                    </div>
                    <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
                    <button type="reset" class="btn btn-danger" name="breset" value="Reset">Kosongkan</button>
                </form>
            </div>
        </div>



        <div class="card mt-3">
            <div class="card-header bg-success text-white">
                Daftar Produk
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>No.</th>
                        <th>Nama Produk</th>
                        <th>Keterangan</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                    $no = 1;
                    $tampil = mysqli_query($koneksi, "SELECT * FROM produk order by id_produk desc");
                    while ($data = mysqli_fetch_array($tampil)) :

                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['nama_produk'] ?></td>
                            <td><?= $data['keterangan'] ?></td>
                            <td><?= $data['harga'] ?></td>
                            <td><?= $data['jumlah'] ?></td>
                            <td>
                                <a href="index.php?hal=edit&id=<?= $data['id_produk'] ?>" class="btn btn-warning">Edit</a>
                                <a href="index.php?hal=hapus&id=<?= $data['id_produk'] ?>" onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; //penutup perulangan while 
                    ?>
                </table>
            </div>
        </div>


    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>