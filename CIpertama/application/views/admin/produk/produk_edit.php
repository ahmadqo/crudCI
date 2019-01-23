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

                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $this->session->flashdata('success'); ?>
                        </div>
				    <?php endif; ?>

                    <div class="card mb-3">
                        <div class="card-header">
                            <a href="<?php echo site_url('admin/produk/') ?>"><i class="fas fa-arrow-left"></i> Back</a>
                        </div>
                        <div class="card-body">

                            <form action="<?php base_url('admin/produk/edit') ?>" method="post" enctype="multipart/form-data" >
                                <input type="hidden" name="id" value="<?php echo $produk->produk_id?>" />
                                <div class="form-group">
                                    <label for="nama">Nama Produk*</label>
                                    <input class="form-control <?php echo form_error('nama') ? 'is-invalid':'' ?>"
                                    type="text" name="nama" placeholder="nama" value="<?php echo $produk->nama ?>" />
                                    <div class="invalid-feedback">
                                        <?php echo form_error('nama') ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="harga">Harga*</label>
                                    <input class="form-control <?php echo form_error('harga') ? 'is-invalid':'' ?>"
                                    type="number" name="harga" min="0" placeholder="harga" value="<?php echo $produk->harga ?>" />
                                    <div class="invalid-feedback">
                                        <?php echo form_error('harga') ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="image">Photo</label>
                                    <input class="form-control-file <?php echo form_error('image') ? 'is-invalid':'' ?>"
                                    type="file" name="image" />
                                    <input type="hidden" name="old_image" value="<?php echo $produk->image ?>">
                                    <div class="invalid-feedback">
                                        <?php echo form_error('image') ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi*</label>
                                    <textarea class="form-control <?php echo form_error('deskripsi') ? 'is-invalid':'' ?>"
                                    name="deskripsi" placeholder="deskripsi..."><?php echo $produk->deskripsi ?></textarea>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('deskripsi') ?>
                                    </div>
                                </div>

                                <input class="btn btn-success" type="submit" name="btn" value="Save" />
                            </form>

                        </div>

                        <div class="card-footer small text-muted">
                            * required fields
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

    </body>

</html>