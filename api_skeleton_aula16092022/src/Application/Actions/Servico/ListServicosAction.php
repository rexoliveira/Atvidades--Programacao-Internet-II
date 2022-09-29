<?php
declare(strict_types=1);

namespace App\Application\Actions\Servico;

use Psr\Http\Message\ResponseInterface as Response;

class ListServicosAction extends ServicoAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $Servicos = $this->ServicoRepository->findAll();

        $this->logger->info("A lista de serviços foi visualizada.");

        return $this->respondWithData($Servicos);
    }
}
