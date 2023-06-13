<?php
declare(strict_types=1);


use Entity\Collection\MovieCollection;
use Html\WebPage;

$html = new WebPage();

$html->appendToHead("<meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>");

$html->setTitle('Artistes');
$html->appendContent("<header><h1>Films</h1></header><main>");

$movies = MovieCollection::findAll();
foreach ($movies as $movie) {
//    TODO: remettre {$movie->getId()} dans le href quand movie.php sera fait
    $html->appendContent("<a href='movie.php?movieId=' class='film'>
    <img src='https://picsum.photos/240/360' alt=''>
      <h2>{$movie->getTitle()}</h2>
  </a>");
}


$html->appendContent("</main>
<footer>
  <p>Dernière modification : 11/06/2023 11:15</p>
</footer>
</body>
</html>");

$html->appendCssUrl("/CSS/index.css");
echo $html->toHTML();
