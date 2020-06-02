<?php

namespace ILOGO\Logoinc\Listeners;

use ILOGO\Logoinc\Events\BreadAdded;
use ILOGO\Logoinc\Facades\Logoinc;

class AddBreadPermission
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
     * Create Permission for a given BREAD.
     *
     * @param BreadAdded $event
     *
     * @return void
     */
    public function handle(BreadAdded $bread)
    {
        if (config('logoinc.bread.add_permission') && file_exists(base_path('routes/web.php'))) {
            // Create permission
            //
            // Permission::generateFor(Str::snake($bread->dataType->slug));
            $role = Logoinc::model('Role')->where('name', config('logoinc.bread.default_role'))->firstOrFail();

            // Get permission for added table
            $permissions = Logoinc::model('Permission')->where(['table_name' => $bread->dataType->name])->get()->pluck('id')->all();

            // Assign permission to admin
            $role->permissions()->attach($permissions);
        }
    }
}
