<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

    function __construct(){
        parent::__construct();


        if(!$this->session->userdata('login')){
            redirect('login');
        }

        $this->load->model('Kategori_model');
        $this->load->model('Peminjaman_model');
        $this->load->model('Pengaturan_model');
    }


    public function index(){
        $data['kategori']    = $this->Kategori_model->get();
        $data['logo']        = $this->Pengaturan_model->get('logo');
        $data['notif_count'] = count($this->Peminjaman_model->notifikasi());

        $this->load->view('kategori/index', $data);
    }

    public function tambah(){


        $this->load->library('form_validation');


        $this->form_validation->set_rules(
            'nama_kategori',
            'Nama Kategori',
            'required|is_unique[kategori.nama_kategori]',
            [
                'required'  => 'Nama kategori tidak boleh kosong.',
                'is_unique' => 'Kategori sudah tersedia.'
            ]
        );


        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error', validation_errors());
            redirect('kategori');
        }


        $data = [
            'nama_kategori' => $this->input->post('nama_kategori', true)
        ];


        $this->Kategori_model->insert($data);

        $this->session->set_flashdata('success','Kategori berhasil ditambahkan');
        redirect('kategori');
    }


    public function edit($id){
            $data['notif_count'] = count($this->Peminjaman_model->notifikasi());
    $data['logo']        = $this->Pengaturan_model->get('logo');
        $data['row'] = $this->Kategori_model->edit($id);
        $this->load->view('kategori/edit', $data);
    }


    public function update(){
        $id = $this->input->post('id');

        $data = [
            'nama_kategori' => $this->input->post('nama_kategori')
        ];

        $this->Kategori_model->update($id, $data);
        redirect('kategori');
    }

    public function hapus($id){

        if($this->Kategori_model->dipakai_buku($id) > 0){
            $this->session->set_flashdata('error','Kategori masih digunakan pada data buku.');
            redirect('kategori');
        }

 
        $this->Kategori_model->delete($id);
        $this->session->set_flashdata('success','Kategori berhasil dihapus');
        redirect('kategori');
    }
}