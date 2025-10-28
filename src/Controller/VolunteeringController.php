<?php

namespace App\Controller;

use App\Dto\Volunteering;
use App\Entity\Conference;
use App\Form\VolunteeringType;
use App\Message\CreateVolunteerCommand;
use App\Repository\ConferenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

final class VolunteeringController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    #[Route('/volunteering/{id}', name: 'app_volunteering_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Volunteering $volunteering): Response
    {
        return $this->render('volunteering/show.html.twig', [
            'volunteering' => $volunteering,
        ]);
    }

    #[Route('/volunteering/new', name: 'app_volunteering_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MessageBusInterface $commandBus, ConferenceRepository $repository): Response
    {
        $volunteering = (new Volunteering(userId: $this->getUser()->getId()));
        $options = [];

        if ($request->query->get('conference')) {
            $conference = $repository->find($request->get('conference'));
            $volunteering->conferenceId = $conference->getId();
            $options['conference'] = $conference;
        }

        $form = $this->createForm(VolunteeringType::class, $volunteering, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $volunteering = $this->handle(new CreateVolunteerCommand($volunteering));

            return $this->redirectToRoute('app_volunteering_show', ['id' => $volunteering->getId()]);
        }

        return $this->render('volunteering/new.html.twig', [
            'form' => $form,
        ]);
    }
}
