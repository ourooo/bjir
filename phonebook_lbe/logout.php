<?php
session_start();
session_destroy();
header("Location: index.php"); // Ganti dengan halaman yang sesuai setelah logout
exit();
?>