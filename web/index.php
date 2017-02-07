<!--
  _____             _____  ____  ______ _______ 
 |  __ \     /\    / ____|/ __ \|  ____|__   __|
 | |__) |   /  \  | (___ | |  | | |__     | |   
 |  _  /   / /\ \  \___ \| |  | |  __|    | |   
 | | \ \  / ____ \ ____) | |__| | |       | |   
 |_|  \_\/_/    \_\_____/ \____/|_|       |_|   
                                                
-->                                                
<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();
