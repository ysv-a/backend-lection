<?php

session_start();

use App\Auth;
use DI\Container;
use Slim\Views\Twig;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;
use Slim\Middleware\MethodOverrideMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();
AppFactory::setContainer($container);

$container->set('db', function () {
    $db = new \PDO("sqlite:" . __DIR__ . '/../database/database.sqlite');
    $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(\PDO::ATTR_TIMEOUT, 5000);
    $db->exec("PRAGMA journal_mode = WAL");
    return $db;
});

$container->set('auth', function () use ($container) {
    return new Auth($container->get('db'));
});

$authenticatedMiddlewareFn = function (Request $request, RequestHandler $handler) {
    $response = $handler->handle($request);

    if (!$this->get('auth')->check()) {
        return $response->withHeader('Location', '/login')->withStatus(302);
    }

    return $response;
};

$authenticateFromCookieMiddlewareFn = function (Request $request, RequestHandler $handler) {
    $check = isset($_COOKIE['remember']) && !empty($_COOKIE['remember']);
    if ($check) {
        $user = $this->get('auth')->getUserByRememberIdentifier($_COOKIE['remember']);
        $this->get('auth')->setUserSession($user);
    }
    $response = $handler->handle($request);

    return $response;
};


$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$twig = Twig::create(__DIR__ . '/../twig', ['cache' => false]);

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});


$app->get('/login', function (Request $request, Response $response, $args) {
    $view = Twig::fromRequest($request);
    return $view->render($response, 'login.html');
});

$app->post('/logaut', function (Request $request, Response $response, $args) {
    $this->get('auth')->logout();

    return $response->withHeader('Location', '/login')->withStatus(302);
});


$app->post('/auth', function (Request $request, Response $response, $args) {
    $parsedBody = $request->getParsedBody();

    $email = $parsedBody['email'];
    $password = $parsedBody['password'];
    $remember_me = isset($parsedBody['remember_me']) ? true : false;

    $result = $this->get('auth')->attempt($email, $password, $remember_me);

    if (!$result) {
        return $response->withStatus(403);
    }



    return $response->withHeader('Location', '/private')->withStatus(302);
});

$app->get('/private', function (Request $request, Response $response, $args) {
    $user = $this->get('auth')->user();
    // if (!$user) {
    //     return $response->withHeader('Location', '/login')->withStatus(302);
    // }

    $products_id = $_SESSION['product_id'] ?? [];
    $products_cookie_id = isset($_COOKIE['products_cookie_id']) ? json_decode($_COOKIE['products_cookie_id']) : [];

    $view = Twig::fromRequest($request);
    return $view->render($response, 'user.html', [
        'user' => $user,
        'products_id' => $products_id,
        'products_cookie_id' => $products_cookie_id,
    ]);
});
// ->add($authenticateFromCookieMiddlewareFn)->add($authenticatedMiddlewareFn);


$app->get('/private2', function (Request $request, Response $response, $args) {
    $user = $this->get('auth')->user();
    dd($user);
})->add($authenticatedMiddlewareFn);
// ->add($authenticateFromCookieMiddlewareFn)->add($authenticatedMiddlewareFn);


$app->post('/add-cart', function (Request $request, Response $response, $args) {
    $_SESSION['product_id'][] = mt_rand(10, 250);

    return $response->withHeader('Location', '/private')->withStatus(302);
});

$app->post('/add-cart-cookie', function (Request $request, Response $response, $args) {
    $products_cookie_id = isset($_COOKIE['products_cookie_id']) ? json_decode($_COOKIE['products_cookie_id']) : [];

    $products_cookie_id[] = mt_rand(10, 250);

    $encodedCart = json_encode($products_cookie_id);

    setcookie("products_cookie_id", $encodedCart, [
        'expires' => time() + 86400,
        'httpOnly' => true
    ]);

    return $response->withHeader('Location', '/private')->withStatus(302);
});


$app->get('/secure', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->post('/bearer-auth', function (Request $request, Response $response, $args) {
    $parsedBody = $request->getParsedBody();

    $token = [
        'access_token' =>  bin2hex(random_bytes(32)),
        // 'refresh_token' =>  bin2hex(random_bytes(32)),
        'expires_in' => 3600
    ];

    $payload = json_encode($token);
    $response->getBody()->write($payload);

    return $response
    ->withHeader('Content-Type', 'application/json')
    ->withStatus(200);
});

$app->get('/restrict-bearer-auth', function (Request $request, Response $response, $args) {
    $headers = $request->getHeaders();

    if (!$request->hasHeader('Authorization')) {
        // Do something
    }

    $token = str_replace('Bearer ', '', $request->getHeader('Authorization')[0]);
    dd($token);
});


$methodOverrideMiddleware = new MethodOverrideMiddleware();
$app->add($methodOverrideMiddleware);

$app->add(TwigMiddleware::create($app, $twig));

$app->add(new Tuupola\Middleware\HttpBasicAuthentication([
    "path" => "/secure",
    "realm" => "Protected",
    "users" => [
        "root" => "t00r",
        "somebody" => "passw0rd"
    ]
]));

$app->run();
