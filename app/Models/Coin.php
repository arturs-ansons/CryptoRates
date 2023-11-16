<?php

declare(strict_types=1);

namespace App\Models;

class Coin
{
    private int $id;
    private string $name;
    private ?float $priceUSD;

    public function __construct(int $id, string $name, ?float $priceUSD)

    {
        $this->id = $id;
        $this->name = $name;
        $this->priceUSD = $priceUSD;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPriceUSD(): string
    {
        $rawPrice = $this->priceUSD;

        return number_format($rawPrice, 2);
    }
}
