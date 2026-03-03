<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman extends CI_Controller {

function __construct(){
    parent::__construct();

    if(!$this->session->userdata('login')){
        redirect('login');
    }

    $this->load->model('Peminjaman_model');
    $this->load->model('Pengaturan_model');
}

public function index(){

$q       = $this->input->get('q',true);
$status  = $this->input->get('status',true);
$filter  = $this->input->get('filter',true);
$tanggal = $this->input->get('tanggal',true);
$ganti   = $this->input->get('ganti',true);

$data['data']  = $this->Peminjaman_model->get($q,$status,$filter,$tanggal,$ganti);
$data['anggota'] = $this->Peminjaman_model->anggota();
$data['buku']    = $this->Peminjaman_model->buku();
$data['logo'] = $this->Pengaturan_model->get('logo');
$data['notif_count'] = count($this->Peminjaman_model->notifikasi());
$data['belum_kembali']=$this->Peminjaman_model->jumlah_belum_kembali();
$data['denda_status'] = $this->Pengaturan_model->get('denda_status');
$data['denda_aktif'] = $this->Pengaturan_model->get('denda_aktif');

$this->load->view('peminjaman/index',$data);
}

public function tambah(){

$id_anggota = $this->input->post('anggota',true);
$buku_data  = json_decode($this->input->post('buku_data'),true);

$anggota = $this->db
->where('id_anggota',$id_anggota)
->get('anggota')
->row();

if(!$anggota){
$this->session->set_flashdata('error','Anggota tidak ditemukan');
redirect('peminjaman');
}

if(strtolower($anggota->kelas)=='alumni'){
$this->session->set_flashdata('error','Anggota Alumni tidak diperbolehkan meminjam buku');
redirect('peminjaman');
}

if(!$id_anggota || empty($buku_data)){
$this->session->set_flashdata('error','Data tidak valid');
redirect('peminjaman');
}

$aktif = $this->Peminjaman_model->jumlah_pinjam_aktif($id_anggota);
$akan  = array_sum(array_column($buku_data,'qty'));

$max = $this->Pengaturan_model->get('max_pinjam');
if(!$max) $max = 4;

if(($aktif + $akan) > $max){
    $this->session->set_flashdata('error','Maksimal '.$max.' buku aktif');
    redirect('peminjaman');
    return;
}

$lama = $this->Pengaturan_model->get('lama_pinjam');
if(!$lama) $lama = 7;

$this->db->insert('peminjaman',[
'id_anggota'=>$id_anggota,
'tanggal_pinjam'=>date('Y-m-d'),
'tanggal_kembali'=>date('Y-m-d',strtotime("+$lama days")),
'status'=>'dipinjam'
]);

$id_pinjam=$this->db->insert_id();

foreach($buku_data as $b){

if(!$b['id'] || $b['qty']<=0) continue;

$cek_sama = $this->db
    ->from('detail_peminjaman dp')
    ->join('peminjaman p','p.id_peminjaman=dp.id_peminjaman')
    ->where('p.id_anggota',$id_anggota)
    ->where('dp.id_buku',$b['id'])
    ->where('dp.status','dipinjam')
    ->count_all_results();

if($cek_sama > 0){
    $this->session->set_flashdata('error','Tidak bisa meminjam buku yang sama sebelum dikembalikan');
    redirect('peminjaman');
    return;
}

$cek = $this->db
    ->where('id_buku',$b['id'])
    ->get('buku')
    ->row();

if(!$cek || $cek->stok < $b['qty']){
    $this->session->set_flashdata('error','Stok buku tidak mencukupi');
    redirect('peminjaman');
    return;
}

$cek = $this->db
    ->where('id_buku',$b['id'])
    ->get('buku')
    ->row();

if(!$cek || $cek->stok < $b['qty']){
    $this->session->set_flashdata('error','Stok buku tidak mencukupi');
    redirect('peminjaman');
}

$this->db->insert('detail_peminjaman',[
'id_peminjaman'=>$id_pinjam,
'id_buku'=>$b['id'],
'jumlah'=>$b['qty'],
'status'=>'dipinjam',
'status_ganti'=>'tidak_perlu'
]);

$this->db->set('stok',"stok-{$b['qty']}",false)
         ->where('id_buku',$b['id'])
         ->update('buku');
}

$this->session->set_flashdata('success','Peminjaman berhasil');
redirect('peminjaman');
}

public function cek_pinjam(){
$id=$this->input->post('id',true);
$j=$this->Peminjaman_model->jumlah_pinjam_aktif($id);
echo json_encode(['jumlah'=>$j]);
}

public function update_status(){

$id     = $this->input->post('id_detail',true);
$status = $this->input->post('status',true);

$detail=$this->db->get_where('detail_peminjaman',['id_detail'=>$id])->row();
if(!$detail) return;

$lama=$detail->status;

if($lama=='dipinjam' && $status=='dikembalikan'){
$this->db->set('stok','stok+'.$detail->jumlah,false)
         ->where('id_buku',$detail->id_buku)
         ->update('buku');
}

if($lama=='dikembalikan' && $status=='dipinjam'){
$this->db->set('stok','stok-'.$detail->jumlah,false)
         ->where('id_buku',$detail->id_buku)
         ->update('buku');
}

$status_ganti = $detail->status_ganti;

if(($status=='rusak'||$status=='hilang') && $detail->status_ganti!='sudah'){
    $status_ganti = 'belum';
}

$denda = 0;

if($status=='dikembalikan'){

    $status_ganti = 'tidak_perlu';

    $pinjam = $this->db
        ->where('id_peminjaman',$detail->id_peminjaman)
        ->get('peminjaman')
        ->row();

    if($pinjam){
        $denda = 0;

$denda_status = $this->Pengaturan_model->get('denda_status');

if($status=='dikembalikan' && $denda_status=='on'){

    $pinjam = $this->db
        ->where('id_peminjaman',$detail->id_peminjaman)
        ->get('peminjaman')
        ->row();

    if($pinjam){
        $denda = hitung_denda($pinjam->tanggal_kembali);
    }
}
    }
}

$this->db->where('id_detail',$id)
->update('detail_peminjaman',[
'status'=>$status,
'status_ganti'=>$status_ganti,
'denda'=>$denda,
'tanggal_dikembalikan'=> ($status=='dikembalikan')?date('Y-m-d'):NULL
]);

$sisa = $this->db
    ->where('id_peminjaman',$detail->id_peminjaman)
    ->where('status','dipinjam')
    ->count_all_results('detail_peminjaman');

if($sisa == 0){
    $this->db->where('id_peminjaman',$detail->id_peminjaman)
             ->update('peminjaman',['status'=>'dikembalikan']);
}
redirect('peminjaman');
}

public function hapus_detail($id){

if($this->session->userdata('level')!='superadmin')
show_error('Akses ditolak',403);

$detail=$this->db->get_where('detail_peminjaman',['id_detail'=>$id])->row();

if($detail){

if($detail->status=='dipinjam'){
$this->db->set('stok','stok+'.$detail->jumlah,false)
         ->where('id_buku',$detail->id_buku)
         ->update('buku');
}

$this->db->delete('detail_peminjaman',['id_detail'=>$id]);

$sisa=$this->db->where('id_peminjaman',$detail->id_peminjaman)
               ->count_all_results('detail_peminjaman');

if($sisa==0){
$this->db->delete('peminjaman',['id_peminjaman'=>$detail->id_peminjaman]);
}
}

redirect('peminjaman');
}

public function monitoring_ganti(){
$data['data']=$this->Peminjaman_model->buku_perlu_ganti();
$data['logo'] = $this->Pengaturan_model->get('logo');
$data['notif_count'] = count($this->Peminjaman_model->notifikasi());
$this->load->view('peminjaman/monitoring_ganti',$data);
}

public function form_ganti($id){

$data['detail'] = $this->db
->select('dp.*,a.nama,b.judul')
->from('detail_peminjaman dp')
->join('peminjaman p','p.id_peminjaman=dp.id_peminjaman')
->join('anggota a','a.id_anggota=p.id_anggota')
->join('buku b','b.id_buku=dp.id_buku')
->where('dp.id_detail',$id)
->get()
->row();

$data['kategori']=$this->db->get('kategori')->result();
$data['buku']=$this->db->order_by('judul','ASC')->get('buku')->result();
$data['logo'] = $this->Pengaturan_model->get('logo');
$data['notif_count'] = count($this->Peminjaman_model->notifikasi());
$this->load->view('peminjaman/form_ganti',$data);
}

public function simpan_ganti(){

$id   = $this->input->post('id_detail');
$tipe = $this->input->post('tipe');

$detail=$this->db->where('id_detail',$id)->get('detail_peminjaman')->row();
if(!$detail) show_404();

$jumlah=$detail->jumlah;

if($tipe=="katalog"){

$id_buku=$this->input->post('buku_katalog');

$this->db->set('stok',"stok+$jumlah",false)
         ->where('id_buku',$id_buku)
         ->update('buku');
}

else{

$this->db->insert('buku',[
'judul'=>$this->input->post('judul'),
'id_kategori'=>$this->input->post('kategori'),
'penulis'=>$this->input->post('penulis'),
'penerbit'=>$this->input->post('penerbit'),
'tahun'=>$this->input->post('tahun'),
'stok'=>$jumlah,
'gambar'=>'default.png'
]);
}

$this->db->where('id_detail',$id)
->update('detail_peminjaman',[
'status_ganti'=>'sudah',
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

$this->session->set_flashdata('success','Buku pengganti berhasil diproses');
redirect('peminjaman/monitoring_ganti');
}

public function bayar_denda($id){

$detail = $this->db
->where('id_detail',$id)
->get('detail_peminjaman')
->row();

if(!$detail) show_404();

$this->db->where('id_detail',$id)
->update('detail_peminjaman',[
'status_bayar'=>'lunas',
'tanggal_bayar'=>date('Y-m-d')
]);

$this->session->set_flashdata('success','Denda berhasil dibayar');

redirect('peminjaman');
}

public function laporan_denda(){

$tanggal = $this->input->get('tanggal');
$data['notif_count'] = count($this->Peminjaman_model->notifikasi());
$data['logo'] = $this->Pengaturan_model->get('logo');
$data['data'] = $this->Peminjaman_model->laporan_denda($tanggal);
$data['tanggal'] = $tanggal;

$this->load->view('peminjaman/laporan_denda',$data);
}

public function export_denda(){

$data['data'] = $this->Peminjaman_model->laporan_denda();

$this->load->library('pdf');
$dompdf = $this->pdf->load();

$html = $this->load->view('peminjaman/pdf_denda',$data,true);

if(ob_get_length()) ob_end_clean();

$dompdf->loadHtml($html);
$dompdf->setPaper('A4','portrait');
$dompdf->render();

$pdf = $dompdf->output();

header("Content-Type: application/pdf");
header("Content-Disposition: inline; filename=laporan_denda.pdf");

echo $pdf;
}
}