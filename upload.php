<?php
//init_set('display_errors',1);
//init_set('display_startup_errors',1);
//error_reporting(E_ALL);


require 'vendor/autoload.php';
use Aws\S3\S3Client;


$archivo = $_FILES["archivo"];
$type = mime_content_type($archivo['tmp_name']);

if ($type === "image/png" or $type === "image/jpeg") {
    
    $uniqueName = uniqid('image_');//Generamos nombre Unico
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);//Cogemos la extensión del archivo
    $target = 'originales';//Nombre del destino
    $uploadedFile = $target . '/' . $uniqueName . '.' . $extension;//Direccion donde se subira + nombre unico
    $tmp_name = $archivo['tmp_name'];//Direccion temporal donde se encuentra la imagen
    
    if(move_uploaded_file($tmp_name, $uploadedFile)) {
        BucektConecction($uniqueName,$extension);
            return [$uploadedFile, $uniqueName . '.' . $extension, $uniqueName, $extension];
        
    } else{
        echo "Fallo en la Subida";
    }
    
}else {
    echo "SOLO PUEDEN SER IMÁGENES";
}



function BucektConecction($nombreUnico, $extension){
    
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();
    
    
    $s3Client = new S3Client([
        'version' => 'latest',
        'region'  => 'us-east-1',
        'credentials' => [
            'key'    => $_ENV['aws_access_key_id'],
            'secret' => $_ENV['aws_secret_access_key'],
            'token' => $_ENV['aws_session_token'],
        ]
        ]);
            
            
        $bucket = 'aws-bucket-facerekognition';
        $file_Path = 'originales/'.$nombreUnico . '.' . $extension;
        $key = basename($file_Path);
            
        try {
            $result = $s3Client->putObject([
                'Bucket' => $bucket,
                'Key'    => $key,
                'Body'   => fopen($file_Path, 'r')
                //'ACL'    => 'public-read', // make file 'public'(sólo funciona si el bucket permite insercción de ACL)
                ]);
                //echo "Image uploaded successfully. Image path is: ". $result->get('ObjectURL');
                echo $result;
        } catch (Aws\S3\Exception\S3Exception $e) {
            echo "There was an error uploading the file.\n";
            echo $e->getMessage();
        }
    
}

?>