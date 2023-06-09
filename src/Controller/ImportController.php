<?php

namespace App\Controller;

use App\Entity\Import;
use App\Repository\ClientRepository;
use App\Repository\ImportRepository;
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

class ImportController extends AbstractController
{

    function __construct(private SerializerInterface $serializer, private EntityManagerInterface $em ,private TokenStorageInterface $tokenStorageInterface,private JWTTokenManagerInterface $jwtManager){}

    #[Route('/import', name: 'app_import')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ImportController.php',
        ]);
    }

    #[Route('api/import', name: 'import' , methods: ['GET'])]
    public function getImports(ImportRepository $importRepository): JsonResponse
    {
        $importList = $importRepository->findAll();

        $jsonImportList = $this->serializer->serialize($importList, 'json', ['groups' => 'getTransactions']);

        return new JsonResponse($jsonImportList, Response::HTTP_OK, [], true);
    }

    #[Route('api/import/{id}', name: 'import_one' , methods: ['GET'])]
    public function getOneImport(Import $import): JsonResponse
    {
        $jsonImport = $this->serializer->serialize($import, 'json', ['groups' => 'getTransactions']);
        return new JsonResponse($jsonImport, Response::HTTP_OK, ['accept' => 'json'], true);
    }

    #[Route('/api/import/{id}', name: 'deleteImport', methods: ['DELETE'])]
    public function deleteImport(Import $import): JsonResponse
    {
        $em=$this->em;
        $em->remove($import);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }


    #[Route('/api/import/', name:"createImport", methods: ['POST'])]
    public function createImport(Request $request, SerializerInterface $serializer,UrlGeneratorInterface $urlGenerator, ClientRepository $clientRepository, ImportRepository $importRepository): JsonResponse
    {
        $em=$this->em;
        $import = $serializer->deserialize($request->getContent(), Import::class, 'json');

        // Check if an import already exists for the same date
        $existingImport = $importRepository->findOneBy(['date' => $import->getDate()]);
        if ($existingImport !== null) {
            return new JsonResponse(['error' => 'An import already exists for this date.'], Response::HTTP_BAD_REQUEST);
        }

        // Récupération de l'ensemble des données envoyées sous forme de tableau
        $content = $request->toArray();


        // Récupération de l'idAuthor. S'il n'est pas défini, alors on met -1 par défaut.
        $idClient = $content['clientId'] ?? -1;


        // On cherche l'auteur qui correspond et on l'assigne au livre.
        // Si "find" ne trouve pas l'auteur, alors null sera retourné.

        $import->setClient($clientRepository->find($idClient));



        $em->persist($import);
        $em->flush();

        $jsonImport = $serializer->serialize($import, 'json', ['groups' => 'getBooks']);
        $location = $urlGenerator->generate('import_one', ['id' => $import->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonImport, Response::HTTP_CREATED, ["Location" => $location], true);
    }


    #[Route('/api/import/{id}', name:"updateImport", methods:['PUT'])]
    public function updateImport(Request $request, Import $currentImport, ClientRepository $clientRepository ,ImportRepository $importRepository): JsonResponse
    {
        $em=$this->em;
        $updatedImport = $this->serializer->deserialize($request->getContent(),
            Import::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $currentImport]);

        // Check if an import already exists for the same date
        $existingImport = $importRepository->findOneBy(['date' => $updatedImport->getDate()]);
        if ($existingImport !== null && $existingImport !== $currentImport) {
            return new JsonResponse(['error' => 'An import already exists for this date.'], Response::HTTP_BAD_REQUEST);
        }

        $content = $request->toArray();
        $idClient = $content['clientId'] ?? -1;
        $updatedImport->setClient($clientRepository->find($idClient));
        $em->persist($updatedImport);
        $em->flush();
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }


    #[Route('/api/imports', name: 'api_imports', methods: ['GET'])]
    public function imports(Request $request, ImportRepository $importRepository,ClientRepository $clientRepository, int $page = 1): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $client = null;
        $decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());

        if (in_array("ROLE_CLIENT", $decodedJwtToken['roles'])) {
            $clientEmail = $decodedJwtToken['username'];
            $client = $clientRepository->findOneByEmailField($clientEmail);
        }

        $imports = $importRepository->getPaginatedImportsByMonth($page,$client);

//        return json_encode($imports, JSON_FORCE_OBJECT);
        $jsonImport = $this->serializer->serialize($imports, 'json', ['groups' => 'getTransactions']);
        return new JsonResponse($jsonImport, Response::HTTP_OK, ['accept' => 'json'], true);
    }

}
