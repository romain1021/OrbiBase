<?php
require_once('controller/user.php');
session_start();
$userID = $_SESSION['user_id'] ?? null;
if ($userID === null) {
    header('Location: index.php?page=connexion');
    exit;
}

$user = getUserById($userID);
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['change_password'])) {
        $newPass = $_POST['new_password'] ?? '';
        if (strlen($newPass) >= 6) {
            if (updateUserPassword($userID, $newPass)) {
                echo '<p style="color:green;">Mot de passe mis à jour.</p>';
            } else {
                echo '<p style="color:red;">Erreur mise à jour mot de passe.</p>';
            }
        } else {
            echo '<p style="color:red;">Le mot de passe doit contenir au moins 6 caractères.</p>';
        }
    }
    if (isset($_FILES['new_photo'])) {
        if (updateUserPhoto($userID, $_FILES['new_photo'])) {
            echo '<p style="color:green;">Photo mise à jour.</p>';
            $user = getUserById($userID);
        } else {
            echo '<p style="color:red;">Erreur lors de l\'upload de la photo.</p>';
        }
    }
}
?>

<h3>Modifier mon profil</h3>
<form method="post">
    <label for="new_password">Nouveau mot de passe :</label>
    <input type="password" name="new_password" id="new_password" />
    <button type="submit" name="change_password">Changer le mot de passe</button>
</form>

<form method="post" enctype="multipart/form-data" style="margin-top:10px;">
    <label for="new_photo">Nouvelle photo de profil :</label>
    <input type="file" name="new_photo" id="new_photo" accept="image/*" />
    <button type="submit">Téléverser la photo</button>
</form>
