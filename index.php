<?php
// Front Controller, singurul punct de intrare
 
$route = $_GET['route'] ?? 'home';
 
// Rute API (returneaza JSON)
$apiRoutes = [
    'api/events'        => 'EventController',
    'api/shelters'      => 'ShelterController',
    'api/alerts'        => 'AlertController',
    'api/users'         => 'UserController',
    'api/import-export' => 'ImportExportController',
    'api/login'         => 'AuthController',
    'api/logout'        => 'AuthController',
];
 

$adminRoutes = [
    'dashboard', 'events', 'shelters', 'alerts',
    'users', 'import-export', 'event-details',
    'cap-details', 'shelter-details',
];
 
// Rute publice (fara autentificare)
$publicRoutes = [
    'login', 'events-public', 'shelter-public', 'details-public', 'documentation',
];
 
// --- API ---
if ($route === 'api/location') {
    // Caz special pentru scriptul de geolocație.
    // Ideal, logica ar trebui mutată într-o metodă de controller.
    require_once __DIR__ . '/api/routes.php';
    exit;
}
if (isset($apiRoutes[$route])) {
    require_once __DIR__ . '/app/controllers/' . $apiRoutes[$route] . '.php';
    $controllerName = $apiRoutes[$route];
    $controller = new $controllerName();
 
    if ($route === 'api/login')       { $controller->login(); }
    elseif ($route === 'api/logout')  { $controller->logout(); }
    else                              { $controller->handleApiRequest(); }
    exit;
}
 
// --- Pagini admin ---
if (in_array($route, $adminRoutes)) {
    require_once __DIR__ . '/app/controllers/AuthController.php';
    AuthController::requireAuth();
    require_once __DIR__ . '/app/views/admin/' . $route . '.php';
    exit;
}
 
// --- Pagini publice ---
if (in_array($route, $publicRoutes)) {
    $file = ($route === 'login')
        ? __DIR__ . '/app/views/public/login.html'
        : __DIR__ . '/app/views/public/' . str_replace('-', '_', $route) . '.php';
    require_once $file;
    exit;
}
 
// --- Default: trimite la login ---
header('Location: index.php?route=login');
exit;
?>