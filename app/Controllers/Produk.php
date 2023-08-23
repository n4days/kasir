<?php

namespace App\Controllers;

use App\Models\ProdukAPIModel;
use App\Models\KategoriAPIModel;
use CodeIgniter\HTTP\Files\UploadedFile;


class Produk extends BaseController
{
    protected $kategoriAPIModel;
    protected $produkAPIModel;
    protected $curl;

    public function __construct()
    {
        $this->kategoriAPIModel = new KategoriAPIModel();
        $this->produkAPIModel = new ProdukAPIModel();
        $this->curl = service('curlrequest');
    }

    public function index()
    {
        $produk = $this->produkAPIModel->getProduk();
        $data = [
            'title' => 'Produk',
            'breadcrumbs' => ['Home', 'Produk'],
            'produk' => $produk,
            'kategori' => $this->kategoriAPIModel->getKategori(),
        ];
        return view('produk', $data);
    }

    public function addProduk()
    {

        // $file = [
        //     'name' => 'gambarProdukView',
        //     'contents' => fopen(new UploadedFile($_FILES['gambarProdukView']['tmp_name'], true), 'r'),
        //     'filename' => $_FILES['gambarProdukView']['tmp_name']
        // ];
        // $post_data = [
        //     'foo'      => 'bar',
        //     'userfile' => new \CURLFile('C:\Users\n4days\Downloads\pancake.jpeg'),
        // ];
        // dd($post_data);
        // $data = [];
        // foreach ($_POST as $key => $value) {
        //     $data[] = [
        //         'name' => $key,
        //         'contents' => $value
        //     ];
        // }
        // $exe = $this->produkAPIModel->insert($post_data);

        // if ($exe->status) {
        //     return redirect()->to('/produk');
        // }
        $file = $this->request->getFile('gambarProdukView');
        $kategori = explode(',', $this->request->getVar('kategoriProdukView'));
        // $data = [
        //     'image' => curl_file_create($file->getTempName(), $file->getClientMimeType(), $file->getName()),
        //     'name' => $this->request->getVar('namaProdukView'),
        // ];
        $dataInsert = [
            'skuProduk' => $this->request->getVar('skuProdukView'),
            'namaProduk' => $this->request->getVar('namaProdukView'),
            'hargaProduk' => $this->request->getVar('hargaProdukView'),
            'isReadyProduk' => 1,
            'gambarProduk' => curl_file_create($file->getTempName(), $file->getClientMimeType(), $file->getName()),
            'kategoriProduk' => $kategori[0],
            'kategoriSlug' => $kategori[1],
        ];

        $exe = $this->produkAPIModel->insert($dataInsert);

        if ($exe->status) {
            return redirect()->to('/produk');
        }
        // $result = $this->curl->post('http://localhost:4444/testUpload', ['debug' => true, 'multipart' => $dataInsert]);
        // return json_decode($result->getBody());
    }

    public function editProduk($idProduk)
    {
        // dd($_POST);
        // dd($this->request->getFile('gambarProdukView'));
        // $kategori = explode(',', $this->request->getVar('kategoriProdukView'));
        // $foto = $this->request->getFile('gambarProdukView');
        // $fotoName = $foto->getRandomName();
        // $ketersediaan = $this->request->getVar('isReadyProdukView');
        // $dataUpdate = [
        //     'skuProduk' => $this->request->getVar('skuProdukView'),
        //     'namaProduk' => $this->request->getVar('namaProdukView'),
        //     'hargaProduk' => $this->request->getVar('hargaProdukView'),
        //     'isReadyProduk' => boolval($ketersediaan),
        //     'gambarProduk' => $fotoName,
        //     'kategoriProduk' => $kategori[0],
        // ];

        // if ($foto->move('assets/images/' . $kategori[1] . '/', $fotoName, true)) {
        //     if ($this->produkAPIModel->update($idProduk, $dataUpdate)) {
        //         return redirect()->to('/produk');
        //     };
        // };
        $file = $this->request->getFile('gambarProdukView');
        $kategori = explode(',', $this->request->getVar('kategoriProdukView'));
        $dataInsert = [
            'skuProduk' => $this->request->getVar('skuProdukView'),
            'namaProduk' => $this->request->getVar('namaProdukView'),
            'hargaProduk' => $this->request->getVar('hargaProdukView'),
            'isReadyProduk' => $this->request->getVar('isReadyProdukView'),
            'gambarProduk' => curl_file_create($file->getTempName(), $file->getClientMimeType(), $file->getName()),
            'gambarProdukLama' => $this->request->getVar('fotoInfoView'),
            'kategoriProduk' => $kategori[0],
            'kategoriSlug' => $kategori[1],
        ];
        // dd($dataInsert);
        $exe = $this->produkAPIModel->update($idProduk, $dataInsert);
        if ($exe->status) {
            return redirect()->to('/produk');
        }
    }

    public function deleteProduk($idProduk)
    {
        // dd($_POST);
        $kategori = explode(',', $this->request->getVar('fotoInfoView'));
        $dataInsert = [
            'kategoriSlug' => $kategori[0],
            'gambarProduk' => $kategori[1],
        ];
        $exe = $this->produkAPIModel->delete($idProduk, $dataInsert);

        if ($exe->status) {
            return redirect()->to('/produk');
        }
    }
}
