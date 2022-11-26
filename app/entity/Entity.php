<?php

namespace ECommerce\App\Entity;

// Entity defines the base class for all entities.
interface Entity {
    // Create this entity from an array.
    public static function fromArray(array $row, string $qualifier = ''): self;
    // Create an array from this entity.
    public function toArray(): array;
}
