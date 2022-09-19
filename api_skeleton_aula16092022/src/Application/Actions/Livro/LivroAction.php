<?php
declare(strict_types=1);

namespace App\Application\Actions\Livro;

use App\Application\Actions\Action;
use App\Domain\Livro\LivroRepository;
use Psr\Log\LoggerInterface;

abstract class LivroAction extends Action
{
    protected LivroRepository $livroRepository;

    public function __construct(LoggerInterface $logger, LivroRepository $livroRepository)
    {
        parent::__construct($logger);
        $this->livroRepository = $livroRepository;
    }
}
