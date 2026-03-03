<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggota_area extends CI_Controller {

	function __construct(){
		parent::__construct();

		if(!$this->session->userdata('login_anggota')){
			redirect('login_anggota');
		}

		$this->load->model('Buku_model');
	}

	public function index(){

		$data['buku']=$this->Buku_model->get();
		$this->load->view('anggota_area/index',$data);
	}

	public function favorit($id){

		$data=[
			'id_anggota'=>$this->session->userdata('id_anggota'),
			'id_buku'=>$id
		];

		$this->db->insert('favorit',$data);

		redirect('anggota_area');
	}
	public function favorit_list(){

	$id=$this->session->userdata('id_anggota');

	$data['buku']=$this->db
	->join('buku','buku.id_buku=favorit.id_buku')
	->where('favorit.id_anggota',$id)
	->get('favorit')->result();

	$this->load->view('anggota_area/favorit',$data);
}
public function hapus_favorit($id_buku)
{
    $id_anggota = $this->session->userdata('id_anggota');

    $this->db->where('id_anggota', $id_anggota);
    $this->db->where('id_buku', $id_buku);
    $this->db->delete('favorit');

    redirect('anggota_area/favorit_list');
}

}
