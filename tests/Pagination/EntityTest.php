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

namespace App\Tests\Pagination;

use App\Entity\FakeEntity;
use App\Repository\FakeEntityRepository;
use Doctrine\ORM\EntityManager;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EntityTest extends KernelTestCase
{
    /**
     * @var FakeEntityRepository
     */
    private $repository;

    /**
     * @var entityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        if (null === $this->repository) {
            $kernel = self::bootKernel();
            $doctrine = $kernel->getContainer()->get('doctrine');
            if ((null !== $doctrine) && (method_exists($doctrine, 'getManager'))) {
                $this->entityManager = $doctrine->getManager();
            } else {
                throw new RuntimeException('Doctrine not available in container.');
            }
            $this->repository = $this->entityManager->getRepository(FakeEntity::class);
        }
    }

    /**
     * testCurrentPage.
     *
     * @dataProvider getCountPage
     */
    public function testEntity(int $current, int $first, int $last): void
    {
        $result = $this->repository->getPage($current)->getEntities();
        $this->assertSame(\count($result), 10);
        $this->assertTrue($result[0] instanceof FakeEntity);
        if ($result[0] instanceof FakeEntity) {
            $this->assertSame($result[0]->getId(), $first);
        }
        $this->assertTrue($result[9] instanceof FakeEntity);
        if ($result[9] instanceof FakeEntity) {
            $this->assertSame($result[9]->getId(), $last);
        }
    }

    /**
     * getCurrentPage.
     *
     * @return \Traversable<int,array>
     */
    public function getCountPage(): \Traversable
    {
//      $delete,$totalCount,$count,$hasPaginate

        yield [1, 45, 36];
        yield [2, 35, 26];
        yield [3, 25, 16];
        yield [4, 15, 6];
    }
}
