<?php
// fonction qui teste les données des ressources et affiche une alerte si une ressource est critique
$test = getLatestResources();
if ($test['oxygene'] < 20 || $test['nourriture'] < 20 || $test['eau'] < 20 || $test['energie'] < 20) {
    echo' <script>alert("Attention : Les ressources sont critiques ! Veuillez agir rapidement pour éviter une situation dangereuse.");</script>';
}