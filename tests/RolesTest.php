<?php

namespace ILOGO\Logoinc\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use ILOGO\Logoinc\Models\Role;

class RolesTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testRoles()
    {
        $this->visit(route('logoinc.login'))
             ->type('admin@admin.com', 'email')
             ->type('password', 'password')
             ->press(__('logoinc::generic.login'))
             ->seePageIs(route('logoinc.dashboard'));

        // Adding a New Role
        $this->visit(route('logoinc.roles.create'))
             ->type('superadmin', 'name')
             ->type('Super Admin', 'display_name')
             ->press(__('logoinc::generic.submit'))
             ->seePageIs(route('logoinc.roles.index'))
             ->seeInDatabase('roles', ['name' => 'superadmin']);

        // Editing a Role
        $this->visit(route('logoinc.roles.edit', 2))
             ->type('regular_user', 'name')
             ->press(__('logoinc::generic.submit'))
             ->seePageIs(route('logoinc.roles.index'))
             ->seeInDatabase('roles', ['name' => 'regular_user']);

        // Editing a Role
        $this->visit(route('logoinc.roles.edit', 2))
             ->type('user', 'name')
             ->press(__('logoinc::generic.submit'))
             ->seePageIs(route('logoinc.roles.index'))
             ->seeInDatabase('roles', ['name' => 'user']);

        // Get the current super admin role
        $superadmin_role = Role::where('name', '=', 'superadmin')->first();

        // Deleting a Role
        $response = $this->call('DELETE', route('logoinc.roles.destroy', $superadmin_role->id), ['_token' => csrf_token()]);
        $this->assertEquals(302, $response->getStatusCode());
        $this->notSeeInDatabase('roles', ['name' => 'superadmin']);
    }
}
