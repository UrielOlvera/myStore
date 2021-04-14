<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\BaseController;

class ProveedoresController extends BaseController{
    public function getAll(Request $req, Response $res, $args){
        $context = $this->container->get('db');
        $qry = $context->query("SELECT * FROM proveedor");
        $payload = json_encode($qry->fetchAll());
        $res->getBody()->write($payload);
        return $res
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
    public function getElementById(Request $req, Response $res, array $args){
        $context = $this->container->get('db');
        $qry = $context->query("SELECT * FROM proveedor WHERE proveedor_id = " . $args['id']);
        $payload = json_encode($qry->fetch());
        $res->getBody()->write($payload);
        return $res
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
    public function addElement(Request $req, Response $res, array $args){
        $context = $this->container->get('db');

        $data = json_decode($req->getBody(), true);
        
        $qry = "INSERT INTO proveedor (nombre, telefono, email, direccion, referencia) values (:nombre, :telefono, :email, :direccion, :referencia)";
        $payload = $context->prepare($qry);
        $payload->bindParam(':nombre', $data['nombre']);
        $payload->bindParam(':telefono', $data['telefono']);
        $payload->bindParam(':email', $data['email']);
        $payload->bindParam(':direccion', $data['direccion']);
        $payload->bindParam(':referencia', $data['referencia']);
        // var_dump($payload);
        // die();
        $payload->execute();
        return $res->withStatus(200);
    }
    public function updateElement(Request $req, Response $res, array $args){
        $context = $this->container->get('db');

        $data = json_decode($req->getBody(), true);
        
        $qry = "UPDATE proveedor SET nombre = :nombre, telefono = :telefono, email = :email, direccion = :direccion, referencia = :referencia WHERE proveedor_id =" . $args['id'];

        $payload = $context->prepare($qry);
        $payload->bindParam(':nombre', $data['nombre']);
        $payload->bindParam(':telefono', $data['telefono']);
        $payload->bindParam(':email', $data['email']);
        $payload->bindParam(':direccion', $data['direccion']);
        $payload->bindParam(':referencia', $data['referencia']);
        // var_dump($payload);
        // die();
        $payload->execute();
        return $res->withStatus(200);
    }
    public function deleteElement(Request $req, Response $res, array $args){
        $context = $this->container->get('db');

        $qry = "DELETE FROM proveedor WHERE proveedor_id =" . $args['id'];

        $payload = $context->prepare($qry);
        $payload->execute();
        
        return $res->withStatus(200);
    }
}