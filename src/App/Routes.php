<?php
use Slim\Routing\RouteCollectorProxy;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

$app->group('/api', function(RouteCollectorProxy $table){
    $table->group('/usuarios', function(RouteCollectorProxy $group){
        $group->get('','App\Controllers\UsuariosController:getAll');
        $group->post('/login','App\Controllers\UsuariosController:login');
        $group->post('/add','App\Controllers\UsuariosController:addElement');
        $group->put('/edit/{id}','App\Controllers\UsuariosController:updateElement');
        $group->delete('/delete/{id}','App\Controllers\UsuariosController:deleteElement');
    });
    $table->group('/proveedores', function(RouteCollectorProxy $group){
        $group->get('','App\Controllers\ProveedoresController:getAll');
        $group->get('/{id}','App\Controllers\ProveedoresController:getElementById');
        $group->post('/add','App\Controllers\ProveedoresController:addElement');
        $group->put('/edit/{id:[0-9]+}','App\Controllers\ProveedoresController:updateElement');
        $group->delete('/delete/{id:[0-9]+}','App\Controllers\ProveedoresController:deleteElement');
    });
    $table->group('/wallets', function(RouteCollectorProxy $group){
        $group->get('','App\Controllers\WalletsController:getAll');
        $group->get('/{cod}','App\Controllers\WalletsController:getElementById');
        $group->post('/add','App\Controllers\WalletsController:addElement');
        $group->put('/edit/{cod}','App\Controllers\WalletsController:updateElement');
        $group->put('/edit_pts/{cod}','App\Controllers\WalletsController:updatePTS');
        $group->delete('/delete/{cod}','App\Controllers\WalletsController:deleteElement');
    });
    $table->group('/productos', function(RouteCollectorProxy $group){
        $group->get('','App\Controllers\ProductosController:getAll');
        $group->get('/{id}','App\Controllers\ProductosController:getElementById');
        $group->post('/add','App\Controllers\ProductosController:addElement');
        $group->put('/edit/{id}','App\Controllers\ProductosController:updateElement');
        $group->delete('/delete/{id}','App\Controllers\ProductosController:deleteElement');

        $group->put('/update-qty/{id}','App\Controllers\ProductosController:updateQty');
    });
    $table->group('/ventas', function(RouteCollectorProxy $group){
        $group->get('','App\Controllers\VentasController:getAll');
        $group->get('/{id}','App\Controllers\VentasController:getElementById');
        $group->post('/add','App\Controllers\VentasController:addElement');
        $group->put('/edit/{id}','App\Controllers\VentasController:updateElement');
        $group->delete('/delete/{id}','App\Controllers\VentasController:deleteElement');

        $group->post('/add-details','App\Controllers\DetallesVentasController:addElement');
    });
});

