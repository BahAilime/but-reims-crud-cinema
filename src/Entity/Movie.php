<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use DateTime;
use Entity\Exception\EntityNotFoundException;

class Movie
{
    private int $id;
    private ?int $posterId;
    private string $originalLanguage;
    private string $originalTitle;
    private string $overview;
    private string $releaseDate;
    private int $runtime;
    private string $tagline;
    private string $title;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return ?int
     */
    public function getPosterId(): ?int
    {
        return $this->posterId;
    }

    /**
     * @return string
     */
    public function getOriginalLanguage(): string
    {
        return $this->originalLanguage;
    }

    /**
     * @return string
     */
    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }

    /**
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /**
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /**
     * @return int
     */
    public function getRuntime(): int
    {
        return $this->runtime;
    }

    /**
     * @return string
     */
    public function getTagline(): string
    {
        return $this->tagline;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    public static function findById(int $id): Movie
    {
        $sql = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM movie
            WHERE id = ?;
        SQL
        );

        $sql->execute([$id]);

        $movie = $sql->fetchObject(Movie::class);

        if (!$movie) {
            throw new EntityNotFoundException();
        }

        return $movie;
    }
}