<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Export extends CI_Model
{
    public function getExportData($timeLine, $timeLine_Value)
    {
        $query = '';
        if ($timeLine == 'Bulan') {
            $query =
                "SELECT p.*, u.* FROM pengaduan p
                   JOIN user u
                     ON u.id = p.user_id
                  WHERE SUBSTR(p.tgl_pengaduan, 1, 7) = '$timeLine_Value'";
        } else {
            $query =
                "SELECT p.*, u.* FROM pengaduan p
                   JOIN user u
                     ON u.id = p.user_id
                  WHERE SUBSTR(p.tgl_pengaduan, 1, 4) = '$timeLine_Value'";
        }
        return $this->db->query($query)->result_array();
    }
}
