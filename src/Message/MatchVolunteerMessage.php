<?php

namespace App\Message;

use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage('async')]
final class MatchVolunteerMessage
{
    public function __construct(
        public string $strategy,
        public int $userId,
    ) {}
}
