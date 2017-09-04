<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use dektrium\user\models\Profile;
use app\models\Paciente;

use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pacientes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paciente-view">

    <h1><?= Html::encode('Paciente') ?></h1><br>
    
    <div class="form-group">
		<div class="col-lg-offset-0 col-lg-9">
	    	<?= Html::a(Yii::t('app', 'Regresar'), ['index'], ['class' => 'btn btn-primary']) ?>
		</div>
	</div>
	
	<br><br><br>

	<div class="form-group">
		<div class="col-lg-offset-0 col-lg-6">	
		    <?= DetailView::widget([
		        'model' => $model,
		        'attributes' => [
					[
						'attribute' => 'name',
		                'label' => 'Nombre del Paciente',
					    'value' => function ($model) {
							$profile=Profile::find()->where(['user_id' => $model->user_id])->one();
							return $profile['name'];
					     }
		            ],
		            [
						'attribute' => 'sexo',
		                'label' => 'Sexo',
					    'value' => function ($model) {
							$profile=Profile::find()->where(['user_id' => $model->user_id])->one();
							return $profile['sexo'];
					     }
		            ], 
		            [
						'attribute' => 'peso',
		                'label' => 'Peso',
					    'value' => function ($model) {
							$profile=Profile::find()->where(['user_id' => $model->user_id])->one();
							return $profile['peso'];
					     }
		            ], 
		            [
						'attribute' => 'telefono',
		                'label' => 'Teléfono',
					    'value' => function ($model) {
							$profile=Profile::find()->where(['user_id' => $model->user_id])->one();
							return $profile['telefono'];
					     }
		            ],
		            [
						'attribute' => 'fecha',
		                'label' => 'Fecha de Nacimiento',
					    'value' => function ($model) {
					    	$profile=Profile::find()->where(['user_id' => $model->user_id])->one();
							return Yii::$app->formatter->asDate($profile['fecha'], 'php: d-m-Y');
					     }
		            ] 
		        ],
		    ]) ?>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-lg-offset-0 col-lg-6">	
			
			<?php if($dataProvider) { ?>
					<?php Pjax::begin(); ?>    
						<?= GridView::widget([
						        'dataProvider' => $dataProvider,
						        'columns' => [
					            	['class' => 'yii\grid\SerialColumn'],
					            	[
								        'attribute' => 'name',
								        'format' => 'text',
								        'label' => 'Nombre',
								    ],
								    [
								        'attribute' => 'mime',
								        'format' => 'text',
								        'label' => 'Tipo',
								    ],
						        ],
						    ]); 
						?>
					<?php Pjax::end(); ?>
			<?php } ?>
		</div>
	</div>
	
	<br><br>
	
	<div class="form-group">
		<div class="col-lg-offset-0 col-lg-6">
			<br><br>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-lg-offset-0 col-lg-6">
			<?php if($dataProviderPeriodo && Paciente::getSexo()) { ?>
				<?php Pjax::begin(); ?>
				    <?= GridView::widget([
				            'dataProvider' => $dataProviderPeriodo,
				            'columns' => [
				                [
							        'attribute' => 'fecha',
							        'format' => 'text',
							        'label' => 'Año',
							        'value' => function ($data) {
										return Yii::$app->formatter->asDate($data->fecha, 'php: Y');
								     }
							    ],
							    [
							        'attribute' => 'fecha',
							        'format' => 'text',
							        'label' => 'Mes',
							        'value' => function ($data) {
										return Yii::$app->formatter->asDate($data->fecha, 'php: m');
								     }
							    ],
							    [
							        'attribute' => 'fecha',
							        'format' => 'text',
							        'label' => 'Día',
							        'value' => function ($data) {
										return Yii::$app->formatter->asDate($data->fecha, 'php: d');
								     }
							    ],
				            ],
				        ]);
				    ?>
				<?php Pjax::end(); ?>
			<?php } ?>
		</div>
	</div>
</div>
