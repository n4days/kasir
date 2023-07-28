<?php

namespace App\Controllers;

use App\Models\AuthGroupsUsersModel;
use App\Models\AuthGroupsModel;
use App\Models\UsersModel;
use App\Models\TransaksiModel;

class Laporan extends BaseController
{
    protected $authGroupsUsersModel;
    protected $authGroupsModel;
    protected $usersModel;
    protected $transaksiModel;

    public function __construct()
    {
        $this->authGroupsUsersModel = new AuthGroupsUsersModel();
        $this->authGroupsModel = new AuthGroupsModel();
        $this->usersModel = new UsersModel();
        $this->transaksiModel = new TransaksiModel();
    }

    public function index()
    {
        $auth_groups_users = $this->authGroupsUsersModel->getAuthGroupsUsers();
        $transaksi = $this->transaksiModel->findAll();
        $i = 0;
        foreach ($transaksi as $key => $valueTransaksi) {
            $transaksi_itemTransaksi[$i] = json_decode($transaksi[$i]->itemTransaksi)->data;
            $i++;
        }
        // $y = 0;
        // $n = 0;
        // foreach ($transaksi_itemTransaksi as $keyTransaksi_itemTransaksi => $valueTransaksi_itemTransaksi) {
        //     foreach ($valueTransaksi_itemTransaksi as $key => $valueValueTransaksi_itemTransaksi) {
        //         $namaProduk[$y] = $valueValueTransaksi_itemTransaksi->namaProduk;
        //         $jumlah[$y] = $valueValueTransaksi_itemTransaksi->jumlah;
        //         $hargaProduk[$y] = $valueValueTransaksi_itemTransaksi->hargaProduk;
        //         $y++;
        //     }
        //     $n++;
        // }
        $data = [
            'title' => 'Laporan',
            'breadcrumbs' => ['Home', 'Laporan'],
            'auth_groups_users' => $auth_groups_users->getResult(),
            'auth_groups' => $this->authGroupsModel->findAll(),
            'users' => $this->usersModel->findAll(),
            'transaksi' => $transaksi,
            'itemTransaksi' => $transaksi_itemTransaksi,
            // 'namaProduk' => $namaProduk,
            // 'jumlah' => $jumlah,
            // 'hargaProduk' => $hargaProduk,

        ];
        return view('laporan', $data);
    }
}
