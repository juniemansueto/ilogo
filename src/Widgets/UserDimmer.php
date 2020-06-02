<?php

namespace ILOGO\Logoinc\Widgets;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use ILOGO\Logoinc\Facades\Logoinc;

class UserDimmer extends BaseDimmer
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = Logoinc::model('User')->count();
        $string = trans_choice('logoinc::dimmer.user', $count);

        return view('logoinc::dimmer', array_merge($this->config, [
            'icon'   => 'logoinc-group',
            'title'  => "{$count} {$string}",
            'text'   => __('logoinc::dimmer.user_text', ['count' => $count, 'string' => Str::lower($string)]),
            'button' => [
                'text' => __('logoinc::dimmer.user_link_text'),
                'link' => route('logoinc.users.index'),
            ],
            'image' => logoinc_asset('images/widget-backgrounds/01.jpg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return Auth::user()->can('browse', Logoinc::model('User'));
    }
}
