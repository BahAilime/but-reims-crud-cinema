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

    /**
     * Recherche un film par son identifiant.
     *
     * @param int $id L'identifiant du film à rechercher.
     * @return Movie Le film correspondant à l'identifiant spécifié.
     * @throws EntityNotFoundException Si aucun film n'est trouvé pour l'identifiant spécifié.
     */
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

    /**
     * Crée une instance de film avec les propriétés spécifiées.
     *
     * @param mixed|null $id
     * @param string|null $title
     * @param string|null $overview
     * @param string|null $tagline
     * @param string|null $originalLanguage
     * @param string|null $releaseDate
     * @param string|null $originalTitle
     * @param int|null $runtime
     * @return Movie Le film créé.
     */
    public static function create(mixed $id = null, string $title = null, string $overview = null, string $tagline = null, string $originalLanguage = null, string $releaseDate = null, string $originalTitle = null, int $runtime = null): Movie
    {
        $movie = new self();
        if ($id) {
            $movie->setId($id);
        }
        if ($title) {
            $movie->setTitle($title);
        }
        if ($overview) {
            $movie->setOverview($overview);
        }
        if ($tagline) {
            $movie->setTagline($tagline);
        }
        if ($originalLanguage) {
            $movie->setOriginalLanguage($originalLanguage);
        }
        if ($releaseDate) {
            $movie->setReleaseDate($releaseDate);
        }
        if ($originalTitle) {
            $movie->setOriginalTitle($originalTitle);
        }
        if ($runtime) {
            $movie->setRuntime($runtime);
        }
        return $movie;
    }

    /**
     * Supprime le film de la base de données.
     *
     * @return Movie Le film supprimé.
     */
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

    /**
     * Enregistre le film dans la base de données.
     *
     * @return Movie Le film enregistré.
     */
    public function save(): Movie
    {
        if (!is_null($this->getId())) {
            $this->update();
        } else {
            $this->insert();
        }

        return $this;
    }

    /**
     * Met à jour les informations du film dans la base de données.
     *
     * @return Movie Le film mis à jour.
     */
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
        if ($this->getReleaseDate()) {
            $rDate = DateTime::createFromFormat("Y-m-d", $this->getReleaseDate()) ? DateTime::createFromFormat("Y-m-d", $this->getReleaseDate()) : null;
        } else {
            $rDate = null;
        }
        $stmt->execute([$this->getTitle(), $this->getOverview(), $this->getTagline(), $this->getOriginalLanguage(), $rDate->format("Y-m-d"), $this->getOriginalTitle(), $this->getRuntime(), $this->getId()]);
        return $this;
    }

    /**
     * Insère le film dans la base de données.
     *
     * @return Movie Le film inséré.
     */
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
        if ($this->getReleaseDate()) {
            $rDate = DateTime::createFromFormat("Y-m-d", $this->getReleaseDate()) ? DateTime::createFromFormat("Y-m-d", $this->getReleaseDate()) : null;
        } else {
            $rDate = null;
        }
        $sql->execute([$this->getTitle(), $this->getOverview(), $this->getTagline(), $this->getOriginalLanguage(), $rDate->format("Y-m-d"), $this->getOriginalTitle(), $this->getRuntime()]);

        $lastInsertId = MyPDO::getInstance()->lastInsertId();
        $this->setId((int)$lastInsertId);

        return $this;
    }
}
