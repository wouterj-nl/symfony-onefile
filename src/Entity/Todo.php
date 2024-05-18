<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\{Entity, Column, Id, GeneratedValue};

#[Entity]
class Todo
{
    #[Column] #[Id] #[GeneratedValue]
    public int $id;

    public function __construct(
        #[Column]
        public string $task,
    ) {
    }
}
