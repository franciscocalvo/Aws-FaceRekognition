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
    <link rel="stylesheet" href="https://unpkg.com/jcrop/dist/jcrop.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="preSelection.css">
    <script src="https://unpkg.com/jcrop"></script>
    
</head>
<body>

<img id="imagen" src="<?= $file ?>" alt="imagen subida"> </img>
    <form action="blurProcess.php" method="post" id="fblur">
        <input type="hidden" name="file" value="<?= $file ?>"/>
        <input type="hidden" name="name" value="<?= $name ?>"/>
        <input type="submit" value="Procesar" class="btn btn-primary"/>
    </form>
    <script type="text/javascript" src="service.js"></script>
</body>
</html>