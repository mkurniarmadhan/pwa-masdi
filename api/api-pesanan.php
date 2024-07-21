<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Content-Type: application/json');

require_once './PesananController.php';

// Buat objek dari pesananController
$pesananController = new PesananController();



// Mendapatkan semua data user
if ($_SERVER['REQUEST_METHOD'] === 'GET') {


    $user_id = $_GET['user_id'] ?? 1;
    $response = $pesananController->semuaPesanan($user_id);
    echo json_encode($response);
}

// Menambahkan barang baru
if ($_SERVER['REQUEST_METHOD'] === 'POST') {



    $nama_pemesan = $_POST['nama_pemesan'];
    $phone = $_POST['phone'];
    $alamat = $_POST['alamat'];
    $barang_id = $_POST['barang_id'];
    $user_id = $_POST['user_id'];
    $total = $_POST['total_bayar'];


    $response = $pesananController->tambahPesanan($nama_pemesan, $phone, $alamat, $barang_id, $user_id, $total);

    if ($response) {
        echo json_encode(['status' => 'success', 'msg' => $response]);
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Terjadi kesalahan saat menyimpan data ke database.']);
    }
}
