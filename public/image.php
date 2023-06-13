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
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}