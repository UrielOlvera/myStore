<?php
$container->set('db_settings',function(){
    return (object)[
        "DB_NAME" => "mystore",
        "DB_PASS" => "",
        "DB_HOST" => "127.0.0.1",
        "DB_USER" => "root",
        "DB_CHAR" => "utf8"
    ];
});