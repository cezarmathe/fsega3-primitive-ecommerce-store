<?php

namespace ECommerce\App\Entity;

// Entity defines the base class for all entities.
interface Entity {
    // Returns the column names of the entity.
    public static function columns(string $qualifier = ''): array;

    // Create this entity from an array.
    public static function fromArray(array $row, string $qualifier = ''): self;

    // Create an array from this entity.
    public function toArray(): array;
}
