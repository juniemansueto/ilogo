<?php

namespace ILOGO\Logoinc\Database\Types\Sqlite;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use ILOGO\Logoinc\Database\Types\Type;

class RealType extends Type
{
    const NAME = 'real';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'real';
    }
}
