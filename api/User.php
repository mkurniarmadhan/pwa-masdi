<?php

class User
{
    private $koneksi;
    public $role = 'user'; // Default role


    public function __construct($koneksi)
    {
        $this->koneksi = $koneksi->getKoneksi();
    }

    // Registrasi pengguna baru
    function daftar($nama, $alamat, $email, $password)
    {

        if ($this->cekUser($email)) {
            return "Email or username sudah ada.";
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->koneksi->prepare("INSERT INTO users (nama, alamat, email, password,role) VALUES (?, ?, ?, ?,?)");
        $stmt->execute([$nama, $alamat, $email, $hashedPassword, $this->role]);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    protected function cekUser($email)
    {
        $stmt = $this->koneksi->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }


    // Memeriksa login pengguna
    function login($email, $password)
    {
        $stmt = $this->koneksi->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        return $stmt;
    }
}
