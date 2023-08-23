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
                <div class="row">
                    <div class="col-md">
                        <div class="card">
                            <div class="card-header">
                                <h3>
                                    <i class="fas fa-list"></i> Menu
                                    <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#tambahProdukModal">Tambah Produk</button>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Sku Produk</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Harga</th>
                                                <th scope="col">Foto Produk</th>
                                                <th scope="col">Kategori</th>
                                                <th scope="col">Ketersediaan</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;
                                            foreach ($produk as $key => $value) : ?>
                                                <tr>
                                                    <th scope="row"><?= $no++ ?></th>
                                                    <td>(<?= $value->skuProduk ?>)</td>
                                                    <td><?= $value->namaProduk ?></td>
                                                    <td><?= number_to_currency((float)$value->hargaProduk, 'IDR', 'id_ID'); ?></td>
                                                    <td><button class="btn btn-info" data-toggle="modal" data-target="#imageModal<?= $value->idProduk ?>"><i class="fas fa-image"></i> Lihat</button></td>
                                                    <td><?= $value->namaKategori ?></td>
                                                    <td><?= $value->isReadyProduk == 1 ? 'Tersedia' : 'Habis' ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editProdukModal<?= $value->idProduk ?>"><i class="fas fa-edit"></i></button>
                                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusProdukModal<?= $value->idProduk ?>"><i class="fas fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
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

    <!-- Modal button-Tambah-Produk -->
    <?php foreach ($produk as $key => $value) : ?>
        <div class="modal fade" id="tambahProdukModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/produk" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Kategori</label>
                                <select class="form-control" name="kategoriProdukView">
                                    <option>-- Kategori --</option>
                                    <?php foreach ($kategori as $key => $value) : ?>
                                        <option value="<?= $value->idKategori ?>,<?= $value->slugKategori ?>"><?= $value->namaKategori ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="namaProdukView">
                            </div>
                            <div class="form-group">
                                <label>Sku Produk</label>
                                <input type="text" class="form-control" name="skuProdukView">
                            </div>
                            <div class="form-group">
                                <label>Harga</label>
                                <input type="text" class="form-control" name="hargaProdukView">
                            </div>
                            <div class="form-group">
                                <label>Foto Produk</label>
                                <input type="file" class="form-control" name="gambarProdukView">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach ?>

    <!-- Modal button-editProduk -->
    <?php foreach ($produk as $key => $valueProduk) : ?>
        <div class="modal fade" id="editProdukModal<?= $valueProduk->idProduk ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Produk <strong><?= $valueProduk->namaProduk ?></strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/produk/<?= $valueProduk->idProduk ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="fotoInfoView" value="<?= $valueProduk->gambarProduk ?>">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Kategori</label>
                                <select class="form-control" name="kategoriProdukView">
                                    <option value="<?= $valueProduk->idKategori ?>,<?= $valueProduk->slugKategori ?>"><?= $valueProduk->namaKategori ?></option>
                                    <?php foreach ($kategori as $key => $valueKategori) : ?>
                                        <?php if ($valueKategori->idKategori != $valueProduk->idKategori) : ?>
                                            <option value="<?= $valueKategori->idKategori ?>,<?= $valueKategori->slugKategori ?>"><?= $valueKategori->namaKategori ?></option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="namaProdukView" placeholder="<?= $valueProduk->namaProduk ?>">
                            </div>
                            <div class="form-group">
                                <label>Sku Produk</label>
                                <input type="text" class="form-control" name="skuProdukView" placeholder="<?= $valueProduk->skuProduk ?>">
                            </div>
                            <div class="form-group">
                                <label>Harga</label>
                                <input type="text" class="form-control" name="hargaProdukView" placeholder="<?= $valueProduk->hargaProduk ?>">
                            </div>
                            <div class="form-group">
                                <label>Ketersediaan</label>
                                <select class="form-control" name="isReadyProdukView">
                                    <option value="<?= $valueProduk->isReadyProduk ?>"><?= $valueProduk->isReadyProduk == 1 ? 'Tersedia' : 'Habis' ?></option>
                                    <?php for ($i = 0; $i < 2; $i++) : ?>
                                        <?php if ($valueProduk->isReadyProduk != $i) : ?>
                                            <option value="<?= $i ?>"><?= $i == 1 ? 'Tersedia' : 'Habis' ?></option>
                                        <?php endif ?>
                                    <?php endfor ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Foto Produk</label>
                                <input type="file" class="form-control" name="gambarProdukView" placeholder="<?= $valueProduk->gambarProduk ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach ?>

    <!-- Modal button-HapusProduk -->
    <?php foreach ($produk as $key => $value) : ?>
        <div class="modal fade" id="hapusProdukModal<?= $value->idProduk ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Produk <strong><?= $value->skuProduk ?></strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/produk/<?= $value->idProduk ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="fotoInfoView" value="<?= $value->slugKategori ?>,<?= $value->gambarProduk ?>">
                        <div class="modal-body">
                            Apakah yakin ingin menghapus <strong><?= $value->namaProduk ?></strong>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach ?>

    <!-- Modal button-Image -->
    <?php foreach ($produk as $key => $value) : ?>
        <div class="modal fade" id="imageModal<?= $value->idProduk ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Gambar Produk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <td><img class="img-fluid" src="<?= 'http://localhost:4444/assets/images/' . $value->slugKategori . '/' . $value->gambarProduk ?>"></td>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>


    <?= view('layout/layoutHomeFooter.php') ?>
</div>
<!-- ./wrapper -->

<?= $this->endSection() ?>