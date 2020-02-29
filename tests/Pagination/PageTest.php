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
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PageTest extends KernelTestCase
{
    /**
     * @var FakeEntityRepository
     */
    private $repository;

    protected function setUp(): void
    {
        if (null === $this->repository) {
            $kernel = self::bootKernel();
            $doctrine = $kernel->getContainer()->get('doctrine');
            if ((null !== $doctrine) && (method_exists($doctrine, 'getManager'))) {
                $entityManager = $doctrine->getManager();
            } else {
                throw new RuntimeException('Doctrine not available in container.');
            }
            $this->repository = $entityManager->getRepository(FakeEntity::class);
        }
    }

    /**
     * testCurrentPage.
     *
     * @dataProvider getCurrentPage
     */
    public function testCurrentPage(int $first, int $previous, int $current, int $next, int $last, bool $hasToPaginate, bool $hasPrevious, bool $hasNext): void
    {
        $pagination = $this->repository->getPage($current);
        $this->assertSame($pagination->getFirstPage(), $first);
        $this->assertSame($pagination->getPreviousPage(), $previous);
        $this->assertSame($pagination->getCurrentPage(), $current);
        $this->assertSame($pagination->getNextPage(), $next);
        $this->assertSame($pagination->getLastPage(), $last);
        $this->assertSame($pagination->hasToPaginate(), $hasToPaginate);
        $this->assertSame($pagination->hasPreviousPage(), $hasPrevious);
        $this->assertSame($pagination->hasNextPage(), $hasNext);
    }

    /**
     * getCurrentPage.
     *
     * @return \Traversable<int,array>
     */
    public function getCurrentPage(): \Traversable
    {
//      $first,$previous,$current,$next,$last,$hasToPaginate,$hasPrevious,$hasNext

        yield [1, 1, 1, 2, 5, true, false, true];
        yield [1, 1, 2, 3, 5, true, true, true];
        yield [1, 2, 3, 4, 5, true, true, true];
        yield [1, 3, 4, 5, 5, true, true, true];
        yield [1, 4, 5, 5, 5, true, true, false];
    }
}
