<?php


require_once './koneksi.php';



header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');



$type = $_POST['type'];
$token = $_POST['token'] ?? '';


$response = ['status' => '', 'message' => ''];

switch ($type) {
    case 'token':
        $db = new KoneksiDatabase();
        $koneksi = $db->getKoneksi();


        $query = "INSERT INTO notifikasi (token) VALUES (:token)
          ON DUPLICATE KEY UPDATE token = :token2
        ";
        $stmt = $koneksi->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':token2', $token);


        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Data saved successfully';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to save data';
        }

        echo json_encode($response);


        break;
    case 'daftar':
        $response = $userController->daftar($nama, $alamat, $email, $password);
        echo json_encode(array("status" => $response));
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
