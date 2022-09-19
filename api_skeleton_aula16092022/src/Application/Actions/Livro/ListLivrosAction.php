<?php
declare(strict_types=1);

namespace App\Application\Actions\Livro;

use Psr\Http\Message\ResponseInterface as Response;

class ListLivrosAction extends LivroAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $livros = $this->livroRepository->findAll();

        $this->logger->info("Livros list was viewed.");

        return $this->respondWithData($livros);
    }
}
