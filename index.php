<?php
require_once('controller/user.php');
require_once('controller/resourcesController.php');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$page = $_GET['page'] ?? null;

if (!$page) {
    if (!empty($_SESSION['user_id'])) {
        header('Location: index.php?page=home');
    } else {
        header('Location: index.php?page=connexion');
    }
    exit;
}

if ($page === 'cookies' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accept'])) {
        setcookie('cookies_accepted', '1', time() + 365*24*3600, '/');
    } elseif (isset($_POST['decline'])) {
        setcookie('cookies_accepted', '0', time() + 365*24*3600, '/');
    }
    $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php?page=home';
    header('Location: ' . $redirect);
    exit;
}

require_once('vues/header.php');


switch ($page) {
    case 'home':
        require_once('vues/home.php');
        require_once('vues/vueUtilisateur.php');
        require_once('controller/resourcescritique.php');
        require_once('vues/cookies.php');
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
        require_once('vues/cookies.php');
        break;
    default:
        header('Location: index.php?page=connexion');
        exit;
}
require_once('vues/footer.php');
?>

</body>
</html>

