<?php

namespace App\Models;

use Config\Services;

class ProdukAPIModel
{
    protected $curl;
    protected $urlAPI;

    public function __construct()
    {
        $this->curl = service('curlrequest');
        $this->urlAPI = config('GlobalConfig')->stringUrlAPI;
    }

    public function getProduk()
    {
        $result = $this->curl->request('GET', $this->urlAPI . 'produk', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
        return json_decode($result->getBody())->data;
    }

    public function getProdukSearch($id)
    {
        $result = $this->curl->request('GET', $this->urlAPI . 'produk' . $id, [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
        return json_decode($result->getBody())->data;
    }

    public function getProdukById($id)
    {
        $result = $this->curl->request('GET', $this->urlAPI . 'produkById/' . $id, [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
        return json_decode($result->getBody())->data;
    }

    // public function insert($post, $file)
    // {
    //     $result = $this->curl->request('POST', 'http://localhost:4444/addProduk', $post, [
    //         'multipart' => $file,
    //     ]);
    //     return json_decode($result->getBody());
    // }
    public function insert($dataInsert)
    {
        $result = $this->curl->post($this->urlAPI . 'addProduk', [
            'debug' => true,
            'multipart' => $dataInsert
        ]);
        return json_decode($result->getBody());
    }

    public function update($idProduk, $dataInsert)
    {
        $result = $this->curl->post($this->urlAPI . 'updateProduk/' . $idProduk, [
            'debug' => true,
            'multipart' => $dataInsert
        ]);
        return json_decode($result->getBody());
    }
    public function delete($idProduk, $dataInsert)
    {
        // $result = $this->curl->request('POST', 'http://localhost:4444/produk/' . $idProduk, [
        //     'headers' => [
        //         'Accept' => 'application/json',
        //         'Content-Type' => 'application/json'
        //     ],
        //     'form_params' => [
        //         'fotoInfoView' => $kategori,
        //     ],
        // ]);
        // return json_decode($result->getBody());
        $result = $this->curl->post($this->urlAPI . 'produk/' . $idProduk, [
            'debug' => true,
            'multipart' => $dataInsert,
        ]);
        return json_decode($result->getBody());
    }
}
