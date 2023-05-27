<?php
session_start(); // Memulai sesi

// Cek apakah pengguna sudah login, jika belum maka arahkan ke halaman login.php
if (!isset($_SESSION['username'])) {
    header("Location:login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>PROYEK UAS DESAIN DAN PEMROGRAMAN WEB</title>
        <link rel="stylesheet" href="CSS/index.css">
    </head>
    <body>
        <nav class="navbar navbar-dark bg-dark">
            <span class="navbar-brand mb-0 h1">Anugrah Gilang Ramadhan TI 2B 223307035</span>
        </nav>
        <br>
        <div class="welcome-message">
        Selamat datang, <?php echo $_SESSION['username']; ?>
        </div>
        <div class="container">

        <div class="logout-button">
            <form action="logout.php" method="post">
                <button type="submit">Logout</button>
            </form>
        </div>        

            <br>
            <h4><center>DAFTAR PESERTA PELATIHAN</center></h4>
            <?php
            include 'koneksi.php';

            // Cek apakah pengguna sudah login, jika tidak arahkan ke halaman login.php
            if (!isset($_SESSION['username'])) {
                header("Location: login.php");
                exit;
            }

            // cek apakah ada kiriman form dari method post
            if (isset($_GET['idPeserta'])) {
                $idPeserta = htmlspecialchars($_GET["idPeserta"]);
                $query = "DELETE FROM peserta WHERE idPeserta='$idPeserta'";
                $hasil = mysqli_query($koneksi, $query); // Fix typo here

                // cek apakah berhasil atau tidak
                if ($hasil) {
                    header("Location:index.php");
                } else {
                    echo "<div class='alert alert-danger'> Data gagal dihapus.</div>";
                }
            }
            ?>


            <tr class="table-danger">
                <br>
                <thead>
                    <tr>
                        <table class="my-3 table table-bordered">
                            <tr class="table-primary";>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Sekolah</th>
                                <th>Jurusan</th>
                                <th>No HP</th>
                                <th>Alamat</th>
                                <th cosplan="2">Aksi</th>
                    </tr>
                </thead>

                <?php
                    include 'koneksi.php';
                    $query = "select * from peserta order by idPeserta desc"; 

                    $hasil = mysqli_query($koneksi, $query);
                    $no = 0;
                    while ($data = mysqli_fetch_array($hasil)) {
                        $no++;

                        ?>
                        <tbody>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $data["nama"]; ?></td>
                                <td><?php echo $data["sekolah"]; ?></td>
                                <td><?php echo $data["jurusan"]; ?></td>
                                <td><?php echo $data["noHp"]; ?></td>
                                <td><?php echo $data["alamat"]; ?></td>
                                <td>
                                    <a href="update.php?idPeserta=<?php echo htmlspecialchars($data['idPeserta']); ?>">Edit</a>
                                    <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?idPeserta=<?php echo htmlspecialchars($data['idPeserta']); ?>">Hapus</a>
                                </td>
                            </tr>
                        </tbody>
                        <?php
                    }
                ?>
            </table>
            <a href="create.php" class="btn btn-primary" role="button"> Tambah Data</a>
            </div>
    </body>
</html>