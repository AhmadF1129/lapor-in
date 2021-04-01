<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaduan extends CI_Model
{
    public function load_data_pengaduan($query)
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

    public function load_data_pengaduan_order_by_user()
    {
        $id = $_POST['dataId'];

        $this->db->select('p.*, u.nama, u.foto');
        $this->db->from('pengaduan p');
        $this->db->join('user u', 'u.id = p.user_id');
        $this->db->where('p.user_id =' . $id);
        $this->db->order_by('p.id', 'DESC');
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

    public function data_pengaduan_order_by_id($id)
    {
        $this->db->select('p.*, u.nama, u.foto');
        $this->db->from('pengaduan p');
        $this->db->join('user u', 'u.id = p.user_id');
        $this->db->where('p.id', $id);
        return $this->db->get()->row_array();
        // $query = "SELECT p.*, u.`nama`,u.`foto` FROM pengaduan p JOIN user u ON u.`id` = p.`user_id` WHERE p.`id` = " . $id;
        // return $this->db->query($query)->row_array();
    }
}
