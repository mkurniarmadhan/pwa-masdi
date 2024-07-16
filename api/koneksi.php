<?php
class KoneksiDatabase
{

    private $host = 'localhost';  // Sesuaikan dengan host database Anda
    private $username = 'u694229934_masdi';   // Sesuaikan dengan username database Anda
    private $password = 'Masdi321#';       // Sesuaikan dengan password database Anda
    private $database = 'u694229934_masdi'; // Sesuaikan dengan nama database Anda
    protected $koneksi;

    // private $host = 'localhost';
    // private $username = 'root';
    // private $password = '';
    // private $database = 'db_pwa';
    // protected $koneksi;

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
