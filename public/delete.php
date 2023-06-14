<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Movie;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = (int)$_GET['id'];

    try {
        $movie = Movie::findById($id);
        $movie->delete();
        echo 'Film supprimé';

        header('Location: edit.php');
        exit;
    } catch (EntityNotFoundException $e) {

        echo 'Film non trouvé';
    }
} else {
    echo 'Requête invalide';
}
