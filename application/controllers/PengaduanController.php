<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PengaduanController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function load_data_pengaduan()
    {
        $query = '';
        $output = '';

        if ($this->input->post('query')) {
            $query = $this->input->post('query');
        }

        // DATA
        $data = $this->Pengaduan->load_data_pengaduan($query);

        if ($data->num_rows() > 0) {
            foreach ($data->result() as $row) {

                if ($row->status == 0) {
                    $status = '<small class="text-secondary">Baru</small>';
                } elseif ($row->status == 1) {
                    $status = '<small class="text-warning">Terverifikasi</small>';
                } elseif ($row->status == 2) {
                    $status = '<small class="text-primary">Diproses</small>';
                } else {
                    $status = '<small class="text-success">Selesai</small>';
                }
                if ($this->session->userdata('id') == $row->user_id) {
                    $edit = '<a href="HomeController/edit_pengaduan/' . $row->id . '" class="badge badge-warning" style="margin-left: 10px;"><i class="fa fa-edit"></i></a>';
                } else {
                    $edit = '';
                }

                $output .= '
                    <div class="card shadow-lg mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header">
                        <image src="./assets/images/profile/' . $row->foto . '" class="img" style="border-radius: 100px; height: 35px;"><a href="' . base_url('UserController/detail_user/') . $row->user_id . '" style="margin-left: 5px; font-size: 15px;">' . $row->nama . ' </a>
                    <div class="float-right">
                    ' . $status . $edit . '
                    </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><a href="' . base_url('HomeController/detail_pengaduan/') . $row->id . '" style="font-size: 24px;">' . $row->judul . '</a></h5>
                        <p class="card-text">
                        <small class="text-muted">Dibuat tanggal ' . $row->tgl_pengaduan . '</small>
                        </p>
                        </div>
                        <img src="./assets/images/blog/' . $row->bukti_foto . '" class="card-img-top">
                    </div>
                ';
            }
        } else {
            $output .= '
                <h2 class="text-secondary">Tidak ada Pengaduan</h2>
            ';
        }
        echo $output;
    }

    public function tambah_pengaduan()
    {
        $this->Pengaduan->tambah_pengaduan();
        $this->session->set_flashdata('flash', 'berhasil membuat pengaduan!');
        redirect('HomeController');
    }

    public function edit_status_pengaduan($id)
    {
        $this->Pengaduan->edit_status_pengaduan($id);
        $this->session->set_flashdata('flash', 'berhasil merubah status pengaduan!');
        redirect('HomeController/tabel_pengaduan');
    }

    public function edit_pengaduan($id)
    {
        $this->Pengaduan->edit_pengaduan($id);
        $this->session->set_flashdata('flash', 'berhasil merubah data pengaduan!');
        redirect('HomeController');
    }

    public function load_data_tabel_pengaduan()
    {
        $query = '';
        $output = '';

        if ($this->input->post('query')) {
            $query = $this->input->post('query');
        }

        // Tabel Header
        $output .= '
            <div class="table-responsive">
                <table class="table table-hover text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Tanggal Pengaduan</th>
                            <th>Judul Pengaduan</th>
                            <th>Nama Pengadu</th>
                            <th>Status</th>
                            <th colspan="4">ACTION</th>
                        </tr>
                    </thead>';

        // DATA
        $data = $this->Pengaduan->load_data_pengaduan($query);
        $i = 1;
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $row) {

                if ($row->status == 0) {
                    $td = '<td><small class="text-secondary">Baru</small><td>';
                } elseif ($row->status == 1) {
                    $td = '<td><small class="text-warning">Terverifikasi</small><td>';
                } elseif ($row->status == 2) {
                    $td = '<td><small class="text-primary">Diproses</small><td>';
                } else {
                    $td = '<td><small class="text-success">Selesai</small><td>';
                }

                $output .= '<tbody>
                                <tr>
                                    <td>' . $i++ . '</td>
                                    <td>' . $row->tgl_pengaduan . '</td>
                                    <td>' . $row->judul . '</td>
                                    <td>' . $row->nama . '</td>
                                    ' . $td . '
                                    <td>
                                        <a href="' . base_url('HomeController/detail_pengaduan/') . $row->id . '" class="badge badge-primary">
                                        Detail
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#edit-pengaduan-modal" data-bs-toggle="modal" id="modal-edit-pengaduan" class="badge badge-warning" data-id-pengaduan="' . $row->id . '">
                                        Edit
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="badge badge-danger">
                                        Hapus
                                        </a>
                                    </td>
                                </tr>
                            </tbody>';
            }
        } else {
            $output .= '<tbody>
                            <tr>
                                <td colspan="8">Data Tidak Ditemukan!!</td>
                            </tr>
                        </tbody>';
        }
        $output .= '
                </table>
                </div>';

        echo $output;
    }

    public function load_data_pengaduan_order_by_user()
    {
        $output = '';

        // DATA
        $data = $this->Pengaduan->load_data_pengaduan_order_by_user();

        if ($data->num_rows() > 0) {
            foreach ($data->result() as $row) {

                if ($row->status == 0) {
                    $status = '<small class="text-secondary" style="font-size: 12px;">Baru</small>';
                } elseif ($row->status == 1) {
                    $status = '<small class="text-warning" style="font-size: 12px;">Terverifikasi</small>';
                } elseif ($row->status == 2) {
                    $status = '<small class="text-primary" style="font-size: 12px;">Diproses</small>';
                } else {
                    $status = '<small class="text-success" style="font-size: 12px;">Selesai Diproses</small>';
                }
                if ($this->session->userdata('id') == $row->user_id) {
                    $edit = '<a href="#" class="text-warning" style="margin-left: 15px; font-size: 12px;"><i class="fa fa-edit"></i></a>';
                } else {
                    $edit = '';
                }

                $output .= '
                    <div class="card shadow-lg mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-body">
                        <h5 class="card-title"><a href="' . base_url('HomeController/detail_pengaduan/') . $row->id . '">' . $row->judul . '</a>
                        <div class="float-right">
                        ' . $status . $edit . '
                        </div>
                        </h5>
                        <p class="card-text">
                        <small class="text-muted">Dibuat tanggal ' . $row->tgl_pengaduan . '</small>
                        </p>
                        </div>
                        <img src="' . base_url('assets/images/blog/') . $row->bukti_foto . '" class="card-img-top">
                    </div>
                ';
            }
        } else {
            $output .= '
                <h2 class="text-secondary">Tidak memiliki pengaduan</h2>
            ';
        }
        echo $output;
    }

    public function get_export_data()
    {
        // GET POST REQUEST
        $mode = $_POST['checkMode']; // Export Format => pdf | xls

        $timeLine = $_POST['whereTimeLine'];  // Bulan | Tahun
        $timeLine_Value = $_POST['valueTimeLine'];

        // PAGE INFO
        $data['jenisLayanan'] = 'LAPORAN DATA PENGADUAN';
        $data['padaWaktu'] = $timeLine . ' @ ' . $timeLine_Value; // Bulan : 2019-02 | Tahun = 2019

        // TABLE FIELDS
        $data['tableFields'] = [
            'pdf' => [
                ['Name' => 'NO', 'Width' => '3%'],
                ['Name' => 'TANGGAL PENGADUAN', 'Width' => '15%'],
                ['Name' => 'JUDUL PENGADUAN', 'Width' => '40%'],
                ['Name' => 'NAMA PENGADU', 'Width' => '32%'],
                ['Name' => 'STATUS', 'Width' => '10%'],
            ],
            'xls' => [
                ['Name' => 'NO', 'CellPos' => 'A10', 'ColPos' => 'A', 'ColWidth' => '4'],
                ['Name' => 'TANGGAL PENGADUAN', 'CellPos' => 'B10', 'ColPos' => 'B', 'ColWidth' => '40'],
                ['Name' => 'JUDUL PENGADUAN', 'CellPos' => 'C10', 'ColPos' => 'C', 'ColWidth' => '100'],
                ['Name' => 'NAMA PENGADU', 'CellPos' => 'D10', 'ColPos' => 'D', 'ColWidth' => '50'],
                ['Name' => 'STATUS', 'CellPos' => 'E10', 'ColPos' => 'E', 'ColWidth' => '20'],
            ]
        ];

        // TABLE DATA
        $queryResult = $this->Export->getExportData($timeLine, $timeLine_Value);

        $tableData = $mode == 'pdf' ? '' : [];

        // For XLS Init Only
        if ($mode == 'xls') {
            $colPos = [];
            $charStart = 'A'; // Column Start Init
            $charLen = count($data['tableFields']['xls']); // Qty of Column
            for ($i = 0; $i < $charLen; $i++) array_push($colPos, $charStart++);
            $rowPos = 11; // Row Start Init
        }

        $i = 1;
        foreach ($queryResult as $dt) {
            if ($dt['status'] == 0) {
                $status = 'Baru';
            } elseif ($dt['status'] == 1) {
                $status = 'Terverifikasi';
            } elseif ($dt['status'] == 2) {
                $status = 'Sedang Diproses';
            } else {
                $status = 'Selesai Diproses';
            }

            if ($mode == 'pdf') {
                $tableData .= '
                <tr  bgcolor="#fff" color="#000">
                    <td align="center">' . $i++ . '</td>
                    <td>' . $dt['tgl_pengaduan'] . '</td>
                    <td>' . $dt['judul'] . '</td>
                    <td>' . $dt['nama'] . '</td>
                    <td>' . $status . '</td>
                </tr>';
            } else {
                array_push($tableData, [
                    'colPos' => $colPos,
                    'rowPos' => $rowPos,
                    'contentData' => [
                        $i++,
                        date(
                            'j F Y',
                            strtotime($dt['tgl_pengaduan'])
                        ),
                        $dt['judul'],
                        $dt['nama'],
                        $status,
                    ]
                ]);
            }
        }
        $data['tableData'] = $tableData;

        // SEND RESPONSE BACK
        echo json_encode($data);
    }
}
