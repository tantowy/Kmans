<?php

class DataSet extends CI_Controller {
    public $x;
    public $y;
    
    function __construct($x,$y=null){
        $this->x = $x;
        $this->y = $y;
    }
}

