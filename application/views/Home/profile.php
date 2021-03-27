<div id="flash-data" data-flashdata="<?= $this->session->flashdata('flash') ?>"></div>
<!-- BLOG -->
<section class="blog section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-12 mb-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <div class="client-info">
                            <img src="<?= base_url('assets/images/profile/') . $user_post['foto'] ?>" class="img mb-3" style="border-radius: 100%;" alt="profiles">
                            <h5 class="card-title" id="data-id-user" data-iduser="<?= $user_post['id'] ?>"><?= $user_post['nama'] ?></h5>
                            <p class="card-text"><?= $user_post['email'] ?></p>
                            <p class="card-text"><small class="text-muted">Dibuat pada <?= $user_post['dibuat_tgl'] ?></small></p>
                        </div>
                    </div>
                </div>
                <?php if ($user_post['id'] == $this->session->userdata('id')) : ?>
                    <div class="text-center">
                        <a href="" class="btn btn-warning fa fa-edit"></a>
                        <a href="" class="btn btn-primary fa fa-eye"></a>
                        <a href="" class="btn btn-danger fa fa-trash"></a>
                    </div>
                <?php else : ?>
                    <div class="text-center">
                        <a href="" class="btn btn-primary fa fa-eye"></a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-9 col-md-9 col-12 mb-4">
                <div id="data-pengaduan-order-by-id"></div>
            </div>
        </div>
    </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        // Load Data User
        load_data_pengaduan_order_by_id()

        function load_data_pengaduan_order_by_id() {
            $.ajax({
                url: '<?= base_url('HomeController/loadPengaduanOrderById') ?>',
                method: 'POST',
                // dataType: 'JSON',
                data: {
                    dataId: function() {
                        return $('#data-id-user').data('iduser');
                    }
                },
                success: function(result) {
                    // console.log(result);
                    $('#data-pengaduan-order-by-id').html(result);
                },
                error: function(error) {
                    console.log(error);
                }
            })
        }
    })
</script>