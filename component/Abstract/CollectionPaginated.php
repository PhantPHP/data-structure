<?php
declare(strict_types=1);

namespace Phant\DataStructure\Abstract;

abstract class CollectionPaginated extends Collection
{
	private int $itemPage;
	private int $itemByPage;
	private int $itemTotal;
	
	private int $pageCurrent;
	private int $pageTotal;
	
	public function __construct(
		int $pageCurrent,
		int $itemByPage,
		int $itemTotal
	)
	{
		$this->itemByPage = $itemByPage;
		$this->itemTotal = $itemTotal;
		$this->itemPage = 0;
		
		$this->pageCurrent = $pageCurrent;
		$this->pageTotal = 0;
		
		parent::__construct();
	}

	protected function addItem(mixed $item): self
	{
		parent::addItem($item);
		
		$this->paginationCalculation();
		
		return $this;
	}

	protected function removeItem(mixed $item): self
	{
		parent::removeItem($item);
		
		$this->paginationCalculation();
		
		return $this;
	}
	
	protected function paginationCalculation(): void
	{
		$this->itemPageCalculation();
		$this->pageTotalCalculation();
	}
	
	private function itemPageCalculation(): void
	{
		$this->itemPage = $this->getNbItems();
	}
	
	private function pageTotalCalculation(): void
	{
		$this->pageTotal = 0;
		
		if ($this->itemTotal && $this->itemByPage) {
			$this->pageTotal = (int)ceil($this->itemTotal / $this->itemByPage);
		}
	}

	public function serialize(): ?array
	{
		return [
			'items'	=> parent::serialize(),
			'pagination' => [
				'item' => [
					'page'		=> $this->itemPage,
					'by_page'	=> $this->itemByPage,
					'total'		=> $this->itemTotal,
				],
				'page' => [
					'current'	=> $this->pageCurrent,
					'total'		=> $this->pageTotal,
				],
			]
		];
	}
	
	public static function unserialize(array $serialized): self
	{
		$collection = new static(
			$serialized['pagination']['page']['current'],
			$serialized['pagination']['item']['by_page'],
			$serialized['pagination']['item']['total']
		);
		
		foreach ($serialized['items'] as $item) {
			$collection->addValue(
				static::unserializeItem($item)
			);
		}
		
		return $collection;
	}
}
