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
				        'attribute' => 'dosis',
				        'format' => 'text',
				        'label' => 'Dosis (mg)',
				        'value' => 'dosis'
				    ],
				    [
				        'attribute' => 'capsula',
				        'format' => 'text',
				        'label' => 'Cápsula (mg)',
				        'value' => 'capsula'
				    ],
				    [
				        'attribute' => 'caja',
				        'format' => 'text',
				        'label' => 'Cajas',
				        'value' => 'cajas'
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
