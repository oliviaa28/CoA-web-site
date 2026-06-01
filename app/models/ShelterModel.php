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
            CAPACITATE AS "capacity",
            LOCURI_DISPONIBILE AS "available",
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

    public function createShelter($data){
        $sql = $this->pdo->prepare("INSERT INTO ADAPOSTURI (nume, adresa, tip, latitudine, longitudine, capacitate, locuri_disponibile, descriere)
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
         $sql->execute([
           $data['name'], $data['address'], $data['type'],
            $data['lat'], $data['lng'], $data['capacity'],
             $data['available'], $data['description']
         ]);
         return true;
    }

    public function deleteShelter($id){

        $sql = $this->pdo->prepare("DELETE FROM ADAPOSTURI WHERE id_adapost = :id");
        $sql->execute(['id' => $id]);
          return true;
    }

    public function updateShelter($id, $data){
        
        $sql = $this->pdo->prepare("UPDATE ADAPOSTURI SET nume = ?, adresa = ?, tip = ?,  latitudine = ?, longitudine = ?,
                                                         capacitate = ? ,locuri_disponibile=?, descriere=?
                                        WHERE id_adapost = ?");
         $sql->execute([
           $data['name'], $data['address'], $data['type'],
            $data['lat'], $data['lng'], $data['capacity'],
             $data['available'], $data['description'],
             $id
         ]);

       return true;

    }
}