<?php

declare (strict_types = 1);

define('ROOT_DIR', __DIR__);

// Autoload all classes via composer-generated autoloader 
require ROOT_DIR . '/vendor/autoload.php';

// Load server-specific configuration
require ROOT_DIR . '/app/config/app.php';
require ROOT_DIR . '/app/config/routes.php';

// Additional requires (this can be also done with conposer.json)
require ROOT_DIR . '/core/functions/form.php';
require ROOT_DIR . '/app/functions/form.php';

/** @var \App\App */
$app = new \App\App();

