<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\KategoriModel;
use CodeIgniter\Router\Exceptions\RedirectException;

class Produk extends BaseController
{
    protected $produkModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $produk = $this->produkModel->getProduk();
        $data = [
            'title' => 'Produk',
            'breadcrumbs' => ['Home', 'Produk'],
            'produk' => $produk->getResult(),
            'kategori' => $this->kategoriModel->findAll(),
        ];
        return view('produk', $data);
    }

    public function addProduk()
    {
        // dd($_POST);
        // dd($this->request->getFile('gambarProdukView'));
        $kategori = explode(',', $this->request->getVar('kategoriProdukView'));
        $foto = $this->request->getFile('gambarProdukView');
        $fotoName = $foto->getRandomName();
        $dataInsert = [
            'skuProduk' => $this->request->getVar('skuProdukView'),
            'namaProduk' => $this->request->getVar('namaProdukView'),
            'hargaProduk' => $this->request->getVar('hargaProdukView'),
            'isReadyProduk' => 1,
            'gambarProduk' => $fotoName,
            'kategoriProduk' => $kategori[0],
        ];

        if ($foto->move('assets/images/' . $kategori[1] . '/', $fotoName, true)) {
            if ($this->produkModel->insert($dataInsert)) {
                return redirect()->to('/produk');
            };
        };
    }

    public function editProduk($idProduk)
    {
        // dd($_POST);
        // dd($this->request->getFile('gambarProdukView'));
        $kategori = explode(',', $this->request->getVar('kategoriProdukView'));
        $foto = $this->request->getFile('gambarProdukView');
        $fotoName = $foto->getRandomName();
        $ketersediaan = $this->request->getVar('isReadyProdukView');
        $dataUpdate = [
            'skuProduk' => $this->request->getVar('skuProdukView'),
            'namaProduk' => $this->request->getVar('namaProdukView'),
            'hargaProduk' => $this->request->getVar('hargaProdukView'),
            'isReadyProduk' => boolval($ketersediaan),
            'gambarProduk' => $fotoName,
            'kategoriProduk' => $kategori[0],
        ];

        if ($foto->move('assets/images/' . $kategori[1] . '/', $fotoName, true)) {
            if ($this->produkModel->update($idProduk, $dataUpdate)) {
                return redirect()->to('/produk');
            };
        };
    }

    public function deleteProduk($idProduk)
    {
        $kategori = explode(',', $this->request->getVar('fotoInfoView'));
        if (unlink('assets/images/' . $kategori[0] . '/' . $kategori[1])) {
            if ($this->produkModel->delete($idProduk)) {
                return redirect()->to('/produk');
            };
        };
    }
}
