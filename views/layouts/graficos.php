<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
   <head>
      <meta charset="<?= Yii::$app->charset ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <?= Html::csrfMetaTags() ?>
      <title><?= Html::encode($this->title) ?></title>
      <?php $this->head() ?>
      <style>
         .wrap {padding: 0 10px 42px; margin:0 auto -60px}
         .wrap > .container { padding: 20px 15px 10px; }
         .footer {height: 60px; background-color: white;   border-top: 0px solid #ddd; padding-top: 0px}
      </style>
   </head>

   <body>
      <?php $this->beginBody() ?>

      <div class="wrap">
         <div class="row" style='padding-bottom: 10px;'>
            <div class="col-centered">
               <?= Html::img('@web/imagenes/asercol.png',['width'=>'350','class' => 'img-responsive center-block']);?>
            </div>
         </div>

         <div class="container">
            <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [] ]) ?>
            <?= $content ?>
         </div>
      </div>

      <footer class="footer" style='margin-top: 60px;'>
         <div class="container">
            <p class="pull-left">&copy; Asercol SIA <?= date('Y') ?></p>
         </div>
      </footer>

   <?php $this->endBody() ?>
   </body>

</html>
<?php $this->endPage() ?>
