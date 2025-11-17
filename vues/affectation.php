<?php
// $pdo = new PDO("mysql:host=localhost;dbname=orbibase", "root", ""); 
$pdo = new PDO("mysql:host=localhost;dbname=test","root",""); 
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

$filtre = $_GET['filtre'] ?? '';
if ($filtre !== '') {
    $result = $pdo->prepare("SELECT * FROM user WHERE idSecteur = :filtre");
    $result->bindParam(':filtre', $filtre, PDO::PARAM_INT);
} else {
    $result = $pdo->prepare("SELECT * FROM user");
}
$result->execute();   
$users = $result->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Affectations</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        select, button { padding: 5px; margin-top: 10px; }
    </style>
</head>
<body>

<h2> Affectations — Liste des utilisateurs</h2>

<form method="GET" action="affectation.php">
    <label for="filtre">Rechercher par secteur: </label>
    <select name="filtre" id="filtre">
        <option value="">-- Tous --</option>
        <option value="1" <?= $filtre === '1' ? 'selected' : '' ?>>Recherche</option>
        <option value="2" <?= $filtre === '2' ? 'selected' : '' ?>>Agriculture</option>
        <option value="3"<?= $filtre === '3'? 'selected' : '' ?>>Maintenance</option>
        <option value="4"<?= $filtre === '4'? 'selected' : '' ?>>Médecine</option>
        <option value="5"<?= $filtre === '5'? 'selected' : '' ?>>Commandement</option>
    </select>
    <button type="submit">Rechercher</button>
</form>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Statut</th>
        <th>Secteur</th>
    </tr>

    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['nom'] ?></td>
            <td><?= $user['prenom'] ?></td>
            <td><?= $user ['statut'] ?></td>
            <td>
                <?= match ($user['idSecteur']){
                    1 => 'Recherche',
                    2 => 'Agriculture', 
                    3 => 'Maintenance',
                    4 => 'Médecine',
                    5 => 'commandement'
                }
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>

