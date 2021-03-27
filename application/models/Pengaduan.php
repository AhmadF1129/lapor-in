<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaduan extends CI_Model
{
    public function loadPengaduan($query)
    {
        $this->db->select('p.*, u.nama, u.foto');
        $this->db->from('pengaduan p');
        $this->db->join('user u', 'u.id = p.user_id');
        if ($query != '') {
            $this->db->like('p.judul', $query);
            $this->db->or_like('u.nama', $query);
        }
        $this->db->order_by('p.id', 'DESC');
        return $this->db->get();
    }

    public function loadPengaduanOrderById()
    {
        $id = $_POST['dataId'];

        $this->db->select('p.*, u.nama, u.foto');
        $this->db->from('pengaduan p');
        $this->db->join('user u', 'u.id = p.user_id');
        $this->db->where('p.user_id =' . $id);
        $this->db->order_by('p.id', 'DESC');
        return $this->db->get();
    }

    public function loadTanggapan($id)
    {
        $this->db->select('t.*, p.*, u.nama, u.foto, u.role_id');
        $this->db->from('tanggapan t');
        $this->db->join('pengaduan p', 'p.id = t.pengaduan_id');
        $this->db->join('user u', 'u.id = t.petugas_id');
        $this->db->where('t.pengaduan_id =' . $id);
        $this->db->order_by('t.id', 'ASC');
        return $this->db->get();
    }

    public function loadAdmin($query, $dataId)
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

    public function loadPetugas($query)
    {
        $this->db->select('u.*, r.role');
        $this->db->from('user u');
        $this->db->join('role r', 'r.id = u.role_id');
        $this->db->where('u.role_id = 2');
        if ($query != '') {
            $this->db->like('u.nik', $query);
            $this->db->or_like('u.nama', $query);
            $this->db->or_like('u.email', $query);
            $this->db->or_like('u.telp', $query);
        }
        $this->db->order_by('u.id', 'DESC');
        return $this->db->get();
    }

    public function tambah_pengaduan()
    {
        $judul = $this->input->post('judul-post');
        $isi_pengaduan = $this->input->post('isi-post');
        $foto = $_FILES['foto']['name'];

        $data = [];

        if ($foto) {
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '4096';
            $config['upload_path'] = './assets/images/blog/';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $foto_baru = $this->upload->data('file_name');
                $data = [
                    'tgl_pengaduan' => date('Y-m-d'),
                    'user_id' => $this->session->userdata('id'),
                    'judul' => htmlspecialchars($judul),
                    'isi_laporan' => htmlspecialchars($isi_pengaduan),
                    'bukti_foto' => $foto_baru,
                    'status' => 0,
                ];
            }
        }
        $this->db->insert('pengaduan', $data);
    }

    public function edit_pengaduan($id)
    {
        $data = [
            'status' => $this->input->post('cmb-status-pengaduan'),
        ];
        $this->db->where('id', $id)->update('pengaduan', $data);
    }

    public function tambah_tanggapan($id)
    {
        $data = [
            'pengaduan_id' => $id,
            'tgl_tanggapan' => gmdate("Y-m-d H:i:s", time() + 60 * 60 * 7),
            'isi_tanggapan' => $this->input->post('tanggapan'),
            'petugas_id' => $this->session->userdata('id'),
        ];
        $this->db->insert('tanggapan', $data);
    }

    public function getPostRow($id)
    {
        $query = "SELECT p.*, u.`nama`,u.`foto` FROM pengaduan p JOIN user u ON u.`id` = p.`user_id` WHERE p.`id` = " . $id;
        return $this->db->query($query)->row_array();
    }

    public function getAllPostOrderById($id)
    {
        $query = "SELECT p.*, u.* FROM pengaduan p JOIN user u ON u.`id` = p.`user_id` WHERE p.`user_id` = " . $id;
        return $this->db->query($query)->result_array();
    }

    public function cekNIK($tabel, $nik)
    {
        return $this->db->get_where($tabel, ['nik' => $nik])->row_array();
    }

    public function cekEmail($tabel, $email)
    {
        return $this->db->get_where($tabel, ['email' => $email])->row_array();
    }

    public function getAllPost()
    {
        $id = $_POST['dataId'];
        return $this->db->get_where('pengaduan', ['id' => $id])->row_array();
    }
}
