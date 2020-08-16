<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../class/peliculas.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Pelicula($db);

    $item->type = isset($_GET['type']) ? $_GET['type'] : die();
  
    $data = $item->getTypePelicula();

    if($data > 0){
        http_response_code(200);
        echo json_encode($data);
    }
    else{
        http_response_code(404);
        echo json_encode("Pelicula not found.");
    }
?>