<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use App\Models\ProdukModel;

class Pos extends BaseController
{
    protected $kategoriModel;
    protected $produkModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
        $kat = $this->request->getVar('kat');
        if ($kat) {
            $produk = $this->produkModel->getProdukSearch($kat)->getResult();
        } else {
            $produk = $this->produkModel->getProduk()->getResult();
        }

        $data = [
            'title' => 'POS',
            'breadcrumbs' => ['Home', 'Pos'],
            'kategori' => $this->kategoriModel->findAll(),
            'produk' => $produk
        ];
        return view('pos', $data);
    }
}
