<?php
  function hex2rgb($hex) {
    // Strip #
    $hex = str_replace("#", "", $hex);
    $rgb = intval($hex, 16);
    $r = ($rgb >> 16) & 0xff;
    $g = ($rgb >> 8) & 0xff;
    $b = ($rgb >> 0) & 0xff;

    return array($r, $g, $b);
  }

  function getTextColor($hex) {
    $color = hex2rgb($hex);

    $luma = 0.2126 * $color[0] + 0.7152 * $color[1] + 0.0722 * $color[2];

    if ($luma > 215) { // too bright for white text
      return [51, 51, 51];
    } else {
      return [255, 255, 255];
    }
  }

  function drawCentered($image, $font_size, $y, $text, $text_color) {
    putenv("GDFONTPATH=" . realpath("."));
    $font = "Oswald-Regular";

    $text_box = imagettfbbox($font_size, 0, $font, $text);
    $text_width = $text_box[2]-$text_box[0];
    $text_height = $text_box[7]-$text_box[1];

    imagettftext($image, $font_size, 0, (500/2) - ($text_width/2), $y, $text_color, $font, $text);
  }

  if (!empty($_GET["query"]) && !empty($_GET["color"])) {
    $query = $_GET["query"];
    $color = $_GET["color"];

    header("Content-Type: image/png");
    $image = imagecreatetruecolor(500, 500); // width, height

    $background = hex2rgb($color);
    $background_color = imagecolorallocate($image, $background[0], $background[1], $background[2]);
    $text = getTextColor($color);
    $text_color = imagecolorallocate($image, $text[0], $text[1], $text[2]);

    imagefill($image, 0, 0, $background_color);

    putenv("GDFONTPATH=" . realpath("."));
    // Write the hex
    drawCentered($image, 70, 270, $color, $text_color);
    // Write the string
    drawCentered($image, 30, 320, $query, $text_color);
    imagepng($image);
    imagedestroy($image);
  } else {
    header("Content-Type: image/jpg");
    readfile("images/cover.jpg");
  }
?>