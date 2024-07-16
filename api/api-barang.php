<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Content-Type: application/json');


require_once './BarangController.php';

// Buat objek dari BarangController
$barangController = new BarangController();

$data = json_decode(file_get_contents("php://input"), true);



// Mendapatkan semua data user
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $response = $barangController->semuaBarang();
    echo json_encode($response);
}


// Menambahkan barang baru
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama_barang = $_POST['nama_barang'];
    $harga_barang = $_POST['harga_barang'];

    // Menangani upload foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        $uploadFile = $uploadDir . basename($_FILES['foto']['name']);
        // Memindahkan file ke direktori tujuan
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadFile)) {

            $foto = $_FILES['foto']['name'];
            $response = $barangController->tambahBarang($nama_barang, $harga_barang, $foto);

            if ($response) {
                echo json_encode(['status' => 'success', 'msg' => 'Barang disimpan']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Terjadi kesalahan saat menyimpan data ke database.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'msg'  => 'Terjadi kesalahan saat mengupload foto']);
        }
    } else {
        echo json_encode(['status' => 'error', 'msg'  => 'No uypdaload file ']);
    }
}


// Mengupdate data barang
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {


    $id = $data['id'];
    $nama_barang = $data['nama_barang'];
    $harga = $data['harga'];
    $stok = $data['stok'];

    $response = $barangController->ubahBarang($id, $nama_barang, $harga, $stok);
    echo json_encode(array("success" => $response));
}



// Menghapus user
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $data['id'];

    $response = $barangController->hapusBarang($id);
    echo json_encode(array("success" => $response));
}
