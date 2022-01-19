<?php

$image1 = imagecreatefromjpeg('pathimage');
$image2 = imagecreatefromjpeg('pathimage');



for($i=0; $i<30; $i++){
    imagefilter($image1, IMG_FILTER_GAUSSIAN_BLUR); //apply repeated times
}

imagecopy($image2, $image1, 200, 100, 200, 100, 400, 400); //copy area
imagepng($image2, 'pathnewimage', 0, PNG_NO_FILTER); //save new file
imagedestroy($image1);
imagedestroy($image2);

header('Location: pathnewimage');

?>