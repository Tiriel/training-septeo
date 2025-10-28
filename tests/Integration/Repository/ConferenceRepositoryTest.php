<?php

namespace App\Tests\Integration\Repository;

use App\Repository\ConferenceRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ConferenceRepositoryTest extends KernelTestCase
{
    /**
     * @dataProvider provideYearCountAndDates
     * @group integration
     */
    public function testFindConferenceBetweenDatesReturnsAllConferencesBetweenDates(
        int $count,
        ?string $lastYear,
        ?\DateTimeImmutable $start = null,
        ?\DateTimeImmutable $end = null
    ): void {
        if (null === $start && null === $end) {
            $this->expectException(\InvalidArgumentException::class);
            $this->expectExceptionMessage('At least one date is required to operate this method.');
        }

        $conferences = static::getContainer()->get(ConferenceRepository::class)->findConferencesBetweenDates($start, $end);

        $lastConference = end($conferences) ?: null;

        $this->assertCount($count, $conferences);
        $this->assertSame($lastYear, $lastConference?->getStartAt()?->format('Y'));
    }

    public static function provideYearCountAndDates(): iterable
    {
        yield 'no date' => [0, ''];
        yield 'not found' => [0, null, new \DateTimeImmutable('01-03-2026')];
        yield 'after 2020' => [5, '2025', new \DateTimeImmutable('01-03-2020')];
        yield 'before 2020' => [10, '2010', null, new \DateTimeImmutable('01-03-2020')];
        yield 'between 2020-2021' => [1, '2021', new \DateTimeImmutable('01-03-2020'), new \DateTimeImmutable('31-03-2021')];
    }
}
