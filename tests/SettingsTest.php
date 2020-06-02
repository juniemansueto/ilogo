<?php

namespace ILOGO\Logoinc\Tests;

use Illuminate\Support\Facades\Auth;
use ILOGO\Logoinc\Models\Setting;

class SettingsTest extends TestCase
{
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = Auth::loginUsingId(1);
        session()->setPreviousUrl(route('logoinc.settings.index'));
    }

    public function testCanUpdateSettings()
    {
        $key = 'site.title';
        $newTitle = 'Just Another LaravelLogoinc.com Site';

        $this->visit(route('logoinc.settings.index'))
             ->seeInField($key, Setting::where('key', '=', $key)->first()->value)
             ->type($newTitle, $key)
             ->seeInElement('button', __('logoinc::settings.save'))
             ->press(__('logoinc::settings.save'))
             ->seePageIs(route('logoinc.settings.index'))
             ->seeInDatabase('settings', [
                 'key'   => $key,
                 'value' => $newTitle,
             ]);
    }

    public function testCanCreateSetting()
    {
        $this->visitRoute('logoinc.settings.index')
             ->type('New Setting', 'display_name')
             ->type('new_setting', 'key')
             ->select('text', 'type')
             ->select('Site', 'group')
             ->press(__('logoinc::settings.add_new'))
             ->seePageIs(route('logoinc.settings.index'))
             ->seeInDatabase('settings', [
                 'display_name' => 'New Setting',
                 'key'          => 'site.new_setting',
                 'type'         => 'text',
                 'group'        => 'Site',
             ]);
    }

    public function testCanDeleteSetting()
    {
        $setting = Setting::firstOrFail();

        $this->call('DELETE', route('logoinc.settings.delete', $setting->id));

        $this->notSeeInDatabase('settings', [
            'id'    => $setting->id,
        ]);
    }

    public function testCanDeleteSettingsValue()
    {
        $setting = Setting::firstOrFail();
        $this->assertFalse(Setting::find($setting->id)->value == null);

        $this->call('PUT', route('logoinc.settings.delete_value', $setting->id));

        $this->seeInDatabase('settings', [
            'id'    => $setting->id,
            'value' => '',
        ]);
    }

    public function testCanMoveSettingUp()
    {
        $setting = Setting::where('order', '!=', 1)->first();

        $this->call('GET', route('logoinc.settings.move_up', $setting->id));

        $this->seeInDatabase('settings', [
            'id'    => $setting->id,
            'order' => ($setting->order - 1),
        ]);
    }

    public function testCanMoveSettingDown()
    {
        $setting = Setting::where('order', '!=', 1)->first();

        $this->call('GET', route('logoinc.settings.move_down', $setting->id));

        $this->seeInDatabase('settings', [
            'id'    => $setting->id,
            'order' => ($setting->order + 1),
        ]);
    }
}
