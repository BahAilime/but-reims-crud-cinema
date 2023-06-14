<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

/**
 *
 */
class Image
{
    private int $id;
    private string $jpeg;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    /**
     * Recherche une image par son identifiant.
     *
     * @param int $id L'identifiant de l'image à rechercher.
     * @return Image L'image correspondant à l'identifiant.
     * @throws EntityNotFoundException Si aucune image correspondante n'est trouvée.
     */
    public static function findById(int $id): Image
    {
        $sql = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM image
            WHERE id = ?;
        SQL
        );

        $sql->execute([$id]);

        $line = $sql->fetchObject(Image::class);

        if (!$line) {
            throw new EntityNotFoundException();
        }

        return $line;
    }
}
