<?php

namespace App\Component;

use App\Entity\Todo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\{AsLiveComponent, LiveAction, LiveArg, LiveProp};
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class TodoList
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $task = '';

    public function __construct(
      private EntityManagerInterface $entityManager
    ) {
    }

    public function getTodos(): array
    {
        return $this->entityManager->getRepository(Todo::class)->findAll();
    }

    #[LiveAction]
    public function addTodo(): void
    {
        $this->entityManager->persist(new Todo($this->task));
        $this->entityManager->flush();

        $this->task = '';
    }

    #[LiveAction]
    public function deleteTodo(#[LiveArg('id')] Todo $todo): void
    {
        $this->entityManager->remove($todo);
        $this->entityManager->flush();
    }
}
