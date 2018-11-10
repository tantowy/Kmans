<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include("teksProcessing.php");
class Dokumen extends CI_Controller {
    
    function __construct(){
        parent::__construct();        
        $this->load->helper('url');
        $this->load->database(); 
        $this->load->model('tabel');
    }
    
    public function index()
    {
        $data['dokumen'] = $this->tabel->ambil_dokumen();
       $this->load->view('dokumen',$data);
        foreach ($this->tabel->ambil_dokumen() as $key1=>$value1){
            foreach ($this->tabel->load_term() as $key2=>$value2){
                $term[$key1][$key2] = $this->tabel->get_bobot($value1->dokumen_id,$value2->term_kata);
            }
        }
        
        // echo "<pre>";
        // print_r($term);
        
    }
    
    public function insert_dokumen() {
        $processing = new TeksProcessing();
        $judul_dokumen = $this->input->post('judul');
        $data_dokumen = array(
            'dokumen_judul' => $this->input->post('judul'),
            'dokumen_tahun' => $this->input->post('tahun'),
            'nama' => $this->input->post('nama'),
            'fakultas' => $this->input->post('fakultas'),
            'jurusan' => $this->input->post('jurusan'),
            'abstrak' => $this->input->post('abstrak'),
            'url' => $this->input->post('url'),
        );

        $this->tabel->insert_dokumen($data_dokumen);
        $id_dokumen = $this->tabel->ambil_max_iddokumen();
        $processing->Processing($judul_dokumen, $id_dokumen);
        redirect('dokumen');
    }
    
    public function tampil_detail(){
        $id = $this->input->post('id');
        $array = $this->tabel->detail($id);
        echo json_encode($array);
    }

}