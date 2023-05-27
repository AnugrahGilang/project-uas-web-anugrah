<!DOCTYPE html>
<html>
<head>
    <title>Form Pendaftaran Anggota</title>
    <style>
        body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
            }

            .navbar {
            background-color: #000;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .container {
            margin-top: 50px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        form {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .form-control:focus {
            outline: none;
            border-color: #007bff;
        }

        textarea.form-control {
            resize: vertical;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            margin-top: 10px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        .my-3 {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        center {
            text-align: center;
        }
    </style>
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

        if (isset($_GET['idPeserta'])) {
            $idPeserta = input($_GET["idPeserta"]);

            $query = "SELECT * FROM peserta WHERE idPeserta=$idPeserta";
            $hasil = mysqli_query($koneksi, $query);
            $data = mysqli_fetch_assoc($hasil);
        }

        // cek apakah ada kiriman form dari method post
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $nama = htmlspecialchars($_POST["nama"]);
            $sekolah = input($_POST["sekolah"]);
            $jurusan = input($_POST["jurusan"]);
            $noHp = input($_POST["noHp"]);
            $alamat = input($_POST["alamat"]);

            // Query update data
            $query = "UPDATE peserta SET nama='$nama', sekolah='$sekolah', jurusan='$jurusan',
                        noHp='$noHp', alamat='$alamat' WHERE idPeserta = '$idPeserta'";

            // Mengeksekusi Query diatas
            $hasil = mysqli_query($koneksi, $query);

            // Kondisi apakah berhasil atau tidak
            if ($hasil) {
                header("Location: index.php");
                exit;
            } else {
                echo "<div class='alert alert-danger'> Data anda gagal diupdate.</div>";
            }
        }
        ?>

        <h2>Update Data</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="form-group">
                <label>Nama:</label>
                <input type="text" name="nama" class="form-control" required />
            </div>
            <div class="form-group">
                <label>Sekolah:</label>
                <input type="text" name="sekolah" class="form-control" required />
            </div>
            <div class="form-group">
                <label>Jurusan:</label>
                <input type="text" name="jurusan" class="form-control" required />
            </div>
            <div class="form-group">
                <label>No Hp:</label>
                <input type="text" name="noHp" class="form-control" placeholder="081222333444" required />
            </div>
            <div class="form-group">
                <label>Alamat:</label>
                <textarea name="alamat" class="form-control" rows="5" required></textarea>
            </div>

            <input type="hidden" name="idPeserta" value="<?php echo $data['idPeserta']; ?>" />

            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>  
</body>
</html>
