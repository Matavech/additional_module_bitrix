<?php

namespace Bitrix\Related\Provider;

use Bitrix\Related\Entity\EntityCollection;
use Bitrix\Related\Provider\Params\GridParams;
use Bitrix\Related\Internals\Repository\RelatedProductRepository;

class RelatedProductProvider
{
    private RelatedProductRepository $repository;
    public function __construct()
    {
        $this->repository = new RelatedProductRepository();
    }

    public function getList(GridParams $params, bool $countTotal = false): EntityCollection
    {
        return $this->repository->getList(
            limit: $params->limit,
            offset: $params->offset,
            filter: $params->getFilter(),
            sort: $params->getSort(),
            select: $params->getSelect(),
            countTotal: $countTotal,
        );
    }
}