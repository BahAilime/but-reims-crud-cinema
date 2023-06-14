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
      <select name="movieId" onchange="this.form.submit()">
        <option value="" disabled hidden selected>Film</option>
        <option value="NEW">NOUVEAU</option>
        {$options}
      </select>
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
<div class="delete">
    <a href="/delete.php?id=$id" >Supprimer</a>
</div>
HTML;
}




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['id'] == "") {
        $movie = Movie::create();
        $movie->setId(null);
        if (isset($_POST['title']) && $_POST['title'] != "") {
            $movie->setTitle($_POST['title']);
        }
        if (isset($_POST['originalTitle']) && $_POST['originalTitle'] != "") {
            $movie->setOriginalTitle($_POST['originalTitle']);
        }
        if (isset($_POST['overview']) && $_POST['overview'] != "") {
            $movie->setOverview($_POST['overview']);
        }
        if (isset($_POST['language']) && $_POST['language'] != "") {
            $movie->setOriginalLanguage($_POST['language']);
        }
        if (isset($_POST['runtime']) && $_POST['runtime'] != "") {
            $movie->setRuntime((int)$_POST['runtime']);
        }
        if (isset($_POST['tagline']) && $_POST['tagline'] != "") {
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
$html->appendContent("<header><div></div><h1>Édit</h1><nav><a href='index.php'><img src='img/home.png' alt='edit icon'></a></nav></header><main>");
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
