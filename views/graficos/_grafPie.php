<?php
use yii2mod\c3\chart\Chart;

/* Se crean las seriesY */
for ($idx = 1; $idx <= 20; $idx++) ${'datos'.($idx)} = [];

for ($i = 0; $i < count($datosY_1)-1; $i++) {
	${'datos'.($i+1)} = explode(',',$categorias[$i]);
	array_push(${'datos'.($i+1)}, $datosY_1[$i]);
}
?>

<style>
	.capitulo{ background: rgba(172,43,36,0.9); height:40px; padding-left: 30px; padding-top: 5px; color:white; font-size: 1.7em;}
	.titulo { background: rgb(248, 223, 222); height:30px; padding-left: 60px; padding-top: 3px; margin-bottom: 30px; font-size: 1.3em;}
</style>
<div class='container'>
	<div class='row' style='padding-bottom: 80px;'>
		<div class='capitulo'><?=$capitulo?></div>
		<div class='titulo'><?=$titulo?></div>
		<div class='col-sm-8'>
			<?php
			echo Chart::widget([
				'clientOptions' => [
					'data' => [
						'columns' => [
							$datos1,$datos2,$datos3,$datos4,$datos5,$datos6,$datos7,$datos8,$datos9,$datos10,
							$datos11,$datos12,$datos13,$datos14,$datos15,$datos16,$datos17,$datos18,$datos19,$datos20
						],
						'type'=>'pie'
					],
					'axis' => [
						'x' => [
							'type' => 'category',
							'tick' => [
								'rotate'=>30,
								'multiline'=>false,
								'height'=>130
							]
						],
					]
					/*
					pie: {
					label: {
					format: function (value, ratio, id) {
					return d3.format('$')(value);
					}
					}
					}      */
				]
			]);
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
						echo '</tr>';
					}

					?>
				</tbody>
			</table>
		</div>

	</div>
</div>
