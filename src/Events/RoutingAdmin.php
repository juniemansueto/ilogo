<?php

namespace ILOGO\Logoinc\Events;

use Illuminate\Queue\SerializesModels;

class RoutingAdmin
{
    use SerializesModels;

    public $router;

    public function __construct()
    {
        $this->router = app('router');

        // @deprecate
        //
        event('logoinc.admin.routing', $this->router);
    }
}
