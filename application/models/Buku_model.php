<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku_model extends CI_Model {

public function get($q = null, $kategori = null, $sort = null, $limit = null, $start = null){

    $this->db->select('buku.*, kategori.nama_kategori');
    $this->db->from('buku');
    $this->db->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left');

    if($q){
        $this->db->group_start();
        $this->db->like('judul', $q);
        $this->db->or_like('penulis', $q);
        $this->db->group_end();
    }

    if($kategori){
        $this->db->where('buku.id_kategori', $kategori);
    }

    switch($sort){
        case 'terlama':
            $this->db->order_by('buku.id_buku', 'ASC');
            break;
        case 'judul_asc':
            $this->db->order_by('buku.judul', 'ASC');
            break;
        case 'judul_desc':
            $this->db->order_by('buku.judul', 'DESC');
            break;
        default:
            $this->db->order_by('buku.id_buku', 'DESC');
            break;
    }

    if($limit != null){
        $this->db->limit($limit, $start);
    }

    return $this->db->get()->result();
}

public function count_all($q = null, $kategori = null){

    $this->db->from('buku');

    if($q){
        $this->db->group_start();
        $this->db->like('judul', $q);
        $this->db->or_like('penulis', $q);
        $this->db->group_end();
    }

    if($kategori){
        $this->db->where('id_kategori', $kategori);
    }

    return $this->db->count_all_results();
}

public function kategori(){
    return $this->db->get('kategori')->result();
}

public function insert($data){
    $this->db->insert('buku', $data);
}

public function edit($id){
    return $this->db
        ->where('id_buku', $id)
        ->get('buku')
        ->row();
}

public function update($id, $data){
    $this->db->where('id_buku', $id);
    $this->db->update('buku', $data);
}

public function delete($id){
    $this->db->where('id_buku', $id);
    $this->db->delete('buku');
}

public function jumlah_dipinjam(){

    $this->db->select('id_buku, SUM(jumlah) as total');
    $this->db->from('detail_peminjaman');
    $this->db->where('status', 'dipinjam');
    $this->db->group_by('id_buku');

    $result = $this->db->get()->result();

    $data = [];
    foreach($result as $r){
        $data[$r->id_buku] = $r->total;
    }

    return $data;
}

public function get_peminjam($id_buku){
    return $this->db
        ->select('
            a.nis,
            a.nama,
            a.kelas,
            dp.jumlah,
            p.tanggal_pinjam,
            p.tanggal_kembali,
            dp.status
        ')
        ->from('detail_peminjaman dp')
        ->join('peminjaman p', 'p.id_peminjaman = dp.id_peminjaman')
        ->join('anggota a', 'a.id_anggota = p.id_anggota')
        ->where('dp.id_buku', $id_buku)
        ->where('dp.status', 'dipinjam')
        ->get()
        ->result();
}

public function riwayat_peminjam($id_buku){
    return $this->db
        ->select('
            a.nis,
            a.nama,
            a.kelas,
            dp.jumlah,
            p.tanggal_pinjam,
            p.tanggal_kembali,
            dp.status
        ')
        ->from('detail_peminjaman dp')
        ->join('peminjaman p', 'p.id_peminjaman = dp.id_peminjaman')
        ->join('anggota a', 'a.id_anggota = p.id_anggota')
        ->where('dp.id_buku', $id_buku)
        ->where_in('dp.status', ['dikembalikan','rusak','hilang'])
        ->order_by('p.tanggal_pinjam', 'DESC')
        ->get()
        ->result();
}

public function get_by_id($id){
    return $this->db
        ->select('buku.*, kategori.nama_kategori')
        ->from('buku')
        ->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left')
        ->where('buku.id_buku', $id)
        ->get()
        ->row();
}

public function get_admin($limit,$start){
    return $this->db
        ->select('buku.*, kategori.nama_kategori')
        ->from('buku')
        ->join('kategori','kategori.id_kategori=buku.id_kategori','left')
        ->order_by('id_buku','DESC')
        ->limit($limit,$start)
        ->get()
        ->result();
}

public function count_all_admin(){
    return $this->db->count_all('buku');
}
}