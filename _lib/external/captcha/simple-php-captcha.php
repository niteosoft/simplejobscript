<?php

    /**
     * Simplejobscript Copyright (©) 2016 Niteosoft
     *
     * @author     Niteosoft
     * @license    MIT
     * 
     */
    
    /**
     *  CAPTCHA CLASS
     */


function simple_php_captcha($text) {

$bg_path = dirname(__FILE__) . '/captchabg/';
$font = dirname(__FILE__) . '/captchabg/fonts/captcha_font.ttf';

$captcha_config = array(
	'backgrounds' => array(
        $bg_path . '45-degree-fabric.png',
        $bg_path . 'cloth-alike.png',
        $bg_path . 'grey-sandbag.png',
        $bg_path . 'kinda-jean.png',
        $bg_path . 'polyester-lite.png',
        $bg_path . 'stitched-wool.png',
        $bg_path . 'white-carbon.png',
        $bg_path . 'white-wave.png'
    )
);

$background = $captcha_config['backgrounds'][rand(0, count($captcha_config['backgrounds']) - 1)];
$im = imagecreatefrompng($background);

$gray = imagecolorallocate($im, 25, 25, 25);
imagettftext($im, 28, 0, 30, 50, $gray, $font, $text);

ob_start();
// // Output the image
imagepng($im);
$rawImageBytes = ob_get_clean();
imagedestroy($im);
return $rawImageBytes;

}

?>