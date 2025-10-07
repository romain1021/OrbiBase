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
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" id="username" required />
        <br />
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required />
        <small style="color: #666;">
            Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.
        </small>
        <br />
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required />
        <br />
        <input type="submit" value="S'inscrire" />
        
        <button type="button" onclick="location.href='connexion.php'">Retour à la connexion</button>
        <button type="submit" name="test_password" value="1" style="background-color: #3498db; margin-left: 10px;">Tester PasswordQuality</button>
    </form>
</body>
</html>

<?php
require_once("../controller/logincontroller.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['test_password'])) {
        require_once("../model/user.php");
        User::testPasswordQuality();
    } else {
        createAccount($_POST['username'], $_POST['password'], $_POST['email']);
    }
}
