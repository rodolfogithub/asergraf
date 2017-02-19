<?php
use
yii\helpers\Html,
yii\widgets\ActiveForm,
yii\widgets\Pjax,
kartik\sortinput\SortableInput;

$script = <<<JS
  function cambioLista() {
	 $("ul[id$='sortable'").trigger('sortupdate');
  }
JS;

$this->registerJs($script, yii\web\View::POS_END);

$this->title = 'Configurar plantilla';
$this->params['breadcrumbs'][] = $this->title;

$form = ActiveForm::begin();
?>

<div class='well'><strong>Configurador de plantillas</strong>,
	por favor seleccione un capitulo o item arrastre el elemento seleccionado y sueltelo donde dice "Soltar aquí". Para ordenar elementos dentro del capitulo, seleccione, arrastre hacia arriba o hacia abajo y luego suelte.
</div>
<div class='row text-center divasercol' style='height: 30px; margin-bottom: 30px;'>
	<?='Plantilla en proceso: '.Html::encode($titulo)?>
</div>

<div class="row">
	<div class="col-sm-4">
		<h4>Soltar Aquí</h4>
		<?php
		echo SortableInput::widget([
			'name'=>'kv-conn-1',
			'items' => $itemsPlantilla,
			'hideInput' => true,
			'sortableOptions' => ['connected'=>true],
			'options' => ['class'=>'form-control', 'readonly'=>true, 'onChange'=>'cambioLista()'],
		]);
		?>
	</div>

	<div class="col-sm-4">
		<div class='row' style='margin: 0px 5px 10px 5px;'>
			<div class='col-sm-12 text-center' style='height: 30px;background:rgba(248,223,222,0.9);padding-top: 3px; font-size: 1.3em;'>
				<?='CAPITULOS DISPONIBLES'?>
			</div>
		</div>
		<?php
		echo SortableInput::widget([
			'name'=>'kv-conn-2',
			'items' => $liscapitulos,
			'hideInput' => true,
			'sortableOptions' => [
				'itemOptions'=>['class'=>'alert alert-warning'],
				'connected'=>true,
			],
			'options' => ['class'=>'form-control', 'readonly'=>true, 'onChange'=>'cambioLista()'],
		]);
		?>
	</div>

	<div class="col-sm-4">
		<div class='row'>
			<div class='col-sm-10'>
				<?= Html::input('text', 'listaItems', Yii::$app->request->post('listaItems'), ['class' => 'form-control']) ?>
			</div>
			<div class='col-sm-1'>
				<?= Html::submitButton('<span class="glyphicon glyphicon-download-alt"></span>', ['class' => 'btn btn-primary', 'name' => 'escogeItems']) ?>
			</div>
		</div>

		<div class='row' style='margin: 10px 0px 10px 0px;'>
			<div class='col-sm-12 text-center' style='height: 30px;background:rgba(248,223,222,0.9);padding-top: 3px; font-size: 1.3em;'>
				<?='ITEMS DISPONIBLES'?>
			</div>
		</div>

		<?php
		echo SortableInput::widget([
			'name'=>'kv-conn-3',
			'items' => $items,
			'hideInput' => true,
			'sortableOptions' => [
				'itemOptions'=>['class'=>'alert alert-info'],
				'connected'=>true,
			],
			'options' => ['class'=>'form-control', 'readonly'=>true, 'onChange'=>'cambioLista()'],
		]);
		?>
	</div>
</div>

<?php
echo '<br>'.Html::submitButton('Grabar cambios', ['class'=>'btn btn-primary', 'name' => 'grabaCambios']);

$form->end();
