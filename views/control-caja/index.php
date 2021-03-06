<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\Paciente;
use app\models\Formula;
use dektrium\user\models\Profile;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Fórmulas');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="control-caja-index">
	<?php if(\Yii::$app->user->can('paciente')){ ?>
    		<h1><?= Html::encode($this->title) ?></h1><br>
    <?php } ?>
	
	<br>
	
    <?= GridView::widget([
    	'id' => 'control_paciente',
        'dataProvider' => $dataProvider,
        'responsive' => true,
        'striped'=>true,
		'hover'=>true,
		'panel'=>['type' => 'primary', 'heading' => 'Listado de Fórmulas'],
        'columns' => [
            [
		        'attribute' => 'fecha',
		        'label' => 'Fecha',
		        'value' => function ($data) {
					return Yii::$app->formatter->asDate($data->fecha, 'php: d-m-y');
			     }
		    ],
            [
		        'attribute' => 'peso',
		        'label' => 'Peso (kg)',
		        'value' => function ($data) {
			    	return Formula::findOne($data->formula_id)->peso;
			    },
		    ],
		    [
		        'attribute' => 'dosis',
		        'label' => 'Dosis (mg)',
		        'value' => function ($data) {
			    	return Formula::findOne($data->formula_id)->dosis;
			    },
			    "visible" => \Yii::$app->user->can('medico')
		    ],
		    [
		        'attribute' => 'dosis',
		        'label' => 'Dosis Total (mg)',
		        'value' => function ($data) {
			    	return (Formula::findOne($data->formula_id)->peso * Formula::findOne($data->formula_id)->dosis);
			    },
			    "visible" => \Yii::$app->user->can('medico')
		    ],
		    [
		        'attribute' => 'caja',
		        'label' => 'Dosis Total de Cajas',
		        'value' => function ($data) {
		        	$datos=Formula::findOne($data->formula_id);
			    	return number_format((($datos->peso*$datos->dosis)/($datos->capsula*30)),0);
			     },
				"visible" => \Yii::$app->user->can('medico')
		    ],
            [
		        'attribute' => 'capsula',
		        'label' => 'mg Cápsula',
		        'value' => function ($data) {
			    	return Formula::findOne($data->formula_id)->capsula;
			    },
		    ],
            'cajaTomada',
            [
		        'attribute' => 'dosisAcumulada',
		        'value' => function ($data) {
			    	return $data->dosisAcumulada;
			    },
		        "visible" => \Yii::$app->user->can('medico')
		    ],
		    [
		        'attribute' => 'dosisRestante',
		        'value' => function ($data) {
			    	return $data->dosisRestante;
			    },
		        "visible" => \Yii::$app->user->can('medico')
		    ],
		    [
		        'attribute' => 'dosisCaja',
		        'value' => function ($data) {
			    	return number_format($data->dosisCaja,0);
			    },
		        "visible" => \Yii::$app->user->can('medico')
		    ],
		    [
				'class' => 'yii\grid\ActionColumn',
		        'template' => '{delete}',
		        'buttons' => [
		        	'delete' => function($url, $model){
		        		return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/control-caja/delete', 'id' => $model->id, 'paciente_id' => $_GET['id']], 
		        		['title' => 'Eliminar', 'aria-label' => 'Eliminar', 'data-pjax' => '0', 'data-confirm' => '¿Está seguro de eliminar este elemento?', 'data-method' => 'post']);
			        }
			    ],
			    "visible" => \Yii::$app->user->can('medico')
			],
        ],
    ]); ?>
</div>
