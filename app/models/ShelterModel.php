<?php

class ShelterModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllShelters() {
        $sql = $this->pdo->prepare('SELECT 
            ID_ADAPOST AS "id",
            TIP AS "type",
            NUME AS "name",
            ADRESA AS "address",
            DESCRIERE AS "details",
            LATITUDINE AS "lat",
            LONGITUDINE AS "lng"
        FROM ADAPOSTURI');   
        
        $shelters = [];
        if ($sql->execute()) {
            while ($row = $sql->fetch()) {
                $shelters[] = $row;
            }
        }
        return $shelters;
    }
}