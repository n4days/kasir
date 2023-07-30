<?= $this->extend('layout\layoutHome') ?>

<?= $this->section('content') ?>

<div class="wrapper">

    <?= view('layout/layoutHomeHeader') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?= $title ?></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <?php foreach ($breadcrumbs as $key => $value) : ?>
                                <li class="breadcrumb-item <?= (count($breadcrumbs) - 1) == $key ? 'active' : '' ?>"><?= (count($breadcrumbs) - 1) == $key ? $value : '<a href="/">' . $value . '</a>' ?></li>
                            <?php endforeach ?>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="invoice p-3 mb-3">
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
                    <br>
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
                    <br>
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

                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-12">
                            <a href="/printlaporan" rel="noopener" target="_blank" class="btn btn-default float-right"><i class="fas fa-print"></i> Print</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?= view('layout/layoutHomeFooter.php') ?>
</div>
<!-- ./wrapper -->

<?= $this->endSection() ?>