<?php
require_once '../config/database.php';
require_once '../app/models/EventModel.php';

$eventModel = new EventModel($pdo);
$f = fopen(__DIR__ . '/kaggle_earthquakes.csv', 'r');

$header= fgetcsv($f); // sarim peste prima linie 
$n = 0;

while (($r = fgetcsv($f)) !== false) {


    //coloane 
   //title,magnitude,date_time,cdi,mmi,alert,tsunami,sig,net,nst,dmin,gap,magType,depth,latitude,longitude,location,continent,country
    //"M 6.5 - 42 km W of Sola, Vanuatu",6.5,16-08-2023 12:47,7,4,green,0,657,us,114,7.177,25,mww,192.955,-13.8814,167.158,"Sola, Vanuatu",,Vanuatu
  
    $eventModel->createEvent('cutremur', 
    [
        'titlu'=> $r[0],                              // title
        'descriere'=> "Magnitudine: {$r[1]}, Adancime: {$r[13]} km",
        'localitate'=> $r[16],                             // location
        'lat'=> $r[14],                             // latitude
        'lng'=> $r[15],                             // longitude
        'stadiu'=> 'REZOLVAT',
        'data_incident'=> $r[2]                              
    ]);

    $n++;
}

fclose($f);
?>