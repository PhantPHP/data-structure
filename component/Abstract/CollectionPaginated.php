<?php

declare(strict_types=1);

namespace Phant\DataStructure\Abstract;

abstract class CollectionPaginated extends Collection
{
    private ?int $itemPage;
    private ?int $pageTotal;

    public function __construct(
        protected readonly ?int $pageCurrent = null,
        protected readonly ?int $itemByPage = null,
        protected readonly ?int $itemTotal = null
    ) {
        $this->itemPage = null;
        $this->pageTotal = null;

        parent::__construct();
    }

    public function getItemByPage(
    ): ?int {
        return $this->itemByPage;
    }

    public function getItemTotal(
    ): ?int {
        return $this->itemTotal;
    }

    public function getItemPage(
    ): ?int {
        return $this->itemPage;
    }

    public function getPageCurrent(
    ): ?int {
        return $this->pageCurrent;
    }

    public function getPageTotal(
    ): ?int {
        return $this->pageTotal;
    }

    protected function addItem(
        mixed $item
    ): static {
        parent::addItem($item);

        $this->paginationCalculation();

        return $this;
    }

    protected function removeItem(
        mixed $item
    ): static {
        parent::removeItem($item);

        $this->paginationCalculation();

        return $this;
    }

    protected function paginationCalculation(
    ): void {
        $this->itemPageCalculation();
        $this->pageTotalCalculation();
    }

    private function itemPageCalculation(
    ): void {
        $this->itemPage = $this->getNbItems();
    }

    private function pageTotalCalculation(
    ): void {
        $this->pageTotal = 0;

        if ($this->itemTotal && $this->itemByPage) {
            $this->pageTotal = (int)ceil($this->itemTotal / $this->itemByPage);
        }
    }
}
