<?php

ini_set('display_errors',1);
ini_set('display_status_errors',1);
error_reporting(E_ALL);


$image1 = imagecreatefromjpeg('originales/'.$_POST['name']);
$image2 = imagecreatefromjpeg('originales/'.$_POST['name']); 



for ($i = 0; $i <30; $i++)
{
imagefilter($image1, IMG_FILTER_GAUSSIAN_BLUR); //apply repeated times
}

foreach($_POST['x'] as $index => $x) {
    $y = $_POST['y'][$index];
    $w = $_POST['w'][$index];
    $h = $_POST['h'][$index];
    imagecopy($image2, $image1, $x, $y, $x, $y, $w, $h);
}



imagejpeg($image2, 'blur_' . $_POST['file']); 
imagedestroy($image1);
imagedestroy($image2);
header('Location: blur_' . $_POST['file']);

?>