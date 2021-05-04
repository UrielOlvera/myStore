<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\BaseController;
use Exception;

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
        $id = strval($args['id']);
        
        $context = $this->container->get('db');
        $qry = $context->prepare("SELECT * FROM producto WHERE producto_id = '" . $id . "'");
        $qry->execute();
        $payload = json_encode($qry->fetch());
        // var_dump($payload);
        // die;
        $res->getBody()->write($payload);
        
        return $res
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
    public function addElement(Request $req, Response $res, array $args){
        try {
            $context = $this->container->get('db');

            $data = json_decode($req->getBody(), true);
            
            $qry = "INSERT INTO producto (producto_id, nombre, precio, descripcion, categoria, stock, unidad) values (:producto_id, :nombre, :precio, :descripcion, :categoria, :stock, :unidad)";
            $payload = $context->prepare($qry);
            $payload->bindParam(':producto_id', $data['producto_id']);
            $payload->bindParam(':nombre', $data['nombre']);
            $payload->bindParam(':precio', $data['precio']);
            $payload->bindParam(':descripcion', $data['descripcion']);
            $payload->bindParam(':categoria', $data['categoria']);
            $payload->bindParam(':stock', $data['stock']);
            $payload->bindParam(':unidad', $data['unidad']);

            // var_dump($payload);
            // die();
            $payload->execute();
            return $res
                ->withHeader('Content-type', 'application/json')
                ->withStatus(200);
        } catch(Exception $e){
            return $res
                ->withHeader('Content-type', 'application/json')
                ->withStatus($e->getCode());
        }
        
    }
    public function updateElement(Request $req, Response $res, array $args){
        try {
            $id = strval($args['id']);
            $context = $this->container->get('db');

            $data = json_decode($req->getBody(), true);
            
            $qry = "UPDATE producto SET producto_id = :producto_id, nombre = :nombre, precio = :precio, descripcion = :descripcion, categoria = :categoria, stock = :stock, unidad = :unidad WHERE producto_id ='" . $id . "'";

            $payload = $context->prepare($qry);
            $payload->bindParam(':producto_id', $data['producto_id']);
            $payload->bindParam(':nombre', $data['nombre']);
            $payload->bindParam(':precio', $data['precio']);
            $payload->bindParam(':descripcion', $data['descripcion']);
            $payload->bindParam(':categoria', $data['categoria']);
            $payload->bindParam(':stock', $data['stock']);
            $payload->bindParam(':unidad', $data['unidad']);
            // var_dump($payload);
            // die();
            $payload->execute();
            return $res
                ->withHeader('Content-type', 'application/json')
                ->withStatus(200);
        } catch(Exception $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
            return $res
                ->withHeader('Content-type', 'application/json')
                ->withStatus($e->getCode());
        }
        
    }
    public function updateQty(Request $req, Response $res, array $args){
        try {
            $id = strval($args['id']);
            $context = $this->container->get('db');

            $data = json_decode($req->getBody(), true);

            $qry = "UPDATE producto SET stock = (stock - :cantidad) WHERE producto_id = '" . $id . "'";

            $payload = $context->prepare($qry);
            $payload->bindParam(':cantidad', $data['cantidad']);
            $payload->execute();
            return $res
                ->withHeader('Content-type', 'application/json')
                ->withStatus(200);

        } catch (Exception $e) {
        return $res
            ->withHeader('Content-type', 'application/json')
            ->withStatus($e->getCode());
        }
    }
    public function deleteElement(Request $req, Response $res, array $args){
        try {
            $id = strval($args['id']);
            $context = $this->container->get('db');

            $qry = "DELETE FROM producto WHERE producto_id = '" . $id . "'";

            $payload = $context->prepare($qry);
            $payload->execute();
            return $res
                ->withHeader('Content-type', 'application/json')
                ->withStatus(200);
        } catch(Exception $e){
            // echo $res->getBody()->write('error');
            // die;
            // echo '{"error":{"text":'. $e->getMessage() .'}}';
            // die;
            return $res
                ->withHeader('Content-type', 'application/json')
                ->withStatus(500);
        }
    }

}