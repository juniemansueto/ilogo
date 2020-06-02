<?php

use Illuminate\Database\Seeder;
use ILOGO\Logoinc\Models\DataType;

class DataTypesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $dataType = $this->dataType('slug', 'users');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'users',
                'display_name_singular' => __('logoinc::seeders.data_types.user.singular'),
                'display_name_plural'   => __('logoinc::seeders.data_types.user.plural'),
                'icon'                  => 'logoinc-person',
                'model_name'            => 'ILOGO\\Logoinc\\Models\\User',
                'policy_name'           => 'ILOGO\\Logoinc\\Policies\\UserPolicy',
                'controller'            => 'ILOGO\\Logoinc\\Http\\Controllers\\LogoincUserController',
                'generate_permissions'  => 1,
                'description'           => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'menus');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'menus',
                'display_name_singular' => __('logoinc::seeders.data_types.menu.singular'),
                'display_name_plural'   => __('logoinc::seeders.data_types.menu.plural'),
                'icon'                  => 'logoinc-list',
                'model_name'            => 'ILOGO\\Logoinc\\Models\\Menu',
                'controller'            => '',
                'generate_permissions'  => 1,
                'description'           => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'roles');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'roles',
                'display_name_singular' => __('logoinc::seeders.data_types.role.singular'),
                'display_name_plural'   => __('logoinc::seeders.data_types.role.plural'),
                'icon'                  => 'logoinc-lock',
                'model_name'            => 'ILOGO\\Logoinc\\Models\\Role',
                'controller'            => 'ILOGO\\Logoinc\\Http\\Controllers\\LogoincRoleController',
                'generate_permissions'  => 1,
                'description'           => '',
            ])->save();
        }
    }

    /**
     * [dataType description].
     *
     * @param [type] $field [description]
     * @param [type] $for   [description]
     *
     * @return [type] [description]
     */
    protected function dataType($field, $for)
    {
        return DataType::firstOrNew([$field => $for]);
    }
}
