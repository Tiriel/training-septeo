<?php

namespace App\MessageHandler;

use App\Message\GetVolunteerMatchesQuery;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class GetVolunteerMatchesQueryHandler
{
    public function __invoke(GetVolunteerMatchesQuery $message): void
    {
        // do something with your message
    }
}
