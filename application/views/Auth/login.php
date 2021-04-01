<!-- BLOG -->
<section class="blog section-padding">
    <div class="container">
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash') ?>"></div>
        <div class="row">
            <div class="col-lg-5 ml-auto mt-5 pt-5 col-md-6 col-12">
                <img src="<?= base_url('assets/') ?>images/office.png" data-aos="fade-up" data-aos-delay="100" class="img-fluid" alt="newsletter">
            </div>

            <div class="col-lg-5 mr-auto mt-5 pt-5 col-md-6 col-12 newsletter-form">
                <h4 data-aos="fade-up" data-aos-delay="200">Masuk untuk memulai sesi.</h4>

                <h2 data-aos="fade-up" data-aos-delay="300"><a href="<?= base_url() ?>">Lapor-in</a> | Masuk</h2>
                <form action="<?= base_url('Authentication/masuk') ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group mt-4" data-aos="fade-up" data-aos-delay="400">
                        <input name="m-email" type="text" class="form-control" id="m-email" placeholder="Masukkan Email">
                    </div>
                    <div class="form-group mt-4" data-aos="fade-up" data-aos-delay="500">
                        <input name="m-password" type="password" class="form-control" id="m-password" placeholder="Masukkan Password">
                    </div>
                    <button type="submit" data-aos="fade-up" data-aos-delay="600" class="btn w-100 mt-3">Masuk</button>
                </form>

                <small class="form-text mt-4" data-aos="fade-up" data-aos-delay="700"><a href="<?= base_url('HomeController/daftar') ?>">Daftar akun baru!</a></small>

            </div>

        </div>
    </div>
</section>

<script>
    const flashData = $('.flash-data').data('flashdata');

    if (flashData) {
        Swal.fire({
            title: 'Lapor-in Menyatakan',
            text: flashData,
        });
    }
</script>