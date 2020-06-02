<?php

namespace ILOGO\Logoinc\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use ILOGO\Logoinc\Models\Role;
use ILOGO\Logoinc\Models\User;

class UserProfileTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected $editPageForTheCurrentUser;

    protected $listOfUsers;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = Auth::loginUsingId(1);

        $this->editPageForTheCurrentUser = route('logoinc.users.edit', [$this->user->id]);

        $this->listOfUsers = route('logoinc.users.index');

        $this->withFactories(__DIR__.'/database/factories');
    }

    public function testCanSeeTheUserInfoOnHisProfilePage()
    {
        $this->visit(route('logoinc.profile'))
             ->seeInElement('h4', $this->user->name)
             ->seeInElement('.user-email', $this->user->email)
             ->seeLink(__('logoinc::profile.edit'));
    }

    public function testCanEditUserName()
    {
        $this->visit(route('logoinc.profile'))
             ->click(__('logoinc::profile.edit'))
             ->see(__('logoinc::profile.edit_user'))
             ->seePageIs($this->editPageForTheCurrentUser)
             ->type('New Awesome Name', 'name')
             ->press(__('logoinc::generic.save'))
             ->seePageIs($this->listOfUsers)
             ->seeInDatabase(
                 'users',
                 ['name' => 'New Awesome Name']
             );
    }

    public function testCanEditUserEmail()
    {
        $this->visit(route('logoinc.profile'))
             ->click(__('logoinc::profile.edit'))
             ->see(__('logoinc::profile.edit_user'))
             ->seePageIs($this->editPageForTheCurrentUser)
             ->type('another@email.com', 'email')
             ->press(__('logoinc::generic.save'))
             ->seePageIs($this->listOfUsers)
             ->seeInDatabase(
                 'users',
                 ['email' => 'another@email.com']
             );
    }

    public function testCanEditUserPassword()
    {
        $this->visit(route('logoinc.profile'))
             ->click(__('logoinc::profile.edit'))
             ->see(__('logoinc::profile.edit_user'))
             ->seePageIs($this->editPageForTheCurrentUser)
             ->type('logoinc-rocks', 'password')
             ->press(__('logoinc::generic.save'))
             ->seePageIs($this->listOfUsers);

        $updatedPassword = DB::table('users')->where('id', 1)->first()->password;
        $this->assertTrue(Hash::check('logoinc-rocks', $updatedPassword));
    }

    public function testCanEditUserAvatar()
    {
        $this->visit(route('logoinc.profile'))
             ->click(__('logoinc::profile.edit'))
             ->see(__('logoinc::profile.edit_user'))
             ->seePageIs($this->editPageForTheCurrentUser)
             ->attach($this->newImagePath(), 'avatar')
             ->press(__('logoinc::generic.save'))
             ->seePageIs($this->listOfUsers)
             ->dontSeeInDatabase(
                 'users',
                 ['id' => 1, 'avatar' => 'user/default.png']
             );
    }

    public function testCanEditUserEmailWithEditorPermissions()
    {
        $user = factory(\ILOGO\Logoinc\Models\User::class)->create();
        $editPageForTheCurrentUser = route('logoinc.users.edit', [$user->id]);
        $roleId = $user->role_id;
        $role = Role::find($roleId);
        // add permissions which reflect a possible editor role
        // without permissions to edit  users
        $role->permissions()->attach(\ILOGO\Logoinc\Models\Permission::whereIn('key', [
            'browse_admin',
            'browse_users',
        ])->get()->pluck('id')->all());
        Auth::onceUsingId($user->id);
        $this->visit(route('logoinc.profile'))
             ->click(__('logoinc::profile.edit'))
             ->see(__('logoinc::profile.edit_user'))
             ->seePageIs($editPageForTheCurrentUser)
             ->type('another@email.com', 'email')
             ->press(__('logoinc::generic.save'))
             ->seePageIs($this->listOfUsers)
             ->seeInDatabase(
                 'users',
                 ['email' => 'another@email.com']
             );
    }

    public function testCanSetUserLocale()
    {
        $this->visit(route('logoinc.profile'))
             ->click(__('logoinc::profile.edit'))
             ->see(__('logoinc::profile.edit_user'))
             ->seePageIs($this->editPageForTheCurrentUser)
             ->select('de', 'locale')
             ->press(__('logoinc::generic.save'));

        $user = User::find(1);
        $this->assertTrue(($user->locale == 'de'));

        // Validate that app()->setLocale() is called
        Auth::loginUsingId($user->id);
        $this->visitRoute('logoinc.dashboard');
        $this->assertTrue(($user->locale == $this->app->getLocale()));
    }

    public function testRedirectBackAfterEditWithoutBrowsePermission()
    {
        $user = User::find(1);

        // Remove `browse_users` permission
        $user->role->permissions()->detach(
            $user->role->permissions()->where('key', 'browse_users')->first()
        );

        $this->visit($this->editPageForTheCurrentUser)
             ->press(__('logoinc::generic.save'))
             ->seePageIs($this->editPageForTheCurrentUser);
    }

    protected function newImagePath()
    {
        return realpath(__DIR__.'/temp/new_avatar.png');
    }
}
