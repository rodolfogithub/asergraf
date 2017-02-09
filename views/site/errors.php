<?php
use yii\helpers\Html;

$this->title = 'Error';
$this->params['breadcrumbs'][] = ['label' => 'Inicio', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<br><br><br><br>
<div class='container center-block'>
	<div class='row>'>
		<div class='col-sm-2'>
			<?= Html::img('@web/imagenes/error.png',['width'=>'160px','height'=>'160px']);?>
		</div>
		<div class='col-sm-10'>
			<?="<h4>Se presentó el siguiente error $modulo, por favor informar a Sistemas.<h4/>"?>
		</div>
	</div>

	<div class='row>'>
		<div class='col-sm-12 alert alert-danger center' style='margin-top: 20px'>
			<?php
			echo '<ul>';
			foreach ($errors as $error=>$key)
				foreach ($key as $valor)
					echo '<li><span style="font-size:1.5em">'.$valor.'</span></li>';

			echo '</ul>';
			?>
		</div>
	</div>
</div>