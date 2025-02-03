<?php

namespace Bitrix\Related\Provider\Params\RelatedProduct;

use Bitrix\Related\Provider\Params\AbstractSort;

class RelatedProductSort extends AbstractSort
{
    protected function getAllowedFields(): array
    {
        return ['ID', 'PRICE', 'DEAL_ID'];
    }

    public function getSort(): array
    {
        $sort = [];
        if (isset($this->sort['ID']))
        {
            $sort['ID'] = $this->sort['ID'];
        }

        if (isset($this->sort['PRICE']))
        {
            $sort['PRICE'] = $this->sort['PRICE'];
        }

        if (isset($this->sort['DEAL_ID']))
        {
            $sort['DEAL_ID'] = $this->sort['DEAL_ID'];
        }

        return $sort;
    }
}
