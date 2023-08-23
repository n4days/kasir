<?php

namespace App\Models;

use Config\Services;

class KategoriAPIModel
{
    protected $curl;
    protected $urlAPI;
    public function __construct()
    {
        $this->curl = service('curlrequest');
        $this->urlAPI = config('GlobalConfig')->stringUrlAPI;
    }

    public function getKategori()
    {
        $result = $this->curl->request('GET', $this->urlAPI . 'kategori', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
        return json_decode($result->getBody())->data;
    }
}
