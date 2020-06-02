<?php

namespace ILOGO\Logoinc\Widgets;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use ILOGO\Logoinc\Facades\Logoinc;

class PostDimmer extends BaseDimmer
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
        $count = Logoinc::model('Post')->count();
        $string = trans_choice('logoinc::dimmer.post', $count);

        return view('logoinc::dimmer', array_merge($this->config, [
            'icon'   => 'logoinc-news',
            'title'  => "{$count} {$string}",
            'text'   => __('logoinc::dimmer.post_text', ['count' => $count, 'string' => Str::lower($string)]),
            'button' => [
                'text' => __('logoinc::dimmer.post_link_text'),
                'link' => route('logoinc.posts.index'),
            ],
            'image' => logoinc_asset('images/widget-backgrounds/02.jpg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return Auth::user()->can('browse', Logoinc::model('Post'));
    }
}
