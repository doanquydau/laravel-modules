<?php

use Nwidart\Modules\Activators\FileActivator;

return [

    /*
    |--------------------------------------------------------------------------
    | Module Namespace
    |--------------------------------------------------------------------------
    |
    | Default module namespace.
    |
     */

    'namespace' => 'Modules',

    /*
    |--------------------------------------------------------------------------
    | Module Stubs
    |--------------------------------------------------------------------------
    |
    | Default module stubs.
    |
     */

    'stubs' => [
        'enabled' => false,
        'path' => base_path('vendor/nwidart/laravel-modules/src/Commands/stubs'),
        'files' => [
            'routes/web' => 'Routes/web.php',
            'routes/api' => 'Routes/api.php',
            'views/index' => 'Resources/views/index.blade.php',
            'views/master' => 'Resources/views/layouts/master.blade.php',
            'scaffold/config' => 'Config/config.php',
            'composer' => 'composer.json',
            'assets/js/app' => 'Resources/assets/js/app.js',
            'assets/sass/app' => 'Resources/assets/sass/app.scss',
            'webpack' => 'webpack.mix.js',
            'package' => 'package.json',
            'gamota/models/item' => 'Entities/Item.php',
            'gamota/models/item_log' => 'Entities/ItemLog.php',
            'gamota/models/role' => 'Entities/Role.php',
            'gamota/models/payment' => 'Entities/Payment.php',
            'gamota/models/configs' => 'Entities/Config.php',
            'gamota/models/share' => 'Entities/Share.php',
            'gamota/middlewares/AuthenticateHeaders' => 'Http/Middleware/AuthenticateHeaders.php',
            'gamota/middlewares/Maintenance' => 'Http/Middleware/Maintenance.php',
        ],
        'gamota' => [
            'item' => [
                'gamota/controllers/item/controller' => 'Http/Controllers/ItemController.php',
                'gamota/views/item/index' => 'Resources/views/item/index.blade.php',
                'gamota/views/item/create' => 'Resources/views/item/create.blade.php',
                'gamota/views/item/edit' => 'Resources/views/item/edit.blade.php',
                'gamota/migrations/items' => 'Database/Migrations/' . date('Y_m_d_H_i_s') . '_create_items_table.blade.php',
            ],
            'item_log' => [
                'gamota/controllers/item_log/controller' => 'Http/Controllers/ItemLogController.php',
                'gamota/views/item_log/index' => 'Resources/views/item_log/index.blade.php',
                'gamota/migrations/item_logs' => 'Database/Migrations/' . date('Y_m_d_H_i_s') . '_create_item_logs_table.blade.php',
            ],
            'role' => [
                'gamota/controllers/role/controller' => 'Http/Controllers/RoleController.php',
                'gamota/views/role/index' => 'Resources/views/role/index.blade.php',
                'gamota/migrations/roles' => 'Database/Migrations/' . date('Y_m_d_H_i_s') . '_create_roles_table.blade.php',
            ],
            'payment' => [
                'gamota/controllers/payment/controller' => 'Http/Controllers/PaymentController.php',
                'gamota/views/payment/index' => 'Resources/views/payment/index.blade.php',
                'gamota/migrations/payments' => 'Database/Migrations/' . date('Y_m_d_H_i_s') . '_create_payments_table.blade.php',
            ],
            'config' => [
                'gamota/controllers/config/controller' => 'Http/Controllers/ConfigController.php',
                'gamota/views/config/index' => 'Resources/views/config/index.blade.php',
                'gamota/migrations/configs' => 'Database/Migrations/' . date('Y_m_d_H_i_s') . '_create_configs_table.blade.php',
            ],
            'share' => [
                'gamota/controllers/share/controller' => 'Http/Controllers/ShareController.php',
                'gamota/migrations/shares' => 'Database/Migrations/' . date('Y_m_d_H_i_s') . '_create_shares_table.blade.php',
            ],
        ],
        'replacements' => [
            'routes/web' => ['LOWER_NAME', 'STUDLY_NAME'],
            'routes/api' => ['LOWER_NAME', 'STUDLY_NAME'],
            'webpack' => ['LOWER_NAME'],
            'json' => ['LOWER_NAME', 'STUDLY_NAME', 'MODULE_NAMESPACE', 'PROVIDER_NAMESPACE'],
            'views/index' => ['LOWER_NAME'],
            'views/master' => ['LOWER_NAME', 'STUDLY_NAME'],
            'scaffold/config' => ['STUDLY_NAME'],
            'composer' => [
                'LOWER_NAME',
                'STUDLY_NAME',
                'VENDOR',
                'AUTHOR_NAME',
                'AUTHOR_EMAIL',
                'MODULE_NAMESPACE',
                'PROVIDER_NAMESPACE',
            ],
            /* ===== Middleware ===== */
            'gamota/middlewares/AuthenticateHeaders' => ['LOWER_NAME', 'STUDLY_NAME'],
            'gamota/middlewares/Maintenance' => ['LOWER_NAME', 'STUDLY_NAME'],
            /* ===== Model ===== */
            'gamota/models/item' => ['MODULE_NAMESPACE', 'LOWER_NAME', 'STUDLY_NAME'],
            'gamota/models/item_log' => ['MODULE_NAMESPACE', 'LOWER_NAME', 'STUDLY_NAME'],
            'gamota/models/role' => ['MODULE_NAMESPACE', 'LOWER_NAME', 'STUDLY_NAME'],
            'gamota/models/payment' => ['MODULE_NAMESPACE', 'LOWER_NAME', 'STUDLY_NAME'],
            'gamota/models/configs' => ['MODULE_NAMESPACE', 'LOWER_NAME', 'STUDLY_NAME'],
            'gamota/models/share' => ['MODULE_NAMESPACE', 'LOWER_NAME', 'STUDLY_NAME'],
            /* ===== Controller ===== */
            'gamota/controllers/item/controller' => ['CLASS_NAMESPACE', 'LOWER_NAME', 'STUDLY_NAME'],
            'gamota/controllers/item_log/controller' => ['CLASS_NAMESPACE', 'LOWER_NAME', 'STUDLY_NAME'],
            'gamota/controllers/role/controller' => ['CLASS_NAMESPACE', 'LOWER_NAME', 'STUDLY_NAME'],
            'gamota/controllers/config/controller' => ['CLASS_NAMESPACE', 'LOWER_NAME', 'STUDLY_NAME'],
            'gamota/controllers/share/controller' => ['CLASS_NAMESPACE', 'LOWER_NAME', 'STUDLY_NAME'],
            'gamota/controllers/payment/controller' => ['CLASS_NAMESPACE', 'LOWER_NAME', 'STUDLY_NAME'],
            /* ===== Views ===== */
            'gamota/views/item/index' => ['LOWER_NAME'],
            'gamota/views/item/create' => ['LOWER_NAME'],
            'gamota/views/item/edit' => ['LOWER_NAME'],
            'gamota/views/item_log/index' => ['LOWER_NAME'],
            'gamota/views/role/index' => ['LOWER_NAME'],
            'gamota/views/payment/index' => ['LOWER_NAME'],
            'gamota/views/config/index' => ['LOWER_NAME'],
            /* ==== Migration ==== */
            'gamota/migrations/items' => ['LOWER_NAME'],
            'gamota/migrations/item_logs' => ['LOWER_NAME'],
            'gamota/migrations/roles' => ['LOWER_NAME'],
            'gamota/migrations/configs' => ['LOWER_NAME'],
            'gamota/migrations/payments' => ['LOWER_NAME'],
            'gamota/migrations/shares' => ['LOWER_NAME'],
        ],
        'gitkeep' => true,
    ],
    'paths' => [
        /*
        |--------------------------------------------------------------------------
        | Modules path
        |--------------------------------------------------------------------------
        |
        | This path used for save the generated module. This path also will be added
        | automatically to list of scanned folders.
        |
         */

        'modules' => base_path('Modules'),
        /*
        |--------------------------------------------------------------------------
        | Modules assets path
        |--------------------------------------------------------------------------
        |
        | Here you may update the modules assets path.
        |
         */

        'assets' => public_path('modules'),
        /*
        |--------------------------------------------------------------------------
        | The migrations path
        |--------------------------------------------------------------------------
        |
        | Where you run 'module:publish-migration' command, where do you publish the
        | the migration files?
        |
         */

        'migration' => base_path('database/migrations'),
        /*
        |--------------------------------------------------------------------------
        | Generator path
        |--------------------------------------------------------------------------
        | Customise the paths where the folders will be generated.
        | Set the generate key to false to not generate that folder
         */
        'generator' => [
            'config' => ['path' => 'Config', 'generate' => true],
            'command' => ['path' => 'Console', 'generate' => true],
            'migration' => ['path' => 'Database/Migrations', 'generate' => true],
            'seeder' => ['path' => 'Database/Seeders', 'generate' => true],
            'factory' => ['path' => 'Database/factories', 'generate' => true],
            'model' => ['path' => 'Entities', 'generate' => true],
            'routes' => ['path' => 'Routes', 'generate' => true],
            'controller' => ['path' => 'Http/Controllers', 'generate' => true],
            'filter' => ['path' => 'Http/Middleware', 'generate' => true],
            'request' => ['path' => 'Http/Requests', 'generate' => true],
            'provider' => ['path' => 'Providers', 'generate' => true],
            'assets' => ['path' => 'Resources/assets', 'generate' => true],
            'lang' => ['path' => 'Resources/lang', 'generate' => true],
            'views' => ['path' => 'Resources/views', 'generate' => true],
            'test' => ['path' => 'Tests/Unit', 'generate' => true],
            'test-feature' => ['path' => 'Tests/Feature', 'generate' => true],
            'repository' => ['path' => 'Repositories', 'generate' => false],
            'event' => ['path' => 'Events', 'generate' => false],
            'listener' => ['path' => 'Listeners', 'generate' => false],
            'policies' => ['path' => 'Policies', 'generate' => false],
            'rules' => ['path' => 'Rules', 'generate' => false],
            'jobs' => ['path' => 'Jobs', 'generate' => false],
            'emails' => ['path' => 'Emails', 'generate' => false],
            'notifications' => ['path' => 'Notifications', 'generate' => false],
            'resource' => ['path' => 'Transformers', 'generate' => false],
            'component-view' => ['path' => 'Resources/views/components', 'generate' => false],
            'component-class' => ['path' => 'View/Components', 'generate' => false],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Package commands
    |--------------------------------------------------------------------------
    |
    | Here you can define which commands will be visible and used in your
    | application. If for example you don't use some of the commands provided
    | you can simply comment them out.
    |
     */
    'commands' => [
        Commands\CommandMakeCommand::class,
        Commands\ComponentClassMakeCommand::class,
        Commands\ComponentViewMakeCommand::class,
        Commands\ControllerMakeCommand::class,
        Commands\DisableCommand::class,
        Commands\DumpCommand::class,
        Commands\EnableCommand::class,
        Commands\EventMakeCommand::class,
        Commands\JobMakeCommand::class,
        Commands\ListenerMakeCommand::class,
        Commands\MailMakeCommand::class,
        Commands\MiddlewareMakeCommand::class,
        Commands\NotificationMakeCommand::class,
        Commands\ProviderMakeCommand::class,
        Commands\RouteProviderMakeCommand::class,
        Commands\InstallCommand::class,
        Commands\ListCommand::class,
        Commands\ModuleDeleteCommand::class,
        Commands\ModuleMakeCommand::class,
        Commands\FactoryMakeCommand::class,
        Commands\PolicyMakeCommand::class,
        Commands\RequestMakeCommand::class,
        Commands\RuleMakeCommand::class,
        Commands\MigrateCommand::class,
        Commands\MigrateRefreshCommand::class,
        Commands\MigrateResetCommand::class,
        Commands\MigrateRollbackCommand::class,
        Commands\MigrateStatusCommand::class,
        Commands\MigrationMakeCommand::class,
        Commands\ModelMakeCommand::class,
        Commands\PublishCommand::class,
        Commands\PublishConfigurationCommand::class,
        Commands\PublishMigrationCommand::class,
        Commands\PublishTranslationCommand::class,
        Commands\SeedCommand::class,
        Commands\SeedMakeCommand::class,
        Commands\SetupCommand::class,
        Commands\UnUseCommand::class,
        Commands\UpdateCommand::class,
        Commands\UseCommand::class,
        Commands\ResourceMakeCommand::class,
        Commands\TestMakeCommand::class,
        Commands\LaravelModulesV6Migrator::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Scan Path
    |--------------------------------------------------------------------------
    |
    | Here you define which folder will be scanned. By default will scan vendor
    | directory. This is useful if you host the package in packagist website.
    |
     */

    'scan' => [
        'enabled' => false,
        'paths' => [
            base_path('vendor/*/*'),
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Composer File Template
    |--------------------------------------------------------------------------
    |
    | Here is the config for composer.json file, generated by this package
    |
     */

    'composer' => [
        'vendor' => 'nwidart',
        'author' => [
            'name' => 'Nicolas Widart',
            'email' => 'n.widart@gmail.com',
        ],
        'composer-output' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | Here is the config for setting up caching feature.
    |
     */
    'cache' => [
        'enabled' => false,
        'key' => 'laravel-modules',
        'lifetime' => 60,
    ],
    /*
    |--------------------------------------------------------------------------
    | Choose what laravel-modules will register as custom namespaces.
    | Setting one to false will require you to register that part
    | in your own Service Provider class.
    |--------------------------------------------------------------------------
     */
    'register' => [
        'translations' => true,
        /**
         * load files on boot or register method
         *
         * Note: boot not compatible with asgardcms
         *
         * @example boot|register
         */
        'files' => 'register',
    ],

    /*
    |--------------------------------------------------------------------------
    | Activators
    |--------------------------------------------------------------------------
    |
    | You can define new types of activators here, file, database etc. The only
    | required parameter is 'class'.
    | The file activator will store the activation status in storage/installed_modules
     */
    'activators' => [
        'file' => [
            'class' => FileActivator::class,
            'statuses-file' => base_path('modules_statuses.json'),
            'cache-key' => 'activator.installed',
            'cache-lifetime' => 604800,
        ],
    ],

    'activator' => 'file',
];
