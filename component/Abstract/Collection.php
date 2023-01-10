<?php

declare(strict_types=1);

namespace Phant\DataStructure\Abstract;

abstract class Collection
{
    protected array $items;

    public function __construct()
    {
        $this->items = [];
    }

    protected function addItem(mixed $item): self
    {
        if (array_search($item, $this->items) == false) {
            $this->items[] = $item;
        }

        return $this;
    }

    protected function removeItem(mixed $item): self
    {
        if (($key = array_search($item, $this->items)) !== false) {
            unset($this->items[ $key ]);
            $this->items = array_values($this->items);
        }

        return $this;
    }

    protected function containsItem(mixed $item): bool
    {
        return array_search($item, $this->items) !== false;
    }

    public function itemsIterator(): \Generator
    {
        foreach ($this->items as $item) {
            yield $item;
        }
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function getNbItems(): int
    {
        return count($this->items);
    }

    public function getByKey(int $key): mixed
    {
        return $this->items[ $key ] ?? null;
    }
}
