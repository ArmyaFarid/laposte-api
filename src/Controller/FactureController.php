<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Export;
use App\Entity\Facture;
use App\Entity\Import;
use App\Repository\ClientRepository;
use App\Repository\FactureRepository;
use App\Units\FactureDataMaker;
use App\Units\UnitPrice;
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

    #[Route('api/facture/{id}/imports-and-exports/{month}', name: 'client_imports_exports', methods: ['GET'])]
    public function getDataForFacture(Client $client, string $month ,SerializerInterface $serializer ,EntityManagerInterface $entityManager): JsonResponse
    {
        $unitPrice = new UnitPrice();
        // Extract the year and month from the provided string
        [$year, $month] = explode('-', $month);

        // Create DateTime objects for the start and end of the specified month
        $startDate = new \DateTime("$year-$month-01");
        $endDate = new \DateTime("$year-$month-01 +1 month -1 day");

        // Retrieve imports and exports within the specified date range
//        $imports = $client->getImports()->filter(function ($import) use ($startDate, $endDate) {
//            return $import->getDate() >= $startDate && $import->getDate() <= $endDate;
//        });
//
//        $exports = $client->getExports()->filter(function ($export) use ($startDate, $endDate) {
//            return $export->getDate() >= $startDate && $export->getDate() <= $endDate;
//        });
//        dump($imports);
//
//
//        // Serialize the imports and exports to JSON using Symfony's Serializer component
//        $data = [
//            'imports' => $this->serializer->normalize($imports, null, ['groups' => ['getClient', 'getDetailClient']]),
//            'exports' => $this->serializer->normalize($exports, null, ['groups' => ['getClient', 'getDetailClient']])
//        ];
//
//        return new JsonResponse($data, Response::HTTP_OK);
        // Retrieve the client's exports for the given month

        $exports = $entityManager->getRepository(Export::class)
            ->createQueryBuilder('e')
            ->where('e.client = :client')
            ->andWhere('e.date BETWEEN :startDate AND :endDate')
            ->setParameter('client', $client)
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->getQuery()
            ->getResult();

        $imports = $entityManager->getRepository(Import::class)
            ->createQueryBuilder('e')
            ->where('e.client = :client')
            ->andWhere('e.date BETWEEN :startDate AND :endDate')
            ->setParameter('client', $client)
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->getQuery()
            ->getResult();

        // You can serialize the $exports to JSON and return a JsonResponse
        // using Symfony's serializer component or any other method you prefer

        $jsonExport = $this->serializer->normalize($exports, null, ['groups' => 'getTransactions']);
        $jsonImport = $this->serializer->normalize($imports, null, ['groups' => 'getTransactions']);


        $facture = new FactureDataMaker($imports,$exports,$unitPrice,$startDate,$client->getId());

        // Serialize the imports and exports to JSON using Symfony's Serializer component
        $data = [
            'imports' => $jsonImport,
            'exports' => $jsonExport
        ];

        $jsonFacture = $this->serializer->normalize($facture);



        return new JsonResponse($jsonFacture, Response::HTTP_OK, ['accept' => 'json']);
    }

    private function calculateTotalQuantity(array $data, $key)
    {
        $total = 0;
        foreach ($data as $item) {
            switch ($key) {
                case 'range_5':
                    $total += $item->getRange5();
                    break;
                case 'range_10':
                    $total += $item->getRange10();
                    break;
                case 'range_15':
                    $total += $item->getRange15();
                    break;
                case 'range_20':
                    $total += $item->getRange20();
                    break;
                case 'range_25':
                    $total += $item->getRange25();
                    break;
                case 'range_30':
                    $total += $item->getRange30();
                    break;
                default:
                    // Handle unrecognized key
                    break;
            }
        }
        return $total;
    }



}
