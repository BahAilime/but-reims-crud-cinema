<?php

declare(strict_types=1);


use Entity\Collection\MovieCollection;
use Html\WebPage;

$html = new WebPage();

$html->appendToHead("<meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>");

$html->setTitle('Films');
$html->appendContent("<header><div></div><h1>Films</h1><nav><a href='edit.php'><img src='img/edit.png' alt='edit icon'></a></nav></header><main>");

if (!isset($_GET['genre']) || !ctype_digit($_GET['genre'])) {
    $movies = MovieCollection::findAll();
} else {
    $movies = MovieCollection::findByGenre($_GET['genre']);
}
foreach ($movies as $movie) {
    $html->appendContent("<a href='movie.php?movieId={$movie->getId()}' class='film'>
    <img src='/image.php?tpImg=poster&&imgId={$movie->getPosterId()}' alt='Poster ID'>
      <h2>{$movie->getTitle()}</h2>
  </a>");
}

$selectedGenre = $_GET['genre'] ?? null;

$genres = MovieCollection::getAllGenres();

$formHtml = "<form action='index.php' method='GET'>
    <select name='genre' onchange='this.form.submit()'>
        <option disabled hidden selected>Sélectionner un genre</option>
        <option value='sansFiltre'>Sans filtre</option>";

foreach ($genres as $genre) {
    $formHtml .= "<option value='{$genre['id']}'>{$genre['name']}</option>";
}

$formHtml .= "</select></form>";

$html->appendContent($formHtml);


$lastModif = $html->getLastModification();
$html->appendContent("</main>
<footer>
  <p>Dernière modification : {$html->escapeString($lastModif)}</p>
</footer>
</body>
</html>");

$html->appendCssUrl("/CSS/index.css");
echo $html->toHTML();
