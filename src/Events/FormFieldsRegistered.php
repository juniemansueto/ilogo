<?php

namespace ILOGO\Logoinc\Events;

use Illuminate\Queue\SerializesModels;

class FormFieldsRegistered
{
    use SerializesModels;

    public $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;

        // @deprecate
        //
        event('logoinc.form-fields.registered', $fields);
    }
}
