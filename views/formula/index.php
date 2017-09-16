<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Paciente;
use dektrium\user\models\Profile;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */

$this->title = Yii::t('app', 'Fórmulas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pacientes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="formula-index">
	
	<h1><?= Html::encode($this->title) ?></h1><br>
	
	<?php if(\Yii::$app->user->can('medico')){ ?>
		<p>
			<?= Html::a(Yii::t('app', 'Crear Fórmula'), ['create'], ['class' => 'btn btn-success']) ?>
	 	</p>
	<?php } ?>
	
	<br>
	 
    <?php Pjax::begin(); ?>
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
				    [
	                    'label' => 'Paciente',
					    'value' => function ($data) {
					    	$paciente=Paciente::find()->where(['id' => $data->paciente_id])->one();
							$profile=Profile::find()->where(['user_id' => $paciente['user_id']])->one();
							return $profile['name'];
					     },
					     "visible" => \Yii::$app->user->can('medico')
	                ],
	                [
				        'attribute' => 'peso',
				        'format' => 'text',
				        'label' => 'Peso',
				        'value' => 'peso'
				    ],
				    [
				        'attribute' => 'dosis',
				        'format' => 'text',
				        'label' => 'Dosis (mg)',
				        'value' => 'dosis'
				    ],
				    [
				        'attribute' => 'caja',
				        'format' => 'text',
				        'label' => 'Dosis total (mg)',
				        'value' => function ($data) {
					    	return ($data->peso*$data->dosis);
					     }
				    ],
				    [
				        'attribute' => 'caja',
				        'format' => 'text',
				        'label' => 'Dosis total cajas (mg)',
				        'value' => function ($data) {
					    	return number_format((($data->peso*$data->dosis)/($data->capsula*30)),0);
					     }
				    ],
				    [
				        'attribute' => 'capsula',
				        'format' => 'text',
				        'label' => 'mg Cápsula',
				        'value' => 'capsula'
				    ],
				    [
						'class' => 'yii\grid\ActionColumn',
				        'template' => '{update}{delete}',
				        "visible" => \Yii::$app->user->can('medico')
					],
	            ],
	        ]);
	    ?>
	<?php Pjax::end(); ?>

</div>
