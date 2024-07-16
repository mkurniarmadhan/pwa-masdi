<?php
class KoneksiDatabase
{
    private $host = 'localhost';  // Sesuaikan dengan host database Anda
    private $username = 'root';   // Sesuaikan dengan username database Anda
    private $password = '';       // Sesuaikan dengan password database Anda
    private $database = 'db_pwa'; // Sesuaikan dengan nama database Anda
    protected $koneksi;

    // Konstruktor untuk koneksi database
    public function __construct()
    {
        $this->koneksi = null;

        try {
            $this->koneksi = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->database, $this->username, $this->password);
            $this->koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
    }

    // Method untuk mendapatkan objek koneksi
    public function getKoneksi()
    {

        return $this->koneksi;
    }

    // Metode untuk menutup koneksi database
    public function tutupKoneksi()
    {
    }
}
