<?php


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once './UserController.php';



$userController = new UserController();
$type = $_POST['type'];
$nama = $_POST['nama'] ?? '';
$alamat = $_POST['alamat'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';


switch ($type) {
    case 'login':
        session_start();
        $result = $userController->login($email, $password);
        if ($result->rowCount() > 0) {
            $user = $result->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {
                echo json_encode(['status' => 'success', 'message' => 'Login successful', 'role' => $user['role'], 'user_id' => $user['id']]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User not found']);
        }
        break;
    case 'daftar':
        $response = $userController->daftar($nama, $alamat, $email, $password);
        echo json_encode(array("status" => $response));
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
