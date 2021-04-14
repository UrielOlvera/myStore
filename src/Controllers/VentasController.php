<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\BaseController;

class VEntasController extends BaseController{
    public function getAll(Request $req, Response $res, $args){
        $context = $this->container->get('db');
        $qry = $context->query("SELECT * FROM venta");
        $payload = json_encode($qry->fetchAll());
        $res->getBody()->write($payload);
        return $res
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
    public function getElementById(Request $req, Response $res, array $args){
        $context = $this->container->get('db');
        $qry = $context->query("SELECT * FROM venta WHERE venta_id = " . $args['id']);
        $payload = json_encode($qry->fetch());
        $res->getBody()->write($payload);
        return $res
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
    public function addElement(Request $req, Response $res, array $args){
        $context = $this->container->get('db');

        $data = json_decode($req->getBody(), true);
        
        $qry = "INSERT INTO venta (total, fecha, stat) values (:total, :fecha, :stat)";
        $payload = $context->prepare($qry);
        $payload->bindParam(':total', $data['total']);
        $payload->bindParam(':fecha', $data['fecha']);
        $payload->bindParam(':stat', $data['stat']);
        // var_dump($payload);
        // die();
        $payload->execute();
        return $res->withStatus(200);
    }
    public function updateElement(Request $req, Response $res, array $args){
        $context = $this->container->get('db');

        $data = json_decode($req->getBody(), true);
        
        $qry = "UPDATE venta SET total = :total, fecha = :fecha, stat = :stat WHERE venta_id =" . $args['id'];

        $payload = $context->prepare($qry);
        $payload->bindParam(':total', $data['total']);
        $payload->bindParam(':fecha', $data['fecha']);
        $payload->bindParam(':stat', $data['stat']);
        // var_dump($payload);
        // die();
        $payload->execute();
        return $res->withStatus(200);
    }
    public function deleteElement(Request $req, Response $res, array $args){
        $context = $this->container->get('db');

        $qry = "DELETE FROM venta WHERE venta_id =" . $args['id'];

        $payload = $context->prepare($qry);
        $payload->execute();
        
        return $res->withStatus(200);
    }
}