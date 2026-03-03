<?php
class Dashboard_model extends CI_Model {

    public function jumlah($tabel){
        return $this->db->count_all($tabel);
    }

    public function dipinjam(){
        $result = $this->db
        ->select_sum('jumlah')
        ->where('status','dipinjam')
        ->get('detail_peminjaman')
        ->row();

        return $result->jumlah ?? 0;
    }

    public function dikembalikan(){
        $result = $this->db
        ->select_sum('jumlah')
        ->where('status','dikembalikan')
        ->get('detail_peminjaman')
        ->row();

        return $result->jumlah ?? 0;
    }


    public function grafik_pengunjung(){
        return $this->db
        ->select('tanggal, COUNT(id_pengunjung) as total')
        ->where('tanggal >=', date('Y-m-d', strtotime('-6 days')))
        ->group_by('tanggal')
        ->order_by('tanggal','ASC')
        ->get('pengunjung')
        ->result();
    }

    public function grafik_peminjaman(){
        return $this->db
        ->select('tanggal_pinjam as tanggal, COUNT(id_peminjaman) as total')
        ->where('tanggal_pinjam >=', date('Y-m-d', strtotime('-6 days')))
        ->group_by('tanggal_pinjam')
        ->order_by('tanggal_pinjam','ASC')
        ->get('peminjaman')
        ->result();
    }

    public function grafik_pengembalian(){
        return $this->db
        ->select('tanggal_dikembalikan as tanggal, COUNT(id_detail) as total')
        ->where('tanggal_dikembalikan >=', date('Y-m-d', strtotime('-6 days')))
        ->where('status','dikembalikan')
        ->group_by('tanggal_dikembalikan')
        ->order_by('tanggal_dikembalikan','ASC')
        ->get('detail_peminjaman')
        ->result();
    }
}

