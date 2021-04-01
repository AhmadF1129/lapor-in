<?php
defined('BASEPATH') or exit('No direct script access allowed');
include($_SERVER['DOCUMENT_ROOT'] . '/lapor-in/application/helpers/ChromePhp.php');

class HomeController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    // LOAD VIEW
    public function index()
    {
        $nama = $this->session->userdata('nama');

        $data['judul'] = '';

        if ($this->session->userdata('role_id') == null) {
            $data['judul'] = 'Lapor-in';
        } elseif ($this->session->userdata('role_id') == 1) {
            $data['judul'] = 'Lapor-in | Admin';
        } elseif ($this->session->userdata('role_id') == 2) {
            $data['judul'] = 'Lapor-in | Petugas';
        } else {
            $data['judul'] = 'Lapor-in';
        }

        $data['user'] = $this->db->get_where('user', ['nama' => $nama])->row_array();

        $this->load->view('Home/Template/header', $data);
        $this->load->view('Home/index');
        $this->load->view('Home/Template/footer');
    }

    public function masuk()
    {
        $data['judul'] = "Lapor-in | Masuk";

        $this->load->view('Auth/Template/header', $data);
        $this->load->view('Auth/login');
        $this->load->view('Auth/Template/footer');
    }

    public function daftar()
    {
        $data['judul'] = "Lapor-in | Daftar";

        $this->load->view('Auth/Template/header', $data);
        $this->load->view('Auth/daftar');
        $this->load->view('Auth/Template/footer');
    }

    public function data_user($id)
    {
        $nama = $this->session->userdata('nama');
        $data['judul'] = '';
        $data['dataId'] = '';
        if ($id == 1) {
            $data['judul'] = 'Lapor-in | Data Admin';
            $data['dataId'] = 1;
        } elseif ($id == 2) {
            $data['judul'] = 'Lapor-in | Data Petugas';
            $data['dataId'] = 2;
        } else {
            $data['judul'] = 'Lapor-in | Data Masyarakat';
            $data['dataId'] = 3;
        }

        $data['user'] = $this->db->get_where('user', ['nama' => $nama])->row_array();

        if ($id == 1) {
            $this->load->view('Home/Template/header', $data);
            $this->load->view('Home/User/admin');
            $this->load->view('Home/Template/footer');
        } elseif ($id == 2) {
            $this->load->view('Home/Template/header', $data);
            $this->load->view('Home/User/petugas');
            $this->load->view('Home/Template/footer');
        } else {
            $this->load->view('Home/Template/header', $data);
            $this->load->view('Home/User/masyarakat');
            $this->load->view('Home/Template/footer');
        }
    }

    // public function detail_user($id)
    // {
    //     $nama = $this->session->userdata('nama');

    //     $data['judul'] = 'Lapor-in | Detail User';
    //     $data['user'] = $this->db->get_where('user', ['nama' => $nama])->row_array();
    //     $data['user_post'] = $this->db->get_where('user', ['id' => $id])->row_array();

    //     $this->load->view('Home/Template/header', $data);
    //     $this->load->view('Home/profile');
    //     $this->load->view('Home/Template/footer');
    // }

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

    public function detail_pengaduan($id)
    {
        $nama = $this->session->userdata('nama');

        $data['judul'] = 'Lapor-in | Detail Pengaduan';
        $data['post'] = $this->Pengaduan->data_pengaduan_order_by_id($id);
        $data['user'] = $this->db->get_where('user', ['nama' => $nama])->row_array();

        $this->load->view('Home/Template/header', $data);
        $this->load->view('Home/detail');
        $this->load->view('Home/Template/footer');
    }

    public function tambah_pengaduan()
    {
        $nama = $this->session->userdata('nama');

        $data['judul'] = '';

        if ($this->session->userdata('role_id') == null) {
            $data['judul'] = 'Lapor-in';
        } elseif ($this->session->userdata('role_id') == 1) {
            $data['judul'] = 'Lapor-in | Admin';
        } elseif ($this->session->userdata('role_id') == 2) {
            $data['judul'] = 'Lapor-in | Petugas';
        } else {
            $data['judul'] = 'Lapor-in';
        }

        $data['user'] = $this->db->get_where('user', ['nama' => $nama])->row_array();

        $this->load->view('Home/Template/header', $data);
        $this->load->view('Home/tambah_pengaduan');
        $this->load->view('Home/Template/footer');
    }

    public function edit_pengaduan($id)
    {
        $nama = $this->session->userdata('nama');

        $data['judul'] = '';

        if ($this->session->userdata('role_id') == null) {
            $data['judul'] = 'Lapor-in';
        } elseif ($this->session->userdata('role_id') == 1) {
            $data['judul'] = 'Lapor-in | Admin';
        } elseif ($this->session->userdata('role_id') == 2) {
            $data['judul'] = 'Lapor-in | Petugas';
        } else {
            $data['judul'] = 'Lapor-in';
        }

        $data['user'] = $this->db->get_where('user', ['nama' => $nama])->row_array();
        $data['pengaduan'] = $this->Pengaduan->data_pengaduan_order_by_id($id);

        $this->load->view('Home/Template/header', $data);
        $this->load->view('Home/edit_pengaduan');
        $this->load->view('Home/Template/footer');
    }
}
