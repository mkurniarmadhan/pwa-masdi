<?php
require_once './koneksi.php';
require_once './User.php';

class UserController
{
    private $user;

    public function __construct()
    {
        $koneksi = new KoneksiDatabase();
        $this->user = new User($koneksi);
    }


    public function login($email, $password)
    {
        return $this->user->login($email, $password);
    }

    public function daftar($nama, $alamat, $email, $password)
    {

        return $this->user->daftar($nama, $alamat, $email, $password);
    }
}
