<?php $form = yii\widgets\ActiveForm::begin() ?>

<div class='container-fluid'> <!-- OJO, container-fluid para efectos del modal -->
	<div class='row'>
		<div class='col-sm-12'><?= $form->field($model,'nombreplantilla') ?></div>
	</div>
	<div class='row'>
		<div class="form-group">
			<?php
			if ($modo == 'C')
				echo yii\helpers\Html::submitButton('<span class="glyphicon glyphicon-save"></span>&nbsp;Crear Plantilla', ['class' => 'btn btn-primary']);
			else
				echo yii\helpers\Html::submitButton('<span class="glyphicon glyphicon-edit"></span>&nbsp;Actualiza Plantilla', ['class' => 'btn btn-primary']);
			?>
		</div>
	</div>
</div>

<?php yii\widgets\ActiveForm::end() ?>