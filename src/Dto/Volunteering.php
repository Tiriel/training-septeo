<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class Volunteering
{
    public function __construct(
        #[Assert\NotBlank()]
        public int $userId = 0,
        #[Assert\NotBlank()]
        public int $conferenceId = 0,
        public ?\DateTimeImmutable $startAt = null,
        #[Assert\GreaterThan(propertyPath: 'startAt')]
        public ?\DateTimeImmutable $endAt = null,
    ) {}
}
