<!DOCTYPE html>
<html lang="en">

    <head>
        <?php $this->load->view('admin/_includes/head.php') ?>
    </head>

    <body id="page-top">

        <?php $this->load->view('admin/_includes/navbar.php') ?>

        <div id="wrapper">

            <!-- Sidebar -->
            <?php $this->load->view('admin/_includes/sidebar'); ?>

            <div id="content-wrapper">

                <div class="container-fluid">

                    <!-- Breadcrumbs-->
                    <?php $this->load->view('admin/_includes/breadcrumbs'); ?>

                   <!-- DataTables -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <a href="<?php echo site_url('admin/produk/add') ?>"><i class="fas fa-plus"></i> Add New</a>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Harga</th>
                                            <th>Gambar</th>
                                            <th>Deskripsi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($produk as $produks): ?>
                                        <tr>
                                            <td width="150">
                                                <?php echo $produks->nama ?>
                                            </td>
                                            <td>
                                                <?php echo $produks->harga ?>
                                            </td>
                                            <td>
                                                <img src="<?php echo base_url('upload/produk/'.$produks->image) ?>" width="64" />
                                                <?php //echo $produks->image ?>
                                            </td>
                                            <td class="small">
                                                <?php echo substr($produks->deskripsi, 0, 120) ?>...</td>
                                            <td width="250">
                                                <a href="<?php echo site_url('admin/produk/edit/'.$produks->produk_id) ?>"
                                                class="btn btn-small"><i class="fas fa-edit"></i> Edit</a>
                                                <a onclick="deleteConfirm('<?php echo site_url('admin/produk/delete/'.$produks->produk_id) ?>')"
                                                href="#!" class="btn btn-small text-danger"><i class="fas fa-trash"></i> Hapus</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

                <!-- Sticky Footer -->
                <?php $this->load->view('admin/_includes/footer'); ?>

            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- Scroll to Top Button-->
        <?php $this->load->view('admin/_includes/scrolltop') ?>

        <!-- Logout Modal-->
        <?php $this->load->view('admin/_includes/modal') ?>

        <?php $this->load->view('admin/_includes/js'); ?>

        <!-- Script Konfirmasi Hapus Data -->
        <script>
            function deleteConfirm(url){
                $('#btn-delete').attr('href', url);
                $('#deleteModal').modal();
            }
        </script>
    </body>

</html>