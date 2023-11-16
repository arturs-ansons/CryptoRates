<?php

declare(strict_types=1);

namespace App\Models;

class CoinCollection
{
    private array $coinCollection =[];

    public function add(Coin $coin): void
    {
        $id = $coin->getId();

        if (!isset($this->coinCollection[$id])) {
            $this->coinCollection[$id] = $coin;
        }
    }

    public function getCoinCollection(): array
    {
        return $this->coinCollection;
    }
}
