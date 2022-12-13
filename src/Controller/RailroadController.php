<?php

namespace App\Controller;

use DateTime;
use DateTimeImmutable;

use App\Entity\Railroad;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RailroadController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('/railroad/create', name: 'create_railroad')]
    public function createRailroad(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $railroad = new Railroad();
        $railroad->setName('Central of Minnesota');

        $startDate = new DateTimeImmutable("2012-09-1 UTC+6");
        $railroad->setStartDate(DateTime::createFromInterface($startDate));

        $railroad->setOwner('Joe Binish');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($railroad);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new railroad with id '.$railroad->getId());
    }

    #[Route('/railroad/{id}', name: 'railroad_show')]
    public function showRailroad(ManagerRegistry $doctrine, int $id): Response
    {
        $railroad = $doctrine->getRepository(Railroad::class)->find($id);

        if (!$railroad) {
            throw $this->createNotFoundException(
                'No railroad found for id ' . $id
            );
        }

        return $this->render('railroad/show.html.twig',
            [ 'railroad' => $railroad ]
        );
    }
}