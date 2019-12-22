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

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Mazarini\PaginationBundle\Controller\AbstractPaginationController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/")
 */
class UserController extends AbstractPaginationController
{
    public function __construct(RequestStack $requestStack, UrlGeneratorInterface $router)
    {
        parent::__construct($requestStack, $router, 'user');
        $this->twigFolder = 'user/';
    }

    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->indexAction();
    }

    /**
     * @Route("/page-{page<[1-9]\d*>}.html", name="user_page", methods={"GET"})
     */
    public function page(UserRepository $UserRepository, int $page): Response
    {
        return $this->PageAction($UserRepository, $page);
    }

    /**
     * @Route("/show-{id<[1-9]\d*>}.html", name="user_show", methods={"GET"})
     */
    public function show(User $entity): Response
    {
        return $this->showAction($entity);
    }
}
