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

namespace Mazarini\PaginationBundle\Controller;

use Mazarini\PaginationBundle\Repository\AbstractRepository;
use Mazarini\ToolsBundle\Controller\AbstractController;
use Mazarini\ToolsBundle\Controller\PaginationTrait;
use Mazarini\ToolsBundle\Data\Data;
use Mazarini\ToolsBundle\Entity\EntityInterface;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractPaginationController extends AbstractController
{
    use PaginationTrait;

    protected function IndexAction(): Response
    {
        $parameters = $this->getPageParameters();
        $parameters['page'] = 1;

        return $this->redirect($this->data->generateUrl('_page', $parameters), Response::HTTP_MOVED_PERMANENTLY);
    }

    protected function PageAction(AbstractRepository $EmptyRowRepository, int $page): Response
    {
        $this->data->setPagination($EmptyRowRepository->getPage($page));

        if ($page === $this->data->getPagination()->getCurrentPage()) {
            return $this->dataRender('index.html.twig');
        }

        $parameters = $this->getPageParameters();
        $parameters['page'] = $this->data->getPagination()->getCurrentPage();

        return $this->redirect($this->data->generateUrl('_page', $parameters));
    }

    protected function showAction(EntityInterface $entity): Response
    {
        $this->data->setEntity($entity);

        return $this->dataRender('show.html.twig', []);
    }

    protected function setNewUrl(Data $data): void
    {
    }
}
