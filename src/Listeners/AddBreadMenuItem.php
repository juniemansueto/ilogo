<?php

namespace ILOGO\Logoinc\Listeners;

use ILOGO\Logoinc\Events\BreadAdded;
use ILOGO\Logoinc\Facades\Logoinc;

class AddBreadMenuItem
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
     * Create a MenuItem for a given BREAD.
     *
     * @param BreadAdded $event
     *
     * @return void
     */
    public function handle(BreadAdded $bread)
    {
        if (config('logoinc.bread.add_menu_item') && file_exists(base_path('routes/web.php'))) {
            $menu = Logoinc::model('Menu')->where('name', config('logoinc.bread.default_menu'))->firstOrFail();

            $menuItem = Logoinc::model('MenuItem')->firstOrNew([
                'menu_id' => $menu->id,
                'title'   => $bread->dataType->getTranslatedAttribute('display_name_plural'),
                'url'     => '',
                'route'   => 'logoinc.'.$bread->dataType->slug.'.index',
            ]);

            $order = Logoinc::model('MenuItem')->highestOrderMenuItem();

            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => $bread->dataType->icon,
                    'color'      => null,
                    'parent_id'  => null,
                    'order'      => $order,
                ])->save();
            }
        }
    }
}
