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
class Plantillas extends AssetBundle
{
   public $basePath = '@webroot';
   public $baseUrl  = '@web';
   public $js       = ['js/plantilla.js'];
   public $depends  = ['yii\web\YiiAsset','yii\bootstrap\BootstrapAsset'];
}
