<?php

namespace ILOGO\Logoinc\Events;

use Illuminate\Queue\SerializesModels;
use ILOGO\Logoinc\Models\DataType;

class BreadDataUpdated
{
    use SerializesModels;

    public $dataType;

    public $data;

    public function __construct(DataType $dataType, $data)
    {
        $this->dataType = $dataType;

        $this->data = $data;

        event(new BreadDataChanged($dataType, $data, 'Updated'));
    }
}
