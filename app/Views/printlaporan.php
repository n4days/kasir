<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kasir | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/jqvmap/jqvmap.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css') ?>">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') ?>">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/daterangepicker/daterangepicker.css') ?>">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/summernote/summernote-bs4.min.css') ?>">
    <style>
        .card-disabled {
            background-color: #ccc;
            opacity: 0.3;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-12">
                    <h2>
                        <i class="fas fa-file"></i> Laporan Laba Rugi.
                        <small class="float-right"><?php $tanggal = date("j F Y");
                                                    echo $tanggal;
                                                    ?></small>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    From
                    <?php if (in_groups('4')) : ?>
                        <?php foreach ($auth_groups_users as $key => $valueAuth_groups_users) : ?>
                            <address>
                                <strong><?= $valueAuth_groups_users->group_id == user_id() ? $valueAuth_groups_users->email : '' ?></strong>
                            </address>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    To
                    <?php foreach ($auth_groups_users as $key => $valueAuth_groups_users) : ?>
                        <address>
                            <strong><?= $valueAuth_groups_users->group_id == 3 ? $valueAuth_groups_users->email : '' ?></strong>
                        </address>
                    <?php endforeach ?>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>Laporan <?php
                                $tanggal = date("YmdH:i:s");
                                echo $tanggal;
                                ?></b>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>
                                    <h5><strong>Pendapatan</strong></h5>
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $totalPendapatanView = 0 ?>
                            <?php foreach ($itemTransaksi as $key => $valueItemTransaksi) : ?>
                                <?php foreach ($valueItemTransaksi as $key => $valueValueItemTransaksi) : ?>
                                    <tr>
                                        <div class="container-fluid">
                                            <td>
                                                <?= $valueValueItemTransaksi->namaProduk ?>
                                            </td>
                                            <td style="text-align: right">
                                                @<?= $valueValueItemTransaksi->jumlah ?>
                                            </td>
                                            <td style="text-align: right">
                                                <?php $hargaView = $valueValueItemTransaksi->hargaProduk * $valueValueItemTransaksi->jumlah ?>
                                                <?= number_format($valueValueItemTransaksi->hargaProduk, 0, '.', '.'); ?>
                                                <?php $totalPendapatanView = $totalPendapatanView + $hargaView ?>
                                            </td>
                                        </div>
                                    </tr>
                                <?php endforeach ?>
                            <?php endforeach ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>
                                    <h5><strong>Total Pendapatan</strong></h5>
                                </th>
                                <th>
                                </th>
                                <th style="text-align: right">
                                    <h5><strong><?= number_to_currency((float)$totalPendapatanView, 'IDR', 'id_ID') ?></strong>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>
                                    <h5><strong>Harga Pokok Penjualan</strong></h5>
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <div class="container-fluid">
                                    <td>
                                        Harga Pokok Penjualan 20% dari Pendapatan
                                    </td>
                                    <td style="text-align: right">
                                        <?php $HPPView = $totalPendapatanView * (20 / 100);
                                        $HPPView = $totalPendapatanView - $HPPView ?>
                                        <?= number_format($HPPView, 0, '.', '.') ?>
                                    </td>
                                </div>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>
                                    <h5><strong>Total Harga Pokok Penjualan</strong></h5>
                                </th>
                                <th style="text-align: right">
                                    <h5><strong><?= number_to_currency((float)$HPPView, 'IDR', 'id_ID') ?></strong>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                    <table class="table table-hover active">
                        <thead>
                            <tr class="table-active">
                                <th>
                                    <h5><strong>TOTAL LABA KOTOR</strong></h5>
                                </th>
                                <th style="text-align: right">
                                    <h5><strong><?php $totalLabaKotorView = $totalPendapatanView - $HPPView ?><?= number_to_currency((float)$totalLabaKotorView, 'IDR', 'id_ID') ?></strong>
                                </th>
                            </tr>
                        </thead>
                    </table>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>
                                    <h5><strong>Beban Operasional</strong></h5>
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <div class="container-fluid">
                                    <td>
                                        Biaya serba serbi
                                    </td>
                                    <td style="text-align: right">
                                        <?php $biayaView = 0 ?><?= $biayaView ?>
                                    </td>
                                </div>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>
                                    <h5><strong>Total Beban Operasional</strong></h5>
                                </th>
                                <th style="text-align: right">
                                    <h5><strong><?= number_to_currency((float)$biayaView, 'IDR', 'id_ID') ?></strong>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                    <table class="table table-hover active">
                        <thead>
                            <tr class="table-active">
                                <th>
                                    <h5><strong>TOTAL LABA BERSIH</strong></h5>
                                </th>
                                <th style="text-align: right">
                                    <h5><strong><?php $totalLabaBersihView = $totalLabaKotorView - $biayaView ?><?= number_to_currency((float)$totalLabaBersihView, 'IDR', 'id_ID') ?></strong>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->
    <!-- Page specific script -->
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>