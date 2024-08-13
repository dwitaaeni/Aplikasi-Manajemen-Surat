<?php
session_start();

// Connect to the database
include 'HOME/koneksi.php';

// Konfigurasi kunci rahasia Anda
$secretKey = '6LdYKiUqAAAAADj6CEGXFp9mtx72i_doxKH9wrUI';

// Mendapatkan nilai token reCAPTCHA dari permintaan POST
$recaptchaResponse = $_POST['g-recaptcha-response'];

// Memeriksa apakah token reCAPTCHA ada
if (!$recaptchaResponse) {
    // Jika tidak ada token reCAPTCHA, arahkan kembali ke halaman login dengan pesan kesalahan
    header("Location: index.php?error=recaptcha");
    exit();
}

// Membuat permintaan POST ke Google reCAPTCHA untuk memverifikasi token
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$recaptchaResponse");
$responseKeys = json_decode($response, true);

// Memeriksa apakah reCAPTCHA valid
if (intval($responseKeys['success']) !== 1) {
    // Jika verifikasi reCAPTCHA gagal, arahkan kembali ke halaman login dengan pesan kesalahan
    header("Location: index.php?error=recaptcha");
    exit();
}

// Get the submitted username and password
$username = $_POST['username'];
$password = md5($_POST['password']); // Hash the password using MD5 (not recommended for production)

// Check if the Pengguna
$query = "SELECT * FROM tb_pengguna WHERE username='$username' AND password='$password' LIMIT 1";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) == 1) {
    // Regular user login successful
    $data = mysqli_fetch_assoc($result);

    $_SESSION['pengguna_type'] = 'pengguna';
    $_SESSION['pengguna'] = $data['id_pg'];
    $_SESSION['nama'] = $data['nama_lengkap'];
    $_SESSION['jabatan'] = $data['jabatan'];
    $_SESSION['akses'] = $data['izin_akses'];

    if ($_SESSION['akses'] == 'Admin') {
        echo '<script language="javascript" type="text/javascript">
        alert("Anda Berhasil Masuk, Selamat Datang '.$_SESSION['nama'].'!");</script>';
        echo "<meta http-equiv='refresh' content='0; url=HOME/index.php'>";
        exit();
    } elseif ($_SESSION['akses'] == 'Pimpinan') {
        echo '<script language="javascript" type="text/javascript">
        alert("Anda Berhasil Masuk, Selamat Datang '.$_SESSION['nama'].'!");</script>';
        echo "<meta http-equiv='refresh' content='0; url=HOME/index.php'>";
        exit();
    } elseif ($_SESSION['akses'] == 'Sekretaris') {
        echo '<script language="javascript" type="text/javascript">
        alert("Anda Berhasil Masuk, Selamat Datang '.$_SESSION['nama'].'!");</script>';
        echo "<meta http-equiv='refresh' content='0; url=HOME/index.php'>";
        exit();
    } elseif ($_SESSION['akses'] == 'Petugas') {
        echo '<script language="javascript" type="text/javascript">
        alert("Anda Berhasil Masuk, Selamat Datang '.$_SESSION['nama'].'!");</script>';
        echo "<meta http-equiv='refresh' content='0; url=HOME/index.php'>";
        exit();
    }
}

// If login failed, redirect back to the login page with an error message
header("Location: index.php?error=1");
exit();
?>
