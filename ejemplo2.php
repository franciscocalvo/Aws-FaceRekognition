<?php 

if(isset($_GET['file']) && isset($_GET['name'])){
  $file = $_GET['file'];
  $name = $_GET['name'];
}else {
    header('Location: https://informatica.ieszaidinvergeles.org:10048/pia');
    exit;
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Face Detector</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/jcrop/dist/jcrop.css">
    <script src="https://unpkg.com/jcrop"></script>
    <script type="text/javascript" src="service.js"></script>
</head>
<body>

<img id="imagen" src="<?= $file ?>" alt="imagen subida"> </img>
<input type="button" value="Procesa"/>
</body>
</html>