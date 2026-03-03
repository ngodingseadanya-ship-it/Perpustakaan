<?php
class Pengaturan_model extends CI_Model {


    public function get($nama)
    {
        $row = $this->db
            ->where('nama_pengaturan',$nama)
            ->get('pengaturan')
            ->row();

        return $row ? $row->nilai : null;
    }

    public function update($nama,$nilai)
    {
        $cek = $this->db
            ->where('nama_pengaturan',$nama)
            ->get('pengaturan')
            ->row();

        if($cek){
            return $this->db
                ->where('nama_pengaturan',$nama)
                ->update('pengaturan',['nilai'=>$nilai]);
        } else {
            return $this->db->insert('pengaturan',[
                'nama_pengaturan'=>$nama,
                'nilai'=>$nilai
            ]);
        }
    }

    public function all()
    {
        return $this->db->get('pengaturan')->result();
    }

}