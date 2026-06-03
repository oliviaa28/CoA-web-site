<?php
require_once __DIR__ . '/../../config/database.php'; //calea e relativa la unde e fierul, nu unde ruleaza
require_once __DIR__ . '/../models/EventModel.php';
require_once __DIR__ . '/../models/ShelterModel.php';
require_once __DIR__ . '/../models/AlertModel.php';

class ImportExportController{
    private $shelterModel;
    private $eventModel;
    private $alertModel;

    public function __construct(){
        global $pdo;
        $this->eventModel = new EventModel($pdo);
        $this->shelterModel = new ShelterModel($pdo);
        $this->alertModel = new AlertModel($pdo);
    }

    public function handleRequest(){ //metoda apelata in api/importexport

         $action = $_GET['action'] ?? ''; //import sau export 
         $type = $_GET['type'] ?? '';    //events, alert sau shelters
         $format = $_GET['format'] ?? ''; //json cvs 

         if($action === 'export'){
            $this->export($type, $format);
         }
    }

    private function export ($type, $format){
        
        if($type=== 'events'){
            $date= $this->eventModel->getAllEvents();
        }
        else if($type=== 'alerts'){
            $date= $this->alertModel->getAllAlerts();
        }
        else if($type=== 'shelters'){
            $date= $this->shelterModel->getAllShelters();
        }
        else{
            echo 'necunoscut';
            return;
        }

        if($format === 'json'){
            $this->exportJSON($date, $type);
        }else if($format === 'csv'){
             $this->exportCSV($date, $type);
        }
    }


    private function  exportJSON ($date, $type){
        //transforman array ul cu date in json, cu identare frumoasa si pastram diacriticile
        $json = json_encode($date, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE); 

        header('Content-Type: application/json; charset= UTF-8');
        header('Content-Disposition: attachment; filename="coa_export_' . $type . '.json"');
    
        echo $json;
    }

    private function exportCSV($date, $type){
        if ( empty($date) ){
            echo 'Nu sunt date';
            return;
        }
        //headrere pt descarcare 
        header('Content-Type: application/csv; charset= UTF-8');
        header('Content-Disposition: attachment; filename="coa_export_' . $type . '.csv"');
        
        //prima linie din fiserul csv -> titlurile coloanelor (luam cheile valorilor primului element din date)
        $col = array_keys( $date[0] );

        $output = fopen('php://output', 'w');

        fputcsv($output, $col); //header 

        foreach ($date as $rand) //randuril cu valori
             fputcsv($output, $rand);
    
        fclose($output);
    }


}