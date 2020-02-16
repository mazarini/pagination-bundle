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
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractPaginationController extends AbstractController
{
    protected function PaginationUrl(Data $data): AbstractController
    {
        if ($data->isSetEntities()) {
            $pagination = $data->getPagination();
            $last = $pagination->getLastPage();
            if ($pagination->hasPreviousPage()) {
                $navUrl['first'] = $data->generateUrl('_page', ['page' => 1]);
                $navUrl['previous'] = $data->generateUrl('_page', ['page' => $pagination->getCurrentPage() - 1]);
            } else {
                $navUrl['first'] = '#';
                $navUrl['previous'] = '#';
            }
            if ($pagination->hasNextPage()) {
                $navUrl['next'] = $data->generateUrl('_page', ['page' => $pagination->getCurrentPage() + 1]);
                $navUrl['last'] = $data->generateUrl('_page', ['page' => $last]);
            } else {
                $navUrl['next'] = '#';
                $navUrl['last'] = '#';
            }
            $data->addLink('first', $navUrl['first'], '1');
            $data->addLink('previous', $navUrl['previous']);
            $data->addLink('next', $navUrl['next']);
            $data->addLink('last', $navUrl['last'], (string) $last);
            for ($i = 1; $i <= $last; ++$i) {
                $data->addLink('page-'.$i, $data->generateUrl('_page', ['page' => $i]), (string) $i);
            }
        } else {
            $data->addLink('index', $data->generateUrl('_page', ['page' => 1]), 'List');
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
                    $data->addLink($action.'-'.$id, $data->generateUrl('_'.$action, $parameters), $action);
                }
            }
        }

        return $this;
    }

    /**
     * listUrl.
     *
     * @param array<int,string> $actions
     */
    protected function EntityUrl(Data $data, array $actions): AbstractController
    {
        if ($data->isSetEntity()) {
            $parameters = ['id' => $data->getEntity()->getId()];
            foreach ($actions as $action) {
                $data->addLink($action, $data->generateUrl('_'.$action, $parameters), $action);
            }
        }
        $data->addLink('index', $data->generateUrl('_index', ['page' => 1]), 'Back');

        return $this;
    }

    protected function initUrl(Data $data): AbstractController
    {
        $this->listUrl($data, ['show']);
        $this->paginationUrl($data);
        $this->EntityUrl($data, ['show']);

        return $this;
    }

    protected function IndexAction(): Response
    {
        return $this->redirect($this->data->generateUrl('_page', ['page' => 1]));
    }

    protected function PageAction(AbstractRepository $EmptyRowRepository, int $page): Response
    {
        $this->data->setPagination($EmptyRowRepository->getPage($page));

        if ($page === $this->data->getPagination()->getCurrentPage()) {
            return $this->dataRender('index.html.twig');
        }

        return $this->redirect($this->data->generateUrl('_page', ['page' => $this->data->getPagination()->getCurrentPage()]));
    }

    protected function showAction(EntityInterface $entity): Response
    {
        $this->data->setEntity($entity);

        return $this->dataRender('show.html.twig', []);
    }

    protected function setNewUrl(Data $data): void
    {
    }

    /**
     * getCrudAction.
     *
     * @return array<string,string>
     */
    protected function getCrudAction(): array
    {
        return ['_show' => 'Show'];
    }

    /**
     * getListAction.
     *
     * @return array<string,string>
     */
    protected function getListAction(): array
    {
        return ['_show' => 'Show'];
    }
}
