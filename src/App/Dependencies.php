<?php

use Psr\Container\ContainerInterface;

$container->set('db', function(ContainerInterface $c){
    $config = $c->get('db_settings');
    $host = $config->DB_HOST;
    $name = $config->DB_NAME;
    $pass = $config->DB_PASS;
    $char = $config->DB_CHAR;
    $user = $config->DB_USER;

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ];
    $dsn = "mysql:host=$host;dbname=$name;charset=$char";

    return new PDO($dsn,$user,$pass,$options);

});