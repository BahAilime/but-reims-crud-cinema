<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class People
{
    private int $id;
    private ?int $avatarId;
    private ?string $birthday;
    private ?string $deathday;
    private string $name;
    private string $biography;
    private string $placeOfBirth;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    /**
     * @return ?int
     */
    public function getAvatarId(): ?int
    {
        return $this->avatarId;
    }
    /**
     * @return ?string
     */
    public function getBirthday(): ?string
    {
        return $this->birthday;
    }
    /**
     * @return ?string
     */
    public function getDeathday(): ?string
    {
        return $this->deathday;
    }
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * @return string
     */
    public function getBiography(): string
    {
        return $this->biography;
    }
    /**
     * @return string
     */
    public function getPlaceOfBirth(): string
    {
        return $this->placeOfBirth;
    }

    /**
     * Recherche une personne par son identifiant.
     *
     * @param int $id L'identifiant de la personne à rechercher.
     * @return People La personne correspondant à l'identifiant.
     * @throws EntityNotFoundException Si aucune personne correspondante n'est trouvée.
     */
    public static function findById(int $id): People
    {
        $sql = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM people
            WHERE id = ?;
        SQL
        );

        $sql->execute([$id]);

        $people = $sql->fetchObject(People::class);

        if (!$people) {
            throw new EntityNotFoundException();
        }

        return $people;
    }
}
