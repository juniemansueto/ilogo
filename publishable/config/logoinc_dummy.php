<?php

return [
    /*
    |--------------------------------------------------------------------------
    | User config
    |--------------------------------------------------------------------------
    |
    | Here you can specify logoinc user configs
    |
    */

    'user' => [
        'add_default_role_on_register' => true,
        'default_role'                 => 'user',
        'default_avatar'               => 'users/default.png',
        'redirect'                     => '/admin',
    ],

    /*
    |--------------------------------------------------------------------------
    | Controllers config
    |--------------------------------------------------------------------------
    |
    | Here you can specify logoinc controller settings
    |
    */

    'controllers' => [
        'namespace' => 'ILOGO\\Logoinc\\Http\\Controllers',
    ],

    /*
    |--------------------------------------------------------------------------
    | Models config
    |--------------------------------------------------------------------------
    |
    | Here you can specify default model namespace when creating BREAD.
    | Must include trailing backslashes. If not defined the default application
    | namespace will be used.
    |
    */

    'models' => [
        //'namespace' => 'App\\',
    ],

    /*
    |--------------------------------------------------------------------------
    | Storage Config
    |--------------------------------------------------------------------------
    |
    | Here you can specify attributes related to your application file system
    |
    */

    'storage' => [
        'disk' => env('FILESYSTEM_DRIVER', 'public'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Media Manager
    |--------------------------------------------------------------------------
    |
    | Here you can specify if media manager can show hidden files like(.gitignore)
    |
    */

    'hidden_files' => false,

    /*
    |--------------------------------------------------------------------------
    | Database Config
    |--------------------------------------------------------------------------
    |
    | Here you can specify logoinc database settings
    |
    */

    'database' => [
        'tables' => [
            'hidden' => ['migrations', 'data_rows', 'data_types', 'menu_items', 'password_resets', 'permission_role', 'settings'],
        ],
        'autoload_migrations' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Multilingual configuration
    |--------------------------------------------------------------------------
    |
    | Here you can specify if you want Logoinc to ship with support for
    | multilingual and what locales are enabled.
    |
    */

    'multilingual' => [
        /*
         * Set whether or not the multilingual is supported by the BREAD input.
         */
        'enabled' => false,

        /*
         * Select default language
         */
        'default' => 'en',

        /*
         * Select languages that are supported.
         */
        'locales' => [
            'en',
            //'pt',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dashboard config
    |--------------------------------------------------------------------------
    |
    | Here you can modify some aspects of your dashboard
    |
    */

    'dashboard' => [
        // Add custom list items to navbar's dropdown
        'navbar_items' => [
            'logoinc::generic.profile' => [
                'route'      => 'logoinc.profile',
                'classes'    => 'class-full-of-rum',
                'icon_class' => 'logoinc-person',
            ],
            'logoinc::generic.home' => [
                'route'        => '/',
                'icon_class'   => 'logoinc-home',
                'target_blank' => true,
            ],
            'logoinc::generic.logout' => [
                'route'      => 'logoinc.logout',
                'icon_class' => 'logoinc-power',
            ],
        ],

        'widgets' => [
            'ILOGO\\Logoinc\\Widgets\\UserDimmer',
            'ILOGO\\Logoinc\\Widgets\\PostDimmer',
            'ILOGO\\Logoinc\\Widgets\\PageDimmer',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Automatic Procedures
    |--------------------------------------------------------------------------
    |
    | When a change happens on Logoinc, we can automate some routines.
    |
    */

    'bread' => [
        // When a BREAD is added, create the Menu item using the BREAD properties.
        'add_menu_item' => true,

        // which menu add item to
        'default_menu' => 'admin',

        // When a BREAD is added, create the related Permission.
        'add_permission' => true,

        // which role add premissions to
        'default_role' => 'admin',
    ],

    /*
    |--------------------------------------------------------------------------
    | UI Generic Config
    |--------------------------------------------------------------------------
    |
    | Here you change some of the Logoinc UI settings.
    |
    */

    'primary_color' => '#22A7F0',

    'show_dev_tips' => true, // Show development tip "How To Use:" in Menu and Settings

    // Here you can specify additional assets you would like to be included in the master.blade
    'additional_css' => [
        //'css/custom.css',
    ],

    'additional_js' => [
        //'js/custom.js',
    ],

    'googlemaps' => [
        'key'    => env('GOOGLE_MAPS_KEY', ''),
        'center' => [
            'lat' => env('GOOGLE_MAPS_DEFAULT_CENTER_LAT', '32.715738'),
            'lng' => env('GOOGLE_MAPS_DEFAULT_CENTER_LNG', '-117.161084'),
        ],
        'zoom' => env('GOOGLE_MAPS_DEFAULT_ZOOM', 11),
    ],

    // Activate compass when environment is NOT local
    'compass_in_production' => false,

    'media' => [
        // The allowed mimetypes to be uploaded through the media-manager.
        'allowed_mimetypes' => '*', //All types can be uploaded
        /*
        'allowed_mimetypes' => [
          'image/jpeg',
          'image/png',
          'image/gif',
          'image/bmp',
          'video/mp4',
        ],
        */
        //Path for media-manager. Relative to the filesystem.
        'path'                => '/',
        'show_folders'        => true,
        'allow_upload'        => true,
        'allow_move'          => true,
        'allow_delete'        => true,
        'allow_create_folder' => true,
        'allow_rename'        => true,
        /*'watermark'           => [
            'source'         => 'watermark.png',
            'position'       => 'bottom-left',
            'x'              => 0,
            'y'              => 0,
            'size'           => 15,
       ],
       'thumbnails'          => [
           [
                'type'  => 'fit',
                'name'  => 'fit-500',
                'width' => 500,
                'height'=> 500
           ],
       ]*/
    ],
];
