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

use Mazarini\ToolsBundle\Entity\EntityInterface;

interface PaginationInterface
{
    /**
     * getEntities.
     *
     * @return \ArrayIterator<int,EntityInterface>
     */
    public function getEntities(): \ArrayIterator;

    public function hasToPaginate(): bool;

    public function hasPreviousPage(): bool;

    public function getFirstPage(): int;

    public function getPreviousPage(): int;

    public function getCurrentPage(): int;

    public function hasNextPage(): bool;

    public function getNextPage(): int;

    public function getLastPage(): int;

    public function count(): int;
}
