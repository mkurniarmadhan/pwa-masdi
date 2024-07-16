<?php

$serverKey = 'AAAAiyFEpYA:APA91bGf75IoZA9zfmixAziXF6tKl2jfspN3l_d6HZ4GMGSGR0Wb9tm09dUuxTiRJqV2J5hM-VnaUBCnBp3fblSHrdlxic_03XQESrrJlDAoRkKJ9DuvGnA9UYc29Y7n4ujtvwOVPHCO';


// cGr7SKe3IphINSgjLbswgV:APA91bG77ErFouLLDoiJLe8IgQLMbVqUoO8SABVdK9o_UXvYwGtrYShYDUwi9hHmOkz3jraYC6eKL6oL01IBTw2ZNIDmyqkbu-UECZodmzYtMFFjGODJnlWJ_5Qdt710HreXHocA6KGK
$token = $_GET['token'];

$header = [
    'Authorization: Key=' . $serverKey,
    'Content-Type: Application/json'
];


$msg = [
    'to' => $token,
    'notification' => [
        'title' => 'ADA BARANG BARU',
        'body' => 'barang baru di tambahkan !',
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
