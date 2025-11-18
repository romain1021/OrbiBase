<?php
require_once('controller/user.php');
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$viewerId = $_SESSION['user_id'] ?? null;

$profileId = isset($_GET['id']) && $_GET['id'] !== '' ? (int) $_GET['id'] : $viewerId;

if ($profileId === null) {
    header('Location: index.php?page=connexion');
    exit;
}

$user = getUserById($profileId);
if (!$user) {
    echo "<p style='color:red;'>Utilisateur non trouvé.</p>";
    exit;
}
?>
<h2>Profil Utilisateur</h2>

<?php if (!empty($user['lienPDP'])): ?>
    <p><img src="<?php echo htmlspecialchars($user['lienPDP']); ?>" alt="Photo de <?php echo htmlspecialchars($user['identifiant']); ?>" style="max-width:200px;max-height:200px;border-radius:6px;" /></p>
<?php else: ?>
    <p>Aucune photo de profil.</p>
<?php endif; ?>

<p><strong>Identifiant :</strong> <?php echo htmlspecialchars($user['identifiant']); ?></p>
<p><strong>Nom :</strong> <?php echo htmlspecialchars($user['nom']); ?></p>
<p><strong>Prénom :</strong> <?php echo htmlspecialchars($user['prenom']); ?></p>
<p><strong>Spécialité :</strong> <?php echo htmlspecialchars($user['specialite'] ?? 'N/A'); ?></p>
<p><strong>Secteur :</strong> <?php echo htmlspecialchars($user['secteur'] ?? 'N/A'); ?></p>
<p><strong>Statut :</strong> <?php echo htmlspecialchars($user['statut']); ?></p>

<?php
// Si l'utilisateur visualisé est le même que la session, afficher la vue de modification dessous
if ($viewerId !== null && $viewerId === $profileId) {
    // inclut le formulaire et le traitement (fichier séparé)
    include __DIR__ . '/modif.php';
}

?>

