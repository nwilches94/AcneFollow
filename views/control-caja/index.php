<?php

use yii\helpers\Html;
use yii\grid\GridView;
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
	
	<!--<?php if(\Yii::$app->user->can('medico')){ ?>
		<p>
			<?= Html::a('Crear Control de Caja', ['create'], ['class' => 'btn btn-success']) ?>
	 	</p>
	<?php } ?>-->
	
	<br>
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
		        'attribute' => 'fecha',
		        'format' => 'text',
		        'label' => 'Fecha',
		        'value' => function ($data) {
					return Yii::$app->formatter->asDate($data->fecha, 'php: d-m-Y');
			     }
		    ],
            /*[
                'label' => 'Paciente',
			    'value' => function ($data) {
			    	$paciente=Paciente::find()->where(['id' => $data->paciente_id])->one();
					$profile=Profile::find()->where(['user_id' => $paciente['user_id']])->one();
					return $profile['name'];
			     },
			     "visible" => \Yii::$app->user->can('medico')
            ],*/
            [
		        'attribute' => 'peso',
		        'format' => 'text',
		        'label' => 'Peso (kg)',
		        'value' => function ($data) {
			    	return Formula::findOne($data->formula_id)->peso;
			    },
		    ],
		    [
		        'attribute' => 'dosis',
		        'format' => 'text',
		        'label' => 'Dosis (mg)',
		        'value' => function ($data) {
			    	return Formula::findOne($data->formula_id)->dosis;
			    },
		    ],
            [
		        'attribute' => 'capsula',
		        'format' => 'text',
		        'label' => 'mg Cápsula',
		        'value' => function ($data) {
			    	return Formula::findOne($data->formula_id)->capsula;
			    },
		    ],
            'cajaTomada',
            [
		        'attribute' => 'dosisAcumulada',
		        'format' => 'text',
		        'value' => function ($data) {
			    	return $data->dosisAcumulada;
			    },
		        "visible" => \Yii::$app->user->can('medico')
		    ],
		    [
		        'attribute' => 'dosisRestante',
		        'format' => 'text',
		        'value' => function ($data) {
			    	return $data->dosisRestante;
			    },
		        "visible" => \Yii::$app->user->can('medico')
		    ],
		    [
		        'attribute' => 'dosisCaja',
		        'format' => 'text',
		        'value' => function ($data) {
			    	return number_format($data->dosisCaja,0);
			    },
		        "visible" => \Yii::$app->user->can('medico')
		    ],
		    [
		        'attribute' => 'caja',
		        'format' => 'text',
		        'label' => 'Total de Cajas',
		        'value' => function ($data) {
		        	$datos=Formula::findOne($data->formula_id);
			    	return number_format((($datos->peso*$datos->dosis)/($datos->capsula*30)),0);
			     }
		    ],
            /*[
				'class' => 'yii\grid\ActionColumn',
		        'template' => '{update}{delete}',
		        "visible" => \Yii::$app->user->can('medico')
			],*/
        ],
    ]); ?>
</div>
