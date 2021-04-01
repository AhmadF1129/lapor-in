<div id="flash-data" data-flashdata="<?= $this->session->flashdata('flash') ?>"></div>
<!-- BLOG DETAIL -->
<section class="project-detail section-padding-half">
    <div class="container">
        <div class="row">

            <div class="col-lg-9 mx-auto col-md-10 col-12 mt-lg-5 text-center" data-aos="fade-up">

                <?php if ($post['status'] == 0) : ?>
                    <h3 class="text-center text-secondary mb-3">Baru</h3>
                <?php elseif ($post['status'] == 1) : ?>
                    <h3 class="text-center text-warning mb-3">Terverifikasi</h3>
                <?php elseif ($post['status'] == 2) : ?>
                    <h3 class="text-center text-primary mb-3">Sedang Diproses</h3>
                <?php else : ?>
                    <h3 class="text-center text-success mb-3">Selesai Diproses</h3>
                <?php endif; ?>


                <h1 id="data-id-pengaduan" class="mb-3" data-id-pengaduan="<?= $post['id'] ?>"><?= $post['judul'] ?></h1>

                <div class="client-info">
                    <div class="d-flex justify-content-center align-items-center mb-3">
                        <img src="<?= base_url('assets/') ?>images/profile/<?= $post['foto'] ?>" class="img" style="border-radius: 100px;" alt="male avatar">
                        <a href="<?= base_url('UserController/detail_user/') . $post['user_id'] ?>"><?= $post['nama'] ?></a>
                    </div>
                    <h5 class="text-secondary"><?= $post['tgl_pengaduan'] ?></h5>
                </div>
            </div>

        </div>
    </div>
</section>


<div class="full-image text-center" data-aos="zoom-in">
    <img src="<?= base_url('assets/') ?>images/blog/<?= $post['bukti_foto'] ?>" class="img-fluid" alt="blog header">
</div>


<!-- BLOG DETAIL -->
<section class="project-detail">
    <div class="container">
        <div class="row">

            <div class="col-lg-9 mx-auto col-md-11 col-12 my-5 pt-3" data-aos="fade-up">

                <p class="lh-base"><?= $post['isi_laporan'] ?></p>
                <hr>

                <div id="data-tanggapan"></div>
            </div>
        </div>

        <div class="col-lg-8 mx-auto mb-5 pb-5 col-12" data-aos="fade-up">


            <?php if ($this->session->userdata('role_id') == 1 || $this->session->userdata('role_id') == 2) : ?>
                <h3 class="my-3" data-aos="fade-up">Berikan Tanggapan</h3>

                <form action="<?= base_url('TanggapanController/tambah_tanggapan/') . $post['id'] ?>" id="form-tanggapan" method="post" class="contact-form" data-aos="fade-up" data-aos-delay="300" role="form">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <textarea class="form-control" rows="6" id="tanggapan" name="tanggapan" placeholder="Message"></textarea>
                        </div>

                        <div class="col-lg-5 mx-auto col-7">
                            <button type="submit" class="form-control" id="submit-button" name="submit">Submit Comment</button>
                        </div>
                    </div>
                </form>
            <?php endif; ?>

        </div>

    </div>

</section>
<script>
    $(document).ready(function() {
        // DATAGRID - SHOW DATA INIT
        load_data_tanggapan();

        function load_data_tanggapan() {
            $.ajax({
                url: '<?= base_url('TanggapanController/load_data_tanggapan') ?>',
                method: 'POST',
                // dataType: 'JSON',
                data: {
                    dataId: function() {
                        return $('#data-id-pengaduan').data('id-pengaduan');
                    },
                },
                success: function(result) {
                    // console.log(result);
                    $('#data-tanggapan').html(result);
                },
                error: function(error) {
                    console.log(error);
                }
            })
        }

        $('#form-tanggapan').validate({
            rules: {
                'tanggapan': {
                    required: true,
                },
            },
            messages: {
                'tanggapan': {
                    required: 'field ini wajib diisi!',
                }
            }
        });

        const flashData = $('#flash-data').data('flashdata');
        if (flashData) {
            Swal.fire({
                icon: 'success',
                title: 'Lapor-in Mengatakan',
                text: flashData,
            });
        }

    })
</script>