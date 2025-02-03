<?php

namespace Bitrix\Related\Internals\Repository\Mapper;

use Bitrix\Related\Entity\RelatedProduct;
use Bitrix\Main\Type\DateTime;
use Bitrix\Related\Internals\Model\EO_RelatedProduct;
use Bitrix\Related\Internals\Model\RelatedProductTable;

class RelatedProductMapper
{
    public function convertFromOrm(EO_RelatedProduct $ormModel): RelatedProduct
    {
        $product = new RelatedProduct(
            $ormModel->getDealId(),
            $ormModel->getTitle(),
            (float)$ormModel->getPrice()
        );

        $product
            ->setId($ormModel->getId())
            ->setCreatedAt(new DateTime($ormModel->getCreatedAt()))
        ;

        return $product;
    }

    public function convertToOrm(RelatedProduct $entity): EO_RelatedProduct
    {
        $ormModel = $entity->getId()
            ? EO_RelatedProduct::wakeUp($entity->getId())
            : RelatedProductTable::createObject()
        ;

        $ormModel
            ->setDealId($entity->getDealId())
            ->setTitle($entity->getTitle())
            ->setPrice($entity->getPrice())
            ->setCreatedAt(new DateTime($entity->getCreatedAt()->format('Y-m-d H:i:s')))
        ;

        return $ormModel;
    }
}
