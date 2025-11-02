<?php
require_once('controller/user.php');
require_once('controller/resourcesController.php');

session_start();


if(isset($_GET['page'])){
    //require_once('vues/cookies.php');

    if ($_GET['page']=="home"){
        require_once('vues/home.php');
    }

    elseif ($_GET['page']=="connexion"){
        require_once('vues/connexion.php');
    }

    elseif ($_GET['page']=="inscription"){
        require_once('vues/inscription.php');
    }

    elseif ($_GET['page']=="resources"){
        require_once('vues/resources.php');
    }





}


else{
        header("Location: index.php?page=connexion");
    }

