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

namespace App\DataFixtures;

use App\Entity\Example;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ExampleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 90; ++$i) {
            $example = new Example();
            $example
                ->setCol1('row_'.$i.'_'.'c_1')
                ->setCol2('row_'.$i.'_'.'c_2')
                ->setCol3('row_'.$i.'_'.'c_3')
                ->setCol4('row_'.$i.'_'.'c_4')
                ->setCol5('row_'.$i.'_'.'c_5')
                ->setCol6('row_'.$i.'_'.'c_6')
                ->setCol7('row_'.$i.'_'.'c_7')
                ->setCol8('row_'.$i.'_'.'c_8')
                ->setCol9('row_'.$i.'_'.'c_9');
            $manager->persist($example);
            $manager->flush();
        }
    }
}
