<?php
defined('BASEPATH') or exit('No direct script access allowed');
include($_SERVER['DOCUMENT_ROOT'] . '/lapor-in/application/helpers/ChromePhp.php');

class TanggapanController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function load_data_tanggapan()
    {
        $output = '';
        $id = $_POST['dataId'];

        // DATA
        $data = $this->Tanggapan->load_data_tanggapan($id);

        if ($data->num_rows() > 0) {
            foreach ($data->result() as $row) {

                if ($row->role_id == 1) {
                    $status = '<i class="text-success">Admin</i>';
                } else {
                    $status = '<i class="text-success">Petugas</i>';
                }

                $output .= '
                    <div class="card mb-4" style="max-width: 50%;" data-aos="fade-up" data-aos-delay="200">
                        <div class="card-header">
                            <image src="' . base_url('assets/images/profile/') . $row->foto . '" class="img" style="border-radius: 100px; height: 35px;"><a href="' . base_url('HomeController/detail_user/') . $row->petugas_id . '" style="margin-left: 5px; font-size: 15px;">' . $row->nama . ' </a>
                            <div class="float-right">
                            <small class="text-secondary" style="margin-right:10px;">' . $row->tgl_tanggapan . '</small>
                            ' . $status . '
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                            <small class="text-muted">' . $row->isi_tanggapan . '</small>
                            </p>
                        </div>
                    </div>
                ';
            }
        } else {
            $output .= '
                <h2 class="text-secondary">Tidak ada Tanggapan</h2>
            ';
        }
        echo $output;
    }

    public function tambah_tanggapan($id)
    {
        $this->Tanggapan->tambah_tanggapan($id);
        $this->session->set_flashdata('flash', 'Tanggapan berhasil ditambahkan!');
        redirect('HomeController/detail_pengaduan/' . $id);
    }
}
