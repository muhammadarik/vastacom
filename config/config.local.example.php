<?php
// Salin file ini menjadi config.local.php lalu sesuaikan dengan device masing-masing.
// config.local.php tidak di-commit, jadi setiap device bisa punya setting sendiri.

// Koneksi database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "vastacom_db_v1";

// (Opsional) Paksa path URL project jika deteksi otomatis tidak sesuai.
// Contoh: "/vastacom", "/fp-pemrograman-web", atau "" jika memakai virtual host (vastacom.test)
// $base_path = "/vastacom";
