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

namespace App\Repository;

use App\Entity\FakeEntity;
use Doctrine\Common\Persistence\ManagerRegistry;
use Mazarini\PaginationBundle\Repository\EntityRepositoryAbstract;

/**
 * @method Ten|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ten|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ten[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FakeEntityRepository extends EntityRepositoryAbstract
{
    /**
     * @var string
     */
    protected $orderDirection = 'DESC';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FakeEntity::class);
    }
}
