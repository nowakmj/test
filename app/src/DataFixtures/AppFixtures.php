<?php
/**
 * AppFixtures.
 */

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class AppFixtures.
 */
class AppFixtures extends Fixture
{
    /**
     * Load fixtures.
     *
     * @param ObjectManager $manager the object manager
     */
    public function load(ObjectManager $manager): void
    {
        $manager->flush();
    }
}
