<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include("teksProcessing.php");
class Jurnal extends CI_Controller {
    
    function __construct(){
        parent::__construct();        
        $this->load->helper('url');
        $this->load->database(); 
        $this->load->model('tabel');
    }
    
    public function index()
    {
        $data['dokumen'] = $this->tabel->ambil_dokumen();
        $data['cluster'] = $this->tabel->ambil_cluster();
        $adaCluster = false;
        if(isset($_GET['cluster']) && $_GET['cluster'] <> ""){
            $cluster = ($_GET['cluster']-1);
            $data['dokumen'] = $this->tabel->ambil_dokumen_by_cluster($cluster);
            $adaCluster = true;
        }
        if(isset($_GET['data'])){
            if($adaCluster){
                $data['dokumen'] = $this->tabel->ambil_dokumen_by_cluster_search($cluster,$_GET['data']);
            }else{
                $data['dokumen'] = $this->tabel->ambil_dokumen_search($_GET['data']);
            }
        }
        $this->load->view('jurnal',$data);
        
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
        redirect('jurnal');
    }
    
    public function tampil_detail(){
        $id = $this->input->post('id');
        $array = $this->tabel->detail($id);
        echo json_encode($array);
    }

}