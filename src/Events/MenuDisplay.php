<?php

namespace ILOGO\Logoinc\Events;

use Illuminate\Queue\SerializesModels;
use ILOGO\Logoinc\Models\Menu;

class MenuDisplay
{
    use SerializesModels;

    public $menu;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;

        // @deprecate
        //
        event('logoinc.menu.display', $menu);
    }
}
