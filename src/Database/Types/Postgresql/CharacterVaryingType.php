<?php

namespace ILOGO\Logoinc\Database\Types\Postgresql;

use ILOGO\Logoinc\Database\Types\Common\VarCharType;

class CharacterVaryingType extends VarCharType
{
    const NAME = 'character varying';
    const DBTYPE = 'varchar';
}
