<?php

namespace Bitrix\Related\Provider\Params;

use Bitrix\Main\Entity\Query\Filter\ConditionTree;
use Bitrix\Main\ORM\Query\Query;

interface FilterInterface
{
    public function prepareFilter(): ConditionTree;
    public function prepareQuery(Query $query): void;
}
