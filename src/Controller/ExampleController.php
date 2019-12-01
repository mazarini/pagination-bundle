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

use App\Entity\Example;
use App\Repository\ExampleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class ExampleController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"})
     * @Route("/page-{page}.html", name="example_page", methods={"GET"})
     */
    public function index(ExampleRepository $exampleRepository, int $page = 1): Response
    {
        $examples = $exampleRepository->findPage($page);
        if ($examples->hasPreviousPage()) {
            $examples->setFirst($this->generateUrl('example_page', ['page' => 1]))
                     ->setPrev($this->generateUrl('example_page', ['page' => $examples->getCurrentPage() - 1]));
        }
        if ($examples->hasNextPage()) {
            $examples->setNext($this->generateUrl('example_page', ['page' => $examples->getCurrentPage() + 1]))
                     ->setLast($this->generateUrl('example_page', ['page' => $examples->getLastPage()]));
        }

        return $this->render('example/index.html.twig', [
            'examples' => $examples,
        ]);
    }
}
