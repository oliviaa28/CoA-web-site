<?php

class EventModel {
    private $pdo;

    public function __construct($pdo) { // se executa automat cand obiectul este creeat
        $this->pdo = $pdo;              //salveaza conexiunea primita
    }

    public function getEventDetails($id, $type) {
        $tables = [
            'cutremur' => ['table' => 'INCIDENTE_CUTREMUR', 'id_col' => 'id_cutremur'],
            'inundatie' => ['table' => 'INCIDENTE_INUNDATIE', 'id_col' => 'id_inundatie'],
            'incendiu' => ['table' => 'INCIDENTE_FOC', 'id_col' => 'id_foc']
        ];

        if (!array_key_exists($type, $tables)) return null;

        $stmt = $this->pdo->prepare("SELECT * FROM {$tables[$type]['table']} WHERE {$tables[$type]['id_col']} = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    

    private function filtreaza($query, $status, $year) {
         $conditii = [];   // lista de conditii WHERE
         $valori = [];     // valorile pentru prepared statement

         // adauga conditie status daca exista
         if ($status !== '') {
            $conditii[] = "LOWER(stadiu) = ?";
            $valori[] = $status;
         }

         // adauga conditie an daca exista
         if ($year !== '') {
            $conditii[] = "YEAR(data_incident) = ?";
            $valori[] = $year;
        }

        // daca avem conditii, le lipim cu AND
         if ( count($conditii) > 0) {
             $query .= " WHERE ";
             $query .= implode(' AND ', $conditii);
         }

        $query .= " ORDER BY data_incident DESC LIMIT 100";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($valori);
        return $stmt->fetchAll();
    }

   public function getAllEvents($type = 'all', $status = '', $year = '') {
    $events = [];

        if ($type === 'cutremur' || $type === 'all') {
             $query = "SELECT id_cutremur as id, 'cutremur' as type, titlu as title, 
                         stadiu as status, localitate as location, descriere as details,
                          data_incident as date, latitudine as lat, longitudine as lng 
                  FROM INCIDENTE_CUTREMUR";

            $events = array_merge($events, $this->filtreaza($query, $status, $year));
         }

        if ($type === 'inundatie' || $type === 'all') {
                $query = "SELECT id_inundatie as id, 'inundatie' as type, titlu as title, 
                         stadiu as status, localitate as location, descriere as details, 
                         data_incident as date, latitudine as lat, longitudine as lng 
                  FROM INCIDENTE_INUNDATIE";

          $events = array_merge($events, $this->filtreaza($query, $status, $year));
         }   

         if ($type === 'incendiu' || $type === 'all') {
                $query = "SELECT id_foc as id, 'incendiu' as type, titlu as title, 
                         stadiu as status, localitate as location, descriere as details,
                         data_incident as date, latitudine as lat, longitudine as lng 
                  FROM INCIDENTE_FOC";

            $events = array_merge($events, $this->filtreaza($query, $status, $year));
             }

        return $events;
    }

    public function createEvent($type, $data){
         $tabele = [
             'cutremur' => 'INCIDENTE_CUTREMUR',
             'inundatie' => 'INCIDENTE_INUNDATIE',
             'incendiu' => 'INCIDENTE_FOC'
         ];

        if (!array_key_exists($type, $tabele))
             return false;
        
        $tabela = $tabele[$type];

         // daca avem data(la import)
         if ( isset($data['data_incident']) && $data['data_incident'] !== null )
         {
                $sql = $this->pdo->prepare("INSERT INTO $tabela 
                                                (titlu, descriere, localitate, latitudine, longitudine, stadiu, data_incident) 
                                                VALUES (?, ?, ?, ?, ?, ?, ?)");
                $sql->execute([
                     $data['titlu'], $data['descriere'], $data['localitate'],
                    $data['lat'], $data['lng'], $data['stadiu'], $data['data_incident']
                 ]);

         } else {
                // creare normala (formular) 
             $sql = $this->pdo->prepare("INSERT INTO $tabela 
                                        (titlu, descriere, localitate, latitudine, longitudine, stadiu) 
                                         VALUES (?, ?, ?, ?, ?, ?)");
             $sql->execute([
                    $data['titlu'], $data['descriere'], $data['localitate'],
                     $data['lat'], $data['lng'], $data['stadiu']
                  ]);
             }
    return true;
    }

    public function deleteEvent($type, $id){

       $tabele =[
         'cutremur' => ['table' => 'INCIDENTE_CUTREMUR', 'id_col' => 'id_cutremur'] ,
         'inundatie' => ['table' => 'INCIDENTE_INUNDATIE', 'id_col'=> 'id_inundatie'],
         'incendiu' => ['table' => 'INCIDENTE_FOC', 'id_col' =>'id_foc']
       ];

       if( ! array_key_exists($type, $tabele))
            return false;

       $tabela = $tabele[$type]['table'];
       $id_col = $tabele[$type]['id_col'];

       $sql = $this->pdo->prepare("DELETE FROM $tabela WHERE $id_col = :id" );
       $sql->execute(['id' => $id]);
       return true;
    }

    public function updateEvent($type, $id, $data){
    
       $tabele =[
         'cutremur' => ['table' => 'INCIDENTE_CUTREMUR', 'id_col' => 'id_cutremur'] ,
         'inundatie' => ['table' => 'INCIDENTE_INUNDATIE', 'id_col'=> 'id_inundatie'],
         'incendiu' => ['table' => 'INCIDENTE_FOC', 'id_col' =>'id_foc']
       ];

        if( ! array_key_exists($type, $tabele))
            return false;

        $tabela = $tabele[$type]['table'];
        $id_col = $tabele[$type]['id_col'];

        $sql = $this->pdo->prepare("UPDATE $tabela SET titlu = ?, descriere = ?, localitate = ?, 
                                                        latitudine = ?, longitudine = ?, stadiu = ? 
                                        WHERE $id_col = ?");
        $sql->execute([
            $data['titlu'], $data['descriere'],
            $data['localitate'], $data['lat'], $data['lng'],
            $data['stadiu'], $id 
         ]);

       return true;

    }

}