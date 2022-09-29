<?php
declare(strict_types=1);

namespace App\Domain\Servico;

interface ServicoRepository
{
    /**
     * @return Servico[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Servico
     * @throws ServicoNotFoundException
     */
    public function findServicoOfId(int $id): Servico;
}
