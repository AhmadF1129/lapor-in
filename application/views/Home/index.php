<div id="flash-data" data-flashdata="<?= $this->session->flashdata('flash') ?>"></div>
<!-- BLOG -->
<section class="blog section-padding">
    <div class="container">

        <div class="row">
            <div class="col-lg-7 col-md-7 col-12 mb-4">
                <div id="data-pengaduan"></div>
            </div>
            <div class="col-lg-5 col-md-5 col-12">
                <div class="card">
                    <div class="card-body">
                        <form>
                            <div class="input-group mb-4">
                                <label for="cari-data-pengaduan" style="font-size: 16px; margin-bottom: 10px;">Cari Pengaduan</label>
                                <input type="text" class="form-control" id="cari-data-pengaduan">
                                <button class="btn btn-success" type="button" id="cari-pengaduan">Cari</button>
                            </div>
                            <?php if ($this->session->userdata('role_id') == 3) : ?>
                                <div class="input-group">
                                    <label for="post" style="font-size: 16px; margin-bottom: 10px;">Tambahkan Pengaduan</label>
                                    <input type="text" class="form-control" id="post" name="post">
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="post-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambahkan Pengaduan</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('HomeController/tambah_pengaduan') ?>" method="post" enctype="multipart/form-data" id="form-post">
                    <div class="form-group mb-2">
                        <input type="text" name="judul-post" id="judul-post" class="form-control" placeholder="Judul Pengaduan">
                    </div>
                    <div class="form-group mb-2">
                        <textarea name="isi-post" id="isi-post" class="form-control" cols="30" rows="10" placeholder="Isi Pengaduan"></textarea>
                    </div>
                    <div class="form-group mb-2">
                        <input class="form-control" type="file" id="foto" name="foto">
                    </div>
                    <div class="float-right">
                        <button type="submit" class="btn btn-success">Tambahkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
                url: '<?= base_url('HomeController/loadPengaduan') ?>',
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
                $('#post-modal').modal('show');
            }
        });

        $('#form-post').validate({
            rules: {
                'judul-post': {
                    required: true,
                },
                'isi-post': {
                    required: true,
                },
                'foto': {
                    required: true,
                },
            },
            messages: {
                'judul-post': {
                    required: 'field ini wajib diisi!',
                },
                'isi-post': {
                    required: 'field ini wajib diisi!',
                },
                'foto': {
                    required: 'field ini wajib diisi!',
                },
            },
        });

    });
</script>