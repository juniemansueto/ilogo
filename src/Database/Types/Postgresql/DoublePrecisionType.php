<?php

namespace ILOGO\Logoinc\Database\Types\Postgresql;

use ILOGO\Logoinc\Database\Types\Common\DoubleType;

class DoublePrecisionType extends DoubleType
{
    const NAME = 'double precision';
    const DBTYPE = 'float8';
}
