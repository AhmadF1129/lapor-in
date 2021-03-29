<!-- BLOG -->
<section class="blog section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 mr-auto col-md-6 col-12 newsletter-form">
                <h4 data-aos="fade-up" data-aos-delay="200">Lapor-in | Daftar</h4>
                <h2 data-aos="fade-up" data-aos-delay="300">Daftar akun baru.</h2>
                <form action="<?= base_url('Authentication/tambah_user') ?>" id="form-daftar" method="post" enctype="multipart/form-data">
                    <div class="form-group mt-1" data-aos="fade-up" data-aos-delay="400">
                        <input name="d-nama" type="text" class="form-control" id="d-nama" placeholder="Nama Lengkap" value="<?= set_value('d-nama') ?>">
                    </div>
                    <div class="form-group mt-1" data-aos="fade-up" data-aos-delay="600">
                        <input name="d-email" type="text" class="form-control" id="d-email" placeholder="Masukkan Email">
                    </div>
                    <div class="form-group mt-1" data-aos="fade-up" data-aos-delay="700">
                        <input name="d-password" type="password" class="form-control" id="d-password" placeholder="Masukkan Password">
                    </div>
                    <div class="form-group mt-1" data-aos="fade-up" data-aos-delay="800">
                        <input name="ulang-password" type="password" class="form-control" id="ulang-password" placeholder="Ulangi Password">
                    </div>
                    <button type="submit" class="btn w-100 mt-1" data-aos="fade-up" data-aos-delay="900">Daftar</button>
                </form>

                <small class="form-text mt-1" data-aos="fade-up" data-aos-delay="900"><a href="<?= base_url('Authentication') ?>">Saya sudah memiliki akun!</a></small>

            </div>
            <div class="col-lg-5w ml-auto col-md-6 col-12">
                <img src="<?= base_url('assets/') ?>images/newsletter.png" class="img-fluid" alt="newsletter" data-aos="fade-up" data-aos-delay="100">
            </div>


        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        $('#form-daftar').validate({
            rules: {
                'd-nama': {
                    required: true,
                },
                'd-email': {
                    required: true,
                    email: true,
                    remote: {
                        url: '<?= base_url('Authentication/cek_email') ?>',
                        type: 'post',
                        data: {
                            email: function() {
                                return $('#d-email').val();
                            }
                        }
                    },
                },
                'd-password': {
                    required: true,
                    minlength: 4,
                },
                'ulang-password': {
                    required: true,
                    equalTo: '#d-password',
                },
            },
            messages: {
                'd-nama': {
                    required: 'field ini wajib diisi!',
                },
                'd-email': {
                    required: 'field ini wajib diisi!',
                    email: 'wajib menggunakan email valid!',
                    remote: 'email sudah digunakan',
                },
                'd-password': {
                    required: 'field ini wajib diisi!',
                    minlength: 'minimal 4 karakter',
                },
                'ulang-password': {
                    required: 'field ini wajib diisi!',
                    equalTo: 'password tidak sama!',
                },
            },
        });
    });
</script>