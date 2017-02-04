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
			.footer {height: 60px; background-color: white;	border-top: 0px solid #ddd; padding-top: 0px}
		</style>
	</head>

	<body>
		<?php $this->beginBody() ?>

		<div class="wrap">
			<div class="row" style='padding-bottom: 10px;'>
				<div class="col-sm-2">
					<?= Html::img('@web/imagenes/c_encab1.png',['width'=>'85','class' => 'img-responsive center-block']);?>
				</div>
				<div class="col-sm-offset-8">
					<?= Html::img('@web/imagenes/asercol.png',['width'=>'230','class' => 'img-responsive center-block']);?>
				</div>
			</div>

			<div class="container">
				<?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [] ]) ?>
				<?= $content ?>
			</div>
		</div>

		<footer class="footer">
				<?= Html::img('@web/imagenes/c_encab2.png',['width'=>'95','class' => 'img-responsive pull-right','style'=>'padding-right:20px']);?>
		</footer>

	<?php $this->endBody() ?>
	</body>

</html>
<?php $this->endPage() ?>
