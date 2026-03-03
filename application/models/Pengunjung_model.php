<?php

class Pengunjung_model extends CI_Model {

    function simpan($nis)
    {

        $anggota = $this->db->where('nis', $nis)
                            ->get('anggota')
                            ->row();

        if (!$anggota) return false;


        $cek = $this->db
            ->where('nis', $nis)
            ->where('tanggal', date('Y-m-d'))
            ->get('pengunjung')
            ->row();

        if ($cek) return false;


        $this->db->insert('pengunjung', [
            'nis'             => $anggota->nis,
            'nama_pengunjung' => $anggota->nama,
            'tanggal'         => date('Y-m-d'),
            'keperluan'       => 'Berkunjung'
        ]);

        return true;
    }

    public function get_pengunjung($filter = null, $sort = null)
    {
        $this->db->from('pengunjung');

        switch($filter){

            case 'harian':
                $this->db->where('DATE(tanggal)', date('Y-m-d'));
            break;

            case 'mingguan':
                $this->db->where('YEARWEEK(tanggal,1)=YEARWEEK(CURDATE(),1)', null, false);
            break;

            case 'bulanan':
                $this->db->where('MONTH(tanggal)', date('m'));
                $this->db->where('YEAR(tanggal)', date('Y'));
            break;

            case 'tahunan':
                $this->db->where('YEAR(tanggal)', date('Y'));
            break;
        }

        if($sort == 'terlama'){
            $this->db->order_by('tanggal','ASC');
        } else {
            $this->db->order_by('tanggal','DESC');
        }

        return $this->db->get()->result();
    }

    public function get_ranking()
    {
        return $this->db
            ->select('nis, nama_pengunjung, COUNT(id_pengunjung) as total_kunjungan')
            ->from('pengunjung')
            ->group_by('nis')
            ->order_by('total_kunjungan', 'DESC')
            ->get()
            ->result();
    }
}