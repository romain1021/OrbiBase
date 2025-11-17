<?php
class Base {
    private PDO $db;

    public function __construct() {
        try {
            $this->db = new PDO("mysql:host=localhost;dbname=orbibase", "root", "");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

   
    public function rechercheBySpecialite(string $nomSpecialite): array {
        $result = $this->db->prepare("SELECT * FROM specialite WHERE nom LIKE :nom");
        $result->execute(['nom' => '%' . $nomSpecialite . '%']);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getListSecteur(): array {
        $result = $this->db->query("SELECT * FROM secteur");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

   
    public function getListeSpecialites(): array {
        $result = $this->db->query("SELECT * FROM specialite");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}