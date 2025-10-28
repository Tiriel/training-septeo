<?php

namespace App\Message;

use App\Dto\Volunteering;
use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage('sync')]
final class CreateVolunteerCommand
{
    public int $userId;
    public int $conferenceId;
    public ?\DateTimeImmutable $startAt;
    public ?\DateTimeImmutable $endAt;

    public function __construct(Volunteering $dto)
    {
        $this->userId = $dto->userId;
        $this->conferenceId = $dto->conferenceId;
        $this->startAt = $dto->startAt;
        $this->endAt = $dto->endAt;
    }
}
