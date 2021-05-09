<?php 
require_once('model.php');

$folder = '/api/';
$method = $_SERVER["REQUEST_METHOD"];
$request = $_SERVER["REQUEST_URI"];
$request = str_replace($folder, '', $request);
echo "REQUEST:<br>";
echo $request;
echo "<br><br><br>";



//GET
if($method == 'GET' && $request == 'users/'){
    $result = getAll("users");
    echo json_encode($result);
}

//POST
if($method == "POST" && $request == 'newuser/'){
    $body = file_get_contents('php://input');
    $data = json_decode($body, true);
    if (json_last_error() == JSON_ERROR_NONE){
    $done = post($data['email'], $data['firstname'], $data['lastname'], $data['password'], $data['phone']);
    }
    else
    echo "request error";
    if ($done)
    echo $body;
}

//GET1 / PUT / DELETE 
$nbr = str_replace('users/','', $request);
if ((int)$nbr > 0){
    $id = (int)$nbr;

    //GET 1
    if($method == 'GET')
    echo get1('users', $id);

//UPDATE
if($method == 'PUT'){
    $body = file_get_contents('php://input');
    $data = json_decode($body, true);
    if (json_last_error() == JSON_ERROR_NONE){
    $done = update($id, $data['email'], $data['firstname'], $data['lastname'], $data['password'], $data['phone']);
    }
    else
    echo "request error";
    if ($done)
    echo "UPDATED";
}
if($method == 'DELETE')
$result = delete1('users', $id);

}

?>