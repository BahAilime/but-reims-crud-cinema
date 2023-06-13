<?php
declare(strict_types=1);

namespace Entity;

use DateTime;

class Movie
{
    private int $id;
    private int $posterld;
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
    public function getPosterld(): int
    {
        return $this->posterld;
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
     * @return DateTime
     */
    public function getReleaseDate(): DateTime
    {
        return $this->releaseDate;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }


}