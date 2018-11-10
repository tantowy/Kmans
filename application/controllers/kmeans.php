<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include("dataSet.php");

class Kmeans extends CI_Controller {
    
    public $clustering_dok = array();
            
    function __construct(){
        parent::__construct();        
        $this->load->helper('url');
        $this->load->database(); 
        $this->load->model('tabel');
    }
    
    public function index()
    {
        $cekWtfidf = $this->tabel->ambil_weight_tfidf();
        if(count($cekWtfidf)<=0 && !isset($_POST['k_means'])){
            $data['mod_dokumen_cluster'] = null;
            $data['konfig'] = $this->tabel->ambil_konfig();
            $data['mod_clustering'] = null;

        }else{
            $var = $this->set_objek_matrik();
            $k = 5;
            $mod_tfidf = $this->tabel->ambil_weight_tfidf();
            $data['mod_dokumen_cluster'] = $this->tabel->ambil_dokumen_cluster();
            $data['konfig'] = $this->tabel->ambil_konfig();
            if(isset($_POST['k_means'])){
                $k = $_POST['k_means'];
            }
            $data['mod_clustering'] = $this->clustering($var, $k);
            
            if(isset($_POST['k_means'])){
                 $k = $_POST['k_means'];
                 foreach($mod_tfidf as $value){
                     $ada = $this->tabel->cek_dok_di_cluster($value->dokumen_id);
                     if($ada <= 0){
                         $this->tabel->insert_dok_cluster($value->dokumen_id,$value->tfidf);
                     }else{
                         $this->tabel->update_dok_cluster($value->dokumen_id,$value->tfidf);
                     }
                 }
                 $this->tabel->update_config_k($k);
                 if(count($this->clustering_dok)>0){
                     foreach ($this->clustering_dok as $key => $value) {
                     
                    }
                 }
                 if(count($this->clustering_dok)>0){
                    foreach ($this->clustering_dok as $key => $value) {
                        foreach ($value as $val){
                            $this->tabel->update_dok_cluster($val->y,$val->x,$key);
                        }
                   }
                }
            }
        }
        
        
        $this->load->view('kmeans',$data);
    }

    public function set_objek_matrik(){
        $mod_tfidf = $this->tabel->ambil_weight_tfidf();
        $jml_dok_tfidf = count($mod_tfidf);
        $jml_temp = 1;
        $temp_tfidf = '';
        $temp_tfidf .= '{"set":[';
        foreach($mod_tfidf as $value){
            if($jml_temp <> $jml_dok_tfidf){
                $temp_tfidf .= '{"x":'.$value->tfidf.',"y":'.$value->dokumen_id.'},';
            }else{
                $temp_tfidf .= '{"x":'.$value->tfidf.',"y":'.$value->dokumen_id.'}';
            }
            $jml_temp++;
        }
        $temp_tfidf .= ']}';
        return $temp_tfidf;
    }

    public function clustering($var, $k){
        
        $html = "";
        $obj = json_decode($var);
				
        $table = array();
        foreach($obj->set as $row){
            $table[] = new DataSet($row->x,$row->y);
        }
        
        $centroid = array();
        for($i=0; $i<$k; $i++)
            $centroid[] = new DataSet($table[$i]->x);

        $iteration_limit = 10;
        
        for($iteration = 0; $iteration < $iteration_limit; $iteration++){
            $html .= "<div class='alert bg-success'' role='alert'>
                        <span class='glyphicon glyphicon-info-sign'></span><b> ITERATION $iteration </b><a href='#' class='pull-right'></a>
                    </div>";

            $cluster = $this->dump($table, $centroid, $k);
            
            $html .= $this->dump_html($table, $centroid, $k);
            
            $group = array();
            for($i=0; $i<$k; $i++){
                    $group[] = array();
            }

            $i = 0;
            foreach($table as $row){
                    $group[ $cluster[$i] ][] = new DataSet( $row->x,$row->y );
                            $i++;
            }

            $new_centroid = $this->dump_group($centroid, $group, $k);
            
            $html .= $this->dump_group_html($centroid, $group, $k);

            // CHECK CHANGED IN NEW CENTROID AND BREAK
            $flag = true;	//ASSUME SAME VALUES EXIST
            $i = 0;
            foreach($new_centroid as $g){
                if( $centroid[$i]->x != $new_centroid[$i]->x)
                {
                    $flag = false;
                    break;
                }
                $i++;
            }

            if($flag){
                break;
            }

            // COPY NEW_CENTROID TO CENTROID
            $i = 0;
            foreach($new_centroid as $g){
                    $centroid[$i] = new DataSet( $g->x );
                    $i++;
            }
            
            $html .= "</br></br>";
        }
        $this->clustering_dok = $group;
        if($flag){
            $html .= "<br><div class='alert bg-warning' role='alert'>
                <span class='glyphicon glyphicon-info-sign'></span><b> CLUSTER BERHASIL DITEMUKAN </b> <a href'#' class='pull-right'></a>
            </div>";
        }else{
            $html .= "<br><div class='alert bg-warning' role='alert'>
                <span class='glyphicon glyphicon-info-sign'></span><b> ITERASI MELAMPAUI BATAS. SILAHKAN GANTI NILAI K </b> <a href'#' class='pull-right'></a>
            </div>";
        }
        return $html;
    }

    public function distance($p1, $p2){
        return abs($p1->x - $p2->x);
    }
    
    public function dump($table, $centroid, $k){
        $cluster = array();
        
            foreach($table as $row){

                $minValue = 999999;
                $minID = 0;

                for($i=0; $i<$k; $i++){
                        $dist = $this->distance($row, $centroid[$i]);
                        if($minValue > $dist){
                                $minID = $i;
                                $minValue = $dist;
                        }
                }

                    $cluster[] = $minID;
            }
            
        return $cluster;
    }
    
    public function dump_html($table, $centroid, $k){
        $html = "";
        $html .= "
        <table class='table table-bordered table-striped' data-url=''>
            <thead>
                <tr>
                    <td>X</td>";
                        for($i=0; $i<$k; $i++)
                            $html .= "<td>(".$centroid[$i]->x.")</td>";
                    $html .= "
                    <td>Cluster</td>
                </tr>
            </thead>
            <tbody>";
                foreach($table as $row){
                $html .= "
                <tr>
                    <td>
                        $row->x
                    </td>";
                        $minValue = 999999;
                        $minID = 0;

                        for($i=0; $i<$k; $i++){
                                $dist = $this->distance($row, $centroid[$i]);
                                $html .= "<td>".$dist."</td>";
                                if($minValue > $dist){
                                        $minID = $i;
                                        $minValue = $dist;
                                }
                        }

                    $html .= "
                    <td>
                        $minID
                    </td>
                </tr>";
                }
            $html .= "
            </tbody>
        </table>
        <br/><br/>";
            
        return $html;
    }
    
    public function dump_group($centroid, $group, $k){
        
        for($i=0; $i<$k; $i++){
            $x = 0;
            $c = 0;
            foreach($group[ $i ] as $set){
                    $c++;
                    $x += $set->x;
            }
            $x /= $c;
            $centroid[$i] = new DataSet($x);
        }

        return $centroid;
    }
    
    public function dump_group_html($centroid, $group, $k){
        $html = "";
        $html .= "
        <table class='table table-bordered table-striped' data-url=''>
                <thead>
                        <tr>";
                            for($i=0; $i<$k; $i++)
                                $html .= "<td>(".$centroid[$i]->x.")</td>";
                        $html .= "
                        </tr>
                </thead>
                <tbody>
                        <tr>";
                            for($i=0; $i<$k; $i++){
                                $html .= "<td>";
                                $x = 0;
                                $c = 0;
                                foreach($group[ $i ] as $set){
                                        $c++;
                                        $html .= "( ".$set->x." )<br/>";
                                        $x += $set->x;
                                }
                                $x /= $c;
                                $html .= "</td>";
                            }
                        $html .= "
                        </tr>
                </tbody>
        </table>";

        return $html;
    }
}

