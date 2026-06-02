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
         $sql = $this->pdo->prepare("INSERT INTO ALERTE 
                                (tip_incident, id_incident, headline, descriere, instructiuni, severitate, urgenta, certitudine, zona, status) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
          $sql->execute([
                $data['tip_incident'], $data['id_incident'],
                $data['headline'], $data['description'],
                $data['instruction'], $data['severity'],
                $data['urgency'], $data['certainty'],  
                $data['zone'],
                'ACTIV'
             ]);
     return true;
    }

    public function deleteAlert($id){
        $sql = $this->pdo->prepare("DELETE FROM ALERTE WHERE id_alerta = :id");
        $sql->execute(['id' => $id]);
        return true;
    }

    
    public function getAlertsByEvent($idIncident, $tipIncident) { //pentru tabelul cu alertele fiecarui eveniment
        $sql = $this->pdo->prepare('SELECT 
                                    id_alerta AS "id",
                                    headline AS "headline",
                                    severitate AS "severity",
                                    urgenta AS "urgency",
                                    status AS "status",
                                    trimis_la AS "sentat"
                                    FROM ALERTE 
                                   WHERE id_incident = :id AND tip_incident = :tip');
    
    $sql->execute( ['id' => $idIncident, 'tip' => $tipIncident] );
    return $sql->fetchAll();
   }

   public function getAlertById($id) {
       $sql= $this->pdo->prepare('SELECT 
                                    id_alerta AS "id",
                                    tip_incident AS "type",
                                    id_incident AS "incidentId",
                                    headline AS "headline",
                                    descriere AS "description",
                                    instructiuni AS "instruction",
                                    severitate AS "severity",
                                    urgenta AS "urgency",
                                    certitudine AS "certainty",
                                    zona AS "zone",
                                    status AS "status",
                                    trimis_la AS "sentat"
                                FROM ALERTE WHERE id_alerta = :id');
    $sql->execute( ['id' => $id]);
    return $sql->fetch();
  }

  private function adaugaElement($doc, $parinte, $nume, $text){ // nume e de la numele tag ului 
    $e = $doc->createElement($nume);
    $e->appendChild( $doc->createTextNode($text));
    $parinte->appendChild($e);
  }

  // ___________________ export cap _____________________________
    private function mapeazaCategorie($tip) {
        if ($tip ==='cutremur') 
            return 'Geo';
        if ($tip ==='inundatie') 
            return 'Met';
        if ($tip ==='incendiu') 
            return 'Fire';
     return 'Other';
    }

    private function formatDataCAP($data) {
        return date('Y-m-d\TH:i:sP', strtotime($data));
    }      

  public function genereazaCAP($alerta){
     //creez documentul xml 
     $doc = new DOMDocument('1.0', 'UTF-8');
     $doc->formatOutput = true; //identare frumoasa

     //radacina alert 
     $alert = $doc->createElement('alert');
     $alert->setAttribute('xmlns',     //xml namespace
                          'urn:oasis:names:tc:emergency:cap:1.2'); //identificatorul unic al standardului cap 1.2 ->urn 

     $doc->appendChild($alert);

      // campuri obligatorii in <alert>
     $this->adaugaElement($doc, $alert, 'identifier', 'COA-'.$alerta['id']);
     $this->adaugaElement($doc, $alert, 'sender', 'coa@proiectweb.ro');
     $this->adaugaElement($doc, $alert, 'sent', $this->formatDataCAP($alerta['sentat']) );
     $this->adaugaElement($doc, $alert, 'status','Actual');
     $this->adaugaElement($doc, $alert, 'msgType', 'Alert');
     $this->adaugaElement($doc, $alert, 'scope', 'Public');

    // bloc <info>
     $info = $doc->createElement('info');
     $alert->appendChild($info);

    $this->adaugaElement($doc, $info, 'category', $this->mapeazaCategorie($alerta['type']));
    $this->adaugaElement($doc, $info, 'event', $alerta['type'] );
    $this->adaugaElement($doc, $info, 'urgency', $alerta['urgency'] );
    $this->adaugaElement($doc, $info, 'severity', $alerta['severity'] );
    $this->adaugaElement($doc, $info, 'certainty', $alerta['certainty'] );
    $this->adaugaElement($doc, $info, 'headline', $alerta['headline'] );
    $this->adaugaElement($doc, $info, 'description', $alerta['description'] );
    $this->adaugaElement($doc, $info, 'instruction', $alerta['instruction'] );

     // bloc <area>
    $area = $doc->createElement('area');
    $info->appendChild($area);
    $this->adaugaElement($doc, $area, 'areaDesc', $alerta['zone']);

    return $doc->saveXML();

  }
}