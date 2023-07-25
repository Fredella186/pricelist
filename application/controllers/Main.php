<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{
    public function index()
    {   
        $this->load->model('tabel_model'); // Memuat model User_model
        $data['tb_pricelist'] = $this->tabel_model->getAllDatas(); // Mengambil semua data barang dari model
        $this->load->view('main1/tabel',$data); //untuk mengirimkan data dari $data['tb_pricelist'] dan menampilkannya
    }
}


