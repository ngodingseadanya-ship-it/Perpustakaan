<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends CI_Controller {

    function __construct()
    {
        parent::__construct();

       
        if (!$this->session->userdata('login')) {
            redirect('login');
        }

       
        $this->load->model('Buku_model');
        $this->load->model('Peminjaman_model');
        $this->load->model('Pengaturan_model');
    }

  
public function index()
{
    $this->load->library('pagination');

    $limit = 10;
    $start = $this->input->get('per_page');

    $config['base_url'] = base_url('index.php/buku/index');
    $config['total_rows'] = $this->Buku_model->count_all_admin();
    $config['per_page'] = $limit;
    $config['page_query_string'] = TRUE;

    
    $config['full_tag_open'] = '<ul class="pagination justify-content-center mt-4">';
    $config['full_tag_close'] = '</ul>';
    $config['attributes'] = ['class'=>'page-link'];

    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
    $config['cur_tag_close'] = '</a></li>';

    $this->pagination->initialize($config);

    $data['buku']        = $this->Buku_model->get_admin($limit,$start);
    $data['kategori']    = $this->Buku_model->kategori();
    $data['dipinjam']    = $this->Buku_model->jumlah_dipinjam();
    $data['pagination']  = $this->pagination->create_links();
$data['logo']        = $this->Pengaturan_model->get('logo');
$data['notif_count'] = count($this->Peminjaman_model->notifikasi());
    $this->load->view('buku/index',$data);
}


   public function katalog()
{
    $this->load->library('pagination');

    $q        = $this->input->get('q', true);
    $kategori = $this->input->get('kategori', true);
    $sort     = $this->input->get('sort', true);

    $limit  = 8; 
    $start  = $this->input->get('per_page');

  
    $total = $this->Buku_model->count_all($q, $kategori);

  
    $config['base_url'] = base_url('index.php/buku/katalog?q='.$q.'&kategori='.$kategori.'&sort='.$sort);
    $config['total_rows'] = $total;
    $config['per_page'] = $limit;
    $config['page_query_string'] = TRUE;

 
    $config['full_tag_open'] = '<ul class="pagination justify-content-center mt-4">';
    $config['full_tag_close'] = '</ul>';

    $config['first_link'] = 'First';
    $config['last_link'] = 'Last';

    $config['next_link'] = '&raquo;';
    $config['prev_link'] = '&laquo;';

    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';

    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
    $config['cur_tag_close'] = '</a></li>';

    $config['attributes'] = array('class' => 'page-link');

    $this->pagination->initialize($config);


    $data['kategori']    = $this->Buku_model->kategori();
    $data['dipinjam']    = $this->Buku_model->jumlah_dipinjam();
    $data['notif_count'] = count($this->Peminjaman_model->notifikasi());
    $data['logo']        = $this->Pengaturan_model->get('logo');
    $data['buku'] = $this->Buku_model->get($q, $kategori, $sort, $limit, $start);
    $data['pagination'] = $this->pagination->create_links();

    $this->load->view('buku/katalog', $data);
}

   
    public function tambah()
    {
        
        if ($this->session->userdata('level') != 'superadmin') {
            show_error('Akses ditolak');
        }

      
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['file_name']     = time();

        $this->load->library('upload', $config);

        $gambar = 'default.png';

        
        if (!empty($_FILES['gambar']['name'])) {
            if ($this->upload->do_upload('gambar')) {
                $gambar = $this->upload->data('file_name');
            }
        }

       
        $data = [
            'judul'       => $this->input->post('judul'),
            'id_kategori' => $this->input->post('kategori'),
            'penulis'     => $this->input->post('penulis'),
            'penerbit'    => $this->input->post('penerbit'),
            'tahun'       => $this->input->post('tahun'),
            'stok'        => $this->input->post('stok'),
            'gambar'      => $gambar
        ];
$this->session->set_flashdata('success','Buku berhasil ditambahkan');
        $this->db->insert('buku', $data);
        redirect('buku');
    }

   
    public function edit($id)
    {
        $data['row']      = $this->Buku_model->edit($id);
        $data['kategori'] = $this->Buku_model->kategori();
    $data['notif_count'] = count($this->Peminjaman_model->notifikasi());
    $data['logo']        = $this->Pengaturan_model->get('logo');
        $this->load->view('buku/edit', $data);
    }

 
    public function update()
    {
        $id = $this->input->post('id');

        $data = [
            'id_kategori'=>$this->input->post('kategori'),
            'judul'=>$this->input->post('judul'),
            'penulis'=>$this->input->post('penulis'),
            'penerbit'=>$this->input->post('penerbit'),
            'tahun'=>$this->input->post('tahun'),
            'stok'=>$this->input->post('stok')
        ];

    
        if(!empty($_FILES['cover']['name'])){

            $config['upload_path']   = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['max_size']      = 2048;
            $config['file_name']     = 'cover_'.time();

            $this->load->library('upload',$config);

            if($this->upload->do_upload('cover')){
                $file = $this->upload->data();
                $data['gambar'] = $file['file_name'];
            }else{
                echo $this->upload->display_errors();
                return;
            }
        }

        $this->db->where('id_buku',$id);
        $this->db->update('buku',$data);

        $this->session->set_flashdata('success','Data buku berhasil diupdate');
        redirect('buku');
    }


    public function hapus($id)
    {
        $this->Buku_model->delete($id);
        redirect('buku');
    }

    public function peminjam($id)
    {
        $data['buku'] = $this->Buku_model->get_by_id($id);

        if(!$data['buku']){
            show_404();
        }
$data['logo'] = $this->Pengaturan_model->get('logo');
$data['notif_count'] = count($this->Peminjaman_model->notifikasi());
        $data['list']    = $this->Buku_model->get_peminjam($id);
        $data['riwayat'] = $this->Buku_model->riwayat_peminjam($id);

        $this->load->view('buku/peminjam', $data);
    }
}