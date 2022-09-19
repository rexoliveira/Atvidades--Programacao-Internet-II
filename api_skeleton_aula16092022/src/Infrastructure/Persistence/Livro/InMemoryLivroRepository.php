<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Livro;

use App\Domain\Livro\Livro;
use App\Domain\Livro\LivroNotFoundException;
use App\Domain\Livro\LivroRepository;
use App\Domain\User\UserNotFoundException;

class InMemoryLivroRepository implements LivroRepository
{
    /**
     * @var Livro[]
     */
    private array $livros;

    /**
     * @param Livro[]|null $livros
     */
    public function __construct(array $livros = null)
    {
        $this->livros = $livros ?? [
            1 => new Livro(1, 'bill.gates', 'Bill', 'Gates'),
            2 => new Livro(2, 'steve.jobs', 'Steve', 'Jobs'),
            3 => new Livro(3, 'mark.zuckerberg', 'Mark', 'Zuckerberg'),
            4 => new Livro(4, 'evan.spiegel', 'Evan', 'Spiegel'),
            5 => new Livro(5, 'jack.dorsey', 'Jack', 'Dorsey'),
            6 => new Livro(6, 'rodrigo.oliveira', 'Rodrigo', 'Oliveira'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->livros);
    }

    /**
     * {@inheritdoc}
     */
    public function findUserOfId(int $id): Livro
    {
        if (!isset($this->livros[$id])) {
            throw new UserNotFoundException();
        }

        return $this->livros[$id];
    }
}
