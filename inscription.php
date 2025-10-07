<?php
    $dsn = 'mysql:host=127.0.0.1;dbname=orbibase;charset=utf8mb4';
    $dbUser = 'root';
    $dbPass = '';
    $conn = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <form action="" method="post">
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

        <br />
        <input type="submit" value="S'inscrire" />
        <button type="button" onclick="location.href='connexion.php'">Retour à la connexion</button>
        <button type="submit" name="test_password" value="1" style="background-color: #3498db; margin-left: 10px;">Tester PasswordQuality</button>
    </form>
</body>
</html>

<?php
require_once("user.php");



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        echo "<p style='color:green;'>Compte créé avec succès. ID utilisateur : $newUserId</p>";
    } catch (Exception $e) {
        echo "<p style='color:red;'>Erreur lors de la création du compte : " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
