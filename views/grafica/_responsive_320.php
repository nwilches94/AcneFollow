<?php

namespace app\controllers;

use yii;
use yii\web\View;
?>

<div id="grafica_320" align="center">		
	<?php 	foreach($model['tipo'] as $tipoE) {
				$mes    = $model['fecha'][$tipoE];
				$valorE = $model['valorExamen'][$tipoE];
				$valorR = $model['valorReferencia'][$tipoE];
	?>
				<div class="col-sm-12 col-lg-6" align="center">
					<br><br>
					<div id="container320_<?= $i ?>" align="center" style="width: 230px; height: 400px; margin: 0 auto;"></div>
					<input type="hidden" id='nameContainer_<?= $i ?>' name='nameContainer[]' value='container320_<?= $i ?>' />
					<input type="hidden" id='myChart_320_<?= $i ?>' name='myChart_320[]' value='Tipo de Examen: <?= $tipoE ?>' />
					<input type="hidden" id='tipo_<?= $i ?>' name='tipo[]' value='<?= $tipoE ?>' />
					<input type="hidden" id='mes_<?= $i ?>' name='mes[]' value='<?= json_encode($mes) ?>' />
					<input type="hidden" id='valorE_<?= $i ?>' name='valorE[]' value='<?=  json_encode($valorE) ?>' />
					<input type="hidden" id='valorR_<?= $i ?>' name='valorR[]' value='<?= json_encode($valorR) ?>' />
				</div>
				
	<?php 		$i++;
			}
	?>
</div>
