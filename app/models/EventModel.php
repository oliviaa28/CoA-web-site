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

    public function getAllEvents($type = 'all') {
        $events = [];

        if ($type === 'cutremur' || $type === 'all') {
            $stmt = $this->pdo->query("SELECT id_cutremur as id, 
                                        'cutremur' as type,
                                        titlu as title, 
                                        stadiu as status, 
                                        localitate as location, 
                                        descriere as details,
                                        data_incident as date,
                                        latitudine as lat, 
                                        longitudine as lng 
                                        FROM INCIDENTE_CUTREMUR");
            $events = array_merge($events, $stmt->fetchAll());
        }
        
        if ($type === 'inundatie' || $type === 'all') {
            $stmt = $this->pdo->query("SELECT id_inundatie as id, 
                                        'inundatie' as type, 
                                        titlu as title, 
                                        stadiu as status, 
                                        localitate as location, 
                                        descriere as details, 
                                        data_incident as date,
                                        latitudine as lat, 
                                        longitudine as lng FROM INCIDENTE_INUNDATIE");
            $events = array_merge($events, $stmt->fetchAll());
        }
        
        if ($type === 'incendiu' || $type === 'all') {
            $stmt = $this->pdo->query("SELECT id_foc as id, 
                                        'incendiu' as type, 
                                        titlu as title, 
                                        stadiu as status, 
                                        localitate as location, 
                                        descriere as details,
                                        data_incident as date, 
                                        latitudine as lat, 
                                        longitudine as lng FROM INCIDENTE_FOC");
            $events = array_merge($events, $stmt->fetchAll());
        }

        return $events;
    }
 
    // ------ insert ---- update --- delete -------------

    public function createEvent($type, $data){ 
        $tabele = [
          'cutremur' => 'INCIDENTE_CUTREMUR',
          'inundatie' => 'INCIDENTE_INUNDATIE',
          'incendiu' => 'INCIDENTE_FOC'
        ];

        if (!array_key_exists($type, $tabele)) return false;
        $tabela = $tabele[$type];

        $sql = $this->pdo->prepare("INSERT INTO $tabela (titlu, descriere, localitate, latitudine, longitudine, stadiu) 
                                    VALUES (?, ?, ?, ?, ?, ?)");
    
        $sql->execute([
            $data['titlu'], $data['descriere'],
            $data['localitate'], $data['lat'], $data['lng'],
            $data['stadiu']
         ]);

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