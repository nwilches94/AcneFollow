<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="periodo-form">

	<div class="form-group">
				
		<div class="col-xs-12 col-lg-6" style="vertical-align:middle; padding-left:0px">
			
			<?php $form = ActiveForm::begin(); ?>
				
				<?php if($proximoPeriodo){ ?>
					<?php 	echo $form->field($model, 'fechaI')->hiddenInput(['value' => json_encode($model['fechaI'])])->label(false);
							echo $form->field($model, 'fechaF')->hiddenInput(['value' => json_encode($model['fechaF'])])->label(false);
							echo $form->field($model, 'fechaFC')->hiddenInput(['value' => json_encode($model['fechaFC'])])->label(false);
							echo $form->field($model, 'fechaA')->hiddenInput(['value' => json_encode($model['fechaA'])])->label(false);
					?>
				<?php } ?>
				
				<h2><?= Html::encode('Crear un Seguimiento de Periodos') ?></h2>
				 
				<div class="col-xs-12 col-lg-12" style="vertical-align:middle; padding-left:0px">			
					<div class="col-xs-3 col-lg-5 periodo">
						<?= $form->field($model, 'fecha')->widget(DatePicker::className(), [
						    'language' => 'es', 'dateFormat' => 'php: d-m-Y', 'clientOptions' => ['multidate' => false, 'autoclose' => true, 'changeMonth' => true, 'changeYear' => true]
						])->textInput(['placeholder' => 'Fecha Inicio de Periodo'])->label(false); ?>
					</div>
					<div class="col-xs-12 col-lg-5 periodo">
						<?= $form->field($model, 'fechaFin')->widget(DatePicker::className(), [
						    'language' => 'es', 'dateFormat' => 'php: d-m-Y', 'clientOptions' => ['multidate' => false, 'autoclose' => true, 'changeMonth' => true, 'changeYear' => true]
						])->textInput(['placeholder' => 'Fecha Fin de Periodo'])->label(false); ?>
					</div>
					
					<?= Html::submitButton(Yii::t('app', 'Generar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			    	
			    </div>
			    
			<?php ActiveForm::end(); ?>
			
		    <br><h2><?= Html::encode('Histórico de Seguimiento de Periodos') ?></h2>
		    <?php Pjax::begin(); ?>
			    <?= GridView::widget([
			            'dataProvider' => $dataProvider,
			            'responsive' => true,
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
						    [
								'class' => 'yii\grid\ActionColumn',
						        'template' => '{update}{delete}'
							],
			            ],
			        ]);
			    ?>
			<?php Pjax::end(); ?>

		</div>
	</div>
	    
    <?php $this->registerJsFile('@web/js/moment.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
	<?php $this->registerJsFile('@web/js/fullcalendar.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
	<?php $this->registerJsFile('@web/js/locale-all.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
	<?php $this->registerJsFile('@web/js/calendario.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
	
	<?php if($proximoPeriodo){ ?>
	    <div class="form-group">
	    	<div class="col-xs-12 col-lg-6">
	    		<div id='calendar'></div>
	    	</div>
	    </div>
   <?php } ?>
</div>
