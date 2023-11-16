<?php
declare(strict_types=1);
namespace App;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Carbon\Carbon;
use function FastRoute\simpleDispatcher;

class Routing
{
    public static function dispatch(): void
    {
        $loader = new FilesystemLoader(__DIR__ . '/Views');
        $twig = new Environment($loader);
        $apiService = new ApiService();

        $currentTime = Carbon::now('Europe/Riga')->format('Y-m-d | H:i');
        $twig->addGlobal('globalTime', $currentTime);

        $dispatcher = simpleDispatcher(function (RouteCollector $r) {

            $r->addRoute('GET', '/', 'App\\Controllers\\CoinsController::index');
            $r->addRoute('POST', '/search', 'App\\Controllers\\CoinsController::index');

        });

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = rawurldecode($_SERVER['REQUEST_URI']);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                // Handle 404 Not Found
                echo '404 Not Found';
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                // Handle 405 Method Not Allowed
                echo '405 Method Not Allowed';
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                list($controllerClass, $action) = explode('::', $handler);
                $controller = new $controllerClass($twig, $apiService);
                $controller->$action($vars);
                break;
        }
    }
}