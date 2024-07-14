<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;
use Psr\Container\ContainerInterface;

return function (Slim\App $app) {
    $container = $app->getContainer();

    $app->group('/api', function (RouteCollectorProxy $group) use ($container) {
        // Sign up route
        $group->post('/signup', function (Request $request, Response $response, array $args) use ($container) {
            $data = $request->getParsedBody();

            if (!isset($data['name']) || !isset($data['email']) || !isset($data['password'])) {
                $response->getBody()->write(json_encode(['error' => 'Invalid input']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }

            $name = $data['name'];
            $email = $data['email'];
            $password = $data['password'];
            $role = 'customer'; // Default role

            $db = $container->get('db');
            $stmt = $db->prepare('INSERT INTO user (name, email, password, role) VALUES (:name, :email, :password, :role)');
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':role', $role);

            if ($stmt->execute()) {
                $response->getBody()->write(json_encode(['message' => 'User registered successfully']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
            } else {
                $response->getBody()->write(json_encode(['error' => 'Failed to register user']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
            }
        });

        // Login route
        $group->post('/login', function (Request $request, Response $response, array $args) use ($container) {
            $data = $request->getParsedBody();

            if (!isset($data['email']) || !isset($data['password'])) {
                $response->getBody()->write(json_encode(['error' => 'Invalid input']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }

            $email = $data['email'];
            $password = $data['password'];

            $db = $container->get('db');
            $stmt = $db->prepare('SELECT * FROM user WHERE email = :email AND password = :password');
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();

            $user = $stmt->fetch();

            if ($user) {
                unset($user['password']);
                $response->getBody()->write(json_encode($user));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
            } else {
                $response->getBody()->write(json_encode(['error' => 'Invalid email or password']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
            }
        });

        // Menus CRUD routes
        $group->get('/menus', function (Request $request, Response $response, array $args) use ($container) {
            $db = $container->get('db');
            $stmt = $db->query('SELECT * FROM menu');
            $menus = $stmt->fetchAll();

            $response->getBody()->write(json_encode($menus));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        });

        $group->post('/menus', function (Request $request, Response $response, array $args) use ($container) {
            $data = $request->getParsedBody();

            if (!isset($data['name']) || !isset($data['price']) || !isset($data['description'])) {
                $response->getBody()->write(json_encode(['error' => 'Invalid input']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }

            $name = $data['name'];
            $price = $data['price'];
            $description = $data['description'];

            $db = $container->get('db');
            $stmt = $db->prepare('INSERT INTO menu (name, price, description) VALUES (:name, :price, :description)');
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':description', $description);

            if ($stmt->execute()) {
                $response->getBody()->write(json_encode(['message' => 'Menu item created successfully']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
            } else {
                $response->getBody()->write(json_encode(['error' => 'Failed to create menu item']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
            }
        });

        $group->put('/menus/{id}', function (Request $request, Response $response, array $args) use ($container) {
            $id = $args['id'];
            $data = $request->getParsedBody();
        
            if (!isset($data['name']) || !isset($data['price']) || !isset($data['description'])) {
                $response->getBody()->write(json_encode(['error' => 'Invalid input']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }
        
            $name = $data['name'];
            $price = $data['price'];
            $description = $data['description'];
        
            $db = $container->get('db');
            $stmt = $db->prepare('UPDATE menu SET name = :name, price = :price, description = :description WHERE id = :id');
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':id', $id);
        
            if ($stmt->execute()) {
                $response->getBody()->write(json_encode(['message' => 'Menu item updated successfully']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
            } else {
                $response->getBody()->write(json_encode(['error' => 'Failed to update menu item']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
            }
        });        

        $group->delete('/menus/{id}', function (Request $request, Response $response, array $args) use ($container) {
            $id = $args['id'];

            $db = $container->get('db');
            $stmt = $db->prepare('DELETE FROM menu WHERE id = :id');
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                $response->getBody()->write(json_encode(['message' => 'Menu item deleted successfully']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
            } else {
                $response->getBody()->write(json_encode(['error' => 'Failed to delete menu item']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
            }
        });
    });
};
