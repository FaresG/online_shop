<?php

namespace App\Interfaces;

use App\Models\User;

interface CartRepositoryInterface
{
    public function count(): int;
    public function amount(): float;
    public function getStripeItemList(): array;
}
