<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
       
        $this->load->model('admin');
    }

    public function index()
    {

            if($this->admin->logged_id())
            {
                
                redirect("dashboard");

            }else{

                $this->form_validation->set_rules('username', 'Username', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required');
                $this->form_validation->set_message('required', '<div class="alert alert-danger" style="margin-top: 3px">
                    <div class="header"><b><i class="fa fa-exclamation-circle"></i> {field}</b> tidak boleh kosong</div></div>');


                if ($this->form_validation->run() == TRUE) {

                $username = $this->input->post("username", TRUE);
                $password = MD5($this->input->post('password', TRUE));

                $checking = $this->admin->check_login('admin_wri', array('username' => $username), array('password' => $password));

                if ($checking != FALSE) {
                    foreach ($checking as $apps) {

                        $session_data = array(
                            'user_id'   => $apps->id_user,
                            'user_name' => $apps->username,
                            'user_pass' => $apps->password,
                        );
                        $this->session->set_userdata($session_data);

                        redirect('beranda/');

                    }
                }else{

                    $data['error'] = '<div class="alert alert-danger" style="margin-top: 3px">
                        <div class="header"> username atau password anda salah!</div></div>';
                    $this->load->view('login', $data);
                }

            }else{

                $this->load->view('login');
            }

        }

    }
}