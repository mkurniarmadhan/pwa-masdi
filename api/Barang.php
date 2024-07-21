<?php
class Barang
{
    private $koneksi;

    public function __construct($koneksi)
    {
        $this->koneksi = $koneksi->getKoneksi();
    }

    // Method untuk menambah barang baru
    public function tambahBarang($nama_barang, $harga, $foto)
    {

        $stmt = $this->koneksi->prepare("INSERT INTO barang (nama_barang, harga, foto) VALUES (:nama_barang, :harga, :foto)");
        $stmt->bindParam(':nama_barang', $nama_barang, PDO::PARAM_STR);
        $stmt->bindParam(':harga', $harga, PDO::PARAM_INT);
        $stmt->bindParam(':foto', $foto, PDO::PARAM_STR);
        $r = $stmt->execute();

        if ($r) {
            $this->sendNotif();
            return true;
        } else {
            return false;
        }
        $this->koneksi = null;
        exit();
    }

    // Method untuk mengambil semua barang
    public function semuaBarang()
    {
        $stmt = $this->koneksi->query("SELECT * FROM barang");
        $barang = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $barang;
        $this->koneksi = null; // Close connection after successful operation
        exit(); // Exit script after response
    }

    // Method untuk mengambil semua barang
    public function hapusBarang($id)
    {

        return json_encode('oke');
        $stmt = $this->koneksi->prepare("DELETE FROM barang WHERE id =:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return 'oke';
        // Close connection after successful operation
        exit(); // Exit script after response
    }


    public function sendNotif()
    {

        $stmt = $this->koneksi->prepare("SELECT token FROM notifikasi");
        $stmt->execute();

        $tokens = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tokens[] = $row['token'];
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = 'AAAAiyFEpYA:APA91bGf75IoZA9zfmixAziXF6tKl2jfspN3l_d6HZ4GMGSGR0Wb9tm09dUuxTiRJqV2J5hM-VnaUBCnBp3fblSHrdlxic_03XQESrrJlDAoRkKJ9DuvGnA9UYc29Y7n4ujtvwOVPHCO';

        $notification = [
            'title' => 'BARANG BARU',
            'body' => 'ADa Barang Baru ! buruan cek',
            'sound' => 'default',
        ];

        $extraNotificationData = ["message" => $notification, "moredata" => 'dd'];

        $fcmNotification = [
            'registration_ids' => $tokens, // array of tokens
            'notification' => $notification,
            'data' => $extraNotificationData,
        ];

        $headers = [
            'Authorization: key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
