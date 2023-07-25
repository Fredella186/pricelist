<?php
class Tabel_model extends CI_Model {
    public function getAllDatas() {
        $query = $this->db->get('tb_pricelist'); // Mengambil semua data dari tabel 'tb_pricelist'
        return $query->result(); // Mengembalikan hasil dalam bentuk array
    }
}
?>