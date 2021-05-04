<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\BaseController;

class UsuariosController extends BaseController{
    public function getAll(Request $req, Response $res, $args){
        $context = $this->container->get('db');
        $qry = $context->query("SELECT * FROM usuario");
        $payload = json_encode($qry->fetchAll());
        $res->getBody()->write($payload);
        return $res
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
    public function login(Request $req, Response $res, array $args){
        $context = $this->container->get('db');

        $data = json_decode($req->getBody(), true);

        $qry = $context->prepare("SELECT * FROM usuario WHERE username = :username AND pass = :pass");
        $qry->bindParam(':username', $data['username']);
        $qry->bindParam(':pass', $data['pass']);
        $qry->execute();
        $payload = json_encode($qry->fetch());
        $res->getBody()->write($payload);
        return $res
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
    public function addElement(Request $req, Response $res, array $args){
        $context = $this->container->get('db');

        $data = json_decode($req->getBody(), true);
        
        $qry = "INSERT INTO usuario (username, pass, nivel, auth_clv) values (:username, :pass, :nivel, :auth_clv)";
        $payload = $context->prepare($qry);
        $payload->bindParam(':username', $data['username']);
        $payload->bindParam(':pass', $data['pass']);
        $payload->bindParam(':nivel', $data['nivel']);
        $payload->bindParam(':auth_clv', $data['auth_clv']);
        // var_dump($payload);
        // die();
        $payload->execute();
        return $res->withStatus(200);
    }
    public function updateElement(Request $req, Response $res, array $args){
        $context = $this->container->get('db');

        $data = json_decode($req->getBody(), true);
        
        $qry = "UPDATE usuario SET username = :username, pass = :pass, nivel = :nivel, auth_clv = :auth_clv WHERE usuario_id =" . $args['id'];

        $payload = $context->prepare($qry);
        $payload->bindParam(':username', $data['username']);
        $payload->bindParam(':pass', $data['pass']);
        $payload->bindParam(':nivel', $data['nivel']);
        $payload->bindParam(':auth_clv', $data['auth_clv']);
        // var_dump($payload);
        // die();
        $payload->execute();
        return $res->withStatus(200);
    }
    public function deleteElement(Request $req, Response $res, array $args){
        $context = $this->container->get('db');

        $qry = "DELETE FROM usuario WHERE usuario_id =" . $args['id'];

        $payload = $context->prepare($qry);
        $payload->execute();
        
        return $res->withStatus(200);
    }
}
