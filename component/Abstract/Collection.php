<?php

declare(strict_types=1);

namespace Phant\DataStructure\Abstract;

/**
 * @template T
 */
abstract class Collection
{
    /**
     * @var array<T>
     */
    protected array $items = [];

    public function __construct(
    ) {
    }

    /**
     * @param T $item
     * @return static
     */
    protected function addItem(
        mixed $item
    ): static {
        if (array_search($item, $this->items) === false) {
            $this->items[] = $item;
        }

        return $this;
    }

    /**
     * @param T $item
     * @return static
     */
    protected function removeItem(
        mixed $item
    ): static {
        if (($key = array_search($item, $this->items)) !== false) {
            unset($this->items[ $key ]);
            $this->items = array_values($this->items);
        }

        return $this;
    }

    /**
     * @param T $item
     */
    final public function contains(
        mixed $item
    ): bool {
        return array_search($item, $this->items) !== false;
    }

    /**
     * @return \Generator<T>
     */
    final public function iterate(
    ): \Generator {
        foreach ($this->items as $item) {
            yield $item;
        }
    }

    final public function isEmpty(
    ): bool {
        return empty($this->items);
    }

    final public function getNbItems(
    ): int {
        return count($this->items);
    }

    /**
     * @return T|null
     */
    final public function getByKey(
        int $key
    ): mixed {
        return $this->items[ $key ] ?? null;
    }

    /**
     * @param Collection<T> $collection
     * @return static
     */
    final public function merge(
        self $collection
    ): static {
        foreach ($collection->items as $item) {
            $this->addItem($item);
        }

        return $this;
    }

    /**
     * @template U
     * @param callable(T): U $callback
     * @return array<U>
     */
    final public function map(
        callable $callback
    ): array {
        return array_map($callback, $this->items);
    }
}
