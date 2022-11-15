<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr7Middlewares\Middleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;
require_once  './middlewares/CheckTokenMiddleware.php';
require_once './middlewares/CheckPerfilVendedorMiddleware.php';
require_once './middlewares/CheckVendedorProveedorMiddleware.php';
require_once './middlewares/CheckPerfilProveedorMiddleware.php';

require __DIR__ . '/../vendor/autoload.php';

require_once './db/AccesoDatos.php';

require_once './controllers/UsuarioController.php';
require_once './controllers/AutenticadorController.php';
require_once './controllers/HortalizaController.php';
require_once './controllers/VentaController.php';


// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

$app->group('/usuarios', function (RouteCollectorProxy $group) {
  $group->get('/traerPorId', \HortalizaController::class . ':TraerPorId');
  $group->post('/altaHortaliza', \HortalizaController::class . ':CargarUno')->add(new CheckPerfilVendedorMiddleware());
  $group->post('/altaVenta', \VentaController::class . ':CargarUno')->add(new CheckVendedorProveedorMiddleware()) ;
  $group->get('/traverVentasNombre',\VentaController::class . ':TraerVentasPorNombre')->add(new CheckPerfilProveedorMiddleware());
  $group->delete('/borrarHortaliza', \HortalizaController::class . ':BorrarUno')->add(new CheckPerfilVendedorMiddleware());
  $group->get('/traerVentaParam',\VentaController::class . ':TraerVentasConParametros')->add(new CheckPerfilVendedorMiddleware());
  $group->put("/modificarHortaliza", \HortalizaController::class . ':ModificarUno')->add(new CheckVendedorProveedorMiddleware());
})->add(new CheckTokenMiddleware());

// Routes
$app->post('/login', \AutentificadorController::class . ':CrearTokenLogin');

//Solo para la primer carga
$app->post('/altaUsuarios', \UsuarioController::class . ':CargarUno');
$app->get('/traerHortalizas',\HortalizaController::class . ':TraerTodos');
$app->get('/traerParametros',\HortalizaController::class . ':TraerPorClima');

$app->get('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("Parcial Programacion III - CRIPTOMONEDAS");
    return $response;
});

$app->run();
