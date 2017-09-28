<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use dektrium\user\models\Profile;
use dektrium\user\models\User;
use app\models\Paciente;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pacientes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paciente-view">

    <h1><?= Html::encode('Datos del Paciente') ?></h1><br>
    
    <div class="row"> 
    	
	    <div class="form-group">
			<div class="col-lg-offset-0 col-lg-9">
				<?= Html::a(Yii::t('app', 'Ver Galería'), ['/foto/galeria?id='.$_GET['id']], ['class' => 'btn btn-success']) ?>
		    	<?= Html::a(Yii::t('app', 'Ver Exámenes'), ['/examen/index?id='.$_GET['id']], ['class' => 'btn btn-success']) ?>
		    	<?= Html::a(Yii::t('app', 'Regresar'), ['index'], ['class' => 'btn btn-primary']) ?>
			</div>
		</div>
		<br><br>
		
		<?php	$form = ActiveForm::begin();
					echo $form->field($modelP, 'fechaI')->hiddenInput(['value' => $modelP['fechaI']])->label(false);
					echo $form->field($modelP, 'fechaF')->hiddenInput(['value' => $modelP['fechaF']])->label(false);
					echo $form->field($modelP, 'fechaA')->hiddenInput(['value' => $modelP['fechaA']])->label(false);
				ActiveForm::end(); 
		?>
		
		<?php	if($dataProviderPeriodo && Paciente::getSexo()){
					$sm=4; $lg=9;
				}
				else {
					$sm=6; $lg=12;
				}
		?>
		<div class="form-group">
			<div class="col-sm-<?= $sm ?> col-lg-<?= $lg ?>">	
				
				<br><h2><?= Html::encode('Datos del Paciente') ?></h2>
				
			    <?= DetailView::widget([
			        'model' => $model,
			        'attributes' => [
			        	[
			            	'label' => 'Paciente ID',
							'attribute' => 'id'
			            ],
			        	[
							'attribute' => 'name',
			                'label' => 'Nombres',
						    'value' => function ($model) {
								$profile=Profile::find()->where(['user_id' => $model->user_id])->one();
								return $profile['name'];
						     }
			            ],
						[
							'attribute' => 'cedula',
			                'label' => 'Cedula',
						    'value' => function ($model) {
								$profile=Profile::find()->where(['user_id' => $model->user_id])->one();
								return $profile['cedula'];
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
			            ],
			            [
							'attribute' => 'id',
			                'label' => 'Email',
						    'value' => function ($model) {
								$user=User::find()->where(['id' => $model->user_id])->one();
								return $user['email'];
						     }
			            ] 
			        ],
			    ]) ?>
			</div>
		</div>
		
		<?php	if($dataProviderPeriodo && Paciente::getSexo()){ ?>
						<div class="form-group">
							<div class="col-sm-3 col-lg-3">
								<?php  if($dataProviderPeriodo && Paciente::getSexo()) { ?>
											<br><h2><?= Html::encode('Ciclo Menstrual') ?></h2>
											<div id="datepicker"></div>
											<br><br><br><br>
								<?php 	} ?>
							</div>
						</div>
		<?php 	} ?>
				
		<div class="form-group">
			<div class="col-sm-2 col-lg-4">
				<h2><?= Html::encode('Calcular Dosis') ?></h2>
				
				<?= $this->render('/formula/_form', [
			        'model' => $formula
			    ]) ?>
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-sm-4 col-lg-8">
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

<?php $this->registerJsFile('@web/js/bootstrap-datepicker.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>

<script>
	window.onload=function()
	{
		var fechaI = $('#periodo-fechai').val();
		var fechasI=fechaI.split('-');
		
		var fechaF = $('#periodo-fechaf').val();
		var fechasF=fechaF.split('-');
		
		var fechaA= $('#periodo-fechaa').val();
		var fechasA=fechaA.split('-');
		
		$('#datepicker').datepicker({multidate: false, autoclose: true});
		$('#datepicker').datepicker('setDates', [new Date(fechasI[0], fechasI[1], fechasI[2]), new Date(fechasF[0], fechasF[1], fechasF[2]), new Date(fechasA[0], fechasA[1], fechasA[2])]);
	};
</script>
