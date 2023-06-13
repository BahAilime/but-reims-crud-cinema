<?php

declare(strict_types=1);

use Entity\Collection\PeopleCollection;
use Entity\Exception\EntityNotFoundException;
use Entity\Movie;
use Entity\People;
use Html\WebPage;

$actorId=0;
if (!empty($_GET["actorId"]) && ctype_digit($_GET["actorId"])) {
    $actorId = $_GET["actorId"];
} else {
    header('Location: index.php');
    die();
}

$html = new WebPage();

try {
    $roles = PeopleCollection::findByPeopleId(intval($actorId));
    $actor = People::findById(intval($actorId));
} catch (EntityNotFoundException) {
    http_response_code(404);
    die();
}

$titre = 'Films - ' . $actor->getName();

$html->setTitle($titre);
$html->appendToHead("<meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>");
$html->appendContent("<header>
        <h1>$titre</h1>
      </header>
      <main>
        <div class='acteur'>
            <img src='/image.php?imgId={$actor->getAvatarId()}' alt=''>
            <div class='acteur-info'>
                <h1>{$actor->getName()}</h1>
                <h2>{$actor->getPlaceOfBirth()}</h2>
                <div class='troisieme-ligne'>
                  <h2>{$actor->getBirthday()}</h2>
                  <h2>-</h2>
                  <h2>{$actor->getDeathday()}</h2>
                </div>
              <h2 class='biographie'>{$actor->getBiography()}</h2>
            </div>
        </div>");
foreach ($roles as $role) {
    $movie = Movie::findById($role->getMovieId());
    $html->appendContent(
        <<<HTML
<a href='/movie.php?movieId={$role->getMovieId()}' class='film'>
    <img src='/image.php?imgId={$movie->getPosterId()}' alt=''>
    <div class='film-info'>
      <div class='prem-ligne'>
        <h1 class='titre'>{$movie->getTitle()}</h1>
        <h1>{$movie->getReleaseDate()}</h1>
      </div>
      <h1>{$role->getRole()}</h1>
    </div>
  </a>
HTML);
}

$html->appendCssUrl("/CSS/actor.css");
$lastModif = $html->getLastModification();
$html->appendContent("</main>
        <footer>
          <p>Dernière modification : {$html->escapeString($lastModif)}</p>
        </footer>
    </body>
</html>");

echo $html->toHTML();
