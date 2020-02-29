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

class CurrentTest extends KernelTestCase
{
    /**
     * @var FakeEntityRepository
     */
    private $repository;

    /**
     * @var EntityManager
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
    public function testCount(int $current, int $currentResult, int $count): void
    {
        $pagination = $this->repository->getPage($current);
        $result = $pagination->getEntities();
        $this->assertSame(\count($result), $count);
        $this->assertSame($pagination->getCurrentPage(), $currentResult);
    }

    /**
     * getCurrentPage.
     *
     * @return \Traversable<int,array>
     */
    public function getCountPage(): \Traversable
    {
//      $delete,$totalCount,$count,$hasPaginate

        yield [0, 1, 0];
        yield [1, 1, 10];
        yield [5, 5, 5];
        yield [6, 5, 0];
    }
}
