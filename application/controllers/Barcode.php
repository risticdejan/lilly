<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barcode extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if(!check_login()) redirect(site_url('home'));

        $this->load->model('barcode_model');
    }


    public function index() {
        $this->load->view('templates/header');
        $this->load->view('barcode/index');
        $this->load->view('templates/footer');
    }

    public function insert(){
        if(!$this->input->is_ajax_request()) redirect(site_url('barcode'));

        $unique_codes = $this->barcode_model->getAllCodes();

        $barcodes = array();

        if ($fh = fopen(PUBPATH.'/resources/sample products.csv', 'r')) {
            while (!feof($fh)) {
                $line_arr = explode(';',fgets($fh));
                if(!empty($line_arr[1]) && $line_arr[0] != 'barkod'  && !in_array($line_arr[0], $unique_codes)){
                    $barcodes[$line_arr[0]] = $line_arr[1];
                }
            }

            fclose($fh);

            if(!empty($barcodes)){
                $data = array();
                foreach ( $barcodes as $k => $v){
                    $data[] = array(
                        'code' => $k,
                        'name' => $v
                    );
                }

                $this->db->insert_batch('barcode', $data, TRUE);

                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(array(
                        'status' => 'success',
                        'csrf_token' => $this->security->get_csrf_hash(),
                        'message' => 'Uspešno ste prebacili podatke u bazu'
                    )
                ));
            } else {
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(array(
                        'status' => 'success',
                        'csrf_token' => $this->security->get_csrf_hash(),
                        'message' => 'Nije bilo novih unosa u bazu'
                    )
                ));
            }
        }
    }

    public function delete() {
        if(!$this->input->is_ajax_request()) redirect(site_url('barcode'));

        $this->db->query('TRUNCATE barcode');

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode(array(
                'status' => 'success',
                'csrf_token' => $this->security->get_csrf_hash(),
                'message' => "Obrisani su podaci u bazi"
            )
        ));
    }

    public function autocomplete(){
        if(!$this->input->is_ajax_request()) redirect(site_url('barcode'));

        $name = $this->input->post('name',true);
        $code = $this->input->post('code',true);

        $arr_suggest = $this->barcode_model->searchCodes($code, $name);

        if(!empty($arr_suggest)){
            $this->output->set_output(json_encode(array(
                    'status' => 'success',
                    'csrf_token' => $this->security->get_csrf_hash(),
                    'arr' => $arr_suggest,
                    'url' => site_url('barcode')
                )
            ));
        } else {
            $this->output->set_output(json_encode(array(
                    'status' => 'success',
                    'csrf_token' => $this->security->get_csrf_hash(),
                    'arr' => array(),
                    'url' => site_url('barcode/all')
                )
            ));
        }
    }

    public function search()
    {
        $name = $this->input->post('name',true);
        $code = $this->input->post('code',true);

        $res = array();

        if($name == '' && $code == '') {
            $res = $this->barcode_model->getCodes();
        } else{
            $res = $this->barcode_model->searchCodes($code, $name);
        }

        $this->load->view('templates/header');
        $this->load->view('barcode/search',compact('res'));
        $this->load->view('templates/footer');
    }

}
