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
                                        <div class="col-md-3">
                                            <div class="card shadow <?= $value->isReadyProduk ? '' : 'card-disabled' ?>">
                                                <img src="<?= base_url('assets/images/' . $value->slugKategori . '/' . $value->gambarProduk) ?>" class="card-img-top">
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

<?= $this->endSection() ?>