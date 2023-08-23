<?php

namespace App\Controllers;

use App\Models\KeranjangModel;
use App\Models\TransaksiModel;
use App\Models\KategoriAPIModel;
use App\Models\ProdukAPIModel;

class Pos extends BaseController
{
    protected $keranjangModel;
    protected $transaksiModel;
    protected $kategoriAPIModel;
    protected $produkAPIModel;

    public function __construct()
    {
        $this->keranjangModel = new KeranjangModel();
        $this->transaksiModel = new TransaksiModel();
        $this->kategoriAPIModel = new KategoriAPIModel();
        $this->produkAPIModel = new ProdukAPIModel();
    }

    public function index()
    {
        $kat = $this->request->getVar('kat');
        if ($kat) {
            $produk = $this->produkAPIModel->getProdukSearch($kat);
        } else {
            $produk = $this->produkAPIModel->getProduk();
        }

        $keranjang = $this->keranjangModel->findAll();
        $total = 0;
        if (count($keranjang) > 0) {
            $keranjang = json_decode($keranjang[0]->data)->data;
            foreach ($keranjang as $key => $value) {
                $total = $total + ((int)$value->jumlah * (int)$value->hargaProduk);
            }
        } else {
            $keranjang = [];
        }

        $data = [
            'title' => 'POS',
            'breadcrumbs' => ['Home', 'Pos'],
            'kategori' => $this->kategoriAPIModel->getKategori(),
            'produk' => $produk,
            'keranjang' => $keranjang,
            'total' => $total,
        ];
        return view('pos', $data);
    }

    public function addKeranjang()
    {
        $id = $this->request->getVar('idProduk');
        $produk = $this->produkAPIModel->getProdukById($id)[0];
        $keranjang = $this->keranjangModel->findAll();
        $itemKeranjang = [];
        if (count($keranjang) == 0) {
            foreach ($produk as $key => $value) {
                $itemKeranjang[$key] = $value;
            }
            $itemKeranjang['jumlah'] = 1;
            $itemKeranjang['keterangan'] = '';
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
            $itemKeranjang['keterangan'] = '';
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
        // echo json_encode([$produk1, $produk[0]]);
    }

    public function deleteKeranjang()
    {
        $id = $this->request->getVar('idProduk');
        $keranjang = $this->keranjangModel->findAll();
        $keranjang = json_decode($keranjang[0]->data)->data;
        $itemKeranjang = [];
        foreach ($keranjang as $key => $value) {
            if ($value->idProduk !== $id) {
                $itemKeranjang[] = $value;
            }
        }
        $dataUpdate = [
            'data' => json_encode(['data' => $itemKeranjang])
        ];
        $this->keranjangModel->update(1, $dataUpdate);
        $keranjangNew = $this->keranjangModel->where(['id' => 1])->findAll();
        echo $keranjangNew[0]->data;
    }

    public function bayarPesanan()
    {
        $keranjang = $this->keranjangModel->where(['id' => 1])->findAll();
        if (count($keranjang) == 0) {
            echo json_encode(['status' => false]);
            exit;
        }
        $keranjang = json_decode($keranjang[0]->data)->data;
        if (count($keranjang) > 0) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }

    public function simpanTransaksi()
    {
        $keranjangRaw = $this->keranjangModel->where(['id' => 1])->findAll();
        $keranjang = json_decode($keranjangRaw[0]->data)->data;
        $grandTotal = 0;
        foreach ($keranjang as $key => $value) {
            $grandTotal = $grandTotal + ((int)$value->jumlah * (int)$value->hargaProduk);
        }
        $dataSimpan = [
            'emailKasirTransaksi' => user()->email,
            'grandTotalTransaksi' => $grandTotal,
            'cashTransaksi' => $this->request->getVar('cash'),
            'itemTransaksi' => $keranjangRaw[0]->data,
            'tanggalBayarTransaksi' => date('Y-m-d H:i:s'),
        ];
        // dd($dataSimpan);
        $this->transaksiModel->insert($dataSimpan);
        if ($this->transaksiModel->insert($dataSimpan)) {
            $this->keranjangModel->delete(1);
        }
        return redirect()->to('/pos');
    }
}
