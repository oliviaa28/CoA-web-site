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

         if($action === 'export'){
            $format = $_GET['format'] ?? ''; //json cvs 
            $type = $_GET['type'] ?? '';    //events, alert sau shelters
            $this->export($type, $format);
         }
         else if($action === 'import'){
            $type = $_POST['type'] ?? ''; //luam tipul din form-> din dropdown 
            $this->import($type);
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
        
        //prima linie din fiserul csv -> titlurile coloanelor (luam cheile valorilor prui element din date)
        $col = array_keys( $date[0] );

        $output = fopen('php://output', 'w');

        fputcsv($output, $col); //header 

        foreach ($date as $rand) //randuril cu valori
             fputcsv($output, $rand);
    
        fclose($output);
    }

    // ------- IMPORT 
    
    private function mapeazaEvent($element){ 
        //transform cheile json din engleza in romana(ce avem si in bd)
        return[
            'titlu' => $element['title'],
            'descriere' => $element['details'],
            'localitate' => $element['location'],
            'lat' => $element['lat'],
            'lng' => $element['lng'],
            'stadiu' => $element['status']

        ];
    }

    private function mapeazaShelter($element){
        return [
        //cheia pt create shelter => cheie json 
            'name' => $element['name'],
            'address' => $element['address'],
            'type'=> $element['type'],
            'lat' => $element['lat'],
            'lng' => $element['lng'],
            'capacity' => $element['capacity'],
            'available' => $element['available'],
            'description' => $element['details']  
        ];
    }

    private function mapeazaAlert($element){
        return [
            'tip_incident' => $element['type'],
            'id_incident' => $element['incidentid'] ?? null,   // pty ca avem CASE_LOWER la setari
            'headline'=> $element['headline'],
            'description' => $element['description'],
            'instruction' => $element['instruction'],
            'severity'=> $element['severity'],
            'urgency'=> $element['urgency'],
            'certainty'=> $element['certainty'],
            'zone'=> $element['zone']
         ];
    }   

    private function parseazaJSON($path){
        $continut= file_get_contents( $path );
        return json_decode($continut, true );
    }

    private function parseazaCSV($path){
        $date=[];
        $f = fopen($path, 'r');

        //numele coloanelor 
        $header = fgetcsv($f);

        //luam fiecare rand cu date si facem un array asociativ  cheie - valoare
        while( ($valori = fgetcsv($f)) !==false ){
            $el = array_combine($header, $valori);
            $date[] = $el;
        }

        fclose($f);
        //array ul date va arata identic ca cel ret dupa imporatrea jsonului
        return $date; 
    }

    private function import($type){

         if( !isset( $_FILES['fisier']) || $_FILES['fisier']['error']!== 0 ){
             header('Location: ../app/views/admin/import-export.php?error=1');
             exit;
        }

        // ia extensia din numele fisierului
        $extensie = pathinfo($_FILES['fisier']['name'], PATHINFO_EXTENSION);
    
        // parseaza in functie de format
         if ($extensie === 'json') {
             $date= $this->parseazaJSON($_FILES['fisier']['tmp_name']);
         } else if ($extensie === 'csv') {
             $date= $this->parseazaCSV($_FILES['fisier']['tmp_name']);
         } else {
            header('Location: ../app/views/admin/import-export.php?error=2');
            exit;
        }

        if ($date === null) {
           header('Location: ../app/views/admin/import-export.php?error=2');
           exit;
         }

        if( !$this->verificaStructura($date, $type) ){
            header('Location: ../app/views/admin/import-export.php?error=3');
            exit;
        }

        foreach( $date as $el){
            
            if( $type === 'events'){
                $tipEveniment = $el['type'];
                $dateMapate = $this->mapeazaEvent($el);

                $this->eventModel->createEvent($tipEveniment, $dateMapate);
            }
            else if( $type === 'shelters'){
                $dateMapate = $this->mapeazaShelter($el);
                $this->shelterModel->createShelter($dateMapate);
            }
            else if($type === 'alerts'){
                 $dateMapate = $this->mapeazaAlert($el);
                 $this->alertModel->createAlert($dateMapate);
            }

        }
     header('Location: ../app/views/admin/import-export.php?success=1');
     exit;
    }

    private function verificaStructura( $date, $type){
        // fisier gol?
        if (empty($date)) {
            return false;
        }
       
        // ia primul element ca sa verificam cheile
        $pr = $date[0];

        // ce chei trebuie sa aiba fiecare tip
        if ($type === 'events') {
            return isset($pr['title']);
        } else if ($type === 'shelters') {
            return isset($pr['name']);
        } else if ($type === 'alerts') {
            return isset($pr['headline']);
        }
      
      return false;
    }
}