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
                <h5 class="mb-2">Kategori</h5>
                <div class="row">
                    <?php foreach ($kategori as $key => $value) : ?>
                        <div class="col-md-4">
                            <a href="/pos?kat=<?= $value->idKategori ?>" style="color:inherit">
                                <div class="info-box">
                                    <span class="info-box-icon bg-<?= $value->colorKategori ?>"><i class="fas <?= $value->iconKategori ?>"></i></span>
                                    <div class="info-box-content">
                                        <?= $value->namaKategori ?>
                                        <!-- <span class="info-box-text"></span> -->
                                    </div>
                                </div>
                            </a>
                            <!-- /.info-box-content -->
                            <!-- /.info-box -->
                        </div>
                    <?php endforeach ?>
                </div>
            </div>

            <br>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h3><i class="fas fa-list"></i> Menu</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php foreach ($produk as $key => $value) : ?>
                                        <div class="col-md-3" <?= $value->isReadyProduk ? 'onclick="addKeranjang(' . $value->idProduk . ')"' : '' ?>>
                                            <?= $value->isReadyProduk ? '' : '
                                            <div class="ribbon-wrapper ribbon-lg">
                                                <div class="ribbon bg-danger text-lg">
                                                    Habis
                                                </div>
                                            </div>
                                            ' ?>
                                            <div class="card shadow">
                                                <img src="<?= 'http://localhost:4444/assets/images/' . $value->slugKategori . '/' . $value->gambarProduk ?>" class="card-img-top" style="height: 12rem;">
                                                <div class="card-body">
                                                    <h5 class="card-title"><strong><?= $value->namaProduk ?> (<?= $value->skuProduk ?>)</strong></h5>
                                                    <p class="card-text"><?= number_to_currency($value->hargaProduk, 'IDR', 'id_ID'); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h3><i class="fas fa-shopping-cart"></i> Keranjang</h3>
                            </div>
                            <div class="card-body">
                                <div id="itemKeranjang">
                                    <?php foreach ($keranjang as $key => $value) : ?>
                                        <div class="callout callout-info" id="itemProduk<?= $value->idProduk ?>">
                                            <div class="row">
                                                <div class="col-2 center">
                                                    <h3><span class="badge badge-primary"><?= $value->jumlah ?></span></h3>
                                                </div>
                                                <div class="col-8">
                                                    <h5><?= $value->namaProduk ?></h5>
                                                    <p><?= number_to_currency((float)$value->hargaProduk, 'IDR', 'id_ID'); ?></p>
                                                </div>
                                                <div class="col-2">
                                                    <button type="button" class="btn btn-danger" onclick="hapusKeranjang(<?= $value->idProduk ?>)"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                                <div class="callout callout-info d-flex align-items-center justify-content-between">
                                    <h5 class="harga">Total : <?= number_to_currency((float)$total, 'IDR', 'id_ID') ?></h5>
                                    <button type="submit" class="btn btn-success ml-auto" onclick="bayar('<?= user()->email ?>')">Bayar</button>
                                </div>
                            </div>
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

<!-- Modal Bayar -->
<div class="modal fade" id="bayarModal" tabindex="-1" aria-labelledby="bayarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/pos/pembayaran" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="bayarModalLabel">
                        Modal title
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="number" min=0 name="cash" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>