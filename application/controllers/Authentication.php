<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authentication extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
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

    public function tambah_user()
    {
        $tabel = 'user';
        $this->User->tambah_user($tabel);
        $this->session->set_flashdata('flash', 'berhasil membuat akun!');
        redirect('Authentication');
    }

    public function masuk()
    {
        $email = $this->input->post('m-email');
        $password = $this->input->post('m-password');

        $tabel = 'user';

        $user = $this->User->cekUser($tabel, $email);

        if ($user) {
            $data = [
                'id' => $user['id'],
                'nama' => $user['nama'],
                'role_id' => $user['role_id'],
            ];
            if ($user['is_active'] == 1) {
                if (password_verify($password, $user['password'])) {
                    $this->session->set_userdata($data);
                    $this->session->set_flashdata('flash', 'anda berhasil login!');
                    redirect('HomeController');
                } else {
                    $this->session->set_flashdata('flash', 'password salah!');
                    redirect('Authentication');
                }
            } else {
                $this->session->set_flashdata('flash', 'user belum diaktivasi!');
                redirect('Authentication');
            }
        } else {
            $this->session->set_flashdata('flash', 'user tidak ditemukan!');
            redirect('Authentication');
        }
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
        exit;
    }


    public function cek_email()
    {
        $tabel = 'user';
        $email = $_POST['email'];

        $data = $this->User->cekUser($tabel, $email);

        if ($data) {
            echo 'false';
        } else {
            echo 'true';
        }
        exit;
    }

    public function logout()
    {
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('flash', 'anda berhasil logout!');
        redirect('Authentication');
    }
}
