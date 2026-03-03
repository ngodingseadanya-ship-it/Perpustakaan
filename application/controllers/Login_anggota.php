<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_anggota extends CI_Controller {

	public function index(){
		$this->load->view('login_anggota');
	}

	public function proses(){

		$nis = $this->input->post('nis');

		$cek = $this->db->where('nis',$nis)->get('anggota')->row();

		if($cek){

			$data = [
				'id_anggota'=>$cek->id_anggota,
				'nama'=>$cek->nama,
				'login_anggota'=>TRUE
			];

			$this->session->set_userdata($data);
			redirect('anggota_area');

		}else{
			$this->session->set_flashdata('error','NIS tidak ditemukan');
			redirect('login_anggota');
		}
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('login_anggota');
	}
}
