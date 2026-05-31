<?php

class EventModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
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
                                        latitudine as lat, 
                                        longitudine as lng FROM INCIDENTE_FOC");
            $events = array_merge($events, $stmt->fetchAll());
        }

        return $events;
    }
}