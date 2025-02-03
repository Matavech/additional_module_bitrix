<?php

namespace Bitrix\Related\Provider\Params\RelatedProduct;

use Bitrix\Related\Provider\Params\SelectInterface;

class RelatedProductSelect implements SelectInterface
{
    protected array $select;

    public function __construct(array $select = [])
    {
        $this->select = $select;
    }

    public function getDefaultSelect(): array
    {
        return ['ID', 'TITLE', 'PRICE', 'DEAL_ID', 'CREATED_AT'];
    }

    public function getAllowedFields(): array
    {
        return ['ID', 'TITLE', 'PRICE', 'DEAL_ID', 'CREATED_AT'];
    }

    public function prepareSelect(): array
    {
        if (empty($this->select))
        {
            return $this->getDefaultSelect();
        }

        return array_values(array_intersect($this->select, $this->getAllowedFields()));
    }
}
