<?php
declare(strict_types=1);

namespace App\Application\Actions\Servico;

use App\Application\Actions\Action;
use App\Domain\Servico\ServicoRepository;
use Psr\Log\LoggerInterface;

abstract class ServicoAction extends Action
{
    protected ServicoRepository $ServicoRepository;

    public function __construct(LoggerInterface $logger, ServicoRepository $ServicoRepository)
    {
        parent::__construct($logger);
        $this->ServicoRepository = $ServicoRepository;
    }
}
