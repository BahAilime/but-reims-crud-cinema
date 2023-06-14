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
     * Constructeur de la classe MovieForm
     *
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

    /**
     * Renvoie le formulaire HTML pour la modification d'un film.
     *
     * @param string $action L'URL de l'action du formulaire.
     * @return string Le code HTML du formulaire.
     */
    public function getHtmlForm(string $action): string
    {
        $movieTitle = $this->movie?->getTitle() ? $this->escapeString($this->movie?->getTitle()) : null;
        $movieOriginalTitle = $this->movie?->getOriginalTitle() ? $this->escapeString($this->movie?->getOriginalTitle()) : null;
        $movieOverview = $this->movie?->getOverview() ? $this->escapeString($this->movie?->getOverview()) : null;
        $movieLanguage = $this->movie?->getOriginalLanguage() ? $this->escapeString($this->movie?->getOriginalLanguage()) : null;
        $movieRuntime = (string)$this->movie?->getRuntime() ? $this->escapeString((string)$this->movie?->getRuntime()) : null;
        $movieTagline = $this->movie?->getTagline() ? $this->escapeString($this->movie?->getTagline()) : null;
        $movieReleaseDate = $this->movie?->getReleaseDate() ? $this->escapeString($this->movie?->getReleaseDate()) : null;

        return <<<HTML
        <form action="{$action}" method="post">
            <input type="hidden" name="id" value="{$this->escapeString((string)$this->movie?->getId())}">
            <div class="modif">
                <div class="island">
                    <label for="title">Titre</label>
                    <input type="text" name="title" value="{$movieTitle}" required>
                </div>
                <div class="island">
                    <label for="originalTitle">Titre original</label>
                    <input type="text" name="originalTitle" value="{$movieOriginalTitle}" required>
                </div>
                <div class="island">
                    <label for="overview">Résumé</label>
                    <textarea name="overview" cols="40" rows="5" required>{$movieOverview}</textarea>
                </div>
                <div class="island">
                    <label for="language">Langue</label>
                    <select name="language" required>
                        <option value="" selected disabled hidden>Langue ($movieLanguage)</option>
                        <option value="cn">Cn</option>
                        <option value="de">De</option>
                        <option value="en">En</option>
                        <option value="fr">Fr</option>
                        <option value="ja">Ja</option>
                        <option value="pt">Pt</option>
                        <option value="sv">Sv</option>
                        <option value="zh">Zh</option>
                    </select>
                </div>
                <div class="island">
                    <label for="runtime">Durée (en min)</label>
                    <input type="number" name="runtime" required value="{$movieRuntime}">
                </div>
                <div class="island">
                    <label for="tagline">Slogan</label>
                    <input type="text" name="tagline" value="{$movieTagline}" required>
                </div>
                <div class="island">
                    <label for="releaseDate">Date de sortie</label>
                    <input type="date" name="releaseDate" required value="{$movieReleaseDate}">
                </div>
            </div>
            <button type="submit">Valider</button>
        </form>
        HTML;
    }
}
