<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_pwa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => $conn->connect_error]));
}

$method = $_SERVER['REQUEST_METHOD'];


switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $sql = "SELECT * FROM barang WHERE id = $id";
            $result = $conn->query($sql);
            echo json_encode($result->fetch_assoc());
        } else {
            $sql = "SELECT * FROM barang";
            $result = $conn->query($sql);
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode($data);
        }
        break;
    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);



        $token = $_POST['token'];

        $sql = "INSERT INTO notifikasi (token) VALUES ('$token')";

        if ($conn->query($sql) === TRUE) {
            // sendNotif();
            echo json_encode(["id" => $conn->insert_id]);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
        break;
    case 'PUT':
        $input = json_decode(file_get_contents('php://input'), true);
        $id = intval($input['id']);
        $nama = $input['nama_barang'];
        $harga = $input['harga_barang'];

        $sql = "UPDATE barang SET nama = '$nama', harga = '$harga' WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "Record updated successfully"]);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
        break;
    case 'DELETE':
        $id = intval($_GET['id']);
        $sql = "DELETE FROM barang WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "Record deleted successfully"]);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
        break;
}

$conn->close();
