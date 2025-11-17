<?php


function getLocalPDO(): PDO
{
    $dsn = 'mysql:host=127.0.0.1;dbname=orbibase;charset=utf8mb4';
    $dbUser = 'root';
    $dbPass = '';
    return new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
}

function addUser($identifiant = null, $password = null, $nom = '', $prenom = '', $idSpecialite = null, $idSecteur = null, $statut = 'Actif') {
    $identifiant = $identifiant ?? ($_POST['identifiant'] ?? null);
    $password = $password ?? ($_POST['mdp'] ?? null);
    $nom = $nom ?: ($_POST['nom'] ?? '');
    $prenom = $prenom ?: ($_POST['prenom'] ?? '');
    $idSpecialite = $idSpecialite ?? (isset($_POST['idSpecialite']) && $_POST['idSpecialite'] !== '' ? (int) $_POST['idSpecialite'] : null);
    $idSecteur = $idSecteur ?? (isset($_POST['idSecteur']) && $_POST['idSecteur'] !== '' ? (int) $_POST['idSecteur'] : null);
    $statut = $statut ?: ($_POST['statut'] ?? 'Actif');

    if (!$identifiant || !$password) {
        throw new Exception('Identifiant et mot de passe requis.');
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO `User` (identifiant, mdp, nom, prenom, idSpecialite, idSecteur, statut)\n VALUES (:identifiant, :mdp, :nom, :prenom, :idSpecialite, :idSecteur, :statut)";

    $pdo = getLocalPDO();
    $stmt = $pdo->prepare($sql);
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

    $newId = $pdo->lastInsertId();

    // Handle uploaded photo if present in $_FILES['photo']
    if (!empty($_FILES['photo']['tmp_name'])) {
        try {
            $uploaded = $_FILES['photo'];
            if ($uploaded['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($uploaded['name'], PATHINFO_EXTENSION);
                $allowed = ['jpg','jpeg','png','gif'];
                if (!in_array(strtolower($ext), $allowed)) {
                    // ignore invalid extensions
                } else {
                    $targetDir = __DIR__ . '/../photo';
                    if (!is_dir($targetDir)) {
                        mkdir($targetDir, 0755, true);
                    }
                    $filename = 'user_' . $newId . '_' . time() . '.' . $ext;
                    $targetPath = $targetDir . '/' . $filename;
                    if (move_uploaded_file($uploaded['tmp_name'], $targetPath)) {
                        $relative = 'photo/' . $filename;
                        $update = $pdo->prepare('UPDATE `User` SET lienPDP = :lien WHERE id = :id');
                        $update->bindParam(':lien', $relative);
                        $update->bindParam(':id', $newId, PDO::PARAM_INT);
                        $update->execute();
                    }
                }
            }
        } catch (Exception $e) {
            // silently ignore upload problem for now
        }
    }

    return $newId;
}

function checkUserCredentials($identifiant = null, $password = null) {
    $identifiant = $identifiant ?? ($_POST['identifiant'] ?? null);
    $password = $password ?? ($_POST['mdp'] ?? null);

    if (!$identifiant || !$password) {
        echo "<p style='color:red;'>Identifiant et mot de passe requis.</p>";
        return false;
    }

    $sql = "SELECT id, mdp FROM `User` WHERE identifiant = :identifiant LIMIT 1";
    $pdo = getLocalPDO();
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':identifiant', $identifiant);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['mdp'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['identifiant'] = $identifiant;
        header("Location: index.php?page=home");
        exit();
    } else {
        echo "<p style='color:red;'>Nom d'utilisateur ou mot de passe incorrect.</p>";
        if (function_exists('logDeviceData')) {
            logDeviceData("Failed login attempt for user $identifiant.");
        }
        return false;
    }
}

function getListeUserByAffectation() {
    $pdo = getLocalPDO();
    $sql = "SELECT s.id AS secteur_id, s.nom AS secteur_nom, u.id AS user_id, u.identifiant, u.nom, u.prenom, u.statut
            FROM Secteur s
            LEFT JOIN User u ON u.idSecteur = s.id
            ORDER BY s.nom, u.nom, u.prenom";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll();

    $liste = [];
    foreach ($result as $row) {
        $secteurNom = $row['secteur_nom'];
        if (!isset($liste[$secteurNom])) {
            $liste[$secteurNom] = [];
        }
        if ($row['user_id'] !== null) {
            $liste[$secteurNom][] = [
                'id' => $row['user_id'],
                'identifiant' => $row['identifiant'],
                'nom' => $row['nom'],
                'prenom' => $row['prenom'],
                'statut' => $row['statut']
            ];
        }
    }
    return $liste;
}

function getUserById($userId) {
    $pdo = getLocalPDO();
    $sql = "SELECT u.id, u.identifiant, u.nom, u.prenom, u.idSpecialite, u.idSecteur, u.statut, u.lienPDP,
                   s.nom AS specialite, se.nom AS secteur
            FROM `User` u
            LEFT JOIN Specialite s ON u.idSpecialite = s.id
            LEFT JOIN Secteur se ON u.idSecteur = se.id
            WHERE u.id = :id LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateUserPassword($userId, $newPassword) {
    if (!$newPassword) return false;
    $pdo = getLocalPDO();
    $hash = password_hash($newPassword, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare('UPDATE `User` SET mdp = :mdp WHERE id = :id');
    $stmt->bindParam(':mdp', $hash);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    return $stmt->execute();
}

function updateUserPhoto($userId, $uploadedFile) {
    if (empty($uploadedFile['tmp_name']) || $uploadedFile['error'] !== UPLOAD_ERR_OK) return false;
    $ext = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
    $allowed = ['jpg','jpeg','png','gif'];
    if (!in_array(strtolower($ext), $allowed)) return false;
    $targetDir = __DIR__ . '/../photo';
    if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
    $filename = 'user_' . $userId . '_' . time() . '.' . $ext;
    $targetPath = $targetDir . '/' . $filename;
    if (move_uploaded_file($uploadedFile['tmp_name'], $targetPath)) {
        $relative = 'photo/' . $filename;
        $pdo = getLocalPDO();
        $stmt = $pdo->prepare('UPDATE `User` SET lienPDP = :lien WHERE id = :id');
        $stmt->bindParam(':lien', $relative);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    return false;
}