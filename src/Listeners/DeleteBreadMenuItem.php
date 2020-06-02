<?php

namespace ILOGO\Logoinc\Listeners;

use ILOGO\Logoinc\Events\BreadDeleted;
use ILOGO\Logoinc\Facades\Logoinc;

class DeleteBreadMenuItem
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Delete a MenuItem for a given BREAD.
     *
     * @param BreadDeleted $bread
     *
     * @return void
     */
    public function handle(BreadDeleted $bread)
    {
        if (config('logoinc.bread.add_menu_item')) {
            $menuItem = Logoinc::model('MenuItem')->where('route', 'logoinc.'.$bread->dataType->slug.'.index');

            if ($menuItem->exists()) {
                $menuItem->delete();
            }
        }
    }
}
