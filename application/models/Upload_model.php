<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_model extends CI_Model
{
    public function getAllCategories()
    {

        $q = $this
            ->db
            ->select('*')
            ->order_by('naziv', 'ASC')
            ->get('kategorije');

        return $q->result();
    }

    public function getCategory($id)
    {

        $q = $this
            ->db
            ->select('*')
            ->where('id',$id)
            ->limit(1)
            ->get('kategorije');

        return $q->row();
    }

    public function insertNewImage($arr)
    {
        $this->db->insert('slike', $arr);
    }

    public function getImage($category_id, $name)
    {
        $q = $this
            ->db
            ->select('*')
            ->where('kategori_id',$category_id)
            ->where('naziv', $name)
            ->limit(1)
            ->get('slike');

        return $q->row();
    }

    public function getAllImagesForCategory($id){
        $q = $this
            ->db
            ->select('slike.naziv AS slika, kategorije.naziv AS kategorija, kategorije.direkorijum AS direktorijum')
            ->join('kategorije', 'kategorije.id = slike.kategori_id')
            ->where('slike.kategori_id', $id)
            ->limit(10)
            ->get('slike');

        return $q->result();
    }
}