<?php

declare(strict_types=1);

use Entity\Collection\MovieCollection;
use Entity\Movie;
use Html\WebPage;
use Html\Form\MovieForm;

function selection(): string
{

    $options = "";
    foreach (MovieCollection::findAll() as $movie) {
        $options .= "<option value='{$movie->getId()}'>{$movie->getTitle()}</option>";
    }

    return <<<HTML
        <form action="/edit.php">
      <select name="movieId">
        <option value="NEW">NOUVEAU</option>
        {$options}
      </select>
      <button type="submit">Selectionner</button>
    </form>
    HTML;
}

function edit(int $id): string
{
    $movie = Movie::findById($id);
    $form = new MovieForm($movie);
    return $form->getHtmlForm("/edit.php");
}

function add(): string
{
    $form = new MovieForm();
    return $form->getHtmlForm("/edit.php");
}

function delete(int $id): string
{
    return <<<HTML
<form>
    <input type="hidden" name="id" value="$id">
    <button type="submit" id="del">Supprimer</button>
</form>
HTML;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && $_POST['id'] === "NEW") {
        $movie = Movie::create();
        if (isset($_POST['title'])) {
            $movie->setTitle($_POST['title']);
        }
        if (isset($_POST['originalTitle'])) {
            $movie->setOriginalTitle($_POST['originalTitle']);
        }
        if (isset($_POST['overview'])) {
            $movie->setOverview($_POST['overview']);
        }
        if (isset($_POST['language'])) {
            $movie->setOriginalLanguage($_POST['language']);
        }
        if (isset($_POST['runtime'])) {
            $movie->setRuntime((int)$_POST['runtime']);
        }
        if (isset($_POST['tagline'])) {
            $movie->setTagline($_POST['tagline']);
        }
        $movie->save();

        header("Location: edit.php?movieId={$movie->getId()}");
        exit;
    } elseif (isset($_POST['id']) && ctype_digit($_POST['id'])) {
        $id = (int)$_POST['id'];
        $movie = Movie::findById($id);

        $movie->setTitle($_POST['title']);
        $movie->setOriginalTitle($_POST['originalTitle']);
        $movie->setOverview($_POST['overview']);
        $movie->setOriginalLanguage($_POST['language']);
        $movie->setRuntime((int)$_POST['runtime']);
        $movie->setTagline($_POST['tagline']);

        $movie->save();

        header("Location: edit.php?movieId={$movie->getId()}");
        exit;
    } elseif (isset($_POST['id']) && $_POST['id'] === "DELETE") {
        header("Location: edit.php");
        exit;
    }
}

$html = new WebPage();

$html->appendToHead("<meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>");
$html->setTitle('Édit');
$html->appendContent("<header><h1>Édit</h1></header><main>");
$html->appendContent(selection());

if (!empty($_GET["movieId"]) && ctype_digit($_GET["movieId"])) {
    if ((int)$_GET["movieId"] >= 0) {
        $html->appendContent(edit((int)$_GET["movieId"]));
        $html->appendContent(delete((int)$_GET["movieId"]));
    }
} elseif (!empty($_GET["movieId"]) && $_GET["movieId"] === "NEW") {
    $html->appendContent(add());
}

$lastModif = $html->getLastModification();
$html->appendContent("</main>
        <footer>
          <p>Dernière modification : {$html->escapeString($lastModif)}</p>
        </footer>
    </body>
</html>");

$html->appendCssUrl("/CSS/edit.css");
echo $html->toHTML();
