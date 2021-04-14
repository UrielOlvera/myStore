<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\BaseController;

class WalletsController extends BaseController{
    public function getAll(Request $req, Response $res, $args){
        $context = $this->container->get('db');
        $qry = $context->query("SELECT * FROM wallet");
        $payload = json_encode($qry->fetchAll());
        $res->getBody()->write($payload);
        return $res
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
    public function getElementById(Request $req, Response $res, array $args){
        $context = $this->container->get('db');
        $qry = $context->query("SELECT * FROM wallet WHERE cod = " . $args['cod']);
        $payload = json_encode($qry->fetch());
        $res->getBody()->write($payload);
        return $res
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
    public function addElement(Request $req, Response $res, array $args){
        $context = $this->container->get('db');

        $data = json_decode($req->getBody(), true);
        
        $qry = "INSERT INTO wallet (cod, puntos) values (:cod, :puntos)";
        $payload = $context->prepare($qry);
        $payload->bindParam(':cod', $data['cod']);
        $payload->bindParam(':puntos', $data['puntos']);

        // var_dump($payload);
        // die();
        $payload->execute();
        return $res->withStatus(200);
    }
    public function updateElement(Request $req, Response $res, array $args){
        $context = $this->container->get('db');

        $data = json_decode($req->getBody(), true);
        
        $qry = "UPDATE wallet SET cod = :cod, puntos = :puntos WHERE cod =" . $args['cod'];

        $payload = $context->prepare($qry);
        $payload->bindParam(':cod', $data['cod']);
        $payload->bindParam(':puntos', $data['puntos']);
        // var_dump($payload);
        // die();
        $payload->execute();
        return $res->withStatus(200);
    }
    public function deleteElement(Request $req, Response $res, array $args){
        $context = $this->container->get('db');

        $qry = "DELETE FROM wallet WHERE cod =" . $args['cod'];

        $payload = $context->prepare($qry);
        $payload->execute();
        
        return $res->withStatus(200);
    }
}