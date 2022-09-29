<?php
declare(strict_types=1);

namespace App\Application\Actions\Servico;

use Psr\Http\Message\ResponseInterface as Response;

class ViewServicoAction extends ServicoAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $ServicoId = (int) $this->resolveArg('id');
        $Servico = $this->ServicoRepository->findServicoOfId($ServicoId);

        $this->logger->info("O Servico de id". $ServicoId ."foi visualizado.");

        return $this->respondWithData($Servico);
    }
}
