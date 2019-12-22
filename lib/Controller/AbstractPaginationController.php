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
use Mazarini\ToolsBundle\Data\Data;
use Mazarini\ToolsBundle\Entity\EntityInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class AbstractPaginationController extends AbstractController
{
    public function __construct(RequestStack $requestStack, UrlGeneratorInterface $router, string $baseRoute)
    {
        parent::__construct($requestStack, $router, $baseRoute);
    }

    protected function PaginationUrl(Data $data): AbstractController
    {
        if ($data->isSetEntities()) {
            $pagination = $data->getPagination();
            $last = $pagination->getLastPage();
            if ($pagination->hasPreviousPage()) {
                $data->addLink('first', '_page', ['page' => 1]);
                $data->addLink('previous', '_page', ['page' => $pagination->getCurrentPage() - 1]);
            }
            if ($pagination->hasNextPage()) {
                $last = $pagination->getLastPage();
                $data->addLink('Next', '_page', ['page' => $pagination->getCurrentPage() + 1]);
                $data->addLink('Last', '_page', ['page' => $last]);
            }
            for ($i = 1; $i <= $last; ++$i) {
                $data->addLink('page-'.$i, '_page', ['page' => $i], (string) $i);
            }
        } else {
            $data->addLink('index', '_page', ['page' => 1], 'List');
        }

        return $this;
    }

    /**
     * listUrl.
     *
     * @param array<int,string> $actions
     */
    protected function listUrl(Data $data, array $actions): AbstractController
    {
        if ($data->isSetEntities()) {
            foreach ($data->getEntities() as $entity) {
                $id = $entity->getId();
                $parameters = ['id' => $id];
                foreach ($actions as $action) {
                    $data->addLink($action.'-'.$id, '_'.$action, $parameters, ucfirst($action));
                }
            }
        }

        return $this;
    }

    protected function initUrl(Data $data): AbstractController
    {
        $this->listUrl($data, ['show']);
        $this->paginationUrl($data);

        return $this;
    }

    protected function IndexAction(): Response
    {
        return $this->redirectToRoute($this->data->getRoute('_page'), ['page' => 1]);
    }

    protected function PageAction(AbstractRepository $EmptyRowRepository, int $page): Response
    {
        $this->data->setPagination($EmptyRowRepository->getPage($page));

        $currentPage = $this->data->getPagination()->getCurrentPage();
        $currentUrl = $this->generateUrl($this->data->getroute('_page'), ['page' => $currentPage]);

        if ($page === $currentPage) {
            return $this->dataRender('index.html.twig');
        }

        return $this->redirectToRoute($this->data->getRoute('_page'), ['page' => $currentPage]);
    }

    protected function showAction(EntityInterface $entity): Response
    {
        $this->data->setEntity($entity);

        return $this->dataRender('show.html.twig', []);
    }
}
