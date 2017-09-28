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
		<?php 	//$graficas = ['Examen 1', 'Examen 1', 'Examen 1', 'Examen 1'];
				$tipo = ["TGO", "TGP", "Colesterol", "Triglicéridos"];
				$mes = [['Ene', 'Feb'], ['Ago', 'Sep'], ['Nov', 'Dic'], ['May']];
				//$valorE = [[50, 60], [60, 70], [70, 80], [40]];
				//$valorR = [["55/75", "55/75"], ["100/200", "100/200"], ["85/120", "85/120"], ["90/100"]];
				
				$i=0;
				if($model) {
					foreach($model as $id => $value) {
						foreach($value['tipo'] as $tipoE) {
							$mes    = $value['fecha'][$tipoE];
							$valorE = $value['valorExamen'][$tipoE];
							$valorR = $value['valorReferencia'][$tipoE];
				?>
							<div class="col-sm-3 col-lg-6">
								<br><br>
								<div id="container_<?= $i ?>" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
								<input type="hidden" id='myChart_<?= $i ?>' name='myChart[]' value='Examen <?= $id ?>' />
								<input type="hidden" id='tipo_<?= $i ?>' name='tipo[]' value='<?= $tipoE ?>' />
								<input type="hidden" id='mes_<?= $i ?>' name='mes[]' value='<?= json_encode($mes) ?>' />
								<input type="hidden" id='valorE_<?= $i ?>' name='valorE[]' value='<?=  json_encode($valorE) ?>' />
								<input type="hidden" id='valorR_<?= $i ?>' name='valorR[]' value='<?= json_encode($valorR) ?>' />
							</div>
				<?php 		$i++;
						}
					} 
				}
		?>
	</div>
</div>

<?php $this->registerJsFile('@web/js/grafica.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
