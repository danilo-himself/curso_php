<?php

$image = imagecreatefromjpeg("Certificado.jpg");

$titleColor = imagecolorallocate($image, 0,0,0);
$gray = imagecolorallocate($image, 100,100,100);


imagestring($image, 5, 450, 150, "CERTIFICADO", $titleColor);
imagestring($image, 5, 440, 350, "DANILO LIMA", $titleColor);
imagestring($image, 5, 440, 370, "CONCLUIDO:" . date("d/m/Y"), $titleColor);

header("Content-Type: image/jpeg");

//imagejpeg($image);
imagejpeg($image, "certificado-".date("Y-m-d").".jpeg", 10);
imagedestroy($image);

?>

