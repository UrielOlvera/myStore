<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\BaseController;

class ProductosController extends BaseController{
    public function getAll(Request $req, Response $res, $args){
        $context = $this->container->get('db');
        $qry = $context->query("SELECT * FROM producto");
        $payload = json_encode($qry->fetchAll());
        $res->getBody()->write($payload);
        return $res
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
    public function getElementById(Request $req, Response $res, array $args){
        $context = $this->container->get('db');
        $qry = $context->query("SELECT * FROM producto WHERE producto_id = " . $args['id']);
        $payload = json_encode($qry->fetch());
        $res->getBody()->write($payload);
        return $res
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
    public function addElement(Request $req, Response $res, array $args){
        $context = $this->container->get('db');

        $data = json_decode($req->getBody(), true);
        
        $qry = "INSERT INTO producto (nombre, precio, descripcion, categoria, stock) values (:nombre, :precio, :descripcion, :categoria, :stock)";
        $payload = $context->prepare($qry);
        $payload->bindParam(':nombre', $data['nombre']);
        $payload->bindParam(':precio', $data['precio']);
        $payload->bindParam(':descripcion', $data['descripcion']);
        $payload->bindParam(':categoria', $data['categoria']);
        $payload->bindParam(':stock', $data['stock']);

        // var_dump($payload);
        // die();
        $payload->execute();
        return $res->withStatus(200);
    }
    public function updateElement(Request $req, Response $res, array $args){
        $context = $this->container->get('db');

        $data = json_decode($req->getBody(), true);
        
        $qry = "UPDATE producto SET nombre = :nombre, precio = :precio, descripcion = :descripcion, categoria = :categoria, stock = :stock WHERE producto_id =" . $args['id'];

        $payload = $context->prepare($qry);
        $payload->bindParam(':nombre', $data['nombre']);
        $payload->bindParam(':precio', $data['precio']);
        $payload->bindParam(':descripcion', $data['descripcion']);
        $payload->bindParam(':categoria', $data['categoria']);
        $payload->bindParam(':stock', $data['stock']);
        // var_dump($payload);
        // die();
        $payload->execute();
        return $res->withStatus(200);
    }
    public function deleteElement(Request $req, Response $res, array $args){
        $context = $this->container->get('db');

        $qry = "DELETE FROM producto WHERE producto_id =" . $args['id'];

        $payload = $context->prepare($qry);
        $payload->execute();
        
        return $res->withStatus(200);
    }
}