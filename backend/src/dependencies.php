<?php
use DI\Container;

return function (Container $container) {
    $config = require __DIR__ . '/config.php';

    $container->set('db', function () use ($config) {
        $dbConfig = $config['settings']['db'];
        $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset=utf8";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        return new PDO($dsn, $dbConfig['user'], $dbConfig['pass'], $options);
    });
};
