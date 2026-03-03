<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct(){
        parent::__construct();

        if(!$this->session->userdata('login')){
            redirect('login');
        }

        $this->load->model('Dashboard_model');
        $this->load->model('Peminjaman_model');
        $this->load->model('Pengaturan_model'); 
    }


    public function index()
    {


        $data['anggota']    = $this->Dashboard_model->jumlah('anggota');
        $data['buku']       = $this->Dashboard_model->jumlah('buku');
        $data['kategori']   = $this->Dashboard_model->jumlah('kategori');
        $data['pengunjung'] = $this->Dashboard_model->jumlah('pengunjung');

        $data['dipinjam']   = $this->Dashboard_model->dipinjam();
        $data['kembali']    = $this->Dashboard_model->dikembalikan();

        $data['logo']       = $this->Pengaturan_model->get('logo');
        $data['notif_count']= count($this->Peminjaman_model->notifikasi());




        $data['grafik_pengunjung']   = $this->Dashboard_model->grafik_pengunjung();
        $data['grafik_peminjaman']   = $this->Dashboard_model->grafik_peminjaman();
        $data['grafik_pengembalian'] = $this->Dashboard_model->grafik_pengembalian();




        $minggu_ini = $this->db->query("
            SELECT COUNT(*) total 
            FROM pengunjung 
            WHERE YEARWEEK(tanggal)=YEARWEEK(NOW())
        ")->row()->total;

        $minggu_lalu = $this->db->query("
            SELECT COUNT(*) total 
            FROM pengunjung 
            WHERE YEARWEEK(tanggal)=YEARWEEK(NOW()-INTERVAL 1 WEEK)
        ")->row()->total;

        $data['growth_pengunjung'] = ($minggu_lalu == 0)
            ? 0
            : round((($minggu_ini-$minggu_lalu)/$minggu_lalu)*100,1);




        $data['growth_anggota'] = 0;
        $data['anggota_hari']   = 0;




        $data['overdue'] = $this->db
            ->where('status','dipinjam')
            ->where('tanggal_kembali <', date('Y-m-d'))
            ->count_all_results('peminjaman');



        $data['buku_populer'] = $this->db->query("
    SELECT buku.judul, COUNT(*) total
    FROM detail_peminjaman
    JOIN buku ON buku.id_buku=detail_peminjaman.id_buku
    GROUP BY detail_peminjaman.id_buku
    ORDER BY total DESC
    LIMIT 1
")->row();




        $today=date('Y-m-d');

        $data['pinjam_hari'] = $this->db
            ->where('tanggal_pinjam',$today)
            ->count_all_results('peminjaman');

        $data['kembali_hari'] = $this->db
            ->where('tanggal_kembali',$today)
            ->count_all_results('peminjaman');




        $this->load->view('dashboard',$data);
    }

}
