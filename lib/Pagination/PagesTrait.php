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

trait PagesTrait
{
    protected $currentPage = null;
    protected $lastPage = null;

    abstract public function count();

    abstract public function getPageSize(): int;

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getLastPage(): int
    {
        if (null === $this->lastPage) {
            $this->lastPage = ceil($this->count() / $this->getPageSize());
        }

        return $this->lastPage;
    }

    public function hasPreviousPage(): bool
    {
        return 1 < $this->currentPage;
    }

    public function hasNextPage(): bool
    {
        return $this->currentPage < $this->getLastPage();
    }

    public function hasToPaginate(): bool
    {
        return $this->lastPage > 1;
    }
}
