<?php

namespace Bitrix\Related\Internals\Repository;

use Bitrix\Related\Entity\EntityInterface;

interface RepositoryInterface
{
    public function getById(int|string $id): ?EntityInterface;

    public function save(EntityInterface $entity): void;

    public function delete(int|string $id): void;
}