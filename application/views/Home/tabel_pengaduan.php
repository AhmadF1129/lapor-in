<div id="flash-data" data-flashdata="<?= $this->session->flashdata('flash') ?>"></div>
<!-- BLOG -->
<section class="blog section-padding">
    <div class="container">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <?php if ($this->session->userdata('role_id') == 1) : ?>
                            <button class="btn btn-success" title="EXPORT" href="#modal-export-pengaduan" data-toggle="modal">
                                EXPORT
                            </button>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari Pengaduan" id="cari-data-pengaduan">
                            <button class="btn btn-success" type="button" id="cari-pengaduan">Cari</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg col-md col-12 mb-4">
                <div id="data-pengaduan"></div>
            </div>
        </div>
    </div>
</section>