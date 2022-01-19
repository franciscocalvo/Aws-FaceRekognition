<?php

require 'vendor/autoload.php';

use Aws\Rekognition\RekognitionClient;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$newCoords = [];
if(isset($_GET['name'])) {
    $name = $_GET['name'];
    $coords = detectFaces($name);
    $newCoords = getFaceValues($coords);
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($newCoords);

function detectFaces($name) {
    try{
        $rekognition = new RekognitionClient([
            'version'     => 'latest',
            'region'      => $_ENV['region'],
            'credentials' => [
                'key'    => $_ENV['aws_access_key_id'],
                'secret' => $_ENV['aws_secret_access_key'],
                'token'  => $_ENV['aws_session_token']
            ]
        ]);
        $result = $rekognition->DetectFaces(array(
            'Image' => [
                'S3Object' => [
                    'Bucket' => $_ENV['bucket'],
                    'Name' => $name,
                ],
            ],
           'Attributes' => ['ALL']
           )
        );
    } catch(Exception $e) {
        echo $e->getMessage();
        $result = false;
    }
    return $result;
}

function getFaceValues($data) {
    $faces = [];
    foreach($data['FaceDetails'] as $index => $value) {
        $face = [];
        $face['width']  = $value['BoundingBox']['Width'];
        $face['height'] = $value['BoundingBox']['Height'];
        $face['left']   = $value['BoundingBox']['Left'];
        $face['top']    = $value['BoundingBox']['Top'];
        $face['low']    = $value['AgeRange']['Low'];
        $face['high']   = $value['AgeRange']['High'];
        $face['gender'] = $value['Gender']['Value'];
        $faces[] = $face;
    }
    return $faces;
}


?>