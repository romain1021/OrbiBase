<?php
require_once('controller/user.php');
require_once('controller/resourcesController.php');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$page = $_GET['page'] ?? null;

// Si aucune page demandée, rediriger vers connexion ou home
if (!$page) {
    if (!empty($_SESSION['user_id'])) {
        header('Location: index.php?page=home');
    } else {
        header('Location: index.php?page=connexion');
    }
    exit;
}

// Traite les POSTs de la bannière cookies avant toute sortie HTML
if ($page === 'cookies' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accept'])) {
        setcookie('cookies_accepted', '1', time() + 365*24*3600, '/');
    } elseif (isset($_POST['decline'])) {
        // stocke la décision (0 = refusé) pour masquer la bannière
        setcookie('cookies_accepted', '0', time() + 365*24*3600, '/');
    }
    $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php?page=home';
    header('Location: ' . $redirect);
    exit;
}

// Wrapper HTML
?><!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>OrbiBase</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
// header (navbar)
require_once('vues/header.php');

// vue de criticité / notifications générales
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
    case 'cookies':
        // page gérant les cookies (POSTs du banner)
        require_once('vues/cookies.php');
        break;
    default:
        header('Location: index.php?page=connexion');
        exit;
}

?>

</body>
</html>

