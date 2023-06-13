<?php

declare(strict_types=1);

use Entity\Collection\PeopleCollection;
use Entity\Exception\EntityNotFoundException;
use Entity\Movie;
use Entity\People;
use Html\WebPage;

$movieId=0;
if (!empty($_GET["movieId"]) && ctype_digit($_GET["movieId"])) {
    $movieId = $_GET["movieId"];
} else {
    header('Location: index.php');
    die();
}

$html = new WebPage();

try {
    $roles = PeopleCollection::findByMovieId(intval($movieId));
    $movie = Movie::findById(intval($movieId));
} catch (EntityNotFoundException) {
    http_response_code(404);
    die();
}

$titre = 'Film - ' . $movie->getTitle();

$html->setTitle($titre);
$html->appendToHead("<meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>");
$html->appendContent("<header><h1>$titre</h1></header><main><div class='film'><img src='/image.php?imgId={$movie->getPosterId()}' alt=''>
    <div class='film-info'>
      <div class='prem-ligne'>
        <h1 class='titre'>{$movie->getTitle()}</h1>
        <h1>{$movie->getReleaseDate()}</h1>
      </div>
      <h2>{$movie->getOriginalTitle()}</h2>
      <h2>{$movie->getTagline()}</h2>
      <h2 class='resume'>{$movie->getOverview()}</h2>
    </div>
  </div>");
foreach ($roles as $role) {
    $ppl = People::findById($role->getPeopleId());
    $html->appendContent(
        <<<HTML
<a href='/people.php?pplId={$role->getPeopleId()}' class='acteur'>
    <img src='/image.php?imgId={$ppl->getAvatarId()}' alt=''>
    <div class='acteur-info'>
      <h1>{$role->getRole()}</h1>
      <h1>joué(e) par {$ppl->getName()}</h1>
    </div>
  </a>
HTML);
}

$html->appendCssUrl("/CSS/movie.css");
$html->appendContent("</main>
<footer>
  <p>Dernière modification : 13/06 14:17</p>
</footer>
</body>
</html>");

echo $html->toHTML();