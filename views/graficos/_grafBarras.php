<?php
use
yii\web\JsExpression,
yii2mod\c3\chart\Chart,
app\models\Itemsgraficos;
?>
<div class='container'>
	<div class='row' style='padding-bottom: 80px;'>
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
						if (!empty($datosY2_1)) echo '<td align="center">'.$datosY2_1[$i+1].'</td>';
						if (!empty($datosY2_2)) echo '<td align="center">'.$datosY2_2[$i+1].'</td>';
						echo '</tr>';
					}

					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
