<div id="flash-data" data-flashdata="<?= $this->session->flashdata('flash') ?>"></div>
<!-- BLOG -->
<section class="blog section-padding" data-role-id="<?= $dataId ?>">
    <div class="container">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <button class="btn btn-success" id="tambah-data" data-bs-toggle="modal" data-bs-target="#tambah-data-modal">
                            <?php if ($dataId == 1) : ?>
                                Tambahkan Admin
                            <?php elseif ($dataId == 2) : ?>
                                Tambahkan Petugas
                            <?php else : ?>
                                Tambahkan Masyarakat
                            <?php endif; ?>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari Data" id="cari-data">
                            <button class="btn btn-success" type="button" id="cari-data">Cari</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg col-md col-12 mb-4">
                <div id="data-admin"></div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="tambah-data-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambahkan Data</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('HomeController/tambah_data_user') ?>" method="post" enctype="multipart/form-data" id="form-admin">
                    <input type="hidden" name="role_id" id="role_id" value="<?= $dataId ?>">
                    <div class="form-group mb-2">
                        <input type="text" name="nik" id="nik" class="form-control" placeholder="NIK">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Lengkap">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" name="email" id="email" class="form-control" placeholder="example@example.com">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" name="telp" id="telp" class="form-control" placeholder="Nomor Telepon">
                    </div>
                    <div class="form-group mb-2">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group mb-2">
                        <input type="password" name="ulang-password" id="ulang-password" class="form-control" placeholder="Ulangi Password">
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

        load_data_admin();

        function load_data_admin(query) {
            $.ajax({
                url: '<?= base_url('HomeController/loadAdmin') ?>',
                method: 'POST',
                // dataType: 'JSON',
                data: {
                    query: query,
                    dataId: function() {
                        return $('.blog').data('role-id');
                    }
                },
                success: function(result) {
                    // console.log(result);
                    $('#data-admin').html(result);
                },
                error: function(error) {
                    console.log(error);
                }
            })
        }

        // DATAGRID - SEARCH DATA
        $('#cari-data').click(function() {
            var search = $('#cari-data').val();
            if (search != '') {
                load_data_admin(search);
            } else {
                load_data_admin();
            }
        });

        let value_nik = $('#nik').val();
        let value_email = $('#email').val();

        $('#form-admin').validate({
            rules: {
                'nik': {
                    required: true,
                    number: true,
                    remote: {
                        url: 'cek_nik',
                        type: 'post',
                        dataType: 'JSON',
                        data: {
                            nik: value_nik,
                        },
                    },
                },
                'nama': {
                    required: true,
                },
                'email': {
                    required: true,
                    email: true,
                    remote: {
                        url: 'cek_email',
                        type: 'post',
                        dataType: 'JSON',
                        data: {
                            email: value_email,
                        }
                    },
                },
                'telp': {
                    required: true,
                    number: true,
                },
                'password': {
                    required: true,
                    minlength: 4,
                },
                'ulang-password': {
                    required: true,
                    equalTo: '#password',
                },
                'foto': {
                    required: true,
                },
            },
            messages: {
                'nik': {
                    required: 'field ini wajib diisi!',
                    number: 'field ini harus diisi dengan angka!',
                    remote: 'nik sudah digunakan!',
                },
                'nama': {
                    required: 'field ini wajib diisi!',
                },
                'email': {
                    required: 'field ini wajib diisi!',
                    email: 'wajib mengguanakan email valid!',
                    remote: 'email sudah digunakan!',
                },
                'telp': {
                    required: 'field ini wajib diisi!',
                    number: 'field ini harus diisi dengan angka!',
                },
                'password': {
                    required: 'field ini wajib diisi!',
                    minlength: 'minimal 4 karakter!',
                },
                'ulang-password': {
                    required: 'field ini wajib diisi!',
                    equalTo: 'password tidak sama!',
                },
                'foto': {
                    required: 'field ini wajib diisi!',
                },
            },
        });
    });
</script>