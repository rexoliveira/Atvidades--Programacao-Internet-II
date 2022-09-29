<?php
declare(strict_types=1);

namespace App\Domain\Servico;

use App\Domain\DomainException\DomainRecordNotFoundException;

class ServicoNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'O Serviço que você solicitou não existe.';
}
