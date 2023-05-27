<?php
session_start();

// Cek apakah pengguna sudah login, jika ya redirect ke halaman selanjutnya
if (isset($_SESSION['username'])) {
    header("Location: halaman_selanjutnya.php");
    exit;
}

// Include koneksi.php
include 'koneksi.php';

// Cek apakah ada kiriman form dari method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hash password menggunakan bcrypt
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk menyimpan data pengguna baru
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // Redirect ke halaman login setelah berhasil mendaftar
        header("Location: login.php?registered=true");
        exit;
    } else {
        $error = "Gagal membuat akun. Silakan coba lagi.";
    }
     // Debugging: Check the MySQL error
     $mysqlError = mysqli_error($koneksi);
     echo "MySQL Error: " . $mysqlError;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="CSS/register.css">
</head>
<body>
    <div class="container">
    <h2></h2>
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } ?>
    <?php if (isset($_GET['registered']) && $_GET['registered'] == 'true') { ?>
        <div class="alert alert-success">Akun berhasil didaftarkan. Silakan login.</div>
    <?php } ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <input type="text" name="username" placeholder="Username" required />
        </div>
        <div class="form-group">
            <input type="password" name="password" placeholder="Password" required />
        </div>
        <button type="submit" name="submit">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="login.php">Login disini</a></p>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </div>
</body>
</html>
