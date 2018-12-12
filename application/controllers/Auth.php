<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct() {
        parent::__construct();

        $this->lang->load('login','serbian');
    }

    public function login()
    {
        if(check_login()) redirect(site_url('admin'));

        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|alpha_dash|min_length[6]|max_length[32]');


        if ($this->form_validation->run() == TRUE )
        {
            $this->load->model('auth_model');

            $email = $this->input->post('email',true);
            $password = md5(trim($this->input->post('password',true)).'lilly');



            if($this->auth_model->login($email, $password))
            {
                if($this->input->is_ajax_request())
                {
                    $this->output->set_content_type('application_json');
                    $this->output->set_output(json_encode(array(
                        'status' => 'success',
                        'message' => 'Usešno ste se ulogovali',
                        'url' => site_url('admin')
                    )));
                }
                else
                {
                    $this->session->set_flashdata(array(
                        'message' =>  'Usešno ste se ulogovali',
                        'message_class' => 'info'
                    ));
                    redirect(site_url('admin'));
                }
            }
            else
            {
                if($this->input->is_ajax_request())
                {
                    $this->output->set_content_type('application_json');
                    $this->output->set_output(json_encode(array(
                        'status' => 'failed',
                        'message' => 'Emeil i/ili lozinka nisu ispravni',
                    )));
                }
                else
                {
                    $this->session->set_flashdata(array(
                        'message' => 'Emeil i/ili lozinka nisu ispravni',
                        'message_class' => 'error'
                    ));
                    redirect(site_url('admin'));
                }
            };
        }
        else
        {
            $this->load->view('templates/header');
            $this->load->view('auth/login');
            $this->load->view('templates/footer');

        }


    }

    public function logout()
    {
        $this->load->model('auth_model');

        $this->auth_model->logout();

        redirect(site_url('home'));
    }

    public function register() {
        if(check_login()) redirect(site_url('admin'));

        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Emeil', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Lozinka', 'required|alpha_dash|min_length[6]|max_length[32]');
        $this->form_validation->set_rules('name', 'Ime', 'required|alpha_numeric|min_length[4]|max_length[32]');


        if ($this->form_validation->run() == TRUE )
        {
            $this->load->model('auth_model');

            $name = $this->input->post('name', true);
            $email = $this->input->post('email', true);
            $password = md5(trim($this->input->post('password',true)).'lilly');



            if($this->auth_model->register($email, $password, $name) > 0)
            {

                $this->session->set_flashdata(array(
                    'message' =>  'Usešno ste se registrovali',
                    'message_class' => 'info'
                ));
                redirect(site_url('home'));

            }
            else
            {
                $this->session->set_flashdata(array(
                    'message' => 'Postoji problem, pokušajte kasnije',
                    'message_class' => 'error'
                ));
                redirect(site_url('home'));

            };
        }
        else
        {
            $this->load->view('templates/header');
            $this->load->view('auth/register');
            $this->load->view('templates/footer');

        }
    }

    public function resetPassword(){

        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[32]');


        if ($this->form_validation->run() == TRUE )
        {
            $this->load->model('auth_model');

            $email = $this->input->post('email',true);


            $findemail = $this->auth_model->getEmail($email);

            if ($findemail) {
                $this->load->library('email');

                $message = $this->getMessage($email);

                $this->email->set_header('Content-type', 'text/html;charset=UTF-8');
                $this->email->from('office@dejanristic.rs', 'dejanristic.rs');
                $this->email->to($email);
                $this->email->subject('Reset Password');
                $this->email->message($message);

                if($this->email->send()){


                    $this->session->set_flashdata(array(
                        'message' => 'Poslat vam je email za promenu lozinke',
                        'message_class' => 'success'
                    ));
                    redirect(site_url('home'));
                } else {
                    $this->session->set_flashdata(array(
                        'message' => 'Doslo je do problema, pokusajte kasnije',
                        'message_class' => 'danger'
                    ));
                    redirect(site_url('reset/password'));
                }


            } else {;
                $this->session->set_flashdata(array(
                    'message' => 'email je pogršan, unesite vasu email adresu',
                    'message_class' => 'danger'
                ));
                redirect(site_url('reset/password'));
            }

        }
        else {
            $this->load->view('templates/header');
            $this->load->view('auth/password');
            $this->load->view('templates/footer');
        }
    }

    public function changePassword($token){

        $this->load->model('auth_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header');
            $this->load->view('auth/resetPassword', compact('token'));
            $this->load->view('templates/footer');
        }else{
            $user = $this->auth_model->getUser($token);
            $password = md5(trim($this->input->post('password',true)).'lilly');

            if(!$user) {
                $this->session->set_flashdata(array(
                    'message' => 'Lozinka nije promenjena, pokusajte ponovo',
                    'message_class' => 'danger'
                ));
                redirect(site_url('home'));
            }

            if($this->auth_model->updatePassword($password, $user->id) > 0){
                $this->session->set_flashdata(array(
                    'message' => 'Uspesno ste promenili lozinku',
                    'message_class' => 'success'
                ));
            }else{
                $this->session->set_flashdata(array(
                    'message' => 'Lozinka nije promenjena, pokusajte ponovo',
                    'message_class' => 'danger'
                ));

            }
            redirect(site_url().'home');
        }



    }

    /**
     * @param $email
     * @return string
     */
    private function getMessage($email)
    {
        $this->load->model('auth_model');
        $token = md5('lilly'.time());
        $this->auth_model->insertToken($token, $email);
        $url = site_url( 'reset/password/token/' . $token);
        $link = '<a href="' . $url . '">' . $url . '</a>';

        $message = "Promena lozinke<br>";
        $message .= "<p>Ovo je verifikacioni email radi promene lozinke, ako i dalje zelite da promenite loziku kliknite na link ispod.</p>";
        $message .= '<strong>Kliknite na link:</strong> ' . $link;

        return $message;
    }



}
