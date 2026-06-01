<?php

class AlertModel {
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function getAllAlerts() {
        $sql = $this->pdo->prepare('SELECT 
                                     id_alerta AS "id",
                                     tip_incident AS "type",
                                     id_incident AS "incidentId",
                                     headline AS "headline",
                                     severitate AS "severity",
                                     urgenta AS "urgency",
                                     zona AS "zone",
                                     status AS "status",
                                    trimis_la AS "sentAt",
                                    destinatari AS "recipients"
                             FROM ALERTE');
        $sql->execute();
        return $sql->fetchAll();
    }

    
    public function createAlert($data){
        $sql = $this->pdo->prepare("INSERT INTO ALERTE (tip_incident, id_incident, headline, descriere, instructiuni, severitate, urgenta, zona, status) 
                                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $sql->execute([
            $data['tip_incident'],$data['id_incident'],
            $data['headline'],$data['description'],
            $data['instruction'],$data['severity'],
            $data['urgency'],$data['zone'],
            'ACTIV'//default
        ]);
        return true;
    }

    public function deleteAlert($id){
        $sql = $this->pdo->prepare("DELETE FROM ALERTE WHERE id_alerta = :id");
        $sql->execute(['id' => $id]);
        return true;
    }


}