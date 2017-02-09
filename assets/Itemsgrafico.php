<?php
/**
* @link http://www.yiiframework.com/
* @copyright Copyright (c) 2008 Yii Software LLC
* @license http://www.yiiframework.com/license/
*/

namespace app\assets;

use yii\web\AssetBundle;

/**
* @author Rodolfo Arias <rodolfo.arias.as>
*/
class Itemsgrafico extends AssetBundle
{
   public $basePath = '@webroot';
   public $baseUrl  = '@web';
   public $js       = [YII_ENV_DEV ? 'js/item.js' : 'js/item.min.js'];
   public $depends  = ['yii\web\YiiAsset','yii\bootstrap\BootstrapAsset'];
}
