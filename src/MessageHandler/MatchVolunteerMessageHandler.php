<?php

namespace App\MessageHandler;

use App\Matching\Strategy\MatchingStrategyInterface;
use App\Message\MatchVolunteerMessage;
use App\Repository\UserRepository;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

#[AsMessageHandler]
final class MatchVolunteerMessageHandler
{
    public function __construct(
        private readonly UserRepository $repository,
        /** @var MatchingStrategyInterface[] $strategies */
        #[AutowireIterator('app.matching_strategy', defaultIndexMethod: 'getName')]
        private iterable $strategies,
    )
    {
        $this->strategies = $strategies instanceof \Traversable ? iterator_to_array($strategies) : $strategies;
    }

    public function __invoke(MatchVolunteerMessage $message): void
    {
        $user = $this->repository->find($message->userId);
        if (null === $user) {
            throw new UserNotFoundException();
        }

        $matchings = $this->strategies[$message->strategy]->match($user);
        dump($matchings);
    }
}
