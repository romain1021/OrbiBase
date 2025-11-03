<?php
require_once __DIR__ . '/user.php';

function getLatestResources(): ?array
{
    $pdo = getLocalPDO();
    $sql = "SELECT id, oxygene, nourriture, eau, energie, date_heure FROM `Resources` ORDER BY id DESC LIMIT 1";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ?: null;
}


