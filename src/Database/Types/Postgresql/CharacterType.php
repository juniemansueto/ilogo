<?php

namespace ILOGO\Logoinc\Database\Types\Postgresql;

use ILOGO\Logoinc\Database\Types\Common\CharType;

class CharacterType extends CharType
{
    const NAME = 'character';
    const DBTYPE = 'bpchar';
}
