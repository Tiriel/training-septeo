<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Conference;
use PHPUnit\Framework\TestCase;

class ConferenceTest extends TestCase
{
    public function testSettersAndGettersSetAndGet(): void
    {
        $conference = (new Conference())
            ->setName('test')
            ->setDescription('test')
            ->setAccessible(true)
            ->setStartAt(new \DateTimeImmutable('2020-01-01'));

        $name = $conference->getName();
        $description = $conference->getDescription();
        $accessible = $conference->isAccessible();
        $startAt = $conference->getStartAt();

        $this->assertSame('test', $name);
        $this->assertSame('test', $description);
        $this->assertTrue($accessible);
        $this->assertSame('2020-01-01', $startAt->format('Y-m-d'));
    }
}
