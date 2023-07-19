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
                        <h1 class="m-0"><?php $title ?></h1>
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

            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?= view('layout/layoutHomeFooter.php') ?>
</div>
<!-- ./wrapper -->

<?= $this->endSection() ?>