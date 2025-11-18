<?php
require_once('controller/user.php');
require_once('controller/resourcesController.php');

session_start();
require_once('vues/header.php');

$page = $_GET['page'] ?? null;

if ($page) {
    //require_once('vues/cookies.php');
    require_once('vues/resourcescritique.php');

    switch ($page) {
        case 'home':
            require_once('vues/home.php');
            require_once('vues/vueUtilisateur.php');
            break;
        case 'connexion':
            require_once('vues/connexion.php');
            break;
        case 'inscription':
            require_once('vues/inscription.php');
            break;
        case 'resources':
            require_once('vues/resources.php');
            break;
        case 'displayUser':
            require_once('vues/vueUtilisateur.php');
            break;
        case 'affectation':
            require_once('vues/affectation.php');
            break;
        case 'userInfos':
            require_once('vues/vueUtilisateur.php');
            break;
        default:
            header('Location: index.php?page=connexion');
            exit;
    }

} else {
    if (!empty($_SESSION['user_id'])) {
        header('Location: index.php?page=home');
    } else {
        header('Location: index.php?page=connexion');
    }
    exit;
}
