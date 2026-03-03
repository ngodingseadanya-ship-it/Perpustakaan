<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    function __construct(){
        parent::__construct();


        if(!$this->session->userdata('login')){
            redirect('login');
        }

        $this->load->model('Peminjaman_model');
        $this->load->model('Pengaturan_model');
    }


    public function peminjaman(){


        $q       = $this->input->get('q');
        $status  = $this->input->get('status');
        $filter  = $this->input->get('filter');
        $tanggal = $this->input->get('tanggal');


        $data['data'] = $this->Peminjaman_model
            ->get($q, $status, $filter, $tanggal);

        $data['total'] = count($data['data']);


        $data['logo']        = $this->Pengaturan_model->get('logo');
        $data['notif_count'] = count($this->Peminjaman_model->notifikasi());


        $data['q']       = $q;
        $data['status']  = $status;
        $data['filter']  = $filter;
        $data['tanggal'] = $tanggal;

        $this->load->view('laporan/peminjaman', $data);
    }


    public function peminjaman_pdf(){


        $q       = $this->input->get('q', true);
        $status  = $this->input->get('status', true);
        $filter  = $this->input->get('filter', true);
        $tanggal = $this->input->get('tanggal', true);


        $this->db->select('
            p.tanggal_pinjam,
            p.tanggal_kembali,
            dp.jumlah,
            dp.status,
            dp.tanggal_dikembalikan,
            b.judul,
            a.nama
        ');

        $this->db->from('detail_peminjaman dp');
        $this->db->join('peminjaman p','p.id_peminjaman = dp.id_peminjaman','left');
        $this->db->join('buku b','b.id_buku = dp.id_buku','left');
        $this->db->join('anggota a','a.id_anggota = p.id_anggota','left');

        if($q){
            $this->db->group_start();
            $this->db->like('a.nama', $q);
            $this->db->or_like('b.judul', $q);
            $this->db->group_end();
        }


        if($status){
            $this->db->where('dp.status', $status);
        }


        if($filter){

            if($filter == 'harian'){
                $this->db->where('DATE(p.tanggal_pinjam)', date('Y-m-d'));
            }
            elseif($filter == 'mingguan'){
                $this->db->where('YEARWEEK(p.tanggal_pinjam,1)=YEARWEEK(CURDATE(),1)');
            }
            elseif($filter == 'bulanan'){
                $this->db->where('MONTH(p.tanggal_pinjam)', date('m'));
                $this->db->where('YEAR(p.tanggal_pinjam)', date('Y'));
            }
            elseif($filter == 'tahunan'){
                $this->db->where('YEAR(p.tanggal_pinjam)', date('Y'));
            }
        }


        if($tanggal){
            $this->db->where('DATE(p.tanggal_pinjam)', $tanggal);
        }


        $data['data'] = $this->db
            ->order_by('dp.id_detail', 'DESC')
            ->get()
            ->result();

        $this->load->view('laporan/peminjaman_pdf', $data);
    }


 
    public function hapus($id_detail)
    {

        if($this->session->userdata('level') != 'superadmin'){
            show_error('Akses ditolak', 403);
        }

    
        $detail = $this->db
            ->where('id_detail', $id_detail)
            ->get('detail_peminjaman')
            ->row();

        if($detail){

           
            if($detail->status == 'dipinjam'){
                $this->db->set('stok', 'stok + ' . $detail->jumlah, false)
                         ->where('id_buku', $detail->id_buku)
                         ->update('buku');
            }

          
            $this->db->delete('detail_peminjaman', [
                'id_detail' => $id_detail
            ]);
        }

       
        redirect($_SERVER['HTTP_REFERER']);
    }

}