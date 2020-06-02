<?php

namespace ILOGO\Logoinc\Events;

use Illuminate\Queue\SerializesModels;

class RoutingAfter
{
    use SerializesModels;

    public $router;

    public function __construct()
    {
        $this->router = app('router');

        // @deprecate
        //
        event('logoinc.routing.after', $this->router);
    }
}
