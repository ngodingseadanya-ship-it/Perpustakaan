<?php
class Peminjaman_model extends CI_Model {

    public function get($q=null,$status=null,$filter=null,$tanggal=null,$ganti=null){

$this->db->select("
    p.id_peminjaman,
    p.tanggal_pinjam,
    p.tanggal_kembali,
    dp.id_detail,
    dp.jumlah,
    dp.status,
    dp.status_ganti,
    dp.tanggal_dikembalikan,
    dp.denda,
    dp.status_bayar,
    b.judul,
    a.nama,
    a.nis
");

        $this->db->from('detail_peminjaman dp');
        $this->db->join('peminjaman p','p.id_peminjaman=dp.id_peminjaman','left');
        $this->db->join('buku b','b.id_buku=dp.id_buku','left');
        $this->db->join('anggota a','a.id_anggota=p.id_anggota','left');

        if($q){
            $this->db->group_start();
            $this->db->like('a.nama',$q);
            $this->db->or_like('b.judul',$q);
            $this->db->group_end();
        }

        if(!empty($status)){
            $this->db->where('dp.status',$status);
        }

        if($filter){

            if($filter=='harian')
                $this->db->where('DATE(p.tanggal_pinjam)',date('Y-m-d'));

            elseif($filter=='mingguan')
                $this->db->where('YEARWEEK(p.tanggal_pinjam,1)=YEARWEEK(CURDATE(),1)');

            elseif($filter=='bulanan'){
                $this->db->where('MONTH(p.tanggal_pinjam)',date('m'));
                $this->db->where('YEAR(p.tanggal_pinjam)',date('Y'));
            }

            elseif($filter=='tahunan')
                $this->db->where('YEAR(p.tanggal_pinjam)',date('Y'));
        }

        if($tanggal)
            $this->db->where('DATE(p.tanggal_pinjam)',$tanggal);

        if($ganti){
            if($ganti=='tidak_perlu')
                $this->db->where_not_in('dp.status',['rusak','hilang']);
            else
                $this->db->where('dp.status_ganti',$ganti);
        }

        return $this->db->order_by('dp.id_detail','DESC')->get()->result();
    }

    public function anggota(){
        return $this->db->get('anggota')->result();
    }

    public function buku(){
        return $this->db->where('stok >',0)->get('buku')->result();
    }

    public function jumlah_pinjam_aktif($id){

        return $this->db
        ->select_sum('dp.jumlah')
        ->from('detail_peminjaman dp')
        ->join('peminjaman p','p.id_peminjaman=dp.id_peminjaman')
        ->where('p.id_anggota',$id)
        ->where('dp.status','dipinjam')
        ->get()->row()->jumlah ?? 0;
    }

public function notifikasi()
{
    $setting = $this->db
        ->where('nama_pengaturan','notif_hari')
        ->get('pengaturan')
        ->row();

    $hari = $setting ? (int)$setting->nilai : 3;

    return $this->db
        ->select('a.nama, a.no_hp,
                  b.judul,
                  p.tanggal_kembali,
                  DATEDIFF(p.tanggal_kembali, CURDATE()) as sisa_hari')
        ->from('detail_peminjaman dp')
        ->join('peminjaman p','p.id_peminjaman=dp.id_peminjaman')
        ->join('anggota a','a.id_anggota=p.id_anggota')
        ->join('buku b','b.id_buku=dp.id_buku')
        ->where('dp.status','dipinjam')
        ->where("DATEDIFF(p.tanggal_kembali, CURDATE()) <=", $hari)
        ->order_by('p.tanggal_kembali','ASC')
        ->get()
        ->result();
}

    public function count_notifikasi(){

        return $this->db->query("
            SELECT COUNT(*) total
            FROM detail_peminjaman dp
            JOIN peminjaman p ON p.id_peminjaman=dp.id_peminjaman
            WHERE dp.status='dipinjam'
            AND DATEDIFF(p.tanggal_kembali,CURDATE()) <=3
        ")->row()->total;
    }

    public function kembali_buku($id_detail){

        $detail=$this->db->get_where('detail_peminjaman',['id_detail'=>$id_detail])->row();
        if(!$detail) return;

        $this->db->set('stok','stok+'.$detail->jumlah,false)
        ->where('id_buku',$detail->id_buku)
        ->update('buku');

        $this->db->where('id_detail',$id_detail)
        ->update('detail_peminjaman',[
            'status'=>'dikembalikan',
            'tanggal_dikembalikan'=>date('Y-m-d')
        ]);

        $sisa=$this->db
        ->where('id_peminjaman',$detail->id_peminjaman)
        ->where('status','dipinjam')
        ->count_all_results('detail_peminjaman');

        if($sisa==0){
            $this->db->where('id_peminjaman',$detail->id_peminjaman)
            ->update('peminjaman',['status'=>'dikembalikan']);
        }
    }

    public function buku_perlu_ganti(){

        return $this->db->select("
            dp.id_detail,
            a.nama,
            b.judul,
            dp.jumlah,
            p.tanggal_pinjam,
            dp.status,
            dp.status_ganti
        ")
        ->from('detail_peminjaman dp')
        ->join('peminjaman p','p.id_peminjaman=dp.id_peminjaman')
        ->join('anggota a','a.id_anggota=p.id_anggota')
        ->join('buku b','b.id_buku=dp.id_buku')
        ->where_in('dp.status',['rusak','hilang'])
        ->where('(dp.status_ganti IS NULL OR dp.status_ganti="belum")')
        ->get()->result();
    }

    public function jumlah_belum_kembali(){
        return $this->db
        ->where('status','dipinjam')
        ->count_all_results('detail_peminjaman');
    }

public function laporan_denda($tgl=null){

$this->db->select("
dp.id_detail,
a.nama,
a.nis,
b.judul,
dp.denda,
dp.status_bayar,
dp.tanggal_bayar,
p.tanggal_kembali
");

$this->db->from('detail_peminjaman dp');
$this->db->join('peminjaman p','p.id_peminjaman=dp.id_peminjaman');
$this->db->join('anggota a','a.id_anggota=p.id_anggota');
$this->db->join('buku b','b.id_buku=dp.id_buku');
$this->db->where('dp.denda >',0);

if($tgl){
$this->db->where('DATE(p.tanggal_kembali)',$tgl);
}

$this->db->order_by('dp.id_detail','DESC');

return $this->db->get()->result();
}

public function cek_by_anggota($id){

    return $this->db
        ->where('id_anggota', $id)
        ->where('status', 'Dipinjam')
        ->count_all_results('peminjaman');
}
}