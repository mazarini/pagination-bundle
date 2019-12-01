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

trait HrefTrait
{
    protected $first = '';
    protected $prev = '';
    protected $next = '';
    protected $last = '';

    abstract public function hasPreviousPage(): bool;

    abstract public function hasNextPage(): bool;

    public function setFirst(string $first): self
    {
        $this->first = $first;

        return $this;
    }

    public function getFirst(): string
    {
        return $this->hasPreviousPage() ? $this->first : '#';
    }

    public function setPrev(string $prev): self
    {
        $this->prev = $prev;

        return $this;
    }

    public function getPrev(): string
    {
        return $this->hasPreviousPage() ? $this->prev : '#';
    }

    public function setNext(string $next): self
    {
        $this->next = $next;

        return $this;
    }

    public function getNext(): string
    {
        return $this->hasNextPage() ? $this->next : '#';
    }

    public function setLast(string $last): self
    {
        $this->last = $last;

        return $this;
    }

    public function getLast(): string
    {
        return $this->hasNextPage() ? $this->last : '#';
    }
}
