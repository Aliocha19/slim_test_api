<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->get('/api/customers', function (Request $request, Response $response) {
    
    
    $sql = "CALL `get_all_customers`();";
    echo "It's in";

    try {
        
        $myDB = new db();
        $myDB = $myDB->connect();
        
        $data = $myDB->query($sql)->fetchAll();
        $myDB = null;
        echo json_encode($data);
      

    } catch (PDOException  $e) {
        //throw $th;
        echo "DataBase Error: The user could not be added.<br>" . $e->getMessage();
    }
});

// get a single customer

$app->get('/api/customers/{id}', function ($request, $response, $args) {

  $myId = $args['id'];

    $sql = "CALL `get_customer_by_id`($myId) ;";
       
    
    try {

        $myDB = new db();
        $myDB = $myDB->connect();

        $data = $myDB->query($sql)->fetchAll();
        $myDB = null;
        echo json_encode($data);
    } catch (PDOException  $e) {
        //throw $th;
        echo "DataBase Error: The user could not be added.<br>" . $e->getMessage();
    }
});

// Add a customer



$app->post('/api/customers', function ($request, $response, $args) {


    $Params = $request->getParsedBody();
    $myState = $Params["state"];


    try {

        $myDB = new db();
        $myDB = $myDB->connect();

        $statement = $myDB->prepare('CALL `add_customer`(:first_name, :last_name, :phone, :email, :address, :city, :stateVal )');

            $statement->bindParam(':first_name', $Params['first_name']);

            $statement->bindParam(':last_name',$Params['last_name']);

            $statement->bindParam(':phone',$Params['phone']);

            $statement->bindParam(':email',$Params['email']);

            $statement->bindParam(':address',$Params['address']);

            $statement->bindParam(':city',$Params['city']);

            $statement->bindParam(':stateVal', $myState);

        $statement->execute();

        // $sql = "CALL `add_customer`(?, ?, ?, ?, ?, ?, ?) ";
       
       // $myDB->prepare($sql)->execute($data);
       
        
        $myDB = null;
        echo "success-2";
    } catch (PDOException  $e) {
        //throw $th;
        echo "DataBase Error: The user could not be added.<br>" . $e->getMessage();
    }
});

