<?php


$public_ip = @file_get_contents('https://api.ipify.org');

$temp = "--";
$geo_data = @json_decode(file_get_contents("http://ip-api.com/json/{$public_ip}"), true);

$weather_data = @json_decode(file_get_contents("https://api.open-meteo.com/v1/forecast?latitude={$geo_data['lat']}&longitude={$geo_data['lon']}&current_weather=true"), true);
 $day_or_night_data = @json_decode(file_get_contents("https://api.open-meteo.com/v1/forecast?latitude={$geo_data['lat']}&longitude={$geo_data['lon']}&day_or_night=true"), true);   
$temp = $weather_data['current_weather']['temperature'] . " °C";
   
echo "<p>IP: " . htmlspecialchars($public_ip) . "</p>";
echo "<p>Temperature: " . htmlspecialchars($temp) . "</p>";
echo "<p>Day or Night: " . htmlspecialchars($day_or_night_data['day_or_night']) . "</p>";

?>