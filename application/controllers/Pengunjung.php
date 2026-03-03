<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengunjung extends CI_Controller {

    public function __construct(){
        parent::__construct();

        if(!$this->session->userdata('login')){
            redirect('login');
        }

        $this->load->model('Pengunjung_model');
        $this->load->model('Peminjaman_model');
        $this->load->model('Pengaturan_model');
    }

    public function index(){

        $filter = $this->input->get('filter');
        $sort   = $this->input->get('sort');

        $data['pengunjung'] = $this->Pengunjung_model
            ->get_pengunjung($filter, $sort);

        $data['logo']        = $this->Pengaturan_model->get('logo');
        $data['notif_count'] = count($this->Peminjaman_model->notifikasi());

        $data['total_hari_ini'] = $this->db
            ->where('DATE(tanggal)', date('Y-m-d'))
            ->count_all_results('pengunjung');

        $start_minggu = date('Y-m-d', strtotime('monday this week'));
        $end_minggu   = date('Y-m-d', strtotime('sunday this week'));

        $data['total_minggu_ini'] = $this->db
            ->where('DATE(tanggal) >=', $start_minggu)
            ->where('DATE(tanggal) <=', $end_minggu)
            ->count_all_results('pengunjung');

        $data['total_bulan_ini'] = $this->db
            ->where('MONTH(tanggal)', date('m'))
            ->where('YEAR(tanggal)', date('Y'))
            ->count_all_results('pengunjung');

        $this->load->view('pengunjung/index', $data);
    }

    public function tambah(){

        $nis = $this->input->post('nis');

        if(!$this->Pengunjung_model->simpan($nis)){
            $this->session->set_flashdata(
                'error',
                'NIS tidak ditemukan atau sudah tercatat hari ini'
            );
        }

        redirect('pengunjung');
    }

    public function ranking(){

        $data['ranking'] = $this->Pengunjung_model->get_ranking();
        $data['logo']    = $this->Pengaturan_model->get('logo');
        $data['notif_count'] = count($this->Peminjaman_model->notifikasi());

        $this->load->view('pengunjung/ranking', $data);
    }

    public function hapus($id)
    {
        if($this->session->userdata('level')!='superadmin'){
            show_404();
        }

        $this->db->where('id_pengunjung',$id);
        $this->db->delete('pengunjung');

        $this->session->set_flashdata('success','Data berhasil dihapus');
        redirect('pengunjung');
    }
}