<?php

namespace App\Controller;

use App\Entity\Export;
use App\Repository\ClientRepository;
use App\Repository\ExportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ExportController extends AbstractController
{

    function __construct(private SerializerInterface $serializer, private EntityManagerInterface $em,private TokenStorageInterface $tokenStorageInterface,private JWTTokenManagerInterface $jwtManager){}

    #[Route('/export', name: 'app_export')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ExportController.php',
        ]);
    }

    #[Route('api/export', name: 'export' , methods: ['GET'])]
    public function getExports(ExportRepository $exportRepository): JsonResponse
    {
        $exportList = $exportRepository->findAll();

        $jsonExportList = $this->serializer->serialize($exportList, 'json', ['groups' => 'getTransactions']);

        return new JsonResponse($jsonExportList, Response::HTTP_OK, [], true);
    }

    #[Route('api/export/{id}', name: 'export_one' , methods: ['GET'])]
    public function getOneExport(Export $export): JsonResponse
    {
        $jsonExport = $this->serializer->serialize($export, 'json', ['groups' => 'getTransactions']);
        return new JsonResponse($jsonExport, Response::HTTP_OK, ['accept' => 'json'], true);
    }

    #[Route('/api/export/{id}', name: 'deleteExport', methods: ['DELETE'])]
    public function deleteExport(Export $export): JsonResponse
    {
        $em=$this->em;
        $em->remove($export);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }


    #[Route('/api/export/', name:"createExport", methods: ['POST'])]
    public function createExport(Request $request, SerializerInterface $serializer,UrlGeneratorInterface $urlGenerator, ClientRepository $clientRepository,ExportRepository $exportRepository): JsonResponse
    {
        $em=$this->em;
        $export = $serializer->deserialize($request->getContent(), Export::class, 'json');

        // Check if an import already exists for the same date
        $existingExport = $exportRepository->findOneBy(['date' => $export->getDate()]);
        if ($existingExport !== null) {
            return new JsonResponse(['error' => 'An export already exists for this date.'], Response::HTTP_BAD_REQUEST);
        }

        // Récupération de l'ensemble des données envoyées sous forme de tableau
        $content = $request->toArray();


        // Récupération de l'idAuthor. S'il n'est pas défini, alors on met -1 par défaut.
        $idClient = $content['clientId'] ?? -1;


        // On cherche l'auteur qui correspond et on l'assigne au livre.
        // Si "find" ne trouve pas l'auteur, alors null sera retourné.

        $export->setClient($clientRepository->find($idClient));

        $em->persist($export);
        $em->flush();

        $jsonExport = $serializer->serialize($export, 'json', ['groups' => 'getBooks']);
        $location = $urlGenerator->generate('export_one', ['id' => $export->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonExport, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    #[Route('/api/export/{id}', name:"updateExport", methods:['PUT'])]
    public function updateExport(Request $request, Export $currentExport, ClientRepository $clientRepository,ExportRepository $exportRepository): JsonResponse
    {
        $em=$this->em;
        $updatedExport = $this->serializer->deserialize($request->getContent(),
            Export::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $currentExport]);

        // Check if an import already exists for the same date
        $existingImport = $exportRepository->findOneBy(['date' => $updatedExport->getDate()]);
        if ($existingImport !== null && $existingImport !== $currentExport) {
            return new JsonResponse(['error' => 'An export already exists for this date.'], Response::HTTP_BAD_REQUEST);
        }

        $content = $request->toArray();
        $idClient = $content['clientId'] ?? -1;
        $updatedExport->setClient($clientRepository->find($idClient));
        $em->persist($updatedExport);
        $em->flush();
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }


    #[Route('/api/exports', name: 'api_exports', methods: ['GET'])]
    public function exports(Request $request, ExportRepository $exportRepository,ClientRepository $clientRepository,  int $page = 1): JsonResponse
    {
        $page = $request->query->getInt('page', 1);

        $client = null;
        $decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());

        if (in_array("ROLE_CLIENT", $decodedJwtToken['roles'])) {
            $clientEmail = $decodedJwtToken['username'];
            $client = $clientRepository->findOneByEmailField($clientEmail);
        }

        $exports = $exportRepository->getPaginatedExportsByMonth($page,$client);

//        return json_encode($exports, JSON_FORCE_OBJECT);
        $jsonExport = $this->serializer->serialize($exports, 'json', ['groups' => 'getTransactions']);
        return new JsonResponse($jsonExport, Response::HTTP_OK, ['accept' => 'json'], true);
    }

}