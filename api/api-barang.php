<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_pwa";
// $username = "u694229934_masdi";
// $password = "Masdi321#";
// $dbname = "u694229934_masdi";



$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => $conn->connect_error]));
}


$method = $_SERVER['REQUEST_METHOD'];

function handleFileUpload($file)
{
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($file["name"]);
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $target_file;

        // return $file['name'];
    }
    return null;
}



function handleSendNotif()
{

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_pwa";
    // $username = "u694229934_masdi";
    // $password = "Masdi321#";
    // $dbname = "u694229934_masdi";



    $conn = new mysqli($servername, $username, $password, $dbname);

    $sql = "SELECT * FROM notifikasi";
    $result = $conn->query($sql);
    $tokens = [];
    while ($row = $result->fetch_assoc()) {
        $tokens[] = $row;
    }

    $serverKey = 'AAAAiyFEpYA:APA91bGf75IoZA9zfmixAziXF6tKl2jfspN3l_d6HZ4GMGSGR0Wb9tm09dUuxTiRJqV2J5hM-VnaUBCnBp3fblSHrdlxic_03XQESrrJlDAoRkKJ9DuvGnA9UYc29Y7n4ujtvwOVPHCO';


    $notification = [
        'title' => 'New Item Added',
        'body' => 'A new item has been added to the inventory.'
    ];

    $data = [
        'registration_ids' => $tokens,
        'notification' => $notification,
    ];

    $headers = [
        'Authorization: key=' . $serverKey,
        'Content-Type: application/json',
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    $err = curl_error($ch);

    curl_close($ch);



    if ($err) {
        return $err;
    } else {
        return $response;
    }
}


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

        $nama = $_POST['nama_barang'];
        $harga = $_POST['harga_barang'];

        $foto = handleFileUpload($_FILES['foto']);

        $sql = "INSERT INTO barang (nama_barang, harga, foto) VALUES ('$nama', '$harga','$foto')";
        if ($conn->query($sql) === TRUE) {
            handleSendNotif();
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

// function sendNotif()
// {

//     $stmt = $conn->query("SELECT token FROM notifikasi");
//     $stmt->execute();

//     $sql = "SELECT * FROM barang";
//     $result = $conn->query($sql);
//     $data = [];
//     while ($row = $result->fetch_assoc()) {
//         $data[] = $row;
//     }

//     $tokens = [];
//     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//         $tokens[] = $row['token'];
//     }

//     $url = 'https://fcm.googleapis.com/fcm/send';
//     $serverKey = 'AAAAiyFEpYA:APA91bGf75IoZA9zfmixAziXF6tKl2jfspN3l_d6HZ4GMGSGR0Wb9tm09dUuxTiRJqV2J5hM-VnaUBCnBp3fblSHrdlxic_03XQESrrJlDAoRkKJ9DuvGnA9UYc29Y7n4ujtvwOVPHCO';

//     $notification = [
//         'title' => 'BARANG BARU',
//         'body' => 'ADa Barang Baru ! buruan cek',
//         'sound' => 'default',
//     ];

//     $extraNotificationData = ["message" => $notification, "moredata" => 'dd'];

//     $fcmNotification = [
//         'registration_ids' => $tokens, // array of tokens
//         'notification' => $notification,
//         'data' => $extraNotificationData,
//     ];

//     $headers = [
//         'Authorization: key=' . $serverKey,
//         'Content-Type: application/json',
//     ];

//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
//     $result = curl_exec($ch);
//     curl_close($ch);

//     return $result;
// }

$conn->close();
