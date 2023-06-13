<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\People;

class PeopleCollection
{
    public static function findByMovieId(int $movieId): array|bool
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
    SELECT *
    FROM people p
    JOIN cast c ON (c.peopleId = p.id)
    WHERE movieId = ?
SQL
        );
        $stmt->execute([$movieId]);
        return $stmt->fetchAll(\PDO::FETCH_CLASS, People::class);
    }
}
