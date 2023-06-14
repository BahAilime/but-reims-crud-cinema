<?php

declare(strict_types=1);

namespace Entity;

class Cast
{
    private int $Id;
    private int $movieId;
    private int $peopleId;
    private string $role;
    private int $orderIndex;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->Id;
    }

    /**
     * @return int
     */
    public function getMovieId(): int
    {
        return $this->movieId;
    }

    /**
     * @return int
     */
    public function getPeopleId(): int
    {
        return $this->peopleId;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return int
     */
    public function getOrderIndex(): int
    {
        return $this->orderIndex;
    }


}
