<?php 
/**
 *@version		1.0
 *@name			captcha.php
 *@abstract		Captcha Library Object
 *@author		maheep vm
 *@copyright	m a h e e p v m (c) 2017
 */
?><?php 
session_start(); // Staring Session
$captchanumber = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'; // Initializing PHP variable with string
$captchanumber = substr(str_shuffle($captchanumber), 0, 6); // Getting first 6 word after shuffle.
$_SESSION["captcha"] = $captchanumber; // Initializing session variable with above generated sub-string
$image = imagecreatefromjpeg(__DIR__ . "/image.jpg"); // Generating CAPTCHA
$foreground = imagecolorallocate($image, 25, 29, 25); // Font Color
imagestring($image, 5, 45, 8, $captchanumber, $foreground);
header('Content-type: image/png');
imagepng($image);
?>