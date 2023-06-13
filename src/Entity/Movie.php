<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use DateTime;
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
     * @param int|null $id
     * @param int|null $posterId
     * @param string $originalLanguage
     * @param string $originalTitle
     * @param string $overview
     * @param string $releaseDate
     * @param int $runtime
     * @param string $tagline
     * @param string $title
     */
    private function __construct(?int $id=null, ?int $posterId=null, ?string $originalLanguage=null, ?string $originalTitle=null, ?string $overview=null, ?string $releaseDate=null, ?int $runtime=null, ?string $tagline=null, ?string $title=null)
    {
        $this->id = $id;
        $this->posterId = $posterId;
        $this->originalLanguage = $originalLanguage;
        $this->originalTitle = $originalTitle;
        $this->overview = $overview;
        $this->releaseDate = $releaseDate;
        $this->runtime = $runtime;
        $this->tagline = $tagline;
        $this->title = $title;
    }

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


    /**
     * @param int $id
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


    public static function create($title, $id = null): Movie
    {
        $movie = new self();
        $movie->setTitle($title);
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
        SET title = ?
        WHERE id = ?
        SQL
        );
        $stmt->execute([$this->getTitle(), $this->getId()]);

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

        $sql->execute([$this->getTitle()]);

        $lastInsertId = MyPDO::getInstance()->lastInsertId();
        $this->setId((int)$lastInsertId);

        return $this;
    }
}
