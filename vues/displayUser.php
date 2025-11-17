<?php
require_once('controller/user.php');
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id === null || $id === false) {
    echo '<p style="color:red;">Identifiant utilisateur manquant ou invalide.</p>';
    echo '<p><a href="index.php?page=home">Retour</a></p>';
    exit;
}

$user = getUserById($id);
if (!$user) {
    echo '<p style="color:orange;">Utilisateur introuvable pour l\'id donné.</p>';
    echo '<p><a href="index.php?page=home">Retour</a></p>';
    exit;
}

session_start();
$currentUserId = $_SESSION['user_id'] ?? null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $currentUserId === $id) {
    if (isset($_POST['change_password'])) {
        $newPass = $_POST['new_password'] ?? '';
        if (strlen($newPass) >= 6) {
            if (updateUserPassword($id, $newPass)) {
                echo '<p style="color:green;">Mot de passe mis à jour.</p>';
            } else {
                echo '<p style="color:red;">Erreur mise à jour mot de passe.</p>';
            }
        } else {
            echo '<p style="color:red;">Le mot de passe doit contenir au moins 6 caractères.</p>';
        }
    }
    if (isset($_FILES['new_photo'])) {
        if (updateUserPhoto($id, $_FILES['new_photo'])) {
            echo '<p style="color:green;">Photo mise à jour.</p>';
            $user = getUserById($id);
        } else {
            echo '<p style="color:red;">Erreur lors de l\'upload de la photo.</p>';
        }
    }
}

?>
<h1>Utilisateur: <?php echo htmlspecialchars($user['identifiant'] ?? $user['id'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></h1>

<?php if (!empty($user['lienPDP'])): ?>
    <p><img src="<?php echo htmlspecialchars($user['lienPDP']); ?>" alt="Photo de <?php echo htmlspecialchars($user['identifiant']); ?>" style="max-width:200px;max-height:200px;border-radius:6px;" /></p>
<?php else: ?>
    <p>Aucune photo de profil.</p>
<?php endif; ?>

<ul>
    <li><strong>Nom :</strong> <?php echo htmlspecialchars($user['nom'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></li>
    <li><strong>Prénom :</strong> <?php echo htmlspecialchars($user['prenom'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></li>
    <li><strong>Statut :</strong> <?php echo htmlspecialchars($user['statut'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></li>
    <li><strong>Spécialité :</strong> <?php echo htmlspecialchars($user['specialite'] ?? 'N/A', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></li>
    <li><strong>Secteur :</strong> <?php echo htmlspecialchars($user['secteur'] ?? 'N/A', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></li>
</ul>

<?php if ($currentUserId === $id): ?>
    <h2>Modifier mon profil</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="new_password">Nouveau mot de passe :</label>
        <input type="password" name="new_password" id="new_password" />
        <button type="submit" name="change_password">Changer le mot de passe</button>
    </form>

    <form method="post" enctype="multipart/form-data" style="margin-top:10px;">
        <label for="new_photo">Nouvelle photo de profil :</label>
        <input type="file" name="new_photo" id="new_photo" accept="image/*" />
        <button type="submit">Téléverser la photo</button>
    </form>
<?php endif; ?>

</body>
</html>
