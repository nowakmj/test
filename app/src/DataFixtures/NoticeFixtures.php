<?php
/**
 * Notice fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Notice;
use DateTimeImmutable;

/**
 * Class NoticeFixtures.
 */
class NoticeFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     */
    public function loadData(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            $notice = new Notice();
            $notice->setTitle($this->faker->sentence);
            $notice->setCreatedAt(
                DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $notice->setUpdatedAt(
                DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $this->manager->persist($notice);
        }

        $this->manager->flush();
    }
}
