<!DOCTYPE html>
<html>
    <head>
        <title>Form Pendaftaran Peserta</title>
        
    </head>
    <body>
        <div class="container">
            <?php
            include 'koneksi.php';

            session_start(); // Memulai sesi

            // Cek apakah pengguna sudah login, jika tidak arahkan ke halaman login.php
            if (!isset($_SESSION['username'])) {
                header("Location: login.php");
                exit;
            }

            function input($data){
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            //cek apakah ada kiriman form dari method post
            if ($_SERVER["REQUEST_METHOD"] == "POST"){

                $nama = input($_POST["nama"]);
                $sekolah = input($_POST["sekolah"]);
                $jurusan = input($_POST["jurusan"]);
                $noHp = input($_POST["noHp"]);
                $alamat = input($_POST["alamat"]);

                //Query input data kedalam tabel peserta
                $query = "INSERT INTO peserta (nama, sekolah, jurusan, noHp, alamat) VALUES ('$nama', '$sekolah', '$jurusan', '$noHp', '$alamat')";

                //Menjalankan query diatas
                $hasil = mysqli_query($koneksi, $query);

                //Cek apakah berhasil menjalankan query atau tidak
                if ($hasil) {
                    header("Location:index.php");
                } else {
                    echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";
                }
            }
            ?>
            <h2>Input Data</h2>

            <form action = "<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"> 
                <div clss="form-group">
                    <label>Nama:</label>
                    <input type="text" name="nama" class="form-control" required />
                </div>
                <div clss="form-group">
                    <label>Sekolah:</label>
                    <input type="text" name="sekolah" class="form-control"  required />
                </div>
                <div clss="form-group">
                    <label>Jurusan:</label>
                    <input type="text" name="jurusan" class="form-control" required />
                </div>
                <div clss="form-group">
                    <label>No Hp:</label>
                    <input type="text" name="noHp" class="form-control" placeholder="081222333444" required />
                </div>
                <div clss="form-group">
                    <label>Alamat:</label>
                    <textarea name="alamat" class="form-control" rows="5" required></textarea>
                </div>
                
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </body>
</html>