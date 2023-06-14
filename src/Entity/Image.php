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
     * @param int $id
     * @throws EntityNotFoundException
     * @return self
     */
    public static function findById(int $id): self
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
