<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Penjualan extends MY_Admin {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_penjualan');
    } 

    public function getDataBarang(){
      
       $this->M_penjualan->ambilBarang();
    }

}    