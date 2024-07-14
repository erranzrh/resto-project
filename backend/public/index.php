<?php
use DI\Container;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Slim\Factory\AppFactory;
use Slim\Middleware\BodyParsingMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/../vendor/autoload.php';

// Create Container using PHP-DI
$container = new Container();
AppFactory::setContainer($container);

// Create App
$app = AppFactory::create();

// Include dependencies
(require __DIR__ . '/../src/dependencies.php')($container);

// Create Request object from globals
$psr17Factory = new Psr17Factory();
$serverRequestCreator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);
$request = $serverRequestCreator->fromGlobals();

// Register routes
(require __DIR__ . '/../src/routes.php')($app);

// Add Body Parsing Middleware
$app->add(new BodyParsingMiddleware());

// Add CORS Middleware
$app->add(function (Request $request, $handler): Response {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
        ->withHeader('Access-Control-Allow-Credentials', 'true');
});

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Handle OPTIONS preflight requests
$app->options('/{routes:.+}', function (Request $request, Response $response, $args) {
    return $response;
});

// Run App
$app->run();
