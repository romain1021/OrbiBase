<?php
require_once __DIR__ . '/user.php';


// fonction qui permet d'obtenir la dernière données des resource en appelant la base de donnée
function getLatestResources(): ?array
{
    $pdo = getLocalPDO();
    $sql = "SELECT id, oxygene, nourriture, eau, energie, date_heure FROM `Resources` ORDER BY id DESC LIMIT 1";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ?: null;
}


