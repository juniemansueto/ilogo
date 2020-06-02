<?php

namespace ILOGO\Logoinc\Database\Types\Mysql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use ILOGO\Logoinc\Database\Types\Type;

class PointType extends Type
{
    const NAME = 'point';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'point';
    }
}
