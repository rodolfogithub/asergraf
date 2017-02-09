<?php $form = yii\widgets\ActiveForm::begin(['id'=>$model->formName()]) ?>

<div class='container-fluid'> <!-- OJO, container-fluid para efectos del modal -->
   <div class='row'>
      <div class='col-sm-6'><?= $form->field($model,'titulo') ?></div>
      <div class='col-sm-6'><?= $form->field($model,'nomgrafico') ?></div>
   </div>
   <div class='row'>
      <div class='col-sm-12'>
         <?=
         $form->field($model,'sql')->textarea(['rows'=>10,'style'=>'font-weight:600;font-family: "Courier";'])
         ?>
      </div>
   </div>

   <div class='row'>
      <div class="form-group">
         <?php
         if ($modo == 'C')
            echo yii\helpers\Html::submitButton('<span class="glyphicon glyphicon-save"></span>&nbsp;Crear Item', ['class' => 'btn btn-primary']);
         else
            echo yii\helpers\Html::submitButton('<span class="glyphicon glyphicon-edit"></span>&nbsp;Actualiza Item', ['class' => 'btn btn-primary']);
         ?>
      </div>
   </div>
</div>

<?php yii\widgets\ActiveForm::end() ?>