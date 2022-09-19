<?php
declare(strict_types=1);

namespace App\Domain\Livro;

interface LivroRepository
{
    /**
     * @return Livro[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Livro
     * @throws LivroNotFoundException
     */
    public function findUserOfId(int $id): Livro;
}
