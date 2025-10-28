<?php

namespace App\Transformer;

use App\Entity\Conference;

class ApiToConferenceTransformer implements ApiToEntityTransformerInterface
{
    public const KEYS = [
        'name',
        'description',
        'prerequisites',
        'accessible',
        'startDate',
        'endDate',
    ];

    public function transform(array $data): object
    {
        if (\count(\array_diff(self::KEYS, \array_keys($data))) > 0) {
            throw new \InvalidArgumentException('Some keys are missing from API data');
        }

        return (new Conference())
            ->setName($data['name'])
            ->setDescription($data['description'])
            ->setPrerequisites($data['prerequisites'])
            ->setAccessible($data['accessible'])
            ->setStartAt(new \DateTimeImmutable($data['startDate']))
            ->setEndAt(new \DateTimeImmutable($data['endDate']))
        ;
    }
}
