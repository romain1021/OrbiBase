<?php
// Ce fichier est inclus depuis vueUtilisateur.php
// Variables attendues : $viewerId, $profileId, $user

if (!isset($viewerId) || !isset($profileId) || $viewerId !== $profileId) {
    // Ne rien afficher si on n'est pas le propriétaire
    return;
}

$messages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Changement de mot de passe
    if (isset($_POST['change_password'])) {
        $newPass = trim($_POST['new_password'] ?? '');
        if (strlen($newPass) >= 6) {
            if (updateUserPassword($profileId, $newPass)) {
                $messages[] = ['type' => 'success', 'text' => 'Mot de passe mis à jour.'];
            } else {
                $messages[] = ['type' => 'error', 'text' => 'Erreur mise à jour mot de passe.'];
            }
        } else {
            $messages[] = ['type' => 'error', 'text' => 'Le mot de passe doit contenir au moins 6 caractères.'];
        }
    }

    // Upload de photo
    if (isset($_FILES['new_photo']) && isset($_FILES['new_photo']['tmp_name']) && $_FILES['new_photo']['tmp_name'] !== '') {
        if (updateUserPhoto($profileId, $_FILES['new_photo'])) {
            $messages[] = ['type' => 'success', 'text' => 'Photo mise à jour.'];
            // rafraîchir les données utilisateur
            $user = getUserById($profileId);
        } else {
            $messages[] = ['type' => 'error', 'text' => 'Erreur lors de l\'upload de la photo.'];
        }
    }
}

// Affichage des messages
foreach ($messages as $m) {
    $color = $m['type'] === 'success' ? 'green' : 'red';
    echo '<p style="color:' . $color . ';">' . htmlspecialchars($m['text']) . '</p>';
}

?>

<h3>Modifier mon profil</h3>
<form method="post">
    <label for="new_password">Nouveau mot de passe :</label>
    <input type="password" name="new_password" id="new_password" required minlength="6" />
    <button type="submit" name="change_password">Changer le mot de passe</button>
</form>

<form method="post" enctype="multipart/form-data" style="margin-top:10px;">
    <label for="new_photo">Nouvelle photo de profil :</label>
    <input type="file" name="new_photo" id="new_photo" accept="image/*" />
    <button type="submit">Téléverser la photo</button>
</form>
