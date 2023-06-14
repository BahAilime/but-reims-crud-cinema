<?php

declare(strict_types=1);

use Entity\Image;
use Entity\Exception\EntityNotFoundException;
use Exception\ParameterException;

try {
    if (!empty($_GET["imgId"]) && ctype_digit($_GET["imgId"])) {
        $id = $_GET["imgId"];
    } else {
        throw new ParameterException();
    }
    $cover = Image::findById((int)$id);
    header('Content-Type: image/jpeg');
    echo $cover->getJpeg();

} catch (Exception) {
    header('Content-Type: image/png');
    if (!empty($_GET["tpImg"]) && $_GET["tpImg"] == 'poster') {
        $imageData = readfile("img/notFound.png");
    } else {
        $imageData = readfile("img/actor.png");
    }
    echo $imageData;
}
