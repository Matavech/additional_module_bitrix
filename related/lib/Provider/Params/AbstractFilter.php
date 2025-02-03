<?php

namespace Bitrix\Related\Provider\Params;

use Bitrix\Main\ORM\Query\Query;

abstract class AbstractFilter implements FilterInterface
{
    public function prepareQuery(Query $query): void
    {}
}