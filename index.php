<?php
require_once('controller/user.php');

session_start();



if(isset($_GET['page'])){
    if ($_GET['page']=="home"){
        require_once('vue/homes.php');
        require_once('vue/listeAnnimal.php');
    }

    elseif ($_GET['page']=="connexion"){
        require_once('vues/connexion.php');
    }

    elseif ($_GET['page']=="inscription"){
        require_once('vues/inscription.php');
    }

}


else{
        header("Location: index.php?page=connexion");
    }

