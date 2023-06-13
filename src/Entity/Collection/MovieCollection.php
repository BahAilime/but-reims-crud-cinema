<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Movie;
use PDO;

class MovieCollection
{

    /**
     * @return Movie[]
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
