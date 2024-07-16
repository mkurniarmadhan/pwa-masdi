<?php
require_once './koneksi.php';
require_once './Barang.php';

class BarangController
{
    private $barang;

    public function __construct()
    {
        $koneksi = new KoneksiDatabase();
        $this->barang = new Barang($koneksi);
    }

    // Method untuk menambah barang baru
    public function tambahBarang($nama_barang, $harga, $foto)
    {
        return $this->barang->tambahBarang($nama_barang, $harga, $foto);
    }

    // Method untuk mengambil semua barang
    public function semuaBarang()
    {
        return $this->barang->semuaBarang();
    }
}
