[![codecov](https://codecov.io/gh/NaokiTsuchiya/NaokiTsuchiya.YiiRouteList/branch/main/graph/badge.svg?token=MZLWSIR471)](https://codecov.io/gh/NaokiTsuchiya/NaokiTsuchiya.YiiRouteList)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/NaokiTsuchiya/NaokiTsuchiya.YiiRouteList/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/NaokiTsuchiya/NaokiTsuchiya.YiiRouteList/?branch=main)
[![Continuous Integration](https://github.com/NaokiTsuchiya/NaokiTsuchiya.YiiRouteList/actions/workflows/continuous-integration.yml/badge.svg)](https://github.com/NaokiTsuchiya/NaokiTsuchiya.YiiRouteList/actions/workflows/continuous-integration.yml)
[![Coding Standards](https://github.com/NaokiTsuchiya/NaokiTsuchiya.YiiRouteList/actions/workflows/coding-standards.yml/badge.svg)](https://github.com/NaokiTsuchiya/NaokiTsuchiya.YiiRouteList/actions/workflows/coding-standards.yml)
[![Static Analysis](https://github.com/NaokiTsuchiya/NaokiTsuchiya.YiiRouteList/actions/workflows/static-analysis.yml/badge.svg)](https://github.com/NaokiTsuchiya/NaokiTsuchiya.YiiRouteList/actions/workflows/static-analysis.yml)

# naoki-tsuchiya/yii-route-list

It gets a list of route from each of rules of UrlManager in Yii Framework 1.1.

## Installation

    composer require --dev naoki-tsuchiya/yii-route-list

## Usage

```php
<?php

use NaokiTsuchiya\YiiRouteList\YiiRouteList;

define('YII_ENABLE_EXCEPTION_HANDLER', false);
define('YII_ENABLE_ERROR_HANDLER', false);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii/framework/yii.php';

// Your Yii application config
$config = dirname(__FILE__).'/protected/config/main.php';

$app = Yii::createWebApplication($config)

$routeList = (new YiiRouteList())($app);

foreach ($routeList as $route) {
    var_dump($route->rule);
    var_dump($route->controller);
    var_dump($route->action);
}
```
