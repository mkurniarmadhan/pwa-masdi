<?php


require_once './koneksi.php';
$serverKey = 'AAAAiyFEpYA:APA91bGf75IoZA9zfmixAziXF6tKl2jfspN3l_d6HZ4GMGSGR0Wb9tm09dUuxTiRJqV2J5hM-VnaUBCnBp3fblSHrdlxic_03XQESrrJlDAoRkKJ9DuvGnA9UYc29Y7n4ujtvwOVPHCO';



$token = $_GET['token'];



$db = new KoneksiDatabase();
$koneksi = $db->getKoneksi();
$stmt = $koneksi->prepare("SELECT token FROM notifikasi WHERE token = :token");
$stmt->bindParam(':token', $token, PDO::PARAM_STR);

$stmt->execute();

$tokens = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $tokens[] = $row['token'];
}





$header = [
    'Authorization: Key=' . $serverKey,
    'Content-Type: Application/json'
];


$msg = [
    'registration_ids' => $tokens,
    'notification' => [
        'title' => 'PESANAN SIAP x',
        'body' => 'pesanan baru di tambahkan !',
        'icon' => '/assets/icons/android/android-launchericon-48-48.png'
    ]
];


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($msg));
$result = curl_exec($ch);
curl_close($ch);


echo $result;
