<?php

namespace ILOGO\Logoinc\Database\Types\Postgresql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use ILOGO\Logoinc\Database\Types\Type;

class MacAddrType extends Type
{
    const NAME = 'macaddr';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'macaddr';
    }
}
