<?php

namespace ILOGO\Logoinc\Database\Types\Postgresql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use ILOGO\Logoinc\Database\Types\Type;

class GeometryType extends Type
{
    const NAME = 'geometry';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'geometry';
    }
}
