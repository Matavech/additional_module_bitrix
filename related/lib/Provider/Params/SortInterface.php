<?php

namespace Bitrix\Related\Provider\Params;

interface SortInterface
{
    public function prepareSort(): array;
}