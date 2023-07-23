<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table      = 'produk';
    protected $primaryKey = 'idProduk';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';

    protected $allowedFields = ['skuProduk', 'namaProduk', 'hargaProduk', 'isReadyProduk', 'gambarProduk', 'kategoriProduk'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getProdukSearch($kat = null)
    {
        $builder = $this->table($this->table);
        $builder->join('kategori', 'kategori.idKategori=' . $this->table . '.kategoriProduk', 'LEFT');
        if ($kat) {
            $builder->where([
                'idKategori' => $kat
            ]);
        }
        return $builder->get();
    }

    public function getProduk()
    {
        $builder = $this->table($this->table);
        $builder->join('kategori', 'kategori.idKategori=' . $this->table . '.kategoriProduk', 'LEFT');
        return $builder->get();
    }
}
