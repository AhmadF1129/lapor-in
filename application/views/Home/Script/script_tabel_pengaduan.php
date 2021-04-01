<script>
    $(document).ready(function() {

        load_data_pengaduan();

        function load_data_pengaduan(query) {
            $.ajax({
                url: '<?= base_url('PengaduanController/load_data_tabel_pengaduan') ?>',
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

        document.querySelectorAll('.time-line').forEach((radio, id) => {
            radio.addEventListener('click', () => {
                radio.childNodes[2].checked = false;
                let select = id == 0 ? 'Tahun' : 'Bulan';
                let disabled = id == 0 ? 'Bulan' : 'Tahun';
                document.querySelector(`#radio${select}`).checked = false;
                radioTimeLineIsDisabled(`#radio${select}`, `#radio${disabled}`, 3);
            });
        });

        radioTimeLineIsDisabled = (param1, param2, child) => {
            document.querySelectorAll(param1).forEach(() => {
                document.querySelector(param1).parentNode.parentNode.parentNode.childNodes[child].disabled = true;
                document.querySelector(param2).parentNode.parentNode.parentNode.childNodes[child].disabled = false;
            });
        }

        $.fn.exportData = function(format) {
            // TIME LINE
            const radioBulan = document.querySelector('#radioBulan');
            let whereTimeLine = '',
                valueTimeLine = '';
            if (radioBulan.checked) { // BULAN
                whereTimeLine = 'Bulan';
                valueTimeLine = $('#cmb-bulan').children("option:selected").val();
            } else { // TAHUN
                whereTimeLine = 'Tahun';
                valueTimeLine = $('#cmb-tahun').children("option:selected").val();
            }

            // EXECUTE
            $.ajax({ // AJAX 1 => GET DATA
                type: 'POST',
                url: '<?= base_url('PengaduanController/get_export_data') ?>', // PengaduanController
                dataType: 'JSON',
                async: false,
                data: { // REQUEST_1
                    checkMode: format,
                    whereTimeLine: whereTimeLine,
                    valueTimeLine: valueTimeLine
                },
                success: function(res1) { // RESPONSE_1
                    // console.log(res1);

                    let pathURL = format == 'pdf' ? '<?= base_url('ExportController/export_pdf'); ?>' : '<?= base_url('ExportController/export_xls'); ?>'

                    $.ajax({ // AJAX 2 => CREATE REPORT
                        type: 'POST',
                        url: pathURL, // cExport
                        dataType: 'JSON',
                        async: false,
                        data: { // REQUEST_2
                            jenisLayanan: res1.jenisLayanan,
                            padaWaktu: res1.padaWaktu,
                            tableFields: res1.tableFields,
                            tableData: res1.tableData
                        },
                        success: function(res2) { // RESPONSE_2
                            console.log(res2);
                            if (res2.mode == 'pdf') { // PDF
                                if (res2.url) {
                                    window.open(res2.url)
                                };
                            } else { // XLS
                                if (res2.file) {
                                    window.open(res2.file);
                                }
                            }
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });

                },
                error: function(err) {
                    console.log(err);
                }
            });
        }

        $('#edit-pengaduan-modal').on('show.bs.modal', function(e) {
            const dataId = $(e.relatedTarget).data('id-pengaduan');
            $('#form-edit-pengaduan').removeAttr('action');
            $('#form-edit-pengaduan').attr('action', '<?= base_url('PengaduanController/edit_status_pengaduan/') ?>' + dataId);
            // $.ajax({
            //     type: 'POST',
            //     url: '</?= base_url('HomeController/getAllPost') ?>',
            //     dataType: 'JSON',
            //     data: {
            //         dataId: dataId,
            //     },
            //     success: function(result) {
            //         // console.log(result)
            //         $('#form-edit-pengaduan').removeAttr('action');
            // $('#form-edit-pengaduan').attr('action', '</?= base_url('HomeController/edit_pengaduan/') ?>' + result.post.id);
            //     }
            // });
        })

    })
</script>