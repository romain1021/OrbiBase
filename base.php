<?php
function rechercheBySecteur($idSecteur){
    $connect = mysqli_connect("localhost", "root", "", "orbibase");

    if ($connect->connect_error) {
        die("erreur de connexion: " . $connect->connect_error);
    }
}
$sql = "SELECT * FROM `idSecteur` WHERE `id_secteur` = $idSecteur";

?>
