<?php

namespace ILOGO\Logoinc\Tests;

use Illuminate\Support\Facades\Auth;

class LoginTest extends TestCase
{
    public function testSuccessfulLoginWithDefaultCredentials()
    {
        $this->visit(route('logoinc.login'))
             ->type('admin@admin.com', 'email')
             ->type('password', 'password')
             ->press(__('logoinc::generic.login'))
             ->seePageIs(route('logoinc.dashboard'));
    }

    public function testShowAnErrorMessageWhenITryToLoginWithWrongCredentials()
    {
        session()->setPreviousUrl(route('logoinc.login'));

        $this->visit(route('logoinc.login'))
             ->type('john@Doe.com', 'email')
             ->type('pass', 'password')
             ->press(__('logoinc::generic.login'))
             ->seePageIs(route('logoinc.login'))
             ->see(__('auth.failed'))
             ->seeInField('email', 'john@Doe.com');
    }

    public function testRedirectIfLoggedIn()
    {
        Auth::loginUsingId(1);

        $this->visit(route('logoinc.login'))
             ->seePageIs(route('logoinc.dashboard'));
    }

    public function testRedirectIfNotLoggedIn()
    {
        $this->visit(route('logoinc.profile'))
             ->seePageIs(route('logoinc.login'));
    }

    public function testCanLogout()
    {
        Auth::loginUsingId(1);

        $this->visit(route('logoinc.dashboard'))
             ->press(__('logoinc::generic.logout'))
             ->seePageIs(route('logoinc.login'));
    }

    public function testGetsLockedOutAfterFiveAttempts()
    {
        session()->setPreviousUrl(route('logoinc.login'));

        for ($i = 0; $i <= 5; $i++) {
            $t = $this->visit(route('logoinc.login'))
                 ->type('john@Doe.com', 'email')
                 ->type('pass', 'password')
                 ->press(__('logoinc::generic.login'));
        }

        $t->see(__('auth.throttle', ['seconds' => 60]));
    }
}
