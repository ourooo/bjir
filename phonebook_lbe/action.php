<?php  
include 'koneksi.php';

$input = filter_input_array(INPUT_POST);
$Nama = $input["newName" . $input["ID"]];
$Departemen = $input["newDepartemen" . $input["ID"]];
$Telepon = $input["newTelepon" . $input["ID"]];
$id = $input["ID"];

if ($input["action"] === 'edit') {
    $query = "UPDATE data_karyawan SET Nama='$Nama', Departemen='$Departemen', Telepon='$Telepon' WHERE id=$id";
    $db1->query($query);
}

if ($input["action"] === 'delete') {
    $query = "DELETE FROM data_karyawan WHERE id=?";
    $edit = $db1->prepare($query);
    $edit->bind_param('i', $id);
    $edit->execute();
}

$response = array("message" => "Data updated successfully");
echo json_encode($response);

?>
