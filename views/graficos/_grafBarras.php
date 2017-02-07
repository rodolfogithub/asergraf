<?php
use yii\helpers\Html;
use yii\web\JsExpression;
use yii2mod\c3\chart\Chart;
?>

<div class='container'>
   <div class='row' style='padding-top: 60px;'>
      <div class='col-sm-12 divasercol' id='capit<?=$idGrafico?>'>
         <div class='col-sm-1'>
            <?= Html::img('@web/imagenes/asercol1.png',['width'=>'50','class' => 'img-responsive']);?>
         </div>
         <div class='col-sm-8' style='padding-top: 11px;'>
            <?=$capitulo?>
         </div>
      </div>
      <div class='col-sm-12' style='height: 30px;background:rgba(248,223,222,0.9);padding-left: 60px; padding-top: 3px; margin-bottom: 30px; font-size: 1.3em;'>
         <?=$titulo?>
      </div>
      <div class='col-sm-8'>
         <?php
         echo Chart::widget([
            'options' => ['id' => 'char'.$idGrafico],
            'clientOptions' => [
               'data' => [
                  'columns' => [$datosY_1, $datosY_2, $datosY_3, $datosY2_1, $datosY2_2],  // Hasta 3 series de datos sin contar con el eje x
                  'axes' => $tipoEjes,
                  'types' => $tipoDatos,
                  'colors'=> $colors,
                  /*'groups'=>[
                  [$datosY_1,$datosY2_1]
                  ]*/
               ],
               'grid' => ['y' => ['show' => true]],    // Muestra lineas horizontales
               'size' => ['height'=>450],
               'axis' => [
                  'x' => [
                     'type' => 'category',
                     'categories' => $categorias,
                     'label' => [],
                     'tick' => [
                        'rotate'=>30,
                        'multiline'=>false,
                        'height'=>130
                     ]
                  ],
                  'y' => [
                     'label' => [
                        'text' => !empty($datosY_1) ? $datosY_1[0] : '',
                        'position' => 'outer-middle',
                        'format' => new JsExpression('function (value,ratio) { console.log(value) }')
                     ],
                     'tick'=>['format'=>new JsExpression(' function (d) { return accounting.formatMoney(d, " ", 0); }')],  // Formatea sin el signo $
                  ],
                  'y2' =>  [
                     'show' => empty($datosY2_1) ? false : true,
                     'label' => [
                        'text' => $labelY2,
                        'position' => 'outer-middle'
                     ],
                     'tick'=>['format'=>new JsExpression(' function (d) { return accounting.formatMoney(d, " ", 0); }')],  // Formatea sin el signo $
                  ],
               ]
            ]
            ]
         );
         ?>
      </div>
      <div class='col-sm-4'>
         <table class="table table-bordered table-sm table-hover" style='font-size: small;'>
            <thead class="thead-inverse">
               <tr>
                  <th><?=$labEjex?></th>
                  <th><?= $datosY_1[0] ?></th>
                  <?php
                  if (!empty($datosY_2)) echo '<th>'.$datosY_2[0].'</th>';
                  if (!empty($datosY2_1)) echo '<th>'.$datosY2_1[0].'</th>';
                  if (!empty($datosY2_2)) echo '<th>'.$datosY2_2[0].'</th>';
                  ?>
               </tr>
            </thead>
            <tbody>
               <?php
               for ($i=0; $i <= count($datosY_1)-2; $i++) {
                  echo '<tr>';
                  echo '<td>'.$categorias[$i].'</td>';
                  echo '<td align="right">'.number_format($datosY_1[$i+1]).'</td>';
                  if (!empty($datosY_2)) echo '<td align="center">'.number_format($datosY_2[$i+1]).'</td>';
                  if (!empty($datosY2_1)) echo '<td align="center">'.number_format($datosY2_1[$i+1]).'</td>';
                  if (!empty($datosY2_2)) echo '<td align="center">'.number_format($datosY2_2[$i+1]).'</td>';
                  echo '</tr>';
               }
               ?>
            </tbody>
         </table>
      </div>
   </div>
</div>
