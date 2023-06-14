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
     * Recherche tous les membres du casting d'un film spécifié par son identifiant.
     *
     * @param int $movieId L'identifiant du film.
     * @return Cast[] Un tableau contenant tous les membres du casting du film.
     * @throws EntityNotFoundException Si aucun membre du casting n'est trouvé pour le film spécifié.
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
     * Recherche tous les films dans lesquels un membre du casting est impliqué, spécifié par son identifiant.
     *
     * @param int $peopleId L'identifiant du membre du casting.
     * @return Cast[] Un tableau contenant tous les films dans lesquels le membre du casting est impliqué.
     * @throws EntityNotFoundException Si aucun film n'est trouvé pour le membre du casting spécifié.
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
