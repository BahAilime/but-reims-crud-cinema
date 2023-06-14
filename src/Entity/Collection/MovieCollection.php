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

    /**
     * Recherche les films par genre.
     *
     * @param string $genre Le genre des films à rechercher.
     * @return Movie[] Un tableau contenant les films correspondants au genre.
     */
    public static function findByGenre(string $genre): array
    {
        $sql = MyPDO::getInstance()->prepare(
            <<<'SQL'
        SELECT *
        FROM movie m
        JOIN movie_genre g ON (g.movieId = m.id)
        WHERE genreId = ?;
        SQL
        );

        $sql->execute([$genre]);

        return $sql->fetchAll(PDO::FETCH_CLASS, Movie::class);
    }

    /**
     * Renvoie un tableau de tout les noms des genres
     *
     * @return bool|array Un tableau contenant le nom des genres.
     */
    public static function getAllGenres(): bool|array
    {
        $sql = MyPDO::getInstance()->prepare(
            <<<'SQL'
        SELECT id, name
        FROM genre;
    SQL
        );

        $sql->execute();

        return $sql->fetchAll();
    }

}
