<?php

$stamp = imagecreatefrompng('qrcode.png');
$im = imagecreatefrompng('../../uploads/qr/1.png');

// Set the margins for the stamp and get the height/width of the stamp image
$marge_right = 1;
$marge_bottom = 1;
$sx = imagesx($stamp);
$sy = imagesy($stamp);

// Copy the stamp image onto our photo using the margin offsets and the photo 
// width to calculate positioning of the stamp. 
imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

// OUTPUT IMAGE:
header("Content-Type: image/png");
imagesavealpha($im, true);
imagepng($im, NULL); 
    ?>

