<?php
declare(strict_types=1);

namespace Dddtest\Domain\Util;

interface DomainModel extends \JsonSerializable
{
    public function events(): array;
}
