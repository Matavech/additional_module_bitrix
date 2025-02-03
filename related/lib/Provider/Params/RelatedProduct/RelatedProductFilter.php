<?php

namespace Bitrix\Related\Provider\Params\RelatedProduct;

use Bitrix\Main\Entity\Query\Filter\ConditionTree;
use Bitrix\Related\Provider\Params\AbstractFilter;

class RelatedProductFilter extends AbstractFilter
{
    public function __construct(private array $filter)
    {}

    public static function getSourceList(): array
    {
        return [
            ['id' => 'ID', 'name' => 'ID', 'type' => 'number'],
            ['id' => 'TITLE', 'name' => 'Title', 'type' => 'string'],
            ['id' => 'PRICE', 'name' => 'Price', 'type' => 'number'],
            ['id' => 'DEAL_ID', 'name' => 'Deal ID', 'type' => 'number'],
        ];
    }

    public function prepareFilter(): ConditionTree
    {
        $conditionTree = new ConditionTree();

        if (isset($this->filter['ID']))
        {
            if (is_array($this->filter['ID']))
            {
                $conditionTree->whereIn('ID', array_map('intval', $this->filter['ID']));
            }
            else
            {
                $conditionTree->where('ID', '=', (int)$this->filter['ID']);
            }
        }

        if (isset($this->filter['!ID']))
        {
            if (is_array($this->filter['!ID']))
            {
                $conditionTree->whereNotIn('ID', array_map('intval', $this->filter['!ID']));
            }
            else
            {
                $conditionTree->where('ID', '!=', (int)$this->filter['!ID']);
            }
        }

        if (isset($this->filter['>ID']))
        {
            $conditionTree->where('ID', '>', (int)$this->filter['>ID']);
        }

        if (isset($this->filter['<ID']))
        {
            $conditionTree->where('ID', '<', (int)$this->filter['<ID']);
        }

        if (isset($this->filter['TITLE']))
        {
            $conditionTree->where('TITLE', '=', (string)$this->filter['TITLE']);
        }

        if (isset($this->filter['TITLE%']))
        {
            $conditionTree->whereLike('TITLE', $this->filter['TITLE%'] . '%');
        }

        if (isset($this->filter['DEAL_ID']))
        {
            if (is_array($this->filter['DEAL_ID']))
            {
                $conditionTree->whereIn('DEAL_ID', array_map('intval', $this->filter['DEAL_ID']));
            }
            else
            {
                $conditionTree->where('DEAL_ID', '=', (int)$this->filter['DEAL_ID']);
            }
        }

        if (isset($this->filter['=PRICE']))
        {
            $conditionTree->where('PRICE', '=', (int)$this->filter['PRICE']);
        }

        if (isset($this->filter['>PRICE']))
        {
            $conditionTree->where('PRICE', '>', (int)$this->filter['>PRICE']);
        }

        if (isset($this->filter['<PRICE']))
        {
            $conditionTree->where('PRICE', '<', (int)$this->filter['<PRICE']);
        }

        return $conditionTree;
    }
}
