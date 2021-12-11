<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

define('YII_ENABLE_EXCEPTION_HANDLER', false);
define('YII_ENABLE_ERROR_HANDLER', false);

class_exists(YiiBase::class); // Avoid yii core interfaces already in use.
