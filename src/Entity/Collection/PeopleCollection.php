<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Cast;
use Entity\Exception\EntityNotFoundException;
use Entity\People;

class PeopleCollection
{
    /**
     * @param int $movieId
     * @return Cast[]
     */
    public static function findByMovieId(int $movieId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
    SELECT p.id AS id, movieId, peopleId, role, orderIndex
    FROM people p
    JOIN cast c ON (c.peopleId = p.id)
    WHERE movieId = ?
    ORDER BY orderIndex
SQL
        );
        $stmt->execute([$movieId]);
        $ppl = $stmt->fetchAll(\PDO::FETCH_CLASS, Cast::class);
        if ($ppl) {
            return $ppl;
        } else {
            throw new EntityNotFoundException();
        }
    }

    /**
     * @param int $peopleId
     * @return Cast[]
     */
    public static function findByPeopleId(int $peopleId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
    SELECT p.id AS id, movieId, peopleId, role, orderIndex
    FROM people p
    JOIN cast c ON (c.peopleId = p.id)
    WHERE peopleId = ?
    ORDER BY orderIndex
SQL
        );
        $stmt->execute([$peopleId]);
        $ppl = $stmt->fetchAll(\PDO::FETCH_CLASS, Cast::class);
        if ($ppl) {
            return $ppl;
        } else {
            throw new EntityNotFoundException();
        }
    }
}
