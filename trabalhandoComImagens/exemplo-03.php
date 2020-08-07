<?php

$image = imagecreatefromjpeg("Certificado.jpg");

$titleColor = imagecolorallocate($image, 0,0,0);
$gray = imagecolorallocate($image, 100,100,100);

$fonteBevan = realpath("fonts" . DIRECTORY_SEPARATOR . "Bevan". DIRECTORY_SEPARATOR . "Bevan-Regular.ttf");
$fontePlayball = realpath("fonts" . DIRECTORY_SEPARATOR . "Playball". DIRECTORY_SEPARATOR . "Playball-Regular.ttf");

echo $fonteBevan  . "<br>";
echo $fontePlayball . "<br>";

/*
imagettftext($image, 32, 0, 450, 150, $titleColor, $fonteBevan, "CERTIFICADO");
imagettftext($image, 32, 0, 440, 350, $titleColor, $fontePlayball, "Danilo Lima");
imagestring($image, 3, 440, 370, utf8_decode("Cloncluído: ").date("d/m/Y"), $titleColor);

header("Content-Type: image/jpeg");

imagejpeg($image, "certificado-".date("Y-m-d").".jpeg", 10);
imagejpeg($image);

imagedestroy($image);
*/
?>

