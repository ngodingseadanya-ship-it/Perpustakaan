<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi extends CI_Controller {

    function __construct(){
        parent::__construct();

        
        if(!$this->session->userdata('login')){
            redirect('login');
        }
        $this->load->model('Peminjaman_model');
        $this->load->model('Pengaturan_model');
    }

    public function index(){
        $data['notif'] = $this->Peminjaman_model->notifikasi();
        $data['notif_count'] = count($data['notif']);
        $data['logo'] = $this->Pengaturan_model->get('logo');
        $this->load->view('notifikasi/index', $data);
    }
}