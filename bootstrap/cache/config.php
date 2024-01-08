<?php return array (
  'app' => 
  array (
    'name' => 'Laravel',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://localhost',
    'timezone' => 'UTC',
    'locale' => 'ru',
    'fallback_locale' => 'en',
    'key' => 'base64:Y0IzLuqfntgERHuS3oeKdPTxziMwvqJ3iNFKcZRRJ1k=',
    'cipher' => 'AES-256-CBC',
    'log' => 'single',
    'log_level' => 'debug',
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      15 => 'Illuminate\\Queue\\QueueServiceProvider',
      16 => 'Illuminate\\Redis\\RedisServiceProvider',
      17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      18 => 'Illuminate\\Session\\SessionServiceProvider',
      19 => 'Illuminate\\Translation\\TranslationServiceProvider',
      20 => 'Illuminate\\Validation\\ValidationServiceProvider',
      21 => 'Illuminate\\View\\ViewServiceProvider',
      22 => 'Laravel\\Tinker\\TinkerServiceProvider',
      23 => 'App\\Providers\\AppServiceProvider',
      24 => 'App\\Providers\\AuthServiceProvider',
      25 => 'App\\Providers\\EventServiceProvider',
      26 => 'App\\Providers\\RouteServiceProvider',
      27 => 'SleepingOwl\\Admin\\Providers\\SleepingOwlServiceProvider',
      28 => 'Intervention\\Image\\ImageServiceProvider',
      29 => 'Barryvdh\\LaravelIdeHelper\\IdeHelperServiceProvider',
      30 => 'Collective\\Html\\HtmlServiceProvider',
      31 => 'Maatwebsite\\Excel\\ExcelServiceProvider',
      32 => 'Lavary\\Menu\\ServiceProvider',
      33 => 'Cmgmyr\\Messenger\\MessengerServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Redis' => 'Illuminate\\Support\\Facades\\Redis',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Form' => 'Collective\\Html\\FormFacade',
      'Html' => 'Collective\\Html\\HtmlFacade',
      'Excel' => 'Maatwebsite\\Excel\\Facades\\Excel',
      'UserI' => 'App\\Helpers\\UserInterface',
      'UImage' => 'App\\Helpers\\UploadImage',
      'Menu' => 'Lavary\\Menu\\Facade',
      'Image' => 'Intervention\\Image\\Facades\\Image',
    ),
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'api' => 
      array (
        'driver' => 'token',
        'provider' => 'users',
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_resets',
        'expire' => 60,
      ),
    ),
  ),
  'broadcasting' => 
  array (
    'default' => 'null',
    'connections' => 
    array (
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => '209256',
        'options' => 
        array (
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'cache' => 
  array (
    'default' => 'file',
    'stores' => 
    array (
      'apc' => 
      array (
        'driver' => 'apc',
      ),
      'array' => 
      array (
        'driver' => 'array',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => '/Users/artemperlov/Sites/upbrain3/storage/framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
    ),
    'prefix' => 'laravel',
  ),
  'compile' => 
  array (
    'files' => 
    array (
      0 => '/Users/artemperlov/Sites/upbrain3/app/Providers/AppServiceProvider.php',
      1 => '/Users/artemperlov/Sites/upbrain3/app/Providers/BusServiceProvider.php',
      2 => '/Users/artemperlov/Sites/upbrain3/app/Providers/ConfigServiceProvider.php',
      3 => '/Users/artemperlov/Sites/upbrain3/app/Providers/EventServiceProvider.php',
      4 => '/Users/artemperlov/Sites/upbrain3/app/Providers/RouteServiceProvider.php',
    ),
    'providers' => 
    array (
    ),
  ),
  'database' => 
  array (
    'default' => 'mysql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'database' => 'upbrain3',
        'prefix' => '',
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'upbrain3',
        'username' => 'root',
        'password' => '122',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'strict' => false,
        'engine' => NULL,
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'host' => '127.0.0.1',
        'port' => '5432',
        'database' => 'upbrain3',
        'username' => 'root',
        'password' => '122',
        'charset' => 'utf8',
        'prefix' => '',
        'schema' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'host' => '127.0.0.1',
        'port' => '1433',
        'database' => 'upbrain3',
        'username' => 'root',
        'password' => '122',
        'charset' => 'utf8',
        'prefix' => '',
      ),
    ),
    'migrations' => 'migrations',
    'redis' => 
    array (
      'client' => 'predis',
      'default' => 
      array (
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => 6379,
        'database' => 0,
      ),
    ),
  ),
  'excel' => 
  array (
    'exports' => 
    array (
      'chunk_size' => 1000,
      'pre_calculate_formulas' => false,
      'csv' => 
      array (
        'delimiter' => ',',
        'enclosure' => '"',
        'line_ending' => '
',
        'use_bom' => false,
        'include_separator_line' => false,
        'excel_compatibility' => false,
      ),
    ),
    'imports' => 
    array (
      'read_only' => true,
      'heading_row' => 
      array (
        'formatter' => 'slug',
      ),
      'csv' => 
      array (
        'delimiter' => ',',
        'enclosure' => '"',
        'escape_character' => '\\',
        'contiguous' => false,
        'input_encoding' => 'UTF-8',
      ),
    ),
    'extension_detector' => 
    array (
      'xlsx' => 'Xlsx',
      'xlsm' => 'Xlsx',
      'xltx' => 'Xlsx',
      'xltm' => 'Xlsx',
      'xls' => 'Xls',
      'xlt' => 'Xls',
      'ods' => 'Ods',
      'ots' => 'Ods',
      'slk' => 'Slk',
      'xml' => 'Xml',
      'gnumeric' => 'Gnumeric',
      'htm' => 'Html',
      'html' => 'Html',
      'csv' => 'Csv',
      'tsv' => 'Csv',
      'pdf' => 'Dompdf',
    ),
    'value_binder' => 
    array (
      'default' => 'Maatwebsite\\Excel\\DefaultValueBinder',
    ),
    'cache' => 
    array (
      'driver' => 'memory',
      'batch' => 
      array (
        'memory_limit' => 60000,
      ),
      'illuminate' => 
      array (
        'store' => NULL,
      ),
      'default_ttl' => 10800,
    ),
    'transactions' => 
    array (
      'handler' => 'db',
    ),
    'temporary_files' => 
    array (
      'local_path' => '/var/tmp/',
      'remote_disk' => NULL,
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'cloud' => 's3',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => '/Users/artemperlov/Sites/upbrain3/storage/app',
        'url' => '/storage',
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => '/Users/artemperlov/Sites/upbrain3/public/',
        'url' => '/public',
        'visibility' => 'public',
      ),
      'images' => 
      array (
        'driver' => 'local',
        'root' => '/Users/artemperlov/Sites/upbrain3/public/images',
        'url' => '/public',
        'visibility' => 'public',
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => NULL,
        'secret' => NULL,
        'region' => NULL,
        'bucket' => NULL,
      ),
    ),
  ),
  'ide-helper' => 
  array (
    'filename' => '_ide_helper',
    'models_filename' => '_ide_helper_models.php',
    'meta_filename' => '.phpstorm.meta.php',
    'include_fluent' => false,
    'include_factory_builders' => false,
    'write_model_magic_where' => true,
    'write_model_external_builder_methods' => true,
    'write_model_relation_count_properties' => true,
    'write_eloquent_model_mixins' => false,
    'include_helpers' => false,
    'helper_files' => 
    array (
      0 => '/Users/artemperlov/Sites/upbrain3/vendor/laravel/framework/src/Illuminate/Support/helpers.php',
    ),
    'model_locations' => 
    array (
      0 => 'app',
    ),
    'ignored_models' => 
    array (
    ),
    'model_hooks' => 
    array (
    ),
    'extra' => 
    array (
      'Eloquent' => 
      array (
        0 => 'Illuminate\\Database\\Eloquent\\Builder',
        1 => 'Illuminate\\Database\\Query\\Builder',
      ),
      'Session' => 
      array (
        0 => 'Illuminate\\Session\\Store',
      ),
    ),
    'magic' => 
    array (
      'Log' => 
      array (
        'debug' => 'Monolog\\Logger::addDebug',
        'info' => 'Monolog\\Logger::addInfo',
        'notice' => 'Monolog\\Logger::addNotice',
        'warning' => 'Monolog\\Logger::addWarning',
        'error' => 'Monolog\\Logger::addError',
        'critical' => 'Monolog\\Logger::addCritical',
        'alert' => 'Monolog\\Logger::addAlert',
        'emergency' => 'Monolog\\Logger::addEmergency',
      ),
    ),
    'interfaces' => 
    array (
    ),
    'custom_db_types' => 
    array (
    ),
    'model_camel_case_properties' => false,
    'type_overrides' => 
    array (
      'integer' => 'int',
      'boolean' => 'bool',
    ),
    'include_class_docblocks' => false,
    'force_fqn' => false,
    'additional_relation_types' => 
    array (
    ),
    'post_migrate' => 
    array (
    ),
    'format' => 'php',
  ),
  'image' => 
  array (
    'driver' => 'gd',
  ),
  'imagecache' => 
  array (
    'route' => 'img/cache',
    'paths' => 
    array (
      0 => '/Users/artemperlov/Sites/upbrain3/public/upload',
      1 => '/Users/artemperlov/Sites/upbrain3/public/images',
    ),
    'templates' => 
    array (
      'small' => 'Intervention\\Image\\Templates\\Small',
      'medium' => 'Intervention\\Image\\Templates\\Medium',
      'large' => 'Intervention\\Image\\Templates\\Large',
    ),
    'lifetime' => 43200,
  ),
  'logging' => 
  array (
    'default' => 'single',
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'single',
        ),
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => '/Users/artemperlov/Sites/upbrain3/storage/logs/laravel.log',
        'level' => 'debug',
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => '/Users/artemperlov/Sites/upbrain3/storage/logs/laravel.log',
        'level' => 'debug',
        'days' => 7,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'critical',
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'with' => 
        array (
          'stream' => 'php://stderr',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'debug',
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
      ),
    ),
  ),
  'mail' => 
  array (
    'driver' => 'smtp',
    'host' => 'smtp.googlemail.com',
    'port' => '465',
    'from' => 
    array (
      'address' => 'email@upbrain.ru',
      'name' => 'Upbrain',
    ),
    'encryption' => 'ssl',
    'username' => 'upbrainschool@gmail.com',
    'password' => 'akfmvhzalrsbergh',
    'sendmail' => '/usr/sbin/sendmail -bs',
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => '/Users/artemperlov/Sites/upbrain3/resources/views/vendor/mail',
      ),
    ),
  ),
  'messenger' => 
  array (
    'message_model' => 'App\\Models\\Message',
    'participant_model' => 'Cmgmyr\\Messenger\\Models\\Participant',
    'thread_model' => 'Cmgmyr\\Messenger\\Models\\Thread',
    'messages_table' => 'messenger_messages',
    'participants_table' => 'messenger_participants',
    'threads_table' => 'messenger_threads',
    'user_model' => 'App\\User',
  ),
  'pusher' => 
  array (
    'appId' => '209256',
    'appKey' => 'a18b03862638dafebf9b',
    'appSecret' => '0167f1b7be19cdcd0ace',
  ),
  'queue' => 
  array (
    'default' => 'sync',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => 'your-public-key',
        'secret' => 'your-secret-key',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'your-queue-name',
        'region' => 'us-east-1',
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
      ),
    ),
    'failed' => 
    array (
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'services' => 
  array (
    'mailgun' => 
    array (
      'domain' => 'upbrain.ru',
      'secret' => 'key-ceda4acee004a424a67ed5a38b55eeb4',
    ),
    'ses' => 
    array (
      'key' => NULL,
      'secret' => NULL,
      'region' => 'us-east-1',
    ),
    'sparkpost' => 
    array (
      'secret' => NULL,
    ),
    'stripe' => 
    array (
      'model' => 'App\\User',
      'key' => NULL,
      'secret' => NULL,
    ),
  ),
  'session' => 
  array (
    'driver' => 'file',
    'lifetime' => 120,
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => '/Users/artemperlov/Sites/upbrain3/storage/framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'laravel_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => false,
    'http_only' => true,
  ),
  'sleeping_owl' => 
  array (
    'show_footer' => false,
    'footer_text' => 'All rights reserved',
    'show_version' => true,
    'version_text' => '',
    'title' => 'UPbrain',
    'logo_mini' => 'UP',
    'menu_top' => 'Main menu',
    'body_default_class' => 'hold-transition sidebar-mini sidebar-open',
    'logo' => '<svg style="padding:10px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 216.123 216.123" style="enable-background:new 0 0 216.123 216.123;" xml:space="preserve" width="48px" height="48px"><g><path d="M173.65,106.51c6.549-7.024,10.567-16.436,10.567-26.774c0-8.585-2.775-16.529-7.464-23.001   c5.319-16.633,5.063-34.71-0.795-51.16L173.974,0l-5.827,1.03c-12.002,2.121-23.325,6.931-33.201,14.037H81.537v0.252   C71.577,8.071,60.122,3.176,47.977,1.03L42.149,0l-1.985,5.575c-5.858,16.45-6.114,34.527-0.795,51.16   c-4.689,6.472-7.464,14.417-7.464,23.001c0,10.338,4.018,19.75,10.567,26.773c-1.028,0.797-1.846,1.88-2.308,3.179   c-10.874,30.534-2.352,64.292,21.71,86c1.048,0.945,2.171,1.862,3.332,2.761v10.673c0,3.866,3.134,7,7,7s7-3.134,7-7v-2.194   c8.347,3.957,17.834,6.887,27.532,8.373c0.352,0.054,0.706,0.081,1.06,0.081s0.708-0.027,1.06-0.081   c4.446-0.681,16.123-2.878,28.059-8.434v2.255c0,3.866,3.134,7,7,7s7-3.134,7-7v-10.656c1.139-0.883,2.254-1.805,3.332-2.777   c24.062-21.709,32.583-55.466,21.71-86C175.496,108.389,174.678,107.306,173.65,106.51z M107.969,152.066   c-4.506-10.226-11.165-19.465-19.743-27.206c-2.717-2.451-5.583-4.7-8.571-6.748c13.12-2.887,23.804-12.341,28.406-24.734   c4.602,12.393,15.286,21.847,28.406,24.734c-2.988,2.048-5.854,4.297-8.57,6.748C119.346,132.575,112.595,141.88,107.969,152.066z    M71.206,54.436c13.951,0,25.301,11.35,25.301,25.301s-11.35,25.301-25.301,25.301s-25.301-11.35-25.301-25.301   S57.255,54.436,71.206,54.436z M170.218,79.736c0,13.951-11.35,25.301-25.301,25.301s-25.301-11.35-25.301-25.301   s11.35-25.301,25.301-25.301S170.218,65.786,170.218,79.736z M108.041,48.088c-3.04-6.825-7.023-13.231-11.845-19.021h23.699   C115.052,34.867,111.074,41.273,108.041,48.088z M164.562,16.17c2.468,9.767,2.65,20.018,0.566,29.875   c-5.909-3.558-12.824-5.61-20.21-5.61c-7.254,0-14.05,1.983-19.889,5.425c3.327-5.397,7.423-10.367,12.248-14.72   C145.142,24.043,154.479,18.934,164.562,16.17z M51.562,16.17c10.082,2.763,19.419,7.872,27.286,14.97   c4.792,4.324,8.877,9.293,12.205,14.695c-5.83-3.426-12.61-5.401-19.847-5.401c-7.386,0-14.301,2.051-20.21,5.61   C48.912,36.188,49.094,25.937,51.562,16.17z M51.555,120.283c10.084,2.763,19.425,7.873,27.293,14.972   c13.908,12.549,21.704,29.884,21.95,48.812v15.742c-10.093-2.564-21.543-7.294-29.546-14.514   C52.951,168.783,45.553,143.818,51.555,120.283z M144.871,185.295c-7.99,7.21-19.708,11.96-30.073,14.539v-15.766   c0.239-18.349,8.431-36.14,22.478-48.813c7.868-7.1,17.209-12.209,27.293-14.972C170.57,143.818,163.172,168.783,144.871,185.295z" fill="#FFFFFF"/><circle cx="71.206" cy="79.736" r="9.757" fill="#FFFFFF"/><circle cx="144.917" cy="79.736" r="9.757" fill="#FFFFFF"/></g></svg><span class="brand-text font-weight-light">Upbrain</span>',
    'url_prefix' => 'admin',
    'domain' => false,
    'middleware' => 
    array (
      0 => 'web',
      1 => 'admin',
    ),
    'favicon' => '/packages/sleepingowl/default/images/favicon.ico',
    'dev_assets' => false,
    'env_editor_url' => 'env/editor',
    'env_editor_excluded_keys' => 
    array (
      0 => 'APP_KEY',
      1 => 'DB_*',
    ),
    'env_editor_middlewares' => 
    array (
    ),
    'enable_editor' => false,
    'env_keys_readonly' => false,
    'env_can_delete' => true,
    'env_can_add' => true,
    'env_editor_policy' => '',
    'state_datatables' => true,
    'default_datatables_method' => 'GET',
    'state_tabs' => false,
    'state_filters' => false,
    'auth_provider' => 'users',
    'bootstrapDirectory' => '/Users/artemperlov/Sites/upbrain3/app/Admin',
    'imagesUploadDirectory' => 'images/uploads',
    'imageLazyLoad' => false,
    'imageLazyLoadFile' => 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==',
    'imagesAllowedExtensions' => 
    array (
      0 => 'jpg',
      1 => 'jpeg',
      2 => 'png',
      3 => 'gif',
      4 => 'bmp',
      5 => 'svg',
      6 => 'webp',
      7 => 'ico',
      8 => 'jpe',
    ),
    'imagesAllowSvg' => false,
    'imagesUploadFilenameBehavior' => 'UPLOAD_HASH',
    'filesUploadDirectory' => 'files/uploads',
    'filesAllowedExtensions' => 
    array (
    ),
    'filesUploadFilenameBehavior' => 'UPLOAD_HASH',
    'template' => 'SleepingOwl\\Admin\\Templates\\TemplateDefault',
    'show_mode' => true,
    'datetimeFormat' => 'd.m.Y H:i',
    'dateFormat' => 'd.m.Y',
    'timeFormat' => 'H:i',
    'timezone' => 'UTC',
    'useWysiwygCard' => false,
    'useRelationCard' => false,
    'useHasManyLocalCard' => false,
    'wysiwyg_cdn' => 
    array (
      'ckeditor5' => 
      array (
        'useCdn' => false,
        'ver' => '36.0.1',
      ),
      'tinymce' => 
      array (
        'api' => 'no-api-key',
        'ver' => 4,
      ),
    ),
    'wysiwyg' => 
    array (
      'default' => 'ckeditor',
      'ckeditor' => 
      array (
        'defaultLanguage' => 'ru',
        'height' => 200,
        'allowedContent' => true,
        'extraPlugins' => 'uploadimage,image2,justify,youtube,uploadfile',
        'uploadUrl' => '/admin/ckeditor/upload',
        'filebrowserUploadUrl' => '/admin/ckeditor/upload',
      ),
      'tinymce' => 
      array (
        'height' => 200,
      ),
      'simplemde' => 
      array (
        'hideIcons' => 
        array (
          0 => 'side-by-side',
          1 => 'fullscreen',
        ),
      ),
      'summernote' => 
      array (
        'height' => 200,
        'lang' => 'ru-RU',
        'codemirror' => 
        array (
          'theme' => 'monokai',
        ),
      ),
      'ckeditor5' => 
      array (
        'language' => 'ru',
        'alignment' => 
        array (
          'options' => 
          array (
            0 => 'left',
            1 => 'right',
          ),
        ),
        'toolbar' => 
        array (
          0 => 'undo',
          1 => 'redo',
          2 => '|',
          3 => 'heading',
          4 => '|',
          5 => 'bold',
          6 => 'italic',
          7 => 'blockQuote',
          8 => '|',
          9 => 'numberedList',
          10 => 'bulletedList',
          11 => '|',
          12 => 'CKFinder',
          13 => 'ImageUpload',
          14 => 'imageTextAlternative',
          15 => 'MediaEmbed',
          16 => 'imageStyle:full',
          17 => 'imageStyle:side',
          18 => '|',
          19 => 'link',
          20 => 'bulletedList',
          21 => 'numberedList',
          22 => '|',
          23 => 'insertTable',
          24 => 'tableColumn',
          25 => 'tableRow',
          26 => 'mergeTableCells',
          27 => '|',
        ),
        'uploadUrl' => '/storage/images_admin',
        'filebrowserUploadUrl' => '/storage/images_admin',
      ),
    ),
    'datatables' => 
    array (
    ),
    'datatables_highlight' => false,
    'breadcrumbs' => true,
    'dt_autoupdate' => false,
    'dt_autoupdate_interval' => 5,
    'dt_autoupdate_class' => '',
    'dt_autoupdate_color' => '#dc3545',
    'scroll_to_top' => true,
    'scroll_to_bottom' => true,
    'aliases' => 
    array (
      'Assets' => 'KodiCMS\\Assets\\Facades\\Assets',
      'PackageManager' => 'KodiCMS\\Assets\\Facades\\PackageManager',
      'Meta' => 'KodiCMS\\Assets\\Facades\\Meta',
      'Form' => 'Collective\\Html\\FormFacade',
      'HTML' => 'Collective\\Html\\HtmlFacade',
      'WysiwygManager' => 'SleepingOwl\\Admin\\Facades\\WysiwygManager',
      'MessagesStack' => 'SleepingOwl\\Admin\\Facades\\MessageStack',
      'AdminSection' => 'SleepingOwl\\Admin\\Facades\\Admin',
      'AdminTemplate' => 'SleepingOwl\\Admin\\Facades\\Template',
      'AdminNavigation' => 'SleepingOwl\\Admin\\Facades\\Navigation',
      'AdminColumn' => 'SleepingOwl\\Admin\\Facades\\TableColumn',
      'AdminColumnEditable' => 'SleepingOwl\\Admin\\Facades\\TableColumnEditable',
      'AdminColumnFilter' => 'SleepingOwl\\Admin\\Facades\\TableColumnFilter',
      'AdminDisplayFilter' => 'SleepingOwl\\Admin\\Facades\\DisplayFilter',
      'AdminForm' => 'SleepingOwl\\Admin\\Facades\\Form',
      'AdminFormElement' => 'SleepingOwl\\Admin\\Facades\\FormElement',
      'AdminDisplay' => 'SleepingOwl\\Admin\\Facades\\Display',
      'AdminWidgets' => 'SleepingOwl\\Admin\\Facades\\Widgets',
    ),
    'show_editor' => false,
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => '/Users/artemperlov/Sites/upbrain3/resources/views',
    ),
    'compiled' => '/Users/artemperlov/Sites/upbrain3/storage/framework/views',
  ),
  'debugbar' => 
  array (
    'enabled' => true,
    'except' => 
    array (
      0 => 'telescope*',
      1 => 'horizon*',
    ),
    'storage' => 
    array (
      'enabled' => true,
      'open' => false,
      'driver' => 'file',
      'path' => '/Users/artemperlov/Sites/upbrain3/storage/debugbar',
      'connection' => NULL,
      'provider' => '',
      'hostname' => '127.0.0.1',
      'port' => 2304,
    ),
    'editor' => 'phpstorm',
    'remote_sites_path' => '',
    'local_sites_path' => '',
    'include_vendors' => true,
    'capture_ajax' => true,
    'add_ajax_timing' => false,
    'error_handler' => false,
    'clockwork' => false,
    'collectors' => 
    array (
      'phpinfo' => true,
      'messages' => true,
      'time' => true,
      'memory' => true,
      'exceptions' => true,
      'log' => true,
      'db' => true,
      'views' => true,
      'route' => true,
      'auth' => false,
      'gate' => true,
      'session' => true,
      'symfony_request' => true,
      'mail' => true,
      'laravel' => false,
      'events' => false,
      'default_request' => false,
      'logs' => false,
      'files' => false,
      'config' => false,
      'cache' => false,
      'models' => true,
      'livewire' => true,
    ),
    'options' => 
    array (
      'auth' => 
      array (
        'show_name' => true,
      ),
      'db' => 
      array (
        'with_params' => true,
        'backtrace' => true,
        'backtrace_exclude_paths' => 
        array (
        ),
        'timeline' => false,
        'duration_background' => true,
        'explain' => 
        array (
          'enabled' => false,
          'types' => 
          array (
            0 => 'SELECT',
          ),
        ),
        'hints' => false,
        'show_copy' => false,
        'slow_threshold' => false,
      ),
      'mail' => 
      array (
        'full_log' => false,
      ),
      'views' => 
      array (
        'timeline' => false,
        'data' => false,
        'exclude_paths' => 
        array (
        ),
      ),
      'route' => 
      array (
        'label' => true,
      ),
      'logs' => 
      array (
        'file' => NULL,
      ),
      'cache' => 
      array (
        'values' => true,
      ),
    ),
    'inject' => true,
    'route_prefix' => '_debugbar',
    'route_domain' => NULL,
    'theme' => 'auto',
    'debug_backtrace_limit' => 50,
  ),
  'lang-publisher-private' => 
  array (
    'plugins' => 
    array (
      '/Users/artemperlov/Sites/upbrain3/vendor/laravel-lang/lang' => 
      array (
        0 => 'LaravelLang\\Lang\\Plugins\\Breeze\\Master',
        1 => 'LaravelLang\\Lang\\Plugins\\Breeze\\V1',
        2 => 'LaravelLang\\Lang\\Plugins\\Cashier\\Stripe\\Master',
        3 => 'LaravelLang\\Lang\\Plugins\\Cashier\\Stripe\\V12',
        4 => 'LaravelLang\\Lang\\Plugins\\Cashier\\Stripe\\V13',
        5 => 'LaravelLang\\Lang\\Plugins\\Cashier\\Stripe\\V14',
        6 => 'LaravelLang\\Lang\\Plugins\\Fortify\\Master',
        7 => 'LaravelLang\\Lang\\Plugins\\Fortify\\V1',
        8 => 'LaravelLang\\Lang\\Plugins\\Jetstream\\Master',
        9 => 'LaravelLang\\Lang\\Plugins\\Jetstream\\V1',
        10 => 'LaravelLang\\Lang\\Plugins\\Jetstream\\V2',
        11 => 'LaravelLang\\Lang\\Plugins\\Jetstream\\V3',
        12 => 'LaravelLang\\Lang\\Plugins\\Laravel\\Master',
        13 => 'LaravelLang\\Lang\\Plugins\\Laravel\\V10',
        14 => 'LaravelLang\\Lang\\Plugins\\Laravel\\V9',
        15 => 'LaravelLang\\Lang\\Plugins\\Lumen\\Master',
        16 => 'LaravelLang\\Lang\\Plugins\\Lumen\\V10',
        17 => 'LaravelLang\\Lang\\Plugins\\Lumen\\V9',
        18 => 'LaravelLang\\Lang\\Plugins\\Nova\\DuskSuite\\Main',
        19 => 'LaravelLang\\Lang\\Plugins\\Nova\\LogViewer\\Main',
        20 => 'LaravelLang\\Lang\\Plugins\\Nova\\V3',
        21 => 'LaravelLang\\Lang\\Plugins\\Nova\\V4',
        22 => 'LaravelLang\\Lang\\Plugins\\Spark\\Aurelius\\Master',
        23 => 'LaravelLang\\Lang\\Plugins\\Spark\\Aurelius\\V11',
        24 => 'LaravelLang\\Lang\\Plugins\\Spark\\Aurelius\\V12',
        25 => 'LaravelLang\\Lang\\Plugins\\Spark\\AureliusMollie\\V2',
        26 => 'LaravelLang\\Lang\\Plugins\\Spark\\Paddle',
        27 => 'LaravelLang\\Lang\\Plugins\\Spark\\Stripe',
        28 => 'LaravelLang\\Lang\\Plugins\\UI\\Master',
        29 => 'LaravelLang\\Lang\\Plugins\\UI\\V3',
        30 => 'LaravelLang\\Lang\\Plugins\\UI\\V4',
      ),
    ),
    'packages' => 
    array (
      '/Users/artemperlov/Sites/upbrain3/vendor/laravel-lang/lang' => 
      array (
        'class' => 'LaravelLang\\Lang\\Plugin',
        'name' => 'laravel-lang/lang',
      ),
    ),
  ),
  'lang-publisher' => 
  array (
    'inline' => false,
    'align' => true,
    'smart_punctuation' => 
    array (
      'enable' => false,
      'common' => 
      array (
        'double_quote_opener' => '“',
        'double_quote_closer' => '”',
        'single_quote_opener' => '‘',
        'single_quote_closer' => '’',
      ),
      'locales' => 
      array (
        'fr' => 
        array (
          'double_quote_opener' => '«&nbsp;',
          'double_quote_closer' => '&nbsp;»',
          'single_quote_opener' => '‘',
          'single_quote_closer' => '’',
        ),
        'ru' => 
        array (
          'double_quote_opener' => '«',
          'double_quote_closer' => '»',
          'single_quote_opener' => '‘',
          'single_quote_closer' => '’',
        ),
        'uk' => 
        array (
          'double_quote_opener' => '«',
          'double_quote_closer' => '»',
          'single_quote_opener' => '‘',
          'single_quote_closer' => '’',
        ),
        'be' => 
        array (
          'double_quote_opener' => '«',
          'double_quote_closer' => '»',
          'single_quote_opener' => '‘',
          'single_quote_closer' => '’',
        ),
      ),
    ),
    'aliases' => 
    array (
    ),
  ),
  'laravel-menu' => 
  array (
    'settings' => 
    array (
      'default' => 
      array (
        'auto_activate' => true,
        'activate_parents' => true,
        'active_class' => 'active',
        'restful' => false,
        'cascade_data' => true,
        'rest_base' => '',
        'active_element' => 'item',
        'data_toggle_attribute' => 'data-toggle',
      ),
    ),
    'views' => 
    array (
      'bootstrap-items' => 'laravel-menu::bootstrap-navbar-items',
    ),
  ),
  'trustedproxy' => 
  array (
    'proxies' => NULL,
    'headers' => 30,
  ),
  'breadcrumbs' => 
  array (
    'view' => 'breadcrumbs::bootstrap4',
    'files' => '/Users/artemperlov/Sites/upbrain3/routes/breadcrumbs.php',
    'unnamed-route-exception' => true,
    'missing-route-bound-breadcrumb-exception' => true,
    'invalid-named-breadcrumb-exception' => true,
    'manager-class' => 'DaveJamesMiller\\Breadcrumbs\\BreadcrumbsManager',
    'generator-class' => 'DaveJamesMiller\\Breadcrumbs\\BreadcrumbsGenerator',
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'alias' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
  ),
);
