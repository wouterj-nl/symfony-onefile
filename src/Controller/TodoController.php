<?php

namespace App\Controller;

use App\Entity\Todo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

#[AsController]
class TodoController
{
    #[Route('/')]
    public function index(Environment $twig, EntityManagerInterface $entityManager): Response
    {
        return new Response(
            $twig->render('index.html.twig', [
                'todos' => $entityManager->getRepository(Todo::class)->findAll(),
            ])
        );
    }

    #[Route('/add', methods: ['POST'], name: 'add_todo')]
    public function add(#[MapRequestPayload] Todo $todo, EntityManagerInterface $entityManager): Response
    {
        $entityManager->persist($todo);
        $entityManager->flush();

        return new RedirectResponse('/');
    }

    #[Route('/{id}/delete', methods: ['POST'], name: 'delete_todo')]
    public function delete(Todo $todo, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($todo);
        $entityManager->flush();

        return new RedirectResponse('/');
    }
}
