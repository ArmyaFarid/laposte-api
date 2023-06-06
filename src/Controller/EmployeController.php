<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EmployeController extends AbstractController
{
    function __construct(private SerializerInterface $serializer, private EntityManagerInterface $em, private ValidatorInterface $validator){}

    #[Route('/employe', name: 'app_employe')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/EmployeController.php',
        ]);
    }

    #[Route('api/employe', name: 'allEmployes', methods: ['GET'])]
    function getAllEmployes(EmployeRepository $employeRepository): JsonResponse
    {
        $employeList = $employeRepository->findAll();
        $jsonList = $this->serializer->serialize($employeList, 'json', ['groups' => 'getEmploye']);
        return new JsonResponse($jsonList, Response::HTTP_OK, [], true);
    }

    #[Route('api/employe/{id}', name: 'detailEmploye', methods: ['GET'])]
    function getEmploye(Employe $employe): JsonResponse
    {
        $jsonEmploye = $this->serializer->serialize($employe, 'json', ['groups' => 'getDetailEmploye']);
        return new JsonResponse($jsonEmploye, Response::HTTP_OK, [], true);
    }

    #[Route('/api/employe/{id}', name: 'deleteEmploye', methods: ['DELETE'])]
    public function deleteEmploye(Employe $employe, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($employe);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/employe/', name: 'createEmploye', methods: ['POST'])]
    public function createEmploye(Request $request, UrlGeneratorInterface $urlGenerator ,UserPasswordHasherInterface $userPasswordHasher): JsonResponse
    {
        $em = $this->em;

        $employe = $this->serializer->deserialize($request->getContent(), Employe::class, 'json');

        $errors = $this->validator->validate($employe);

        if ($errors->count() > 0) {
            return new JsonResponse($this->serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        // Hash the password
        $hashedPassword = $userPasswordHasher->hashPassword($employe, $employe->getPassword());
        $employe->setPassword($hashedPassword);


        $em->persist($employe);
        $em->flush();

        $jsonEmploye = $this->serializer->serialize($employe, 'json', ['groups' => 'getEmploye']);
        $location = $urlGenerator->generate('detailEmploye', ['id' => $employe->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
        return new JsonResponse($jsonEmploye, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    #[Route('/api/employe/{id}', name: "updateEmploye", methods: ['PUT'])]
    public function updateEmploye(Request $request, Employe $currentEmploye, EmployeRepository $employeRepository ,UserPasswordHasherInterface $userPasswordHasher): JsonResponse
    {
        $em = $this->em;
        $updatedEmploye = $this->serializer->deserialize($request->getContent(), Employe::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $currentEmploye]);

        // Hash the password if a new password is provided
        if ($updatedEmploye->getPassword()) {
            $hashedPassword = $userPasswordHasher->hashPassword($updatedEmploye, $updatedEmploye->getPassword());
            $updatedEmploye->setPassword($hashedPassword);
        }

        $em->persist($updatedEmploye);
        $em->flush();

        $jsonEmploye = $this->serializer->serialize($updatedEmploye, 'json', ['groups' => 'getEmploye']);

        return new JsonResponse($jsonEmploye, JsonResponse::HTTP_NO_CONTENT);
    }
}
