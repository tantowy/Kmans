<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller {
    
    function __construct(){
        parent::__construct();        
        $this->load->helper('url');
        $this->load->database(); 
        $this->load->model('tabel');
    }
    
    public function index()
    {
        $username = isset($_POST['username'])? $_POST['username'] : "";
        $password = isset($_POST['password'])? $_POST['password'] : "";
        if(isset($_POST['password']) || isset($_POST['username'])){
            redirect('dokumen');
        }
        $this->load->view('login');
    }
}