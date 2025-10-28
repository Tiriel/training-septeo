<?php

namespace App\Tests\Unit\Transformer;

use App\Entity\Conference;
use App\Transformer\ApiToConferenceTransformer;
use PHPUnit\Framework\TestCase;

class ApiToConferenceTransformerTest extends TestCase
{
    public function testTransformerTransformsDataFromApi(): void
    {
        $data = [
            'name' => 'test',
            'description' => 'test',
            'prerequisites' => 'test',
            'accessible' => true,
            'startDate' => '2019-01-01',
            'endDate' => '2019-01-02',
        ];
        $transformer = new ApiToConferenceTransformer();

        $result = $transformer->transform($data);

        $this->assertInstanceOf(Conference::class, $result);
        $this->assertSame('test', $result->getName());
        $this->assertSame('test', $result->getDescription());
        $this->assertSame('test', $result->getPrerequisites());
        $this->assertTrue($result->isAccessible());
        $this->assertSame('2019-01-01', $result->getStartAt()->format('Y-m-d'));
        $this->assertSame('2019-01-02', $result->getEndAt()->format('Y-m-d'));
    }

    public function testTransformerThrowsOnMissingData(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Some keys are missing from API data');

        $data = [
            'name' => 'test',
        ];
        $transformer = new ApiToConferenceTransformer();

        $transformer->transform($data);
    }
}
