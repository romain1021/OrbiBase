<?php
function rechercheBySecteur($idSecteur){
    $connect = mysqli_connect("localhost", "root", "", "orbibase");

    if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
    }
}

?>
