<?php

namespace ILOGO\Logoinc\Tests\Feature;

use Illuminate\Support\Facades\Auth;
use ILOGO\Logoinc\Facades\Logoinc;
use ILOGO\Logoinc\Tests\TestCase;

class DashboardTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->install();
    }

    /**
     * Test Dashboard Widgets.
     *
     * This test will make sure the configured widgets are being shown on
     * the dashboard page.
     */
    public function testWidgetsAreBeingShownOnDashboardPage()
    {
        // We must first login and visit the dashboard page.
        Auth::loginUsingId(1);

        $this->visit(route('logoinc.dashboard'))
            ->see(__('logoinc::generic.dashboard'));

        // Test UserDimmer widget
        $this->see(trans_choice('logoinc::dimmer.user', 1))
             ->click(__('logoinc::dimmer.user_link_text'))
             ->seePageIs(route('logoinc.users.index'))
             ->click(__('logoinc::generic.dashboard'))
             ->seePageIs(route('logoinc.dashboard'));

        // Test PostDimmer widget
        $this->see(trans_choice('logoinc::dimmer.post', 4))
             ->click(__('logoinc::dimmer.post_link_text'))
             ->seePageIs(route('logoinc.posts.index'))
             ->click(__('logoinc::generic.dashboard'))
             ->seePageIs(route('logoinc.dashboard'));

        // Test PageDimmer widget
        $this->see(trans_choice('logoinc::dimmer.page', 1))
             ->click(__('logoinc::dimmer.page_link_text'))
             ->seePageIs(route('logoinc.pages.index'))
             ->click(__('logoinc::generic.dashboard'))
             ->seePageIs(route('logoinc.dashboard'))
             ->see(__('logoinc::generic.dashboard'));
    }

    /**
     * UserDimmer widget isn't displayed without the right permissions.
     */
    public function testUserDimmerWidgetIsNotShownWithoutTheRightPermissions()
    {
        // We must first login and visit the dashboard page.
        $user = \Auth::loginUsingId(1);

        // Remove `browse_users` permission
        $user->role->permissions()->detach(
            $user->role->permissions()->where('key', 'browse_users')->first()
        );

        $this->visit(route('logoinc.dashboard'))
            ->see(__('logoinc::generic.dashboard'));

        // Test UserDimmer widget
        $this->dontSee('<h4>1 '.trans_choice('logoinc::dimmer.user', 1).'</h4>')
             ->dontSee(__('logoinc::dimmer.user_link_text'));
    }

    /**
     * PostDimmer widget isn't displayed without the right permissions.
     */
    public function testPostDimmerWidgetIsNotShownWithoutTheRightPermissions()
    {
        // We must first login and visit the dashboard page.
        $user = \Auth::loginUsingId(1);

        // Remove `browse_users` permission
        $user->role->permissions()->detach(
            $user->role->permissions()->where('key', 'browse_posts')->first()
        );

        $this->visit(route('logoinc.dashboard'))
            ->see(__('logoinc::generic.dashboard'));

        // Test PostDimmer widget
        $this->dontSee('<h4>1 '.trans_choice('logoinc::dimmer.post', 1).'</h4>')
             ->dontSee(__('logoinc::dimmer.post_link_text'));
    }

    /**
     * PageDimmer widget isn't displayed without the right permissions.
     */
    public function testPageDimmerWidgetIsNotShownWithoutTheRightPermissions()
    {
        // We must first login and visit the dashboard page.
        $user = \Auth::loginUsingId(1);

        // Remove `browse_users` permission
        $user->role->permissions()->detach(
            $user->role->permissions()->where('key', 'browse_pages')->first()
        );

        $this->visit(route('logoinc.dashboard'))
            ->see(__('logoinc::generic.dashboard'));

        // Test PageDimmer widget
        $this->dontSee('<h4>1 '.trans_choice('logoinc::dimmer.page', 1).'</h4>')
             ->dontSee(__('logoinc::dimmer.page_link_text'));
    }

    /**
     * Test See Correct Footer Version Number.
     *
     * This test will make sure the footer contains the correct version number.
     */
    public function testSeeingCorrectFooterVersionNumber()
    {
        // We must first login and visit the dashboard page.
        Auth::loginUsingId(1);

        $this->visit(route('logoinc.dashboard'))
             ->see(Logoinc::getVersion());
    }
}
