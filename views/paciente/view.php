<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use app\models\Profile;
use app\models\User;
use app\models\Paciente;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pacientes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('@vendor/dektrium/yii2-user/views/_alert', ['module' => Yii::$app->getModule('user'),]) ?>

<div class="paciente-view">

    <h1><?= Html::encode('Datos del Paciente') ?></h1><br>
    
    <div class="row">
    	
	    <div class="form-group">
			<div class="col-lg-offset-0 col-xs-12 col-lg-9">
				<?= Html::a(Yii::t('app', 'Ver Galería'), ['/foto/galeria?id='.$_GET['id']], ['class' => 'btn btn-success']) ?>
		    	<?= Html::a(Yii::t('app', 'Ver Exámenes'), ['/examen/index?id='.$_GET['id']], ['class' => 'btn btn-success']) ?>
		    	<div class="space_all"></div>
		    	<?= Html::a(Yii::t('app', 'Regresar'), ['index'], ['class' => 'btn btn-primary']) ?>
			</div>
		</div>
		<br><br>
		
		<?php	$form = ActiveForm::begin();
					echo $form->field($modelP, 'fechaI')->hiddenInput(['value' => json_encode($modelP['fechaI'])])->label(false);
					echo $form->field($modelP, 'fechaFC')->hiddenInput(['value' => json_encode($modelP['fechaFC'])])->label(false);
					echo $form->field($modelP, 'fechaA')->hiddenInput(['value' => json_encode($modelP['fechaA'])])->label(false);
				ActiveForm::end(); 
		?>
		
		<?php	if($dataProviderPeriodo && Paciente::getSexo())
					$lg=6;
				else
					$lg=12;
		?>
		<div class="form-group">
			<div style="padding-right: 10px" class="col-xs-12 col-lg-<?= $lg ?>">	
				
				<br><h2><?= Html::encode('Datos del Paciente') ?></h2>
				
			    <?= DetailView::widget([
			        'model' => $model,
			        'attributes' => [
			        	[
							'attribute' => 'name',
			                'label' => 'Nombres',
			                'format' => 'text',
						    'value' => Profile::find()->where(['user_id' => $model->user_id])->one()->name
			            ],
						[
							'attribute' => 'cedula',
			                'label' => 'Cédula',
						    'value' => Profile::find()->where(['user_id' => $model->user_id])->one()->cedula
						],
			            [
							'attribute' => 'sexo',
			                'label' => 'Sexo',
						    'value' => Profile::find()->where(['user_id' => $model->user_id])->one()->sexo
			            ], 
			            [
							'attribute' => 'peso',
			                'label' => 'Peso (Kg)',
						    'value' => Profile::find()->where(['user_id' => $model->user_id])->one()->peso
			            ], 
			            [
							'attribute' => 'telefono',
			                'label' => 'Teléfono',
						    'value' => Profile::find()->where(['user_id' => $model->user_id])->one()->telefono
			            ],
			            [
							'attribute' => 'fecha',
			                'label' => 'Edad',
						    'value' => Profile::getEdad(Profile::find()->where(['user_id' => $model->user_id])->one()->fecha)
			            ],
			            [
							'attribute' => 'id',
			                'label' => 'Email',
						    'value' => User::find()->where(['id' => $model->user_id])->one()->email
			            ] 
			        ],
			    ]) ?>
			</div>
		</div>
		
		<?php	if($dataProviderPeriodo && Paciente::getSexo()){ ?>
						<div class="form-group">
							<div class="col-xs-12 col-lg-6">
								<?php  if($dataProviderPeriodo && Paciente::getSexo()) { ?>
											<?php $this->registerJsFile('@web/js/moment.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
											<?php $this->registerJsFile('@web/js/fullcalendar.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
											<?php $this->registerJsFile('@web/js/locale-all.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
											<?php $this->registerJsFile('@web/js/calendario.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>

											<div id='calendar'></div>
								<?php 	} ?>
							</div>
						</div>
		<?php 	} ?>
			
		<div class="form-group">
			<div class="col-xs-12 col-lg-4">
				<div class="space_all"></div>
				<h2><?= Html::encode('Calcular Dosis') ?></h2>
				
				<?= $this->render('/formula/_form', [
			        'model' => $formula
			    ]) ?>
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-xs-12 col-lg-8">
				<div class="space_all"></div>
				<h2><?= Html::encode('Fórmulas') ?></h2>
				
				<?= $this->render('/control-caja/index', [
			        'dataProvider' => $controlCaja
			    ]) ?>
			</div>
		</div>
	</div>
</div>

<br>

<?php if($graficas){ ?>
	<?= $this->render('_grafica', ['model' => $graficas]) ?>
<?php } ?>
