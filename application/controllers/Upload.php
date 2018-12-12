<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if(!check_login()) redirect(site_url('home'));

        $this->load->model('upload_model');
    }




    public function index() {
        $categories = $this->upload_model->getAllCategories();

        $this->load->view('templates/header');
        $this->load->view('admin/image', compact('categories'));
        $this->load->view('templates/footer');
    }

    public function upload() {
        if(!$this->input->is_ajax_request()) redirect(site_url('admin/image'));


        $this->load->library('form_validation');

        $this->form_validation->set_rules('kategorija', 'Kategorija', 'trim|required|integer|max_length[11]');

        if ($this->form_validation->run() == TRUE )
        {
            $categori_id = $this->input->post('kategorija',true);
            $categorija = $this->upload_model->getCategory($categori_id);


            $imageExisted = $this->upload_model->getImage($categori_id, $_FILES['image']['name']);

            if(empty($imageExisted)) {

                $config['upload_path']          = PUBPATH.'/resources/uploads/'.$categorija->direkorijum.'/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['overwrite']            = TRUE;
                $config['max_filename']         = 64;
                $config['max_size']             = 2048;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('image'))
                {

                    $this->output->set_content_type('application/json');
                    $this->output->set_output(json_encode(array(
                            'status' => 'failed',
                            'csrf_token' => $this->security->get_csrf_hash(),
                            'errors' => array(
                                'image' => $this->upload->display_errors('<span class="text-danger err">','</span>')
                            )
                        )
                    ));
                }
                else
                {
                    $data = array('upload_data' => $this->upload->data());

                    $data = array(
                        'naziv' => $data['upload_data']['file_name'],
                        'kategori_id' => $categori_id
                    );

                    $this->upload_model->insertNewImage($data);

                    if($this->db->insert_id() > 0) {
                        $this->output->set_content_type('application/json');
                        $this->output->set_output(json_encode(array(
                                'status' => 'success',
                                'csrf_token' => $this->security->get_csrf_hash(),
                                'message' => 'Uspesno ste dodali sliku'
                            )
                        ));
                    } else {
                        $this->output->set_content_type('application/json');
                        $this->output->set_output(json_encode(array(
                                'status' => 'failed',
                                'csrf_token' => $this->security->get_csrf_hash(),
                                'message' => 'Niste dodali novu sliku, pokušajte kasnije'
                            )
                        ));
                    }
                }
            }
            else
            {
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(array(
                        'status' => 'failed',
                        'csrf_token' => $this->security->get_csrf_hash(),
                        'errors' => array(
                            'image' => '<span class="text-danger err">Izaberite drugu sliku, ova vec postoji</span>'
                        )
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
                    'kategorija' => $this->form_validation->error('kategorija','<span class="text-danger err">','</span>')
                ),
                'csrf_token' => $this->security->get_csrf_hash()

            )));
        }


    }

    public function showCategory($id){
        $all = $this->upload_model->getAllImagesForCategory($id);
        $category =  $this->upload_model->getCategory($id);
        $categories = $this->upload_model->getAllCategories();
        $category_name = $category->naziv;

        $this->load->view('templates/header');
        $this->load->view('admin/category', compact('all', 'category_name', 'categories'));
        $this->load->view('templates/footer');
    }
}
