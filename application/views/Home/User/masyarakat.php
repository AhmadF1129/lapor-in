<div id="flash-data" data-flashdata="<?= $this->session->flashdata('flash') ?>"></div>
<!-- BLOG -->
<section class="blog section-padding">
    <div class="container">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari Data Masyarakat" id="cari-masyarakat">
                            <button class="btn btn-success" type="button" id="cari-masyarakat">Cari</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg col-md col-12 mb-4">
                <div id="data-masyarakat"></div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {

        load_data_masyarakat();

        function load_data_masyarakat(query) {
            $.ajax({
                url: '<?= base_url('HomeController/loadDataUser') ?>',
                method: 'POST',
                data: {
                    query: query,
                    dataId: 3,
                },
                success: function(result) {
                    // console.log(result);
                    $('#data-masyarakat').html(result);
                },
                error: function(error) {
                    console.log(error);
                }
            })
        }

        // DATAGRID - SEARCH DATA
        $('#cari-masyarakat').click(function() {
            var search = $('#cari-masyarakat').val();
            if (search != '') {
                load_data_masyarakat(search);
            } else {
                load_data_masyarakat();
            }
        });
    });
</script>