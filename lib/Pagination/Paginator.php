<?php

/*
 * Copyright (C) 2019 Mazarini <mazarini@protonmail.com>.
 * This file is part of mazarini/pagination-bundle.
 *
 * mazarini/pagination-bundle is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.
 *
 * mazarini/pagination-bundle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License
 */

namespace Mazarini\PaginationBundle\Pagination;

use Doctrine\ORM\QueryBuilder as DoctrineQueryBuilder;
use Doctrine\ORM\Tools\Pagination\CountWalker;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;

class Paginator extends DoctrinePaginator
{
    private const PAGE_SIZE = 10;
    private $queryBuilder;
    private $result = null;

    use PagesTrait;
    use HrefTrait;

    public function __construct(DoctrineQueryBuilder $queryBuilder, int $currentPage = 1, int $pageSize = self::PAGE_SIZE)
    {
        $this->queryBuilder = $queryBuilder;
        $this->setUseOutputWalkers(false);

        $query = $queryBuilder
            ->setMaxResults($pageSize)
            ->getQuery();

        parent::__construct($query, true);

        if (0 === \count($queryBuilder->getDQLPart('join'))) {
            $this->getQuery()->setHint(CountWalker::HINT_DISTINCT, false);
        }

        $this->currentPage = min($this->getLastPage(), max($currentPage, 1));
        $query->setFirstResult(($this->currentPage - 1) * $pageSize);
        $this->result = $this->getIterator();
    }

    public function getPageSize(): int
    {
        return $this->queryBuilder->getMaxResults();
    }

    public function getEntities(): ?\Traversable
    {
        return $this->result;
    }
}
