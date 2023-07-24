<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use App\Models\ProdukModel;
use App\Models\KeranjangModel;

class Pos extends BaseController
{
    protected $kategoriModel;
    protected $produkModel;
    protected $keranjangModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
        $this->produkModel = new ProdukModel();
        $this->keranjangModel = new KeranjangModel();
    }

    public function index()
    {
        $kat = $this->request->getVar('kat');
        if ($kat) {
            $produk = $this->produkModel->getProdukSearch($kat);
        } else {
            $produk = $this->produkModel->getProduk();
        }

        $keranjang = $this->keranjangModel->findAll();
        if (count($keranjang) == 0) {
            $keranjang = $this->keranjangModel->findAll();
        } else {
            $keranjang = json_decode($keranjang[0]->data)->data;
        }

        $data = [
            'title' => 'POS',
            'breadcrumbs' => ['Home', 'Pos'],
            'kategori' => $this->kategoriModel->findAll(),
            'produk' => $produk->getResult(),
            'keranjang' => $keranjang,
        ];
        return view('pos', $data);
    }

    public function addKeranjang()
    {
        $id = $this->request->getVar('idProduk');
        $produk = $this->produkModel->where(['idProduk' => $id])->first();
        $keranjang = $this->keranjangModel->findAll();
        $itemKeranjang = [];
        if (count($keranjang) == 0) {
            foreach ($produk as $key => $value) {
                $itemKeranjang[$key] = $value;
            }
            $itemKeranjang['jumlah'] = 1;
            $dataInsert = [
                'id' => 1,
                'data' => json_encode(['data' => [$itemKeranjang]])
            ];
            $this->keranjangModel->insert($dataInsert);
        } else {
            $keranjang = json_decode($keranjang[0]->data)->data;
            foreach ($produk as $key => $value) {
                $itemKeranjang[$key] = $value;
            }
            $itemKeranjang['jumlah'] = 1;
            $keranjangNew = array_merge($keranjang, [$itemKeranjang]);
            $jsonKeranjangNew = json_encode(['data' => $keranjangNew]);
            $dataArray = json_decode($jsonKeranjangNew, true);
            $mergedData = [];
            foreach ($dataArray['data'] as $item) {
                $idProduk = $item['idProduk'];
                if (isset($mergedData[$idProduk])) {
                    $mergedData[$idProduk]['jumlah'] += $item['jumlah'];
                } else {
                    $mergedData[$idProduk] = $item;
                }
            }
            $mergedData = array_values($mergedData);
            $dataUpdate = [
                'data' => json_encode(['data' => $mergedData])
            ];
            $this->keranjangModel->update(1, $dataUpdate);
        }
        $keranjangNew = $this->keranjangModel->where(['id' => 1])->findAll();
        echo $keranjangNew[0]->data;
    }
}
