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

    function getResources(): array{
        return[
            $this->oxygene=$oxygene,
            $this->nourriture=$nourriture,
            $this->eau=$eau,
            $this->energie=$energie,
        ];
        
    }

    function ResourcesIsCritique(): bool {
    $critique = false;

        if ($this->oxygene < 20) {
            echo "<script>alert('Niveau d'Oxygène critique !');</script>";
            $critique = true;
        }
        if ($this->nourriture < 20) {
            echo "<script>alert('Niveau de Nourriture critique !');</script>";
            $critique = true;
        }
        if ($this->eau<20){
            echo"<script>alert('Niveau d'Eau critique !');</script>";
            $critique=true;
        }
        if($this->energie<20){
            echo"<script>alert('Niveau d'Energie critique !');</script>";
            $critique=true;
        }
    }

    
}