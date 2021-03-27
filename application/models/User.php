<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Model
{
    public function tambah_user($tabel)
    {
        $nama = $this->input->post('d-nama');
        $email = $this->input->post('d-email');
        $password = $this->input->post('d-password');

        $data = [
            'nama' => htmlspecialchars($nama),
            'email' => htmlspecialchars($email),
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'foto' => 'default.jpg',
            'role_id' => 3,
            'is_active' => 1,
            'dibuat_tgl' => date('Y-m-d'),
        ];

        $this->db->insert($tabel, $data);
    }

    public function cekUser($tabel, $email)
    {
        return $this->db->get_where($tabel, ['email' => $email])->row_array();
    }

    public function tambah_admin($tabel, $id)
    {
        $nik = $this->input->post('nik');
        $nama = $this->input->post('nama');
        $email = $this->input->post('email');
        $telp = $this->input->post('telp');
        $password = $this->input->post('password');
        $foto = $_FILES['foto']['name'];

        $data = [];

        if ($foto) {
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '4096';
            $config['upload_path'] = './assets/images/profile/';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $foto_baru = $this->upload->data('file_name');

                $data = [
                    'nik' => htmlspecialchars($nik),
                    'nama' => htmlspecialchars($nama),
                    'email' => htmlspecialchars($email),
                    'telp' => htmlspecialchars($telp),
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'foto' => $foto_baru,
                    'role_id' => $id,
                    'is_active' => 1,
                    'dibuat_tgl' => date('Y-m-d'),
                ];
            }
        }
        $this->db->insert($tabel, $data);
    }

    public function tambah_petugas($tabel)
    {
        $nik = $this->input->post('nik-petugas');
        $nama = $this->input->post('nama-petugas');
        $email = $this->input->post('email-petugas');
        $telp = $this->input->post('telp-petugas');
        $password = $this->input->post('password-petugas');
        $foto = $_FILES['foto']['name'];

        $data = [];

        if ($foto) {
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '4096';
            $config['upload_path'] = './assets/images/profile/';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $foto_baru = $this->upload->data('file_name');

                $data = [
                    'nik' => htmlspecialchars($nik),
                    'nama' => htmlspecialchars($nama),
                    'email' => htmlspecialchars($email),
                    'telp' => htmlspecialchars($telp),
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'foto' => $foto_baru,
                    'role_id' => 2,
                    'is_active' => 1,
                    'dibuat_tgl' => date('Y-m-d'),
                ];
            }
        }
        $this->db->insert($tabel, $data);
    }

    // EXPORT
    public function getAllUser()
    {
        return $this->db->get_where('user', ['role_id' => 3])->result_array();
    }
}
