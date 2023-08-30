<?php
$Server = "localhost";
$Username = "root";
$Password = "";
$Database = "phonebook";

$conn = new mysqli($Server, $Username, $Password, $Database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['addSubmit'])) {
    $newName = $_POST['newName'];
    $newDepartemen = $_POST['newDepartemen'];
    $newTelepon = $_POST['newTelepon'];

    $sql = "INSERT INTO data_karyawan (Nama, Departemen, Telepon) VALUES ('$newName', '$newDepartemen', '$newTelepon')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil ditambahkan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
header("Location: index.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
</body>
</html>
