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
        $railroad->setName('State Belt Railway of California');

        $startDate = new DateTimeImmutable("2015-04-01 UTC+6");
        $railroad->setStartDate(DateTime::createFromInterface($startDate));

        $railroad->setOwner('david d zuhn');

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