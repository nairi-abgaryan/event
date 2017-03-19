<?php

namespace AppBundle\ORM\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements FixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        Fixtures::load(__DIR__ . '/fixtures.yml', $manager, ['providers' => [$this]]);
    }
}
