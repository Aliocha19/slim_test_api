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



$app->post('/api/customers/add', function ($request, $response, $args) {


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

               
        
        $myDB = null;
        echo "{Notice: Customer added}";
    } catch (PDOException  $e) {
        //throw $th;
        echo "DataBase Error: The user could not be added.<br>" . $e->getMessage();
    }
});




$app->put('/api/customers/update/{id}', function ($request, $response, $args) {


    $Params = $request->getParsedBody();
   
    $myID = $args['id'];
    

    if (!isset($myState)) $myState = null;

    if (!isset($Params['first_name'])) $Params['first_name'] = null;

    if (!isset($Params['last_name'])) $Params['last_name'] = null;

    if (!isset($Params['phone'])) $Params['phone'] = null;

    if (!isset($Params['email']))  $Params['email'] = null;

    if (!isset($Params['address'])) $Params['address'] = null;

    if (!isset($Params['city'])) $Params['city'] = null;
    

    try {

        $myDB = new db();
        $myDB = $myDB->connect();

        $statement = $myDB->prepare('CALL `update_customer`(:first_name, :last_name, :phone, :email, :address, :city, :stateVal,:id )');

        $statement->bindParam(':first_name', $Params['first_name']);

        $statement->bindParam(':last_name', $Params['last_name']);

        $statement->bindParam(':phone', $Params['phone']);

        $statement->bindParam(':email', $Params['email']);

        $statement->bindParam(':address', $Params['address']);

        $statement->bindParam(':city', $Params['city']);

        $statement->bindParam(':stateVal', $myState);

        $statement->bindParam(':id', $myID);

        $statement->execute();



        $myDB = null;
        echo "{Notice: Customer Updated}";
    } catch (PDOException  $e) {
        //throw $th;
        echo "DataBase Error: The user could not be added.<br>" . $e->getMessage();
    }
});

