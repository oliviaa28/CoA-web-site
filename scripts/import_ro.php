<?php
require_once '../config/database.php';
require_once '../app/models/EventModel.php';

$eventModel = new EventModel($pdo);
$f = fopen(__DIR__ . '/cutremure_romania.csv', 'r');

$header = fgetcsv($f); 
$n = 0;

while (($r = fgetcsv($f)) !== false) {
    // ordinea coloanelor
    //dateTime,magnitude,magnitude type,depth,latitude,longitude,zone description 2024-10-31 00:00:17,2.1,ML,19.7,45.2831,27.2761,MUNTENIA BUZAU
    // 0=dateTime  1=magnitude  2=magnitude type  3=depth  4=latitude  5=longitude  6=zone description

    $eventModel->createEvent('cutremur', 
    [
        'titlu'=> "Cutremur M{$r[1]} - {$r[6]}",
        'descriere'=> "Magnitudine: {$r[1]} ML, Adancime: {$r[3]} km",
        'localitate'=> $r[6],     
        'lat'=> $r[4],      // latitude
        'lng'=> $r[5],      // longitude
        'stadiu'=> 'REZOLVAT',
        'data_incident' => $r[0]   
    ]);

    $n++;
}

fclose($f);
?>