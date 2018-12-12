<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function getAllCities()
    {

        $q = $this
            ->db
            ->select('*')
            ->order_by('naziv', 'ASC')
            ->get('gradovi');

        return $q->result();
    }

    public function getAllTownship($city_id)
    {
        $q = $this
            ->db
            ->select('*')
            ->where('grad_id', $city_id)
            ->order_by('naziv', 'ASC')
            ->get('opstine');

        return $q->result();
    }

    public function insertNewStore($arr)
    {
        $this->db->insert('main', $arr);
    }

    public function getAllStores(){
       $q = $this
            ->db
            ->select('main.naziv AS naziv, main.adresa AS adresa,gradovi.naziv AS grad, opstine.naziv AS opstina, main.lat, main.lon')
            ->from('main')
            ->join('gradovi', 'gradovi.id = main.grad_id')
            ->join('opstine', 'opstine.id = main.opstina_id')
            ->order_by('created_at', 'DESC')
            ->get();

        return $q->result();
    }



}