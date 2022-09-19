<?php
declare(strict_types=1);

namespace App\Domain\Livro;

use App\Domain\DomainException\DomainRecordNotFoundException;

class LivroNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The book you requested does not exist.';
}
