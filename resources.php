<?php
class resources{
    private $oxygene;
    private $nourriture;
    private $eau; 
    private $energie;
    private $date_heure;

    function __construct($oxygene=100, $nourriture=100, $eau=100, $energie=100, $date_heure){
        $this->oxygene=$oxygene;
        $this->nourriture=$nourriture;
        $this->eau=$eau;
        $this->energie=$energie;
        $this->date_heure=date('Y-m-d H:i:s');
    }

    function getResources(){

    }
        
    

    
}