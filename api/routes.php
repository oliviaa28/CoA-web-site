<?php
header('Content-Type: application/json');

// Functie robusta pentru a prelua continutul de la un URL (foloseste cURL daca e disponibil)
function fetchUrl($url) {
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignora erorile SSL pe XAMPP
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    } else {
        $context = stream_context_create(["ssl" => ["verify_p eer" => false, "verify_peer_name" => false]]);
        return @file_get_contents($url, false, $context);
    }
}

function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

$ip = getUserIP();

if ($ip === '::1' || $ip === '127.0.0.1') {
    $ip = trim(fetchUrl('https://api.ipify.org'));
}

if (empty($ip)) {
    echo json_encode(['success' => false, 'error' => 'Nu am putut prelua IP-ul public. Verifica conexiunea la net sau setarile cURL din XAMPP.']);
    exit;
}

$apiUrl = "http://ip-api.com/json/" . $ip;
$response = fetchUrl($apiUrl);

if ($response) {
    $data = json_decode($response, true);
    if (isset($data['status']) && $data['status'] === 'success') {
        echo json_encode([
            'success' => true,
            'lat' => $data['lat'],
            'lng' => $data['lon'],
            'city' => $data['city']
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'API-ul nu a putut găsi locația. Detalii: ' . (isset($data['message']) ? $data['message'] : 'Eroare necunoscuta')]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Nu s-a putut contacta API-ul de locație.']);
}