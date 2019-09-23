<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT');

$method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI']; // get the request URL
$tables = ['box','box_contient_colis','casier','livreur','vendeur']; // the tables of our database
$url = rtrim($request_uri, '/');
$url = filter_var($request_uri, FILTER_SANITIZE_URL);
$url = explode('/', $url); // convert the URL to an array
// print_r($url);
$numcasier = null;
$numBox=null;
$tableName = (string) $url[3];      // exemple http://localhost/Smart_Box_API_php/api/box/132/21  ==> tableName=url[3]==box
if (($url[4])&&($url[5])) {
    $numcasier = (int) $url[4]; // exemple http://localhost/Smart_Box_API_php/api/box/132/21  ==> numcasier=url[4]==box
    $numBox=(int)$url[5];       //exemple http://localhost/Smart_Box_API_php/api/box/132/21  ==> numBox=url[5]==box
}
if (in_array($tableName, $tables)) //if the table name exist in our database
{
    // Include that api route
    include_once './classes/Database.php';
    include_once './api/boxes.php';
} else {
    echo json_encode(['message' => 'Table does not exists']);
}