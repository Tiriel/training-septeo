<?php

namespace App\MessageHandler;

use App\Entity\Conference;
use App\Entity\User;
use App\Entity\Volunteering;
use App\Message\CreateVolunteerCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateVolunteerCommandHandler
{
    public function __construct(private EntityManagerInterface $manager)
    {
    }

    public function __invoke(CreateVolunteerCommand $message): Volunteering
    {
        $user = $this->manager->getRepository(User::class)->find($message->userId);
        $conference = $this->manager->getRepository(Conference::class)->find($message->conferenceId);

        $entity = (new Volunteering())
            ->setForUser($user)
            ->setConference($conference)
            ->setStartAt($message->startAt)
            ->setEndAt($message->endAt);

        $this->manager->persist($entity);

        return $entity;
    }
}
