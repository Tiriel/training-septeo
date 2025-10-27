<?php

namespace App\Message;

use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage('async')]
final class SendEmailMessage
{
    public function __construct(
        public string $to,
        public string $subject,
        public string $body,
    ) {}
}
