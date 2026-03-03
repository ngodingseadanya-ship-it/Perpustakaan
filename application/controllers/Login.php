    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Login extends CI_Controller {

        public function index()
        {
            $this->load->view('login');
        }

        public function proses()
        {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $this->db->where('username', $username);
            $this->db->where('password', md5($password));
            $petugas = $this->db->get('petugas')->row();

            if ($petugas) {

                $data = [
                    'id_petugas' => $petugas->id_petugas,
                    'nama'       => $petugas->nama_petugas,
                    'level'      => $petugas->level,
                    'login'      => TRUE
                ];

                $this->session->set_userdata($data);
                redirect('dashboard');
                return;
            }

            $this->db->where('nama', $username);
            $this->db->where('nis', $password);
            $anggota = $this->db->get('anggota')->row();

            if ($anggota) {

                $data = [
                    'id_anggota'    => $anggota->id_anggota,
                    'nama'          => $anggota->nama,
                    'login_anggota' => TRUE
                ];

                $this->session->set_userdata($data);
                redirect('anggota_area');
                return;
            }

            $this->session->set_flashdata('error', 'Login gagal');
            redirect('login');
        }

        public function logout()
        {
            $this->session->sess_destroy();
            redirect('login');
        }
    }
