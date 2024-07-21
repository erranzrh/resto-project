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

        // Cart routes
        $group->post('/cart', function (Request $request, Response $response, array $args) use ($container) {
            $data = $request->getParsedBody();
        
            if (!isset($data['user_id']) || !isset($data['menu_id']) || !isset($data['quantity'])) {
                $response->getBody()->write(json_encode(['error' => 'Invalid input']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }
        
            $userId = $data['user_id'];
            $menuId = $data['menu_id'];
            $quantity = $data['quantity'];
        
            $db = $container->get('db');
            $stmt = $db->prepare('INSERT INTO cart (user_id, menu_id, quantity) VALUES (:user_id, :menu_id, :quantity)');
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':menu_id', $menuId);
            $stmt->bindParam(':quantity', $quantity);
        
            if ($stmt->execute()) {
                $response->getBody()->write(json_encode(['message' => 'Item added to cart successfully']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
            } else {
                $response->getBody()->write(json_encode(['error' => 'Failed to add item to cart']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
            }
        });

        $group->get('/cart/{user_id}', function (Request $request, Response $response, array $args) use ($container) {
            $userId = $args['user_id'];
        
            $db = $container->get('db');
            $stmt = $db->prepare('SELECT cart.*, menu.name, menu.price, menu.description FROM cart JOIN menu ON cart.menu_id = menu.id WHERE cart.user_id = :user_id');
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
        
            $cartItems = $stmt->fetchAll();
        
            $response->getBody()->write(json_encode($cartItems));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        });

        // Cart checkout and order placement
        $group->post('/cart/checkout', function (Request $request, Response $response, array $args) use ($container) {
            $data = $request->getParsedBody();

            if (!isset($data['user_id']) || !isset($data['items'])) {
                $response->getBody()->write(json_encode(['error' => 'Invalid input']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }

            $userId = $data['user_id'];
            $cartItems = $data['items'];

            $db = $container->get('db');
            $db->beginTransaction();

            try {
                // Insert into orders table
                $stmt = $db->prepare('INSERT INTO orders (user_id) VALUES (:user_id)');
                $stmt->bindParam(':user_id', $userId);
                $stmt->execute();
                $orderId = $db->lastInsertId();

                // Insert cart items into order_items
                foreach ($cartItems as $item) {
                    $stmt = $db->prepare('INSERT INTO order_items (order_id, menu_id, quantity) VALUES (:order_id, :menu_id, :quantity)');
                    $stmt->bindParam(':order_id', $orderId);
                    $stmt->bindParam(':menu_id', $item['menu_id']);
                    $stmt->bindParam(':quantity', $item['quantity']);
                    $stmt->execute();
                }

                // Clear the cart
                $stmt = $db->prepare('DELETE FROM cart WHERE user_id = :user_id');
                $stmt->bindParam(':user_id', $userId);
                $stmt->execute();

                $db->commit();

                $response->getBody()->write(json_encode(['message' => 'Order placed successfully']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
            } catch (Exception $e) {
                $db->rollBack();
                $response->getBody()->write(json_encode(['error' => 'Failed to place order', 'details' => $e->getMessage()]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
            }
        });

        // Orders routes
        $group->get('/orders', function (Request $request, Response $response, array $args) use ($container) {
            $userId = $request->getQueryParams()['user_id'];

            $db = $container->get('db');
            $stmt = $db->prepare('SELECT * FROM orders WHERE user_id = :user_id');
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            $orders = $stmt->fetchAll();

            foreach ($orders as &$order) {
                $stmt = $db->prepare('SELECT order_items.*, menu.name, menu.price, menu.description FROM order_items JOIN menu ON order_items.menu_id = menu.id WHERE order_items.order_id = :order_id');
                $stmt->bindParam(':order_id', $order['id']);
                $stmt->execute();
                $order['items'] = $stmt->fetchAll();
            }

            $response->getBody()->write(json_encode($orders));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        });

        // New route to get all orders for admin notifications
        $group->get('/admin/notifications', function (Request $request, Response $response, array $args) use ($container) {
            $db = $container->get('db');
            $stmt = $db->query('SELECT orders.id as order_id, orders.order_date, user.name as user_name, user.email as user_email FROM orders JOIN user ON orders.user_id = user.id');
            $orders = $stmt->fetchAll();

            foreach ($orders as &$order) {
                $stmt = $db->prepare('SELECT order_items.*, menu.name, menu.price FROM order_items JOIN menu ON order_items.menu_id = menu.id WHERE order_items.order_id = :order_id');
                $stmt->bindParam(':order_id', $order['order_id']);
                $stmt->execute();
                $order['items'] = $stmt->fetchAll();
            }

            $response->getBody()->write(json_encode($orders));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        });

        // New route to get total users
        $group->get('/users/count', function (Request $request, Response $response, array $args) use ($container) {
            $db = $container->get('db');
            $stmt = $db->query('SELECT COUNT(*) as userCount FROM user');
            $result = $stmt->fetch();
            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        });

        // New route to get total menu items
        $group->get('/menus/count', function (Request $request, Response $response, array $args) use ($container) {
            $db = $container->get('db');
            $stmt = $db->query('SELECT COUNT(*) as menuCount FROM menu');
            $result = $stmt->fetch();
            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        });

        // New route to get total orders
        $group->get('/orders/count', function (Request $request, Response $response, array $args) use ($container) {
            $db = $container->get('db');
            $stmt = $db->query('SELECT COUNT(*) as orderCount FROM orders');
            $result = $stmt->fetch();
            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        });

        // New route to get total revenue
        $group->get('/orders/total-revenue', function (Request $request, Response $response, array $args) use ($container) {
            $db = $container->get('db');
            $stmt = $db->query('SELECT SUM(order_items.quantity * menu.price) as totalRevenue FROM order_items JOIN menu ON order_items.menu_id = menu.id');
            $result = $stmt->fetch();
            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        });


    });
};
?>
