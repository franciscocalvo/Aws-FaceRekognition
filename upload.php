<?php

//init_set('display_errors',1);
//init_set('display_startup_errors',1);
//error_reporting(E_ALL);
//Visualizar errores en timepo de ejecución


require 'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\S3\MultipartUploader;
use Aws\Exception\S3Exception;
use Aws\Exception\MultipartUploadException;




$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$archivo = $_FILES["archivo"];
$type = mime_content_type($archivo['tmp_name']);

if ($type === "image/png" or $type === "image/jpeg") {
    
    $uniqueName = uniqid('image_');//Generamos nombre Unico
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);//Cogemos la extensión del archivo
    $target = 'originales';//Nombre del destino
    $uploadedFile = $target . '/' . $uniqueName . '.' . $extension;//Direccion donde se subira + nombre unico
    $nameExtension = $uniqueName . '.' . $extension;
    $tmp_name = $archivo['tmp_name'];//Direccion temporal donde se encuentra la imagen
    
    if(move_uploaded_file($tmp_name, $uploadedFile)) {
        uploadFileToBucket($uploadedFile,$nameExtension);
        header('Location: https://informatica.ieszaidinvergeles.org:10048/pia/upload/Aws-FaceRekognition/preSelection.php?file='. $uploadedFile . '&name=' . $nameExtension);
        exit;
        return [$uploadedFile, $uniqueName . '.' . $extension, $uniqueName, $extension];
        
    } else{
        echo "Fallo en la Subida";
    }
    
}else {
    echo "SOLO PUEDEN SER IMÁGENES";
}



function uploadFileToBucket($file, $key) {
    $result = false;
    try {
        $s3 = new S3Client([
            'version'     => 'latest',
            'region'      => 'us-east-1', //depends on the value of your region
            'credentials' => [
                'key'    => $_ENV['aws_access_key_id'],
                'secret' => $_ENV['aws_secret_access_key'],
                'token' => $_ENV['aws_session_token']
            ]
        ]);
        $uploader = new MultipartUploader($s3, $file, [
            'bucket' => $_ENV['bucket'],
            'key'    => $key,
        ]);
        $result = $uploader->upload();
    } catch(MultipartUploadException $e) {
        //to see the message: $e->getMessage()
    } catch (S3Exception $e) {
        //to see the message: $e->getMessage()
    }
    return $result;
}

?>