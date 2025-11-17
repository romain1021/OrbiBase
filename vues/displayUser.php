<?php
require_once('controller/user.php');
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

?>

<?php
if ($id === null || $id === false) {
    echo '<p style="color:red;">Identifiant utilisateur manquant ou invalide.</p>';
    echo '<p><a href="index.php?page=home">Retour</a></p>';
    exit;
}
var_dump($_GET['id']);
$user = null;
$user = getUserById($id);
if (!$user) {
    echo '<p style="color:orange;">Utilisateur introuvable pour l\'id donné.</p>';
    echo '<p><a href="index.php?page=home">Retour</a></p>';
    exit;
}
?>
<h1>Utilisateur: <?php echo htmlspecialchars($user['identifiant'] ?? $user['id'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></h1>
<ul>
    <li><strong>Nom :</strong> <?php echo htmlspecialchars($user['nom'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></li>
    <li><strong>Prénom :</strong> <?php echo htmlspecialchars($user['prenom'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></li>
    <li><strong>Statut :</strong> <?php echo htmlspecialchars($user['statut'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></li>
    <li><strong>Spécialité (id) :</strong> <?php echo htmlspecialchars($user['idSpecialite'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></li>
    <li><strong>Secteur (id) :</strong> <?php echo htmlspecialchars($user['idSecteur'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></li>
</ul>
</body>
</html>
