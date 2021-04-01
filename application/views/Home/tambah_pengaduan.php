<div id="flash-data" data-flashdata="<?= $this->session->flashdata('flash') ?>"></div>
<!-- BLOG DETAIL -->
<section class="project-detail section-padding-half">
    <div class="container">
        <div class="row">

            <div class="col-lg-9 mx-auto col-md-10 col-12 mt-lg-5 text-center" data-aos="fade-up">

                <h3 class="text-center mt-3 mb-5">Tambahkan Pengaduan</h3>

                <div class="card shadow-lg" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-body">
                        <form action="<?= base_url('PengaduanController/tambah_pengaduan') ?>" id="form-pengaduan" enctype="multipart/form-data" method="post" role="form">
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <div class="form-group">
                                        <input type="text" name="judul" id="judul" class="form-control" placeholder="Judul Pengaduan">
                                    </div>
                                    <div class="form-group">
                                        <textarea name="isi-pengaduan" class="form-control" id="isi-pengaduan" cols="30" rows="15" placeholder="Isi Pengaduan"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="file" name="foto" id="foto" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-5 mx-auto col-7">
                                    <button type="submit" class="btn btn-info">Tambahkan Pengaduan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

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
                title: 'Lapor-in Mengatakan',
                text: flashData,
            });
        }


        $('#form-pengaduan').validate({
            rules: {
                'judul': {
                    required: true,
                },
                'isi-pengaduan': {
                    required: true,
                },
                'foto': {
                    required: true,
                },
            },
            messages: {
                'judul': {
                    required: 'field ini wajib diisi!',
                },
                'isi': {
                    required: 'field ini wajib diisi!',
                },
                'foto': {
                    required: 'field ini wajib diisi!',
                },
            },
        });

    })
</script>