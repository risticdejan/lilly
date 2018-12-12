<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barcode_model extends CI_Model
{
    public function getAllCodes()
    {

        $q = $this
            ->db
            ->select('code')
            ->order_by('code', 'ASC')
            ->get('barcode');

        $res = array();

        foreach ($q->result() as $row)
        {
            $res[] = $row->code;
        }

        return $res;
    }

    public function getCodes()
    {

        $q = $this
            ->db
            ->select('*')
            ->order_by('code', 'ASC')
            ->get('barcode');

        return $q->result();
    }

    public function searchCodes($code, $name) {
        $q = $this
            ->db
            ->order_by('name', 'DESC')
            ->like("name", $name)
            ->like("code", $code)
            ->limit(15)
            ->get('barcode');

        return $q->result();
    }

}