<?php
require_once './koneksi.php';
require_once './Pesanan.php';

class PesananController
{
    private $pesanan;

    public function __construct()
    {
        $koneksi = new KoneksiDatabase();
        $this->pesanan = new Pesanan($koneksi);
    }

    // Method untuk menambah barang baru
    public function tambahPesanan($nama_pemesan, $phone, $alamat, $barang_id, $user_id, $total)
    {
        return $this->pesanan->tambahPesanan($nama_pemesan, $phone, $alamat, $barang_id, $user_id, $total);
    }

    // Method untuk mengambil semua pesanan
    public function semuaPesanan($user_id)
    {
        return $this->pesanan->semuaPesanan($user_id);
    }
}
