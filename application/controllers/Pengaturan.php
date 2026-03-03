<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if(!$this->session->userdata('login')){
            redirect('login');
        }

        $this->load->model('Peminjaman_model');
        $this->load->model('Pengaturan_model');
    }

    public function index()
    {
        $data['notif_count'] = count($this->Peminjaman_model->notifikasi());
        $data['logo']        = $this->Pengaturan_model->get('logo');

        $setting = $this->db->get('pengaturan')->result();

        $pengaturan = [];
        foreach($setting as $s){
            $pengaturan[$s->nama_pengaturan] = $s->nilai;
        }

        $data['notif_hari'] = $pengaturan['notif_hari'] ?? 3;

        $this->load->view('pengaturan/index', $data);
    }

    public function logo()
    {
        $data['logo']        = $this->Pengaturan_model->get('logo');
        $data['notif_count'] = count($this->Peminjaman_model->notifikasi());

        $this->load->view('pengaturan/logo', $data);
    }

    public function upload_logo()
    {
        $config['upload_path']   = './assets/logo/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;
        $config['file_name']     = 'logo_'.time();

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('logo')){
            $this->session->set_flashdata('error', $this->upload->display_errors());
        } else {
            $file = $this->upload->data('file_name');
            $this->Pengaturan_model->update('logo', $file);

            $this->session->set_flashdata('success','Logo berhasil diperbarui');
        }

        redirect('pengaturan/logo');
    }

    public function notifikasi()
    {
        $data['notif_count'] = count($this->Peminjaman_model->notifikasi());
        $data['logo']        = $this->Pengaturan_model->get('logo');

        $setting = $this->db
            ->where('nama_pengaturan','notif_hari')
            ->get('pengaturan')
            ->row();

        $data['notif_hari'] = $setting ? $setting->nilai : 3;

        $this->load->view('pengaturan/notifikasi', $data);
    }

    public function update_notifikasi()
    {
        $hari = $this->input->post('notif_hari');

        $this->db->where('nama_pengaturan','notif_hari')
                 ->update('pengaturan', ['nilai' => $hari]);

        $this->session->set_flashdata('success','Notifikasi berhasil diperbarui');
        redirect('pengaturan/notifikasi');
    }

    public function lama_pinjam()
    {
        $data['notif_count'] = count($this->Peminjaman_model->notifikasi());
        $data['logo']        = $this->Pengaturan_model->get('logo');

        $data['lama'] = $this->db
            ->get_where('pengaturan',['nama_pengaturan'=>'lama_pinjam'])
            ->row()->nilai;

        $this->load->view('pengaturan/lama_pinjam', $data);
    }

    public function update_lama_pinjam()
    {
        $hari = $this->input->post('lama');

        $this->db->where('nama_pengaturan','lama_pinjam')
                 ->update('pengaturan',['nilai'=>$hari]);

        $this->session->set_flashdata('success','Durasi peminjaman berhasil diperbarui');

        redirect('pengaturan/lama_pinjam');
    }

    public function denda()
    {
        $data['notif_count'] = count($this->Peminjaman_model->notifikasi());
        $data['logo']        = $this->Pengaturan_model->get('logo');

        $data['status']  = $this->Pengaturan_model->get('denda_status');
        $data['nominal'] = $this->Pengaturan_model->get('denda_per_hari');

        $this->load->view('pengaturan/denda', $data);
    }

    public function update_denda()
    {
        $status  = $this->input->post('status');
        $nominal = $this->input->post('nominal');

        $status_lama = $this->Pengaturan_model->get('denda_status');

        $this->db->where('nama_pengaturan','denda_status')
                 ->update('pengaturan',['nilai'=>$status]);

        $this->db->where('nama_pengaturan','denda_per_hari')
                 ->update('pengaturan',['nilai'=>$nominal]);

        if($status_lama == 'on' && $status == 'off'){
            $this->session->set_flashdata('warning',
                '⚠ Denda berhasil dinonaktifkan. Kolom denda tidak akan tampil di transaksi.');
        }
        elseif($status_lama == 'off' && $status == 'on'){
            $this->session->set_flashdata('success',
                '✅ Denda berhasil diaktifkan kembali.');
        }
        else{
            $this->session->set_flashdata('success','Pengaturan denda diperbarui.');
        }

        redirect('pengaturan/denda');
    }

    public function max_pinjam()
    {
        $data['notif_count'] = count($this->Peminjaman_model->notifikasi());
        $data['logo']        = $this->Pengaturan_model->get('logo');

        $data['max'] = $this->Pengaturan_model->get('max_pinjam');

        if(!$data['max']) $data['max'] = 4;

        $this->load->view('pengaturan/max_pinjam', $data);
    }

    public function update_max_pinjam()
    {
        $max = $this->input->post('max');

        $this->db->where('nama_pengaturan','max_pinjam')
                 ->update('pengaturan',['nilai'=>$max]);

        $this->session->set_flashdata('success','Maksimal pinjam berhasil diperbarui');

        redirect('pengaturan/max_pinjam');
    }

    public function sidebar()
    {
        $data['notif_count'] = count($this->Peminjaman_model->notifikasi());
        $data['logo']        = $this->Pengaturan_model->get('logo');

        $order = [
            'menu_dashboard',
            'menu_anggota',
            'menu_kategori',
            'menu_buku',
            'menu_peminjaman',
            'menu_notifikasi',
            'menu_laporan',
            'menu_denda',
            'menu_pengunjung',
            'menu_pengaturan'
        ];

        $menu = $this->db
            ->like('nama_pengaturan','menu_')
            ->get('pengaturan')
            ->result();

        usort($menu, function($a,$b) use ($order){
            return array_search($a->nama_pengaturan,$order)
                 - array_search($b->nama_pengaturan,$order);
        });

        $data['menu'] = $menu;

        $this->load->view('pengaturan/sidebar',$data);
    }

    public function update_sidebar_ajax()
    {
        $menu   = $this->input->post('menu');
        $status = $this->input->post('status');

        $this->db->where('nama_pengaturan',$menu)
                 ->update('pengaturan',['nilai'=>$status]);

        echo json_encode(['success'=>true]);
    }
}