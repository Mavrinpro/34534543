<?php
require 'vendor/autoload.php';
use Workerman\Worker;


$worker = new Worker('websocket://127.0.0.1:8001');
$worker->count = 4;
//    $worker->onConnect = function ($connection){
//        if (isset($_POST['name'])){
//            $connection->send($_POST['name']);
//        }
//
//
//    };

$worker->onMessage = function ($connection, $data) {
    // if, server got message from frontend, server send message to Frontend $data

    $file = 'text.json';
    //$jsonArray[] = $data;
    file_put_contents($file, $data,FILE_APPEND);

    if (file_exists('text.json')){
        $json = file_get_contents('text.json');
        $jsonArray = json_decode($json, true);
    }
    $connection->send(json_encode($jsonArray));
};


Worker::runAll();

