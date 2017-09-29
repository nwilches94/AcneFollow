<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="periodo-form">

    <?php $form = ActiveForm::begin(); ?>
		
		<?php 	echo $form->field($model, 'fechaI')->hiddenInput(['value' => $model['fechaI']])->label(false);
				echo $form->field($model, 'fechaF')->hiddenInput(['value' => $model['fechaF']])->label(false);
				echo $form->field($model, 'fechaFC')->hiddenInput(['value' => $model['fechaFC']])->label(false);
				echo $form->field($model, 'fechaA')->hiddenInput(['value' => $model['fechaA']])->label(false);
		?>
		<div class="form-group">
			
			<div class="col-sm-6 col-lg-6" style="vertical-align:middle; padding-left:0px">
				
				 <h2><?= Html::encode('Crear un Seguimiento de Periodos') ?></h2>
				 
				<div class="col-sm-6 col-lg-12" style="vertical-align:middle; padding-left:0px">			
					<div class="col-sm-2 col-lg-5" style="vertical-align:middle; padding-left:0px; width: 42%">
						<?= $form->field($model, 'fecha')->widget(DatePicker::className(), [
						    'language' => 'es', 'dateFormat' => 'php: d-m-Y', 'clientOptions' => ['multidate' => false, 'autoclose' => true, 'changeMonth' => true, 'changeYear' => true]
						])->textInput(['placeholder' => 'Fecha Inicio de Periodo'])->label(false); ?>
					</div>
					<div class="col-sm-2 col-lg-5" style="vertical-align:middle; padding-left:0px; width: 42%">
						<?= $form->field($model, 'fechaFin')->widget(DatePicker::className(), [
						    'language' => 'es', 'dateFormat' => 'php: d-m-Y', 'clientOptions' => ['multidate' => false, 'autoclose' => true, 'changeMonth' => true, 'changeYear' => true]
						])->textInput(['placeholder' => 'Fecha Fin de Periodo'])->label(false); ?>
					</div>
					<div class="col-sm-1 col-lg-1">
			        	<?= Html::submitButton(Yii::t('app', 'Generar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			    	</div>
			    </div>

				<br><br><br>
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
	    </div>
	    
	    <?php $this->registerJsFile('@web/js/moment.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
		<?php $this->registerJsFile('@web/js/fullcalendar.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
		<?php $this->registerJsFile('@web/js/locale-all.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
		<?php $this->registerJsFile('@web/js/calendario.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>

	    <div class="form-group">
	    	<div class="col-sm-6 col-lg-6">
	    		<div id='calendar'></div>
	    	</div>
	    </div>

    <?php ActiveForm::end(); ?>
    
</div>
