<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Model
{
    public function tambah_user($tabel, $token)
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
            'is_active' => 0,
            'dibuat_tgl' => date('Y-m-d'),
        ];
        $user_token = [
            'email' => $email,
            'token' => $token,
            'tgl_dibuat' => time(),
        ];
        $this->db->insert($tabel, $data);
        $this->db->insert('user_token', $user_token);
    }

    public function cek_nik($tabel, $nik)
    {
        return $this->db->get_where($tabel, ['nik' => $nik])->row_array();
    }

    public function cek_email($tabel, $email)
    {
        return $this->db->get_where($tabel, ['email' => $email])->row_array();
    }

    public function tambah_data_admin($tabel)
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
                    'role_id' => 1,
                    'is_active' => 1,
                    'dibuat_tgl' => date('Y-m-d'),
                ];
            }
        }
        $this->db->insert($tabel, $data);
    }

    public function tambah_data_petugas($tabel)
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
                    'role_id' => 2,
                    'is_active' => 1,
                    'dibuat_tgl' => date('Y-m-d'),
                ];
            }
        }
        $this->db->insert($tabel, $data);
    }

    public function load_user_data_order_by_role_id($query, $dataId)
    {
        $this->db->select('u.*, r.role');
        $this->db->from('user u');
        $this->db->join('role r', 'r.id = u.role_id');
        $this->db->where('u.role_id = ' . $dataId);
        if ($query != '') {
            $this->db->like('u.nik', $query);
            $this->db->or_like('u.nama', $query);
            $this->db->or_like('u.email', $query);
            $this->db->or_like('u.telp', $query);
        }
        $this->db->order_by('u.id', 'DESC');
        return $this->db->get();
    }
}
