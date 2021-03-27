<footer class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
                <p class="copyright-text">Copyright &copy; <?= date('Y')  ?> Lapor-in dan
                    <a rel="nofollow noopener" href="https://templatemo.com">Design oleh TemplateMo</a>
                </p>
                <!-- <h1 class="text-white">We make creative <strong>brands</strong> only.</h1> -->
            </div>

            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <h4 class="my-4">Hubungi Saya</h4>

                <p class="mb-1">
                    <a href="#">
                        <i class="fa fa-envelope mr-2 footer-icon"></i>
                        ahmadfadilah202003@gmail.com
                    </a>
                </p>

                <p>
                    <a href="https://www.instagram.com/ahmdf2_/">
                        <i class="fa fa-instagram mr-2 footer-icon"></i>
                        ahmdf2_
                    </a>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- SCRIPTS -->
<script src="<?= base_url('assets/') ?>js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/') ?>js/bootstrap.min.js"></script>
<script src="<?= base_url('assets/') ?>js/aos.js"></script>
<script src="<?= base_url('assets/') ?>js/owl.carousel.min.js"></script>
<script src="<?= base_url('assets/') ?>js/custom.js"></script>

<script>
    $('#btn-logout').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        Swal.fire({
            icon: 'question',
            title: 'Apakah anda yakin',
            text: 'ingin keluar dari halaman ini?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Batalkan',
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
            }
        });
    });
</script>

</body>

</html>