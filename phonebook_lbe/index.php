<?php
session_start();
$isAdmin = isset($_SESSION["admin"]) && $_SESSION["admin"] === true;

$hideActions = $isAdmin ? '' : 'style="display: none;"';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHONEBOOK LBE</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>


<body>
<div class="content">
    <nav class="navbar navbar-expand-lg bg-body-tertiary ">
        <div class="container-fluid">
        <div class="d-flex align-items-center">
                <img src="logolbe.png" alt="Bootstrap"width="50" height="50">
                <a class="navbar-brand ms-3" href="index.php">PT Lestari Banten Energi</a>
        </div>
        </div>
    </nav>

    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">Login Admin</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="login_admin.php" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <script>
    $(document).ready(function () {
        // Mendengarkan event saat tombol keyboard ditekan
        $(document).keydown(function (event) {
            // Memeriksa apakah Ctrl dan F12 ditekan secara bersamaan
            if (event.ctrlKey && event.keyCode === 123) {
                // Menampilkan modal login ketika kombinasi tombol ditekan
                $('#loginModal').modal('show');
            }
        });
    });
</script>
<script>
document.addEventListener('keydown', function(event) {
    if (event.ctrlKey && event.key === 'F11') {
        event.preventDefault(); // Mencegah browser memicu fungsi bawaan F11
        window.location.href = 'logout.php'; // Ganti dengan URL yang sesuai untuk logout
    }
});
</script>

    <div class="container mt-4">
        <div class="text-center">
            <h2>PHONEBOOK</h2>
        </div>
        <form action="" method="post" id="searchForm">
        <div class="row mb-4 justify-content-center">
    <div class="col-md-6">
        <div class="input-group">
            <input type="text" class="form-control" id="searchName" name="searchName" placeholder="Cari Nama, Departemen, atau Telepon">
            <button type="submit" class="btn btn-primary" name="searchSubmit" id="searchButton">Cari</button>
        </div>
    </div>
</div>

        </form>

        <?php
        $Server = "localhost";
        $Username = "root";
        $Password = "";
        $Database = "phonebook";
    
        $conn = new mysqli($Server, $Username, $Password, $Database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_POST['editSubmit'])) {
            $editName = $_POST['editName'];
            $newName = $_POST['newName'];
            $newDepartemen = $_POST['newDepartemen'];
            $newTelepon = $_POST['newTelepon'];
        }

        if (isset($_GET['delete'])) {
            $deleteName = $_GET['delete'];
            $sql = "DELETE FROM data_karyawan WHERE Nama='$deleteName'";
            $conn->query($sql);
        }

        $searchName = "";
        if (isset($_POST['searchSubmit'])) {
            $searchName = $_POST['searchName'];
        }

        $phonebookData = [];
        if (!empty($searchName)) {
            $sql = "SELECT * FROM data_karyawan WHERE Nama LIKE '%$searchName%' OR Departemen LIKE '%$searchName%' OR Telepon LIKE '%$searchName%'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $phonebookData[] = $row;
                }
            }
        }

        $conn->close();

        echo '<table id="myTable" class="table table-striped fs-5">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Departemen</th>
                <th>Telepon</th>
                <th ' . $hideActions . '>Aksi</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($phonebookData as $data) : ?>
    <tr>
        <td><?= $data['Nama'] ?></td>
        <td><?= $data['Departemen'] ?></td>
        <td><?= $data['Telepon'] ?></td>
        <td <?= $hideActions ?> class="aksi">
            <?php if ($isAdmin) : ?>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $data['ID'] ?>">Edit</button>
                <a href="?delete=<?= $data['Nama'] ?>" class="btn btn-danger ms-2">Hapus</a>
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach; ?>

    <?php foreach ($phonebookData as $data) : ?>
    <?php endforeach; ?>

    <!-- Modal for Adding Data -->
    <div class="content">
    <div class="mb-3 d-flex justify-content-end">
        <?php if ($isAdmin) : ?>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Data</button>
        <?php endif; ?>
    </div>
    <?php foreach ($phonebookData as $data) : ?>
    <?php endforeach; ?>
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Data Karyawan</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="tambah.php" method="post" id="addForm">
                        <div class="form-group">
                            <label for="newName">Nama:</label>
                            <input type="text" class="form-control" id="newName" name="newName" required>
                        </div>
                        <div class="form-group">
                            <label for="newDepartemen">Departemen:</label>
                            <input type="text" class="form-control" id="newDepartemen" name="newDepartemen" required>
                        </div>
                        <div class="form-group">
                            <label for="newTelepon">Telepon:</label>
                            <input type="text" class="form-control" id="newTelepon" name="newTelepon" required>
                        </div>
                        <button type="submit" class="btn btn-primary float-end" name="addSubmit">Tambah Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


        <?php echo '</tbody>
</table>';

foreach ($phonebookData as $data) {
    echo '<div class="modal fade" id="editModal' . $data['ID'] .'" tabindex="-1" role="dialog" aria-labelledby="editModalLabel' . $data['ID'] . '" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel' . $data['ID'] . '">Edit Data Karyawan</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" id="editForm' . $data['ID'] . '" enctype="multipart/form-data">
                            <input type="hidden" name="editName' . $data['ID'] . '" value="' . $data['Nama'] . '">
                            <div class="form-group">
                                <label for="newName' . $data['ID'] . '">Nama Baru:</label>
                                <input type="text" class="form-control" id="newName' . $data['ID'] . '" name="newName' . $data['ID'] . '" value="' . $data['Nama'] . '" required>
                            </div>
                            <div class="form-group">
                                <label for="newDepartemen' . $data['ID'] . '">Departemen Baru:</label>
                                <input type="text" class="form-control" id="newDepartemen' . $data['ID'] . '" name="newDepartemen' . $data['ID'] . '" value="' . $data['Departemen'] . '" required>
                            </div>
                            <div class="form-group">
                                <label for="newTelepon' . $data['ID'] . '">Telepon Baru:</label>
                                <input type="text" class="form-control" id="newTelepon' . $data['ID'] . '" name="newTelepon' . $data['ID'] . '" value="' . $data['Telepon'] . '" required>
                            </div>';
                            
    if ($isAdmin) {
        echo '<button type="submit" class="btn btn-primary float-end" name="editSubmit' . $data['ID'] . '" text="center">Simpan Perubahan</button>';
    }
    echo '</form>
        </div>
    </div>
</div>
</div>';
    echo '</form>
        </div>
    </div>
</div>
</div>';
}

?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>
    </div>
    <footer class="footer">
    <div class="container">
    <?php
    $clientIP = $_SERVER['REMOTE_ADDR'];
    echo "IP address: " . $clientIP;
    ?> 
    <br>
        <?php include 'jam.php'; ?>
        <p class="left-aligned">create by @denirasya.g</p>
    </div>
</footer>
</body>

</html>