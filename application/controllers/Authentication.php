<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authentication extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function tambah_user()
    {
        $tabel = 'user';
        $token = base64_encode(openssl_random_pseudo_bytes(32));
        // echo $token;
        // die;
        $this->User->tambah_user($tabel, $token);

        $this->_kirim_email($token, 'verify');

        $this->session->set_flashdata('flash', "berhasil membuat akun!\r\n harap segera aktivasi akun!");
        redirect('Authentication');
    }

    private function _kirim_email($token, $type)
    {
        $email = $this->input->post('d-email');
        $config = [
            'protocol'      => 'smtp',
            'smtp_host'     => 'ssl://smtp.googlemail.com',
            'smtp_user'     => 'codecoffee1022021@gmail.com',
            'smtp_pass'     => 'Novita1129',
            'smtp_port'     => 465,
            'mailtype'      => 'html',
            'charset'       => 'utf-8',
            'newline'       => "\r\n"
        ];
        $this->load->library('email', $config);
        $this->email->initialize($config);
        $this->email->from('codecoffee1022021@gmail.com', 'Lapor-in');
        $this->email->to($email);
        if ($type == 'verify') {
            $this->email->subject('Verifikasi Email');
            $this->email->message('Klik link tersebut untuk mengaktifkan user : <a href="' . base_url('Authentication/verify?email=') . $email . '&token=' . urlencode($token) . '">Verifikasi!</a>');
        }

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($user_token) {
                if (time() - $user_token['tgl_dibuat'] < (86400)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('flash',  "Aktivasi " . $email . " berhasil! \r\n silahkan masuk untuk memulai sesi.");
                    redirect('Authentication');
                } else {
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('flash',  "User Aktivasi gagal! masa aktif token habis! \r\n lakukan daftar ulang dan coba lagi!");
                    redirect('Authentication');
                }
            } else {
                $this->session->set_flashdata('flash',  'User Aktivasi gagal! Kesalahan sistem atau token tidak valid!');
                redirect('Authentication');
            }
        } else {
            $this->session->set_flashdata('flash',  'User Aktivasi gagal! Kesalahan sistem atau email tidak valid!');
            redirect('Authentication');
        }
    }

    public function masuk()
    {
        $email = $this->input->post('m-email');
        $password = $this->input->post('m-password');

        $tabel = 'user';

        $user = $this->User->cek_email($tabel, $email);

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
                    redirect('HomeController/masuk');
                }
            } else {
                $this->session->set_flashdata('flash', 'user belum diaktivasi!');
                redirect('HomeController/masuk');
            }
        } else {
            $this->session->set_flashdata('flash', 'user tidak ditemukan!');
            redirect('HomeController/masuk');
        }
    }

    public function cek_nik()
    {
        $tabel = 'user';
        $nik = $_POST['nik'];

        $data = $this->User->cek_nik($tabel, $nik);

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

        $data = $this->User->cek_email($tabel, $email);

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
        redirect('HomeController/masuk');
    }
}
