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

   public function getResources(){
    return [
        'oxygene' => $this->oxygene,
        'nourriture' => $this->nourriture,
        'eau' => $this->eau,
        'energie' => $this->energie
    ];
}

    function ResourcesIsCritique(){
    $critique = false;

        if ($this->oxygene < 20) {
            echo "<script>alert('Le niveau d'Oxygène est critique !');</script>";
            $critique = true;
        }
        if ($this->nourriture < 20) {
            echo "<script>alert('Le niveau de Nourriture est critique !');</script>";
            $critique = true;
        }
        if ($this->eau<20){
            echo"<script>alert('Le niveau d'Eau est critique !');</script>";
            $critique=true;
        }
        if($this->energie<20){
            echo"<script>alert('Le niveau d'Energie est critique !');</script>";
            $critique=true;
        }
    }

    
}