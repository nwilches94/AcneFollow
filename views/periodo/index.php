<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */

$this->title = Yii::t('app', 'Seguimiento de Periodo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pacientes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("@web/css/bootstrap-datepicker.standalone.min.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
    'media' => 'print',
], 'css-print-theme');

?>
<div class="p-create">

    <h1><?= Html::encode($this->title) ?></h1><br>

    <?= $this->render('_form', [
        'model' => $model, 'proximoPeriodo' => $proximoPeriodo
    ]) ?>
    
    <br>
    
    <br><h2><?= Html::encode('Histórico de Seguimiento de Periodos') ?></h2>
    
    <?php Pjax::begin(); ?>
	    <?= GridView::widget([
	            'dataProvider' => $dataProvider,
	            'columns' => [
	                [
				        'attribute' => 'fecha',
				        'format' => 'text',
				        'label' => 'Fecha de Inicio de Periodo',
				        'value' => function ($data) {
							return Yii::$app->formatter->asDate($data->fecha, 'php: d-m-Y');
					     }
				    ],
				    [
				        'attribute' => 'fecha',
				        'format' => 'text',
				        'label' => 'Fecha de Fin de Periodo',
				        'value' => function ($data) {
							return Yii::$app->formatter->asDate($data->fechaFin, 'php: d-m-Y');
					     }
				    ],
				    [
				        'attribute' => 'fecha',
				        'format' => 'text',
				        'label' => 'Fecha Aproximada de Periodo',
				        'value' => function ($data) {
				        	
							$fecha = $data->fecha;
							$proximoPeriodo = strtotime('+28 day', strtotime($fecha));
							$proximoPeriodo = date('d-m-Y', $proximoPeriodo);
			
							return $proximoPeriodo;
					     }
				    ],
	            ],
	        ]);
	    ?>
	<?php Pjax::end(); ?>

</div>

<br>
