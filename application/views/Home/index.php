<div id="flash-data" data-flashdata="<?= $this->session->flashdata('flash') ?>"></div>
<!-- BLOG -->
<section class="blog">
    <div class="container">
        <div class="row section-padding justify-content-center">
            <div class="col-lg-8 col-md-8 col-12 mb-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <form>
                            <div class="input-group mb-4">
                                <label for="cari-data-pengaduan" style="font-size: 16px; margin-bottom: 10px;">Cari Pengaduan</label>
                                <input type="text" class="form-control" id="cari-data-pengaduan">
                                <button class="btn btn-info" type="button" id="cari-pengaduan">Cari</button>
                            </div>
                            <?php if ($this->session->userdata('role_id') == 3 || $this->session->userdata('role_id') == null) : ?>
                                <div class="input-group">
                                    <label for="post" style="font-size: 16px; margin-bottom: 10px;">Tambahkan Pengaduan</label>
                                    <input type="text" class="form-control" id="post" name="post">
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
                <div id="data-pengaduan"></div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        const flashData = $('#flash-data').data('flashdata');

        if (flashData) {
            Swal.fire({
                icon: 'success',
                title: 'Lapor-in menyatakan',
                text: flashData
            });
        }

        // DATAGRID - SHOW DATA INIT
        load_data_pengaduan();

        function load_data_pengaduan(query) {
            $.ajax({
                url: '<?= base_url('PengaduanController/load_data_pengaduan') ?>',
                method: 'POST',
                // dataType: 'JSON',
                data: {
                    query: query
                },
                success: function(result) {
                    // console.log(result);
                    $('#data-pengaduan').html(result);
                },
                error: function(error) {
                    console.log(error);
                }
            })
        }

        // DATAGRID - SEARCH DATA
        $('#cari-pengaduan').click(function() {
            var search = $('#cari-data-pengaduan').val();
            if (search != '') {
                load_data_pengaduan(search);
            } else {
                load_data_pengaduan();
            }
        });

        const href = $('#direct-login').attr('href');
        let userdata = $('#user-data').data('userdata');

        $('#post').on('focus', function() {
            if (userdata == null) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Lapor-in menyatakan',
                    text: 'anda harus masuk terlebih dahulu untuk melanjutkan pengaduan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.location.href = href;
                    }
                });
            } else {
                document.location.href = '<?= base_url('HomeController/tambah_pengaduan') ?>'
                // $('#post-modal').modal('show');
            }
        });
    });
</script>