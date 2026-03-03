<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggota extends CI_Controller {

    function __construct(){
        parent::__construct();

        if(!$this->session->userdata('login')){
            redirect('login');
        }

        $this->load->model('Anggota_model');
        $this->load->model('Peminjaman_model');
        $this->load->model('Pengaturan_model');

        $this->load->library('form_validation');
        $this->load->library('pagination');
       
    }

    public function index(){

        $q      = $this->input->get('q');
        $kelas  = $this->input->get('kelas');
        $sort   = $this->input->get('sort');

        if(!$sort){
            $sort = 'desc';
        }

       

        $config['base_url'] = base_url('index.php/anggota/index');
        $config['total_rows'] = $this->Anggota_model->count($q,$kelas);
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = TRUE;

        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';

        $config['attributes'] = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        $page  = $this->input->get('page');
        $start = ($page) ? $page : 0;

      

        $data['logo'] = $this->Pengaturan_model->get('logo');
        $data['anggota'] = $this->Anggota_model->get(
            $config['per_page'],
            $start,
            $q,
            $kelas,
            $sort
        );

        $data['pagination'] = $this->pagination->create_links();
        $data['notif_count'] = count($this->Peminjaman_model->notifikasi());
        $data['kelas'] = $this->Anggota_model->kelas();
        $data['sort'] = $sort;

        $this->load->view('anggota/index',$data);
    }

    public function tambah(){

        $this->form_validation->set_rules(
            'nis',
            'NIS',
            'required|is_unique[anggota.nis]'
        );

        $this->form_validation->set_rules('nama','Nama','required');
        $this->form_validation->set_rules('kelas','Kelas','required');

        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error', validation_errors());
            redirect('anggota');
        }

        $data = [
            'nis'    => $this->input->post('nis',true),
            'nama'   => $this->input->post('nama',true),
            'kelas'  => $this->input->post('kelas',true),
            'alamat' => $this->input->post('alamat',true),
            'no_hp'  => $this->input->post('no_hp',true)
        ];

        $this->Anggota_model->insert($data);

        $this->session->set_flashdata('success','Data anggota berhasil ditambahkan');
        redirect('anggota');
    }

    public function edit($id){
            $data['notif_count'] = count($this->Peminjaman_model->notifikasi());
    $data['logo']        = $this->Pengaturan_model->get('logo');
        $data['row'] = $this->Anggota_model->edit($id);
        $this->load->view('anggota/edit',$data);
    }

    public function update(){

        $id = $this->input->post('id');

        $this->form_validation->set_rules('nis','NIS','required');
        $this->form_validation->set_rules('nama','Nama','required');
        $this->form_validation->set_rules('kelas','Kelas','required');

        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error', validation_errors());
            redirect('anggota/edit/'.$id);
        }

        $data = [
            'nis'    => $this->input->post('nis',true),
            'nama'   => $this->input->post('nama',true),
            'kelas'  => $this->input->post('kelas',true),
            'alamat' => $this->input->post('alamat',true),
            'no_hp'  => $this->input->post('no_hp',true)
        ];

        $this->Anggota_model->update($id,$data);

        $this->session->set_flashdata('success','Data anggota berhasil diperbarui');
        redirect('anggota');
    }

    public function hapus($id){

        if($this->Peminjaman_model->cek_by_anggota($id) > 0){
            $this->session->set_flashdata('error','Anggota masih memiliki peminjaman aktif');
            redirect('anggota');
        }

        $this->Anggota_model->delete($id);
        $this->session->set_flashdata('success','Data anggota berhasil dihapus');
        redirect('anggota');
    }

    public function get_by_nis(){
        $nis = $this->input->post('nis',true);
        $data = $this->Anggota_model->by_nis($nis);
        echo json_encode($data);
    }
    public function import_excel(){

    if(isset($_FILES["file"]["name"])){

        $path = $_FILES["file"]["tmp_name"];

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
        $sheet = $spreadsheet->getActiveSheet()->toArray();

        $berhasil = 0;
        $gagal = 0;

        foreach($sheet as $key => $row){

            if($key == 0) continue; 

            $nis    = trim($row[0]);
            $nama   = trim($row[1]);
            $kelas  = trim($row[2]);
            $alamat = trim($row[3]);
            $no_hp  = trim($row[4]);

            if(empty($nis) || empty($nama)){
                $gagal++;
                continue;
            }

            $cek = $this->db->where('nis',$nis)->get('anggota')->row();
            if($cek){
                $gagal++;
                continue;
            }

            $this->db->insert('anggota',[
                'nis'=>$nis,
                'nama'=>$nama,
                'kelas'=>$kelas,
                'alamat'=>$alamat,
                'no_hp'=>$no_hp
            ]);

            $berhasil++;
        }

        $this->session->set_flashdata(
            'success',
            "Import selesai. Berhasil: $berhasil | Gagal/Duplikat: $gagal"
        );

        redirect('anggota');
    }
}
}
