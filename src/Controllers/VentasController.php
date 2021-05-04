<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\BaseController;
use Exception;

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
        try {
            $context = $this->container->get('db');

            $data = json_decode($req->getBody(), true);
            //venta
            $qry = "INSERT INTO venta (total, fecha) values (:total, :fecha)";
            $payload = $context->prepare($qry);
            $payload->bindParam(':total', $data['total']);
            $payload->bindParam(':fecha', $data['fecha']);
            // $payload->bindParam(':stat', $data['stat']);

            $payload->execute();
            $venta_id = $context->lastInsertId();
            // $res->getBody()->write($id);
            $payload = null;
            //detalles_venta
            foreach($data['items'] as $value){
                // var_dump($value);
                // die;
                $qry = "INSERT INTO detalles_venta (producto, venta, cantidad, stat) values (:producto, :venta, :cantidad, :stat)";
                $payload = $context->prepare($qry);
                $payload->bindParam(':producto', $value['producto_id']);
                $payload->bindParam(':venta', $venta_id);
                $payload->bindParam(':cantidad', $value['cantidad']);
                $payload->bindParam(':stat', $value['stat']);
                
                $payload->execute();
                // var_dump($payload);
                // die;
                $payload = null;

                $qry = "UPDATE producto SET stock = (stock - :cantidad) WHERE producto_id = :producto";

                $payload = $context->prepare($qry);
                $payload->bindParam(':producto', $value['producto_id']);
                $payload->bindParam(':cantidad', $value['cantidad']);
                $payload->execute();
                // var_dump($value['producto_id']);
                // die;
            }
            return $res->withStatus(200);
        } catch (Exception $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
        
        // 
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