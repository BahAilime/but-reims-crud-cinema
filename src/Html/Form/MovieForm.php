<?php

declare(strict_types=1);

namespace Html\Form;

use Entity\Movie;
use Html\StringEscaper;

class MovieForm
{
    use StringEscaper;
    private ?Movie $movie;

    /**
     * @param Movie|null $movie
     */
    public function __construct(?Movie $movie = null)
    {
        $this->movie = $movie;
    }

    /**
     * @return Movie|null
     */
    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function getHtmlForm(string $action): string
    {
        $movieTitle = $this->escapeString($this->movie?->getTitle());
        $movieOriginalTitle = $this->escapeString($this->movie?->getOriginalTitle());
        $movieOverview = $this->escapeString($this->movie?->getOverview());
        $movieLanguage = $this->escapeString($this->movie?->getOriginalLanguage());
        $movieRuntime = $this->escapeString((string)$this->movie?->getRuntime());
        $movieTagline = $this->escapeString($this->movie?->getTagline());

        return <<<HTML
        <form action="{$action}" method="post">
            <input type="hidden" name="id" value="{$this->escapeString((string)$this->movie?->getId())}">
            <div class="modif">
                <div class="island">
                    <label for="title">Titre</label>
                    <input type="text" name="title" value="{$movieTitle}">
                </div>
                <div class="island">
                    <label for="originalTitle">Titre original</label>
                    <input type="text" name="originalTitle" value="{$movieOriginalTitle}">
                </div>
                <div class="island">
                    <label for="overview">Résumé</label>
                    <textarea name="overview" cols="40" rows="5">{$movieOverview}</textarea>
                </div>
                <div class="island">
                    <label for="language">Langue</label>
                    <select name="language">
                        <option value="">Fr</option>
                        <option value="1">En</option>
                        <option value="2">Jp</option>
                        <option value="3">De</option>
                    </select>
                </div>
                <div class="island">
                    <label for="runtime">Durée (en min)</label>
                    <input type="number" name="runtime" value="{$movieRuntime}">
                </div>
                <div class="island">
                    <label for="tagline">Slogan</label>
                    <input type="text" name="tagline" value="{$movieTagline}">
                </div>
            </div>
            <button type="submit">Valider</button>
        </form>
        HTML;
    }
}
