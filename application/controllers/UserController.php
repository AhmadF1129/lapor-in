<?php
defined('BASEPATH') or exit('No direct script access allowed');
include($_SERVER['DOCUMENT_ROOT'] . '/lapor-in/application/helpers/ChromePhp.php');

class UserController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function load_data_user()
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
        $data = $this->User->load_user_data_order_by_role_id($query, $dataId);

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
                                        <a href="' . base_url('UserController/detail_user/') . $row->id . '" class="btn btn-primary fa fa-eye">
                                        </a>
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

    public function tambah_data_admin()
    {
        $tabel = 'user';
        $this->User->tambah_data_admin($tabel);

        $this->session->set_flashdata('flash', 'Berhasil menambahkan data Admin!');
        redirect('HomeController/data_user/1');
    }

    public function tambah_data_petugas()
    {
        $tabel = 'user';
        $this->User->tambah_data_petugas($tabel);
        $this->session->set_flashdata('flash', 'berhasil menambahkan data Petugas!');
        redirect('HomeController/data_user/2');
    }
}
