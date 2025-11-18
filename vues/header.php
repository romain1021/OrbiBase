<?php
if (isset($_SESSION['user_id'])) {
    ?>
    <nav class="navbar" style="padding:10px;background:#f5f5f5;display:flex;gap:10px;">
        <a href="index.php?page=home" >home</a>
        <a href="index.php?page=resources" >Ressources</a>
        <a href="index.php?page=affectation" >Affectation</a>
        <a href="controller/logout.php">Déconnexion</a>
    </nav>
    <?php

}

