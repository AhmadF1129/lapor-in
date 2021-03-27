<!-- MODAL - EXPORT -->
<div class="modal fade" id="modal-export-pengaduan" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">TIME LINE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- TIME LINE -->
                <div id="divTimeLine" class="form-group">
                    <!-- BULAN -->
                    <div class="form-group mt-3">
                        <div class="form-row">
                            <div class="col-3">
                                <div class="custom-control custom-radio time-line">
                                    <input type="radio" class="custom-control-input" id="radioBulan" checked>
                                    <label class="custom-control-label" for="radioBulan">Bulan</label>
                                </div>
                            </div>
                            <select id="cmb-bulan" name="cmb-bulan" class="form-control custom-select col-8">
                                <?php
                                $currentYear = date('Y');
                                $arrMonth = [
                                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                                ];
                                for ($i = 0; $i < 12; $i++) {
                                    echo '<option value="' . $currentYear . '-' . str_pad(($i + 1), 2, 0, STR_PAD_LEFT) . '">' . $arrMonth[$i] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- TAHUN -->
                    <div class="form-group mt-3">
                        <div class="form-row">
                            <div class="col-3">
                                <div class="custom-control custom-radio time-line">
                                    <input type="radio" class="custom-control-input" id="radioTahun">
                                    <label class="custom-control-label" for="radioTahun">Tahun</label>
                                </div>
                            </div>
                            <select id="cmb-tahun" name="cmb-tahun" class="form-control custom-select col-8" disabled>
                                <?php
                                $starting_year = date('Y', strtotime('-5 year'));
                                $curentYear = date('Y');
                                for ($curentYear; $curentYear >= $starting_year; $curentYear--) {
                                    echo '<option value="' . $curentYear . '">' . $curentYear . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button class="btn btn-success" onclick="$(this).exportData('xls');">Excel</button> -->
                <button class="btn btn-danger" onclick="$(this).exportData('pdf');">PDF</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="edit-pengaduan-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Pengaduan</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form-edit-pengaduan">
                    <div class="form-group mb-4">
                        <label for="cmb-status-pengaduan" style="font-size: 16px;">Edit Status</label>
                        <select id="cmb-status-pengaduan" name="cmb-status-pengaduan" class="form-control">
                            <option value="1">Varifikasi</option>
                            <option value="2">Proses</option>
                            <option value="3">Selesai Proses</option>
                        </select>
                    </div>

                    <div class="float-right">
                        <button type="submit" class="btn btn-success">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>