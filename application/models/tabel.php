<?php
class Tabel extends CI_Model {

    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function cek_kt_dasar($kata) {
        $query = $this->db->query('select katadasar_nama from katadasar_m where katadasar_nama="' . $kata . '"');
        $result = $query->num_rows();
        return $result;
    }

    public function sum_dokumen() {
        $query = $this->db->query('select * from dokumen_m');
        $result = $query->num_rows();
        return $result;
    }

    public function ambil_term() {
        $query = $this->db->query('select * from term_dokumen_m order by term_id');
        $result = $query->result();
        return $result;
    }
    
    public function ambil_dokumen() {
        $query = $this->db->query('select * from dokumen_m order by dokumen_tahun desc');
        $result = $query->result();
        return $result;
    }
    
    public function ambil_dokumen_search($data) {
        $query = $this->db->query('select * from dokumen_m where dokumen_judul like "%'.$data.'%" order by dokumen_tahun desc');
        $result = $query->result();
        return $result;
    }
    
    public function ambil_dokumen_by_cluster($cluster) {
        $query = $this->db->query('SELECT * FROM dokumen_m
                                    JOIN cluster ON cluster.`dokumen_id`=dokumen_m.`dokumen_id` 
                                    WHERE cluster='.$cluster.' ORDER BY dokumen_tahun DESC');
        $result = $query->result();
        return $result;
    }
    
    public function ambil_dokumen_by_cluster_search($cluster,$data) {
        $query = $this->db->query('SELECT * FROM dokumen_m
                                    JOIN cluster ON cluster.`dokumen_id`=dokumen_m.`dokumen_id` 
                                    WHERE cluster='.$cluster.' AND dokumen_judul like "%'.$data.'%" ORDER BY dokumen_tahun DESC');
        $result = $query->result();
        return $result;
    }
    
    public function ambil_cluster(){
        $query = $this->db->query('SELECT COUNT(dokumen_id) AS jumlah FROM cluster GROUP BY cluster ORDER BY cluster ASC');
        $result = $query->result();
        return $result;
    }

    public function ambil_term_by_term($term) {
        $query = $this->db->query('select count(*) as N from term_dokumen_m where term_kata="' . $term . '"');
        $result = $query->row();
        return $result->N;
    }
    
    public function ambil_dokumen_cluster(){
        $query = $this->db->query('SELECT * FROM cluster JOIN dokumen_m ON dokumen_m.`dokumen_id`=cluster.`dokumen_id` ORDER BY cluster');
        $result = $query->result();
        return $result;
    }

    public function ambil_max_iddokumen() {
        $query = $this->db->query('select max(dokumen_id) as max from dokumen_m');
        $result = $query->row();
        return $result->max;
    }
    
    public function ambil_weight_tfidf(){
        $query = $this->db->query('SELECT SUM(term_tfidf) as tfidf,dokumen_id FROM term_dokumen_m GROUP BY dokumen_id ORDER BY dokumen_id');
        $result = $query->result();
        return $result;
    }
    
    public function cek_dok_di_cluster($dokumen_id){
        $query = $this->db->query('select count(dokumen_id) as ada from cluster where dokumen_id='.$dokumen_id);
        $result = $query->row();
        return $result->ada;
    }

    public function ambil_konfig(){
        $query = $this->db->query('SELECT * FROM konfig');
        $result = $query->result();
        return $result;
    }

    public function insert_dokumen($data) {
        $this->db->insert('dokumen_m', $data);
    }
    
    public function insert_dokumen_term($data) {
        $this->db->insert('term_dokumen_m', $data);
    }
    
    public function iddoc_not_instem() {
        $query = $this->db->query('SELECT dokumen_m.`dokumen_id`,dokumen_judul FROM dokumen_m WHERE dokumen_m.`dokumen_id` NOT IN (SELECT term_dokumen_m.`dokumen_id` FROM term_dokumen_m)');
        $result = $query->result();
        return $result;
    }
    
    public function count_iddoc_not_instem() {
        $query = $this->db->query('SELECT count(dokumen_m.`dokumen_id`) as jumlah FROM dokumen_m WHERE dokumen_m.`dokumen_id` NOT IN (SELECT term_dokumen_m.`dokumen_id` FROM term_dokumen_m)');
        $result = $query->row();
        return $result->jumlah;
    }
    
    public function load_weight_tfidf(){
        $query = $this->db->query('SELECT dokumen_m.dokumen_id,dokumen_judul,SUM(term_tfidf) as tfidf FROM term_dokumen_m 
                                    JOIN dokumen_m ON dokumen_m.`dokumen_id`=term_dokumen_m.`dokumen_id`
                                    GROUP BY dokumen_id ORDER BY dokumen_id');
        $result = $query->result();
        return $result;
    }

        public function detail($id)
    {
        $query = $this->db->query('SELECT * FROM dokumen_m WHERE dokumen_id="'.$id.'"');
        foreach ($query->result() as $value) {
                $data[0][] = $value->dokumen_judul;
                $data[1][] = $value->dokumen_tahun;
                $data[2][] = $value->nama;
                $data[3][] = $value->fakultas;
                $data[4][] = $value->jurusan;
                $data[5][] = $value->abstrak;
                $data[6][] = $value->url;
        }
        return $data;
    }
    
    public function update_bobot($id,$bobot){
        $query = $this->db->query('UPDATE term_dokumen_m SET term_tfidf='.$bobot.' WHERE term_id='.$id.'');
    }
    
    public function load_term() {
        $query = $this->db->query('SELECT term_kata FROM term_dokumen_m GROUP BY term_kata');
        $result = $query->result();
        return $result;
    }
    public function get_bobot($dokumen_id,$term) {
        $query = $this->db->query('SELECT term_tfidf FROM term_dokumen_m WHERE dokumen_id='.$dokumen_id.' AND term_kata="'.$term.'"');
        $result = $query->row();
        if(isset($result->term_tfidf)){
            return $result->term_tfidf;
        }else{
            return 0;
        }
    }
    
    public function cek_dokumen_cluster($dokumen_id){
        $query = $this->db->query('SELECT id_cluster FROM cluster WHERE dokumen_id='.$dokumen_id);
        $result = $query->row();
        if(isset($result->id_cluster)){
            return 1;
        }else{
            return 0;
        }
    }
    
    public function cek_dokumen_in($dokumen_id = array()){
        $query = $this->db->query('SELECT dokumen_id FROM cluster WHERE dokumen_id='.$dokumen_id);
        $result = $query->result();
    }
    
    public function insert_dok_cluster($dokumen_id,$tfidf,$cluster="(NULL)"){
        $query = $this->db->query('insert into cluster (dokumen_id,term_tfidf,cluster) values ('.$dokumen_id.','.$tfidf.','.$cluster.')');
    }
    
    public function update_dok_cluster($dokumen_id,$tfidf,$cluster="(NULL)"){
        $query = $this->db->query('update cluster set term_tfidf='.$tfidf.',cluster='.$cluster.' where dokumen_id='.$dokumen_id);
    }
    
    public function update_config_k($k){
        $query = $this->db->query('update konfig set jml_cluster='.$k.' where id_konfig=1');
    }

    public function hapus_cluster(){
        $this->db->truncate('cluster');
    }

}
?>
