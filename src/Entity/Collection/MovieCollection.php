<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Movie;
use PDO;

class MovieCollection
{
    /**
     * Récupère tous les films de la base de données.
     *
     * @return Movie[] Un tableau contenant tous les films.
     */
    public static function findAll(): array
    {
        $sql = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM movie;
        SQL
        );

        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_CLASS, Movie::class);
    }
}
