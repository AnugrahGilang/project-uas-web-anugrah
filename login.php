<?php
session_start();

// Cek apakah pengguna sudah login, jika ya redirect ke halaman selanjutnya
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Include koneksi.php
include 'koneksi.php';

// Cek apakah ada kiriman form dari method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Query untuk mengambil data pengguna berdasarkan username
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);

    // Cek apakah pengguna ditemukan dan password cocok
    if ($row && password_verify($password, $row["password"])) {
        // Set session username dan redirect ke halaman selanjutnya
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="CSS/login.css">
</head>
<body>
    <div class="container">
    <h2>Login</h2>
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <ion-icon name="person-sharp"></ion-icon>
            <input type="text" name="username" required />
        </div>
        <div class="form-group">
            <ion-icon name="lock-closed"></ion-icon>
            <input type="password" name="password" required />
        </div>
        <button type="submit" name="submit">Masuk</button>
        <h4>---------------------------------------------------------------------------</h4>
    </form>
    <p>Belum punya akun? <a href="register.php">Buat Akun Baru</a></p>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
