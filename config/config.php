<?php
// Aktifkan session (jika belum)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Koneksi ke database
$host = "127.0.0.1";
$user = "root"; // Ganti sesuai hosting jika live
$pass = "root";     // Ganti sesuai hosting jika live
$db   = "vastacom_db"; // Ganti jika perlu
$port = 3307;

$conn = mysqli_connect($host, $user, $pass, $db, $port);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Path folder project di filesystem (misal: C:/laragon/www/vastacom)
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', str_replace('\\', '/', dirname(__DIR__)));
}

// Deteksi otomatis path URL project (misal: "/vastacom" atau "/fp-pemrograman-web"),
// sehingga nama folder hasil clone bebas. Bisa di-override lewat $base_path di config.local.php.
if (!isset($base_path)) {
    $base_path = '';
    $script_file = isset($_SERVER['SCRIPT_FILENAME']) ? str_replace('\\', '/', realpath($_SERVER['SCRIPT_FILENAME']) ?: $_SERVER['SCRIPT_FILENAME']) : '';
    $script_name = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '';
    $root_real   = str_replace('\\', '/', realpath(ROOT_PATH) ?: ROOT_PATH);

    if ($script_file !== '' && stripos($script_file, $root_real . '/') === 0) {
        // Bagian path script relatif terhadap root project, misal "/admin/index.php"
        $relative = substr($script_file, strlen($root_real));
        if (strcasecmp(substr($script_name, -strlen($relative)), $relative) === 0) {
            $base_path = substr($script_name, 0, -strlen($relative));
        }
    } elseif (!empty($_SERVER['DOCUMENT_ROOT'])) {
        $doc_root = rtrim(str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']) ?: $_SERVER['DOCUMENT_ROOT']), '/');
        if (stripos($root_real, $doc_root) === 0) {
            $base_path = substr($root_real, strlen($doc_root));
        }
    }
}
$base_path = rtrim($base_path, '/');

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$http_host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';

// BASE_PATH = path URL tanpa domain (misal "/vastacom"), BASE_URL = URL lengkap.
// Keduanya TANPA garis miring di akhir, jadi pakai: BASE_URL . '/assets/...'
if (!defined('BASE_PATH')) {
    define('BASE_PATH', $base_path);
}
if (!defined('BASE_URL')) {
    define('BASE_URL', $protocol . "://" . $http_host . $base_path);
}

// URL untuk user dan admin (DENGAN garis miring di akhir)
$base_url_user  = BASE_URL . "/";
$base_url_admin = BASE_URL . "/admin/";

// Fungsi untuk menampilkan pesan flash (di config.php agar bisa diakses oleh semua halaman)
// Pesan ini akan muncul sebagai alert JavaScript sebelum halaman dimuat.
if (isset($_SESSION['message'])) {
    $js_message = addslashes($_SESSION['message']); // Escape untuk JavaScript
    echo "<script>alert('{$js_message}');</script>";
    unset($_SESSION['message']); // Hapus pesan setelah ditampilkan
}
?>
