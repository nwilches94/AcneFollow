<?php

namespace app\controllers;

use yii;
use yii\web\View;

$this->registerJsFile('@web/js/highcharts.js', ['position' => View::POS_BEGIN]); 
$this->registerJsFile('@web/js/exporting.js', ['position' => View::POS_BEGIN]); 
?>

<div class="row"> 
	<hr>
	<div align="center"><h1>Estadísticas</h1></div>
	<div class="form-group">
		<?php 	$tipo = ["TGO", "TGP", "Colesterol", "Triglicéridos"];
				$mes = [['Ene', 'Feb'], ['Ago', 'Sep'], ['Nov', 'Dic'], ['May']];

				if($model) {
					$i=0;
		?>
		
		<div id="grafica">	
			<?php	foreach($model['tipo'] as $tipoE) {
						$mes    = $model['fecha'][$tipoE];
						$valorE = $model['valorExamen'][$tipoE];
						$valorR = $model['valorReferencia'][$tipoE];
			?>
						<div class="col-sm-12 col-lg-6">
							<br><br>
							<div id="container_<?= $i ?>" align="center" style="min-width: 310px; height: 400px; margin: 0 auto;"></div>
							<input type="hidden" id='nameContainer_<?= $i ?>' name='nameContainer[]' value='container_<?= $i ?>' />
							<input type="hidden" id='myChart_<?= $i ?>' name='myChart[]' value='Tipo de Examen: <?= $tipoE ?>' />
							<input type="hidden" id='tipo_<?= $i ?>' name='tipo[]' value='<?= $tipoE ?>' />
							<input type="hidden" id='mes_<?= $i ?>' name='mes[]' value='<?= json_encode($mes) ?>' />
							<input type="hidden" id='valorE_<?= $i ?>' name='valorE[]' value='<?=  json_encode($valorE) ?>' />
							<input type="hidden" id='valorR_<?= $i ?>' name='valorR[]' value='<?= json_encode($valorR) ?>' />
						</div>
						
			<?php 		$i++;
					}
			?>
		</div>
		
		<div id="grafica_responsive" align="center">		
			<?php 	foreach($model['tipo'] as $tipoE) {
						$mes    = $model['fecha'][$tipoE];
						$valorE = $model['valorExamen'][$tipoE];
						$valorR = $model['valorReferencia'][$tipoE];
			?>
						<div class="col-sm-12 col-lg-6" align="center">
							<br><br>
							<div id="containerR_<?= $i ?>" align="center" style="width: 230px; height: 400px; margin: 0 auto;"></div>
							<input type="hidden" id='nameContainer_<?= $i ?>' name='nameContainer[]' value='containerR_<?= $i ?>' />
							<input type="hidden" id='myChart_<?= $i ?>' name='myChart[]' value='Tipo de Examen: <?= $tipoE ?>' />
							<input type="hidden" id='tipo_<?= $i ?>' name='tipo[]' value='<?= $tipoE ?>' />
							<input type="hidden" id='mes_<?= $i ?>' name='mes[]' value='<?= json_encode($mes) ?>' />
							<input type="hidden" id='valorE_<?= $i ?>' name='valorE[]' value='<?=  json_encode($valorE) ?>' />
							<input type="hidden" id='valorR_<?= $i ?>' name='valorR[]' value='<?= json_encode($valorR) ?>' />
						</div>
						
			<?php 		$i++;
					}
			?>
		</div>
		
		<?php } ?>
	</div>
</div>

<?php $this->registerJsFile('@web/js/grafica.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
