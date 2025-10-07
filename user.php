<?php

function createAccount(PDO $conn) {
    $identifiant = $_POST['identifiant'] ?? null;
    $password = $_POST['mdp'] ?? null; // mot de passe en clair côté requête
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $idSpecialite = isset($_POST['idSpecialite']) && $_POST['idSpecialite'] !== '' ? (int) $_POST['idSpecialite'] : null;
    $idSecteur = isset($_POST['idSecteur']) && $_POST['idSecteur'] !== '' ? (int) $_POST['idSecteur'] : null;
    $statut = $_POST['statut'] ?? 'Actif';

    if (!$identifiant || !$password) {
        throw new InvalidArgumentException('Les champs identifiant et mdp sont requis.');
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO `User` (identifiant, mdp, nom, prenom, idSpecialite, idSecteur, statut)\n            VALUES (:identifiant, :mdp, :nom, :prenom, :idSpecialite, :idSecteur, :statut)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':identifiant', $identifiant);
    $stmt->bindParam(':mdp', $hashedPassword);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    if ($idSpecialite === null) {
        $stmt->bindValue(':idSpecialite', null, PDO::PARAM_NULL);
    } else {
        $stmt->bindValue(':idSpecialite', $idSpecialite, PDO::PARAM_INT);
    }
    if ($idSecteur === null) {
        $stmt->bindValue(':idSecteur', null, PDO::PARAM_NULL);
    } else {
        $stmt->bindValue(':idSecteur', $idSecteur, PDO::PARAM_INT);
    }
    $stmt->bindParam(':statut', $statut);

    $stmt->execute();

    return $conn->lastInsertId();
}

function checkUserCredentials(PDO $conn) {
    $identifiant = $_POST['identifiant'] ?? null;
    $password = $_POST['mdp'] ?? null; // mot de passe en clair fourni par l'utilisateur
    $sql = "SELECT id, mdp FROM `User` WHERE identifiant = :identifiant LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':identifiant', $identifiant);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['mdp'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['identifiant'] = $identifiant;
        header("Location: ../view/home.php");
        if (function_exists('logDeviceData')) {
            logDeviceData("User $identifiant logged in successfully.");
        }
        exit();
    } else {
        echo "<p style='color:red;'>Nom d'utilisateur ou mot de passe incorrect.</p>";
        if (function_exists('logDeviceData')) {
            logDeviceData("Failed login attempt for user $identifiant.");
        }
        return false;
    }
}