<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ClientController extends AbstractController
{
    function __construct(private SerializerInterface $serializer, private EntityManagerInterface $em){}

    #[Route('/client', name: 'app_client')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ClientController.php',
        ]);
    }

    #[Route('api/client',name: 'allClients' , methods: ['GET'])]
    function getAuAllAuthor(ClientRepository $clientRepository):JsonResponse
    {
        $authorList =  $clientRepository->findAll();
        $jsonList = $this->serializer->serialize($authorList,'json',['groups'=>'getClient']);
        return new JsonResponse($jsonList,Response::HTTP_OK,[],true);
    }

    #[Route('api/client/{id}',name: 'detailClient' , methods: ['GET'])]
    function getAuthor(Client $client):JsonResponse
    {
        $jsonClient = $this->serializer->serialize($client,'json',['groups'=>'getDetailClient']);
        return new JsonResponse($jsonClient, Response::HTTP_OK, [], true);
    }

    #[Route('/api/client/{id}', name: 'deleteClient', methods: ['DELETE'])]
    public function deleteAuthor(Client $client, EntityManagerInterface $em): JsonResponse {
        $em->remove($client);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/client/', name: 'createClient', methods: ['POST'])]
    public function createAuthor(Request $request,UrlGeneratorInterface $urlGenerator): JsonResponse {
        $em = $this->em;

        $client = $this->serializer->deserialize($request->getContent(), Client::class, 'json');

        dump($request->getContent());

        $em->persist($client);
        $em->flush();

        $jsonAuthor = $this->serializer->serialize($client, 'json', ['groups' => 'getClient']);
        $location = $urlGenerator->generate('detailClient', ['id' => $client->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
        return new JsonResponse($jsonAuthor, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    #[Route('/api/client/{id}', name:"updateClient", methods:['PUT'])]
    public function updateBook(Request $request, Client $currentClient, ClientRepository $clientRepository): JsonResponse
    {
        $em=$this->em;
        $updatedClient = $this->serializer->deserialize($request->getContent(),
            Client::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $currentClient]);
        $em->persist($updatedClient);
        $em->flush();
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
