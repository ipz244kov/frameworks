<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Repository\SubjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/subjects', name: 'api_subjects_')]
class SubjectController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(SubjectRepository $subjectRepository): JsonResponse
    {
        $subjects = $subjectRepository->findAll();
        $data = [];

        foreach ($subjects as $subject) {
            $data[] = [
                'id' => $subject->getId(),
                'name' => $subject->getName(),
                'description' => $subject->getDescription(),
                'credits' => $subject->getCredits(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK, [], false);
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $content = json_decode($request->getContent(), true);

        if (!isset($content['name']) || !isset($content['credits'])) {
            return new JsonResponse(['message' => 'Необхідні поля відсутні'], Response::HTTP_BAD_REQUEST);
        }

        $subject = new Subject();
        $subject->setName($content['name']);
        $subject->setDescription($content['description'] ?? null);
        $subject->setCredits((int)$content['credits']);

        $em->persist($subject);
        $em->flush();

        return new JsonResponse([
            'id' => $subject->getId(),
            'name' => $subject->getName(),
            'description' => $subject->getDescription(),
            'credits' => $subject->getCredits(),
        ], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, SubjectRepository $subjectRepository): JsonResponse
    {
        $subject = $subjectRepository->find($id);

        if (!$subject) {
            return new JsonResponse(['message' => 'Предмет не знайдено'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'id' => $subject->getId(),
            'name' => $subject->getName(),
            'description' => $subject->getDescription(),
            'credits' => $subject->getCredits(),
        ]);
    }

    #[Route('/{id}', name: 'update', methods: ['PATCH'])]
    public function update(int $id, Request $request, SubjectRepository $subjectRepository, EntityManagerInterface $em): JsonResponse
    {
        $subject = $subjectRepository->find($id);

        if (!$subject) {
            return new JsonResponse(['message' => 'Предмет не знайдено'], Response::HTTP_NOT_FOUND);
        }

        $content = json_decode($request->getContent(), true);

        if (isset($content['name'])) {
            $subject->setName($content['name']);
        }
        if (array_key_exists('description', $content)) {
            $subject->setDescription($content['description']);
        }
        if (isset($content['credits'])) {
            $subject->setCredits((int)$content['credits']);
        }

        $em->flush();

        return new JsonResponse([
            'id' => $subject->getId(),
            'name' => $subject->getName(),
            'description' => $subject->getDescription(),
            'credits' => $subject->getCredits(),
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id, SubjectRepository $subjectRepository, EntityManagerInterface $em): JsonResponse
    {
        $subject = $subjectRepository->find($id);

        if (!$subject) {
            return new JsonResponse(['message' => 'Предмет не знайдено'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($subject);
        $em->flush();

        return new JsonResponse(['message' => 'Предмет успішно видалено']);
    }
}
