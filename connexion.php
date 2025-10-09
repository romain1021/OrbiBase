<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <form action="" method="post">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" id="username" required />
        
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required />
        <br>
        
        <input type="submit" value="Se connecter" />

        <button type="button" onclick="location.href='inscription.php'">Créer un compte</button>
    </form>
</body>
</html>
    
<?php
require_once("../controller/logincontroller.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkUserCredentials($_POST['username'], $_POST['password']);
}
?>