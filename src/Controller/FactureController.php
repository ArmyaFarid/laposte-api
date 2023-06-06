<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Repository\ClientRepository;
use App\Repository\FactureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;

class FactureController extends AbstractController
{

    function __construct(private SerializerInterface $serializer, private EntityManagerInterface $em){}

    #[Route('/facture', name: 'app_facture')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/FactureController.php',
        ]);
    }

    #[Route('api/facture/{id}', name: 'facture_one' , methods: ['GET'])]
    public function getOneFacture(Facture $import): JsonResponse
    {
        $jsonFacrure = $this->serializer->serialize($import, 'json', ['groups' => 'getDetailFacture']);
        return new JsonResponse($jsonFacrure, Response::HTTP_OK, ['accept' => 'json'], true);
    }

    #[Route('api/facture', name: 'facture' , methods: ['GET'])]
    public function getFactures(FactureRepository $factureRepository): JsonResponse
    {
        $factureList = $factureRepository->findAll();

        $jsonFactureList = $this->serializer->serialize($factureList, 'json', ['groups' => 'getFacture']);

        return new JsonResponse($jsonFactureList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/facture/', name:"createFacture", methods: ['POST'])]
    public function createFacture(Request $request, SerializerInterface $serializer,UrlGeneratorInterface $urlGenerator, ClientRepository $clientRepository): JsonResponse
    {
        $em=$this->em;
        $facture = $serializer->deserialize($request->getContent(), Facture::class, 'json');

        // Récupération de l'ensemble des données envoyées sous forme de tableau
        $content = $request->toArray();


        // Récupération de l'idAuthor. S'il n'est pas défini, alors on met -1 par défaut.
        $idClient = $content['clientId'] ?? -1;


        // On cherche l'auteur qui correspond et on l'assigne au livre.
        // Si "find" ne trouve pas l'auteur, alors null sera retourné.

        $facture->setClient($clientRepository->find($idClient));

        $em->persist($facture);
        $em->flush();

        $jsonImport = $serializer->serialize($facture, 'json', ['groups' => 'getBooks']);
        $location = $urlGenerator->generate('import_one', ['id' => $facture->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonImport, Response::HTTP_CREATED, ["Location" => $location], true);
    }

}
