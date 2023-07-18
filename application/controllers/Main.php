<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{
    public function index()
    {
        $this->load->view('main1/tabel');

    }


}
