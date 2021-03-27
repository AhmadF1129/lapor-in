<?php
defined('BASEPATH') or exit('No direct script access allowed');
include($_SERVER['DOCUMENT_ROOT'] . '/lapor-in/application/helpers/ChromePhp.php');

class HomeController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Export');
        $this->load->model('Pengaduan');
        $this->load->model('User');
    }

    // LOAD VIEW
    public function index()
    {
        $nama = $this->session->userdata('nama');

        $data['judul'] = 'Lapor-in | Beranda';
        $data['user'] = $this->db->get_where('user', ['nama' => $nama])->row_array();

        $this->load->view('Home/Template/header', $data);
        $this->load->view('Home/index');
        $this->load->view('Home/Template/footer');
    }

    public function user($id)
    {
        $nama = $this->session->userdata('nama');

        $data['judul'] = '';
        if ($id == 1) {
            $data['judul'] = 'Lapor-in | Tabel Admin';
        } elseif ($id == 2) {
            $data['judul'] = 'Lapor-in | Tabel Petugas';
        } else {
            $data['judul'] = 'Lapor-in | Tabel Masyarakat';
        }

        $data['dataId'] = $id;
        $data['user'] = $this->db->get_where('user', ['nama' => $nama])->row_array();

        $this->load->view('Home/Template/header', $data);
        $this->load->view('Home/user');
        $this->load->view('Home/Template/footer');
    }

    public function tabel_pengaduan()
    {
        $nama = $this->session->userdata('nama');

        $data['judul'] = 'Lapor-in | Tabel Pengaduan';
        $data['user'] = $this->db->get_where('user', ['nama' => $nama])->row_array();

        $this->load->view('Home/Template/header', $data);
        $this->load->view('Home/Modal/modal_tabel_pengaduan');
        $this->load->view('Home/tabel_pengaduan');
        $this->load->view('Home/Script/script_tabel_pengaduan');
        $this->load->view('Home/Template/footer');
    }

    // LOAD DATA
    public function loadPengaduan()
    {
        $query = '';
        $output = '';

        if ($this->input->post('query')) {
            $query = $this->input->post('query');
        }

        // DATA
        $data = $this->Pengaduan->loadPengaduan($query);

        if ($data->num_rows() > 0) {
            foreach ($data->result() as $row) {

                if ($row->status == 0) {
                    $status = '<i class="badge badge-secondary">Baru</i>';
                } elseif ($row->status == 1) {
                    $status = '<i class="badge badge-warning">Terverifikasi</i>';
                } elseif ($row->status == 2) {
                    $status = '<i class="badge badge-primary">Diproses</i>';
                } else {
                    $status = '<i class="badge badge-success">Selesai</i>';
                }

                $output .= '
                    <div class="card shadow-lg mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header">
                        <image src="./assets/images/profile/' . $row->foto . '" class="img" style="border-radius: 100px; height: 35px;"><a href="' . base_url('HomeController/detail_user/') . $row->user_id . '" style="margin-left: 5px; font-size: 15px;">' . $row->nama . ' </a>
                    <div class="float-right">
                    ' . $status . '
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

    public function loadTabelPengaduan()
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
        $data = $this->Pengaduan->loadPengaduan($query);
        $i = 1;
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $row) {

                if ($row->status == 0) {
                    $td = '<td><i class="badge badge-secondary">Baru</i><td>';
                } elseif ($row->status == 1) {
                    $td = '<td><i class="badge badge-warning">Terverifikasi</i><td>';
                } elseif ($row->status == 2) {
                    $td = '<td><i class="badge badge-primary">Diproses</i><td>';
                } else {
                    $td = '<td><i class="badge badge-success">Selesai</i><td>';
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
                                        <a href="#edit-pengaduan-modal" data-bs-toggle="modal" id="modal-edit-pengaduan" class="badge badge-warning" data-idpengaduan="' . $row->id . '">
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

    public function loadAdmin()
    {
        $query = '';
        $dataId = '';
        $output = '';

        if ($this->input->post('query') || $this->input->post('dataId')) {
            $query = $this->input->post('query');
            $dataId = $this->input->post('dataId');
        }

        $output .= '
            <div class="table-responsive">
                <table class="table table-hover text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. Telp</th>
                            <th colspan="2">ACTION</th>
                        </tr>
                    </thead>';

        // DATA
        $data = $this->Pengaduan->loadAdmin($query, $dataId);

        $i = 1;

        if ($data->num_rows() > 0) {
            foreach ($data->result() as $row) {
                $output .= '<tbody>
                                <tr>
                                    <td>' . $i++ . '</td>
                                    <td>' . $row->nik . '</td>
                                    <td>' . $row->nama . '</td>
                                    <td>' . $row->email . '</td>
                                    <td>' . $row->telp . '</td>
                                    <td>
                                        <a href="' . base_url('HomeController/detail_user/') . $row->id . '" class="btn btn-primary fa fa-eye">
                                        </a>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning fa fa-edit">
                                        </button>
                                    </td>
                                </tr>
                            </tbody>';
            }
        } else {
            $output .= '<tbody>
                            <tr>
                                <td colspan="12">Data Tidak Ditemukan!!</td>
                            </tr>
                        </tbody>';
        }
        $output .= '
                </table>
                </div>';

        echo $output;
    }

    public function loadPetugas()
    {
        $query = '';
        $output = '';

        if ($this->input->post('query')) {
            $query = $this->input->post('query');
        }

        $output .= '
            <div class="table-responsive">
                <table class="table table-hover text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. Telp</th>
                            <th colspan="2">ACTION</th>
                        </tr>
                    </thead>';

        // DATA
        $data = $this->Pengaduan->loadPetugas($query);

        $i = 1;

        if ($data->num_rows() > 0) {
            foreach ($data->result() as $row) {
                $output .= '<tbody>
                                <tr>
                                    <td>' . $i++ . '</td>
                                    <td>' . $row->nik . '</td>
                                    <td>' . $row->nama . '</td>
                                    <td>' . $row->email . '</td>
                                    <td>' . $row->telp . '</td>
                                    <td>
                                        <a href="' . base_url('HomeController/detail_user/') . $row->id . '" class="btn btn-primary fa fa-eye">
                                        </a>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning fa fa-edit">
                                        </button>
                                    </td>
                                </tr>
                            </tbody>';
            }
        } else {
            $output .= '<tbody>
                            <tr>
                                <td colspan="12">Data Tidak Ditemukan!!</td>
                            </tr>
                        </tbody>';
        }
        $output .= '
                </table>
                </div>';

        echo $output;
    }

    public function loadTanggapan()
    {
        $output = '';
        $id = $_POST['dataId'];

        // DATA
        $data = $this->Pengaduan->loadTanggapan($id);

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
                            <image src="' . base_url('assets/images/profile/') . $row->foto . '" class="img" style="border-radius: 100px; height: 35px;"><a href="' . base_url('HomeController/detail_user/') . $row->user_id . '" style="margin-left: 5px; font-size: 15px;">' . $row->nama . ' </a>
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

    public function loadPengaduanOrderById()
    {
        $output = '';

        // DATA
        $data = $this->Pengaduan->loadPengaduanOrderById();

        if ($data->num_rows() > 0) {
            foreach ($data->result() as $row) {

                if ($row->status == 0) {
                    $status = '<i class="badge badge-secondary float-right">Baru</i>';
                } elseif ($row->status == 1) {
                    $status = '<i class="badge badge-warning float-right">Terverifikasi</i>';
                } elseif ($row->status == 2) {
                    $status = '<i class="badge badge-primary float-right">Diproses</i>';
                } else {
                    $status = '<i class="badge badge-success float-right">Selesai Diproses</i>';
                }

                $output .= '
                    <div class="card shadow-lg mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-body">
                        <h5 class="card-title"><a href="' . base_url('HomeController/detail_pengaduan/') . $row->id . '" style="font-size: 24px;">' . $row->judul . '</a></h5>
                        ' . $status . '
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

    public function cek_nik()
    {
        $tabel = 'user';
        $nik = $_POST['nik'];

        $data = $this->Pengaduan->cekNIK($tabel, $nik);

        if ($data) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    public function cek_email()
    {
        $tabel = 'user';
        $email = $_POST['email'];

        $data = $this->Pengaduan->cekEmail($tabel, $email);

        if ($data) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    public function getAllPost()
    {
        $data['post'] = $this->Pengaduan->getAllPost();
        echo json_encode($data);
    }

    // CRUD
    public function tambah_pengaduan()
    {
        $this->Pengaduan->tambah_pengaduan();
        $this->session->set_flashdata('flash', 'berhasil membuat pengaduan!');
        redirect('HomeController');
    }

    public function edit_pengaduan($id)
    {
        $this->Pengaduan->edit_pengaduan($id);
        $this->session->set_flashdata('flash', 'berhasil merubah status pengaduan!');
        redirect('HomeController/tabel_pengaduan');
    }

    public function detail_pengaduan($id)
    {
        $nama = $this->session->userdata('nama');

        $data['judul'] = 'Lapor-in | Detail Pengaduan';
        $data['post'] = $this->Pengaduan->getPostRow($id);
        $data['user'] = $this->db->get_where('user', ['nama' => $nama])->row_array();

        $this->load->view('Home/Template/header', $data);
        $this->load->view('Home/detail');
        $this->load->view('Home/Template/footer');
    }

    public function detail_user($id)
    {
        $nama = $this->session->userdata('nama');

        $data['judul'] = 'Lapor-in | Detail User';
        $data['user'] = $this->db->get_where('user', ['nama' => $nama])->row_array();
        $data['user_post'] = $this->db->get_where('user', ['id' => $id])->row_array();

        $this->load->view('Home/Template/header', $data);
        $this->load->view('Home/profile');
        $this->load->view('Home/Template/footer');
    }

    public function tambah_data_user()
    {
        $id = $this->input->post('role_id');
        $tabel = 'user';
        $this->User->tambah_admin($tabel, $id);
        $this->session->set_flashdata('flash', 'berhasil menambahkan admin!');
        redirect('HomeController/user/' . $id);
    }

    public function tambah_petugas()
    {
        $tabel = 'user';
        $this->User->tambah_petugas($tabel);
        $this->session->set_flashdata('flash', 'berhasil menambahkan petugas!');
        redirect('HomeController/petugas');
    }

    public function tambah_tanggapan($id)
    {
        $this->Pengaduan->tambah_tanggapan($id);
        $this->session->set_flashdata('flash', 'Tanggapan berhasil ditambahkan!');
        redirect('HomeController/detail_pengaduan/' . $id);
    }

    // EXPORT
    public function getAllUser()
    {
        $data['allUser'] = $this->User->getAllUser();
        echo json_encode($data);
    }

    public function getExportData()
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
