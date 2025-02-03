<?php

namespace Bitrix\Related\Internals\Repository;

use Bitrix\Main\DB\Exception;
use Bitrix\Main\ORM\Query\Filter\ConditionTree;
use Bitrix\Related\Entity\EntityCollection;
use Bitrix\Related\Internals\Repository\Mapper\RelatedProductMapper;
use Bitrix\Related\Internals\Model\RelatedProductTable;
use Bitrix\Related\Entity\RelatedProduct;

class RelatedProductRepository
{
    private RelatedProductMapper $mapper;
    public function __construct()
    {
        $this->mapper = new RelatedProductMapper();
    }

    public function getById(int|string $id): ?RelatedProduct
    {
        $ormModel = RelatedProductTable::getById($id)->fetchObject();

        return $ormModel ? $this->mapper->convertFromOrm($ormModel) : null;
    }

    public function getList(
        int $limit = 0,
        int $offset = 0,
        ?ConditionTree $filter = null,
        ?array $sort = null,
        ?array $select = null,
        bool $countTotal = false
    ): EntityCollection
    {
        $query = RelatedProductTable::query();

        if ($filter)
        {
            $query->where($filter);
        }

        if ($sort)
        {
            $query->setOrder($sort);
        }

        if ($select)
        {
            $query->setSelect($select);
        }

        if ($limit > 0)
        {
            $query->setLimit($limit);
        }

        $query->setOffset($offset);

        $collection = new EntityCollection();

        if ($countTotal)
        {
            $collection->setTotalCount($this->getTotalCount($filter));
        }

        foreach ($query->fetchCollection() as $row)
        {
            $collection->add($this->mapper->convertFromOrm($row));
        }


        return $collection;
    }

    private function getTotalCount(?ConditionTree $filter): int
    {
        $query = RelatedProductTable::query()
            ->setSelect(['CNT'])
            ->registerRuntimeField(
                'CNT',
                [
                    'data_type' => 'integer',
                    'expression' => ['COUNT(%s)', 'ID'],
                ]
            )
        ;

        if ($filter)
        {
            $query->where($filter);
        }

        return (int)($query->fetch()['CNT'] ?? 0);
    }

    public function save(RelatedProduct $entity): void
    {
        try
        {
            $result = $this->mapper->convertToOrm($entity)->save();
        }
        catch (\Exception $e)
        {
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }

        if ($result->isSuccess())
        {
            if (!$entity->getId())
            {
                $entity->setId($result->getId());
            }
        }
        else
        {
            throw new Exception('Unable to save related product', $result->getErrorMessages());
        }
    }

    public function delete(int|string $id): void
    {
        try
        {
            $result = RelatedProductTable::delete($id);
        }
        catch (\Exception $e)
        {
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }

        if (!$result->isSuccess())
        {
            throw new Exception('Unable to delete related product', $result->getErrorMessages());
        }
    }
}
