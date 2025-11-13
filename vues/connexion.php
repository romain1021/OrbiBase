<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>OrbiBase</h1>
    <p>Bienvenue ! Veuillez vous connecter pour continuer.</p>
    <form action="" method="post">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" id="username" required />
        
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required />
        <br>
        
        <input type="submit" value="Se connecter" />

        <button type="button" onclick="location.href='index.php?page=inscription'">Créer un compte</button>
    </form>
</body>
</html>
    
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkUserCredentials($_POST['username'], $_POST['password']);
}
?>