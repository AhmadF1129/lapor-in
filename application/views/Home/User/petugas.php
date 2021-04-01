<div id="flash-data" data-flashdata="<?= $this->session->flashdata('flash') ?>"></div>
<!-- BLOG -->
<section class="blog section-padding">
    <div class="container">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <button class="btn btn-success" id="tambah-petugas" data-bs-toggle="modal" data-bs-target="#tambah-data-petugas">
                            Tambah Petugas
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari Data Petugas" id="cari-petugas">
                            <button class="btn btn-success" type="button" id="cari-petugas">Cari</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg col-md col-12 mb-4">
                <div id="data-petugas"></div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="tambah-data-petugas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambahkan Data Petugas</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('UserController/tambah_data_petugas') ?>" method="post" enctype="multipart/form-data" id="form-petugas">
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

        load_data_petugas();

        function load_data_petugas(query) {
            $.ajax({
                url: '<?= base_url('UserController/load_data_user') ?>',
                method: 'POST',
                data: {
                    query: query,
                    dataId: 2,
                },
                success: function(result) {
                    // console.log(result);
                    $('#data-petugas').html(result);
                },
                error: function(error) {
                    console.log(error);
                }
            })
        }

        // DATAGRID - SEARCH DATA
        $('#cari-petugas').click(function() {
            var search = $('#cari-petugas').val();
            if (search != '') {
                load_data_petugas(search);
            } else {
                load_data_petugas();
            }
        });

        $('#form-petugas').validate({
            rules: {
                'nik': {
                    required: true,
                    number: true,
                    remote: {
                        url: '<?= base_url('Authentication/cek_nik') ?>',
                        type: 'post',
                        data: {
                            nik: function() {
                                return $('#nik').val();
                            }
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
                        url: '<?= base_url('Authentication/cek_email') ?>',
                        type: 'post',
                        data: {
                            email: function() {
                                return $('#email').val();
                            }
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