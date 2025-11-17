<?php
require_once('controller/user.php');
$userID = $_SESSION['user_id'] ?? null;
if ($userID === null) {
    header('Location: index.php?page=connexion');
    exit;
}

$user = getUserByID($userID);
if (!$user) {
    echo "<p style='color:red;'>Utilisateur non trouvé.</p>";
    exit;
}
?>
<h2>Profil Utilisateur</h2>
<div class="profile">
    <img src="images/profile.jpg" alt="Utilisateur">
    <p><strong>Identifiant :</strong> <?php echo htmlspecialchars($user['identifiant']); ?></p>
    <p><strong>Nom :</strong> <?php echo htmlspecialchars($user['nom']); ?></p>
    <p><strong>Prénom :</strong> <?php echo htmlspecialchars($user['prenom']); ?></p>
    <p><strong>Spécialité :</strong> <?php echo htmlspecialchars($user['specialite'] ?? 'N/A'); ?></p>
    <p><strong>Secteur :</strong> <?php echo htmlspecialchars($user['secteur'] ?? 'N/A'); ?></p>
    <p><strong>Statut :</strong> <?php echo htmlspecialchars($user['statut']); ?></p>  
</div>