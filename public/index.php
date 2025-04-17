<?php

declare(strict_types=1);

use App\Config\Container;
use App\Config\Database;
use App\Utils\CustomLogger;

require_once __DIR__ . '/../vendor/autoload.php';

// Enable all error reporting (development only)
error_reporting(E_ALL);
// Display errors on the screen (development only)
ini_set('display_errors', 1);

// Load environment variables from the .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

CustomLogger::logInfo('Starting server');
CustomLogger::logInfo("Requested method: " . $_SERVER['REQUEST_METHOD']);

// Initialize the Dependency Injection Container
$container = new Container();

// Set up the database connection in the DI container
$container->set(PDO::class, function () {
    try {
        $database = new Database();
        $database->connect();
        return $database->getConnection();
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal Server Error - Database connection failed']);
        exit();
    }
});

// Define allowed domains for CORS
$allowed_domains = explode(',', $_ENV['ALLOWED_DOMAINS'] ?? '');

// Check if the request origin is allowed
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
CustomLogger::logInfo("Requesting origin: $origin");

$host = $_SERVER['HTTP_HOST'] ?? '';
CustomLogger::logInfo("Requesting host: $host");

if (in_array($origin, $allowed_domains) || in_array($host, $allowed_domains)) {
    header("Access-Control-Allow-Origin: $origin");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header('content-type: application/json; charset=utf-8');
} else {
    http_response_code(403);
    echo "403 Forbidden - This origin is not allowed.";
    exit();
}

// Handle preflight requests (OPTIONS method)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // No Content
    exit;
}

// application routes
$dispatcher = FastRoute\simpleDispatcher(
    function (FastRoute\RouteCollector $r) use ($container) {
        $r->post('/graphql', function () use ($container) {
            return \App\Controller\GraphQL::handle($container);
        });
        $r->get("/", fn() => "Server is running"); // for server health check
    }
);

try {
    $routeInfo = $dispatcher->dispatch(
        $_SERVER['REQUEST_METHOD'],
        $_SERVER['REQUEST_URI']
    );

    switch ($routeInfo[0]) {
        case FastRoute\Dispatcher::NOT_FOUND:
            // Respond with a 404 error for unknown routes
            echo "ERROR 404: Route Not Found";
            break;
        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            $allowedMethods = $routeInfo[1];
            // Respond with a 405 error for unsupported methods
            echo "ERROR 405: Method Not Allowed";
            break;
        case FastRoute\Dispatcher::FOUND:
            $handler = $routeInfo[1];
            $vars = $routeInfo[2];
            echo $handler($vars);
            break;
    }
} finally {
    if (isset($database)) {
        $database->disconnect();
        CustomLogger::logInfo('Database connection closed.');
    }
}
