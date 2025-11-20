<?php

$specialites = [];
$secteurs = [];
try {
    $pdo = getLocalPDO();
    $specialites = $pdo->query('SELECT id, nom FROM Specialite ORDER BY nom')->fetchAll();
    $secteurs = $pdo->query('SELECT id, nom FROM Secteur ORDER BY nom')->fetchAll();
} catch (Exception $e) {
    $specialites = [];
    $secteurs = [];
}
?>

    <form action="" method="post" enctype="multipart/form-data">
        <label for="identifiant">Identifiant :</label>
        <input type="text" name="identifiant" id="identifiant" required />

        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" />

        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" />

        <label for="mdp">Mot de passe :</label>
        <input type="password" name="mdp" id="mdp" required />
        <small style="color: #666;">
            Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.
        </small>

        <label for="idSpecialite">Spécialité :</label>
        <select name="idSpecialite" id="idSpecialite">
            <option value="">-- Aucune --</option>
            <?php foreach ($specialites as $s): ?>
                <option value="<?= htmlspecialchars($s['id']) ?>"><?= htmlspecialchars($s['nom']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="idSecteur">Secteur :</label>
        <select name="idSecteur" id="idSecteur">
            <option value="">-- Aucune --</option>
            <?php foreach ($secteurs as $se): ?>
                <option value="<?= htmlspecialchars($se['id']) ?>"><?= htmlspecialchars($se['nom']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="statut">Statut :</label>
        <select name="statut" id="statut">
            <option value="Actif">Actif</option>
            <option value="Repos">Repos</option>
            <option value="Malade">Malade</option>
            <option value="Danger">Danger</option>
        </select>

        <label for="photo">Photo de profil (jpg/png/gif) :</label>
        <input type="file" name="photo" id="photo" accept="image/*" />

        <br />
        <input type="submit" value="S'inscrire" />
        <button type="button" onclick="location.href='index.php?page=connexion'">Retour à la connexion</button>
        <button type="submit" name="test_password" value="1" style="background-color: #3498db; margin-left: 10px;">Tester PasswordQuality</button>
    </form>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['test_password'])) {
        $pw = $_POST['mdp'] ?? '';
        $errors = [];
        if (strlen($pw) < 12) $errors[] = 'Moins de 12 caractères.';
        if (!preg_match('/[A-Z]/', $pw)) $errors[] = 'Pas de majuscule.';
        if (!preg_match('/[a-z]/', $pw)) $errors[] = 'Pas de minuscule.';
        if (!preg_match('/\d/', $pw)) $errors[] = 'Pas de chiffre.';
        if (!preg_match('/[^a-zA-Z\d]/', $pw)) $errors[] = 'Pas de caractère spécial.';

        if (empty($errors)) {
            echo '<p style="color:green;">Mot de passe OK.</p>';
        } else {
            echo '<p style="color:red;">' . implode(' ', $errors) . '</p>';
        }
    } else {
        try {
            $newUserId = addUser(
                $_POST['identifiant'] ?? null,
                $_POST['mdp'] ?? null,
                $_POST['nom'] ?? '',
                $_POST['prenom'] ?? '',
                isset($_POST['idSpecialite']) && $_POST['idSpecialite'] !== '' ? (int) $_POST['idSpecialite'] : null,
                isset($_POST['idSecteur']) && $_POST['idSecteur'] !== '' ? (int) $_POST['idSecteur'] : null,
                $_POST['statut'] ?? 'Actif'
            );
            echo "<p style='color:green;'>Compte créé avec succès. ID utilisateur : " . htmlspecialchars($newUserId) . "</p>";
        } catch (Exception $e) {
            echo "<p style='color:red;'>Erreur lors de la création du compte : " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
}
