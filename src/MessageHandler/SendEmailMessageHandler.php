<?php

namespace App\MessageHandler;

use App\Message\SendEmailMessage;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;

#[AsMessageHandler]
final class SendEmailMessageHandler
{
    public function __construct(
        private readonly MailerInterface $mailer,
    ) {}

    public function __invoke(SendEmailMessage $message): void
    {
        $email = (new Email())
            ->to($message->to)
            ->subject($message->subject)
            ->html($message->body);

        $this->mailer->send($email);
    }
}
