<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if(!check_login()) redirect(site_url('home'));

        $this->load->model('admin_model','admin');
    }


    public function index()
    {
        $stores = $this->admin->getAllStores();
        $cities = $this->admin->getAllCities();
        $tonwshipes = $this->admin->getAllTownship($cities[0]->id);


        $this->load->view('templates/header');
        $this->load->view('admin/index', compact("cities",'tonwshipes', 'stores'));
        $this->load->view('templates/footer');
	}

	public function sendData(){

        if(!$this->input->is_ajax_request()) redirect(site_url('admin'));

        $this->load->library('form_validation');

        $this->form_validation->set_rules('naziv', 'Naziv', 'trim|required|alpha_numeric_spaces|max_length[255]');
        $this->form_validation->set_rules('adresa', 'Adresa', 'trim|required|alpha_numeric_spaces|max_length[255]');
        $this->form_validation->set_rules('grad', 'Grad', 'trim|required|integer|max_length[11]');
        $this->form_validation->set_rules('opstina', 'opstina', 'trim|required|integer|max_length[11]');
        $this->form_validation->set_rules('lat', 'Lat', 'trim|required|numeric|max_length[11]');
        $this->form_validation->set_rules('lon', 'Lon', 'trim|required|numeric|max_length[11]');

        if ($this->form_validation->run() == TRUE )
        {
            $data = array(
                'naziv' => $this->input->post('naziv',true),
                'adresa' => $this->input->post('adresa',true),
                'grad_id' => $this->input->post('grad', true),
                'opstina_id' => $this->input->post('opstina', true),
                'lat' => $this->input->post('lat', true),
                'lon' => $this->input->post('lon', true)
            );

            $this->admin->insertNewStore($data);

            if($this->db->insert_id() > 0) {
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(array(
                        'status' => 'success',
                        'csrf_token' => $this->security->get_csrf_hash(),
                        'message' => 'Uspesno ste dodali novo prodajno mesto'
                    )
                ));
            } else {
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(array(
                        'status' => 'failed',
                        'csrf_token' => $this->security->get_csrf_hash(),
                        'message' => 'Niste dodali novo prodajno mesto, pokušajte kasnije'
                    )
                ));
            }
        }
        else
        {

            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array(
                'status' => 'failed',
                'errors' => array(
                    'naziv' => $this->form_validation->error('naziv','<span class="text-danger err">','</span>'),
                    'adresa' => $this->form_validation->error('adresa','<span class="text-danger err">','</span>'),
                    'grad' => $this->form_validation->error('grad','<span class="text-danger err">','</span>'),
                    'opstina' => $this->form_validation->error('opstina','<span class="text-danger err">','</span>'),
                    'adresa' => $this->form_validation->error('adresa','<span class="text-danger err">','</span>'),
                    'lat' => $this->form_validation->error('lat','<span class="text-danger err">','</span>'),
                    'lon' => $this->form_validation->error('lon','<span class="text-danger err">','</span>'),
                ),
                'csrf_token' => $this->security->get_csrf_hash()

            )));
        }
    }

    public function getOpstine()
    {
        if(!$this->input->is_ajax_request()) redirect(site_url('admin'));

        $city_id = $this->input->post('city_id',true);

        $all = $this->admin->getAllTownship($city_id);


        if(!empty($all)) {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array(
                    'status' => 'success',
                    'csrf_token' => $this->security->get_csrf_hash(),
                    'opstine' => $all
                )
            ));
        } else {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array(
                    'status' => 'failed',
                    'csrf_token' => $this->security->get_csrf_hash(),
                    'opstine' => array()
                )
            ));
        }

    }

    public function getStores()
    {
        if(!$this->input->is_ajax_request()) redirect(site_url('admin'));

        $stores = $this->admin->getAllStores();

        if(!empty($stores)) {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array(
                    'status' => 'success',
                    'csrf_token' => $this->security->get_csrf_hash(),
                    'pmesta' => $stores
                )
            ));
        } else {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array(
                    'status' => 'failed',
                    'csrf_token' => $this->security->get_csrf_hash(),
                    'pmesta' => array()
                )
            ));
        }
    }

}
