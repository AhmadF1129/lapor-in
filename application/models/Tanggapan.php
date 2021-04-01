<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tanggapan extends CI_Model
{
    public function load_data_tanggapan($id)
    {
        $this->db->select('t.*, p.*, u.nama, u.foto, u.role_id');
        $this->db->from('tanggapan t');
        $this->db->join('pengaduan p', 'p.id = t.pengaduan_id');
        $this->db->join('user u', 'u.id = t.petugas_id');
        $this->db->where('t.pengaduan_id =' . $id);
        $this->db->order_by('t.id', 'ASC');
        return $this->db->get();
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
}
