<?php
class Pesanan
{
    private $koneksi;

    public function __construct($koneksi)
    {
        $this->koneksi = $koneksi->getKoneksi();
    }


    // tambah pesanan
    public function tambahPesanan($nama_pemesan, $phone, $alamat, $barang_id, $user_id, $total)
    {
        $stmt = $this->koneksi->prepare("INSERT INTO pesanan (nama_pemesan, phone, alamat, barang_id, user_id, total) VALUES (:nama_pemesan, :phone, :alamat, :barang_id, :user_id, :total)");
        $stmt->bindParam(':nama_pemesan', $nama_pemesan, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':alamat', $alamat, PDO::PARAM_STR);
        $stmt->bindParam(':barang_id', $barang_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':total', $total, PDO::PARAM_STR);


        if ($stmt->execute()) {
            $stmt = $this->koneksi->query("SELECT LAST_INSERT_ID()");
            $lastId = $stmt->fetchColumn();
            return $lastId;
        } else {
            return false;
        }
        $this->koneksi = null;
        exit();
    }

    // Method untuk mengambil semua pesanan
    public function semuaPesanan($user_id)
    {


        $stmt = $this->koneksi->query("SELECT * FROM pesanan where user_id = $user_id ");
        $barang = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $barang;
        $this->koneksi = null; // Close connection after successful operation
        exit(); // Exit script after response
    }

    private function sendNotif($tokens)
    {

        $serverKey = 'AAAAiyFEpYA:APA91bGf75IoZA9zfmixAziXF6tKl2jfspN3l_d6HZ4GMGSGR0Wb9tm09dUuxTiRJqV2J5hM-VnaUBCnBp3fblSHrdlxic_03XQESrrJlDAoRkKJ9DuvGnA9UYc29Y7n4ujtvwOVPHCO';


        $header = [
            'Authorization: Key=' . $serverKey,
            'Content-Type: Application/json'
        ];

        $msg = [
            'registration_ids' => 'eUujRltCXWXSo-aCQjH-gq:APA91bGjM-HhVMHIKI_REgji_sx1ei9-qQZ65blUBSFh3BeubIGbL8W_n1zqvf6GLcMU8CeEVhV_QkQ97ufNlCRApiJWSc2psiWgTeKsL-P9MWZLeBNii7fES_K0jmaWCtOGw152el9Q', // Mengirim ke beberapa token
            'notification' => [
                'title' => 'PESANN SIAP',
                'body' => 'PEsanan kamu behasik di terma !',
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
    }
}
