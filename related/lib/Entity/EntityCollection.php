<?php

namespace Bitrix\Related\Entity;

use Countable;
use IteratorAggregate;
use ArrayIterator;

class EntityCollection implements Countable, IteratorAggregate
{
    private array $items = [];
    private int $totalCount = 0;

    public function add(EntityInterface $entity): void
    {
        $this->items[] = $entity;
    }

    public function toArray(): array
    {
        return array_map(static fn($item) => $item->toArray(), $this->items);
    }

    public function toGrid(): array
    {
        return array_map(static fn($item) => ['data' => $item->toArray()], $this->items);
    }

    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    public function setTotalCount(int $totalCount): void
    {
        $this->totalCount = $totalCount;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function all(): array
    {
        return $this->items;
    }
}