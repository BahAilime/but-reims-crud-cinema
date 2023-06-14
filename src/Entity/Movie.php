<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Movie
{
    private ?int $id;
    private ?int $posterId;
    private string $originalLanguage;
    private string $originalTitle;
    private string $overview;
    private string $releaseDate;
    private int $runtime;
    private string $tagline;
    private string $title;

    /**
     * Constructeur privé
     */
    private function __construct()
    {
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
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


    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $originalLanguage
     */
    public function setOriginalLanguage(string $originalLanguage): void
    {
        $this->originalLanguage = $originalLanguage;
    }

    /**
     * @param string $originalTitle
     */
    public function setOriginalTitle(string $originalTitle): void
    {
        $this->originalTitle = $originalTitle;
    }

    /**
     * @param string $overview
     */
    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    /**
     * @param string $releaseDate
     */
    public function setReleaseDate(string $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @param int $runtime
     */
    public function setRuntime(int $runtime): void
    {
        $this->runtime = $runtime;
    }

    /**
     * @param string $tagline
     */
    public function setTagline(string $tagline): void
    {
        $this->tagline = $tagline;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
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

    public static function create($id = null, $title = null, $overview = null, $tagline = null, $originalLanguage = null, $releaseDate = null, $originalTitle = null, $runtime = null): Movie
    {
        $movie = new self();
        $movie->setTitle($title);
        $movie->setOverview($overview);
        $movie->setTagline($tagline);
        $movie->setOriginalLanguage($originalLanguage);
        $movie->setReleaseDate($releaseDate);
        $movie->setOriginalTitle($originalTitle);
        $movie->setRuntime($runtime);
        if ($id) {
            $movie->setId($id);
        }
        return $movie;
    }

    public function delete(): Movie
    {
        if ($this->id !== null) {
            $stmt = MyPdo::getInstance()->prepare(
                <<<'SQL'
    DELETE FROM movie
    WHERE id = ?
    SQL
            );
            $stmt->execute([$this->getId()]);
        }

        $this->id = null;
        return $this;
    }

    public function save(): Movie
    {
        if (!is_null($this->getId())) {
            $this->update();
        } else {
            $this->insert();
        }

        return $this;
    }

    protected function update(): Movie
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
        UPDATE movie
        SET title = ?,
            overview = ?,
            tagline = ?,
            originalLanguage = ?,
            releaseDate = ?,
            originalTitle = ?,
            runtime = ?
        WHERE id = ?
        SQL
        );
        $stmt->execute([$this->getTitle(), $this->getOverview(), $this->getTagline(), $this->getOriginalLanguage(), $this->getReleaseDate(), $this->getOriginalTitle(), $this->getRuntime(), $this->getId()]);
        return $this;
    }

    protected function insert(): Movie
    {
        $sql = MyPDO::getInstance()->prepare(
            <<<'SQL'
        INSERT INTO movie (title,
                           overview,
                           tagline,
                           originalLanguage,
                           releaseDate,
                           originalTitle,
                           runtime)
        VALUES (?, ?, ?, ?, ?, ?, ?);
        SQL
        );

        $sql->execute([$this->getTitle(), $this->getOverview(), $this->getTagline(), $this->getOriginalLanguage(), $this->getReleaseDate(), $this->getOriginalTitle(), $this->getRuntime()]);

        $lastInsertId = MyPDO::getInstance()->lastInsertId();
        $this->setId((int)$lastInsertId);

        return $this;
    }
}
