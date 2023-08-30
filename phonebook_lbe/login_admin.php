<?php
require('koneksi.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Ganti dengan koneksi database yang sesuai
    // $server = "localhost";
    // $username = "root";
    // $password = "";
    // $database = "phonebook";

    // $conn = new mysqli($server, $username, $password, $database);

    // if ($conn->connect_error) {
    //     die("Koneksi gagal: " . $conn->connect_error);
    // }

    $query = "SELECT * FROM admin_login WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);
    session_start();

    if (isset($_POST['username']) && isset($_POST['password'])) {
        // ... (kode validasi login)
        if ($result->num_rows > 0) {
            $isAdmin = true; // Set variabel $isAdmin menjadi true setelah login berhasil
            $_SESSION["admin"] = true;
            header("Location: index.php");
            exit();
        }
    }
    
}
 else {
    $loginError = "Username atau password salah.";
}
    exit();
    $conn->close();
?>