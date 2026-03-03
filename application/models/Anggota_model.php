<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggota_model extends CI_Model {

    public function get($limit,$start,$q=null,$kelas=null,$sort='desc'){

        if($q){
            $this->db->group_start();
            $this->db->like('nama',$q);
            $this->db->or_like('nis',$q);
            $this->db->group_end();
        }

        if($kelas){
            $this->db->where('kelas',$kelas);
        }

        if($sort == 'asc'){
            $this->db->order_by('id_anggota','ASC');
        }else{
            $this->db->order_by('id_anggota','DESC');
        }

        return $this->db
            ->limit($limit,$start)
            ->get('anggota')
            ->result();
    }

    public function count($q=null,$kelas=null){

        if($q){
            $this->db->group_start();
            $this->db->like('nama',$q);
            $this->db->or_like('nis',$q);
            $this->db->group_end();
        }

        if($kelas){
            $this->db->where('kelas',$kelas);
        }

        return $this->db->count_all_results('anggota');
    }

    public function kelas(){
        $this->db->select('kelas');
        $this->db->group_by('kelas');
        return $this->db->get('anggota')->result();
    }

    public function insert($data){
        $this->db->insert('anggota',$data);
    }

    public function edit($id){
        return $this->db->where('id_anggota',$id)->get('anggota')->row();
    }

    public function update($id,$data){
        $this->db->where('id_anggota',$id);
        $this->db->update('anggota',$data);
    }

    public function delete($id){
        $this->db->where('id_anggota',$id);
        $this->db->delete('anggota');
    }

    public function by_nis($nis){
        return $this->db->where('nis',$nis)->get('anggota')->row();
    }
}