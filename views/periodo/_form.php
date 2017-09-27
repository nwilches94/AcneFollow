<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="periodo-form">

    <?php $form = ActiveForm::begin(); ?>
		
		<?php 	echo $form->field($model, 'fechaI')->hiddenInput(['value' => $model['fechaI']])->label(false);
				echo $form->field($model, 'fechaF')->hiddenInput(['value' => $model['fechaF']])->label(false);
				echo $form->field($model, 'fechaA')->hiddenInput(['value' => $model['fechaA']])->label(false);
		?>
		<div class="form-group">
			
			<div class="col-sm-3 col-lg-8" style="vertical-align:middle; padding-left:0px">
				<div class="col-sm-3 col-lg-8" style="vertical-align:middle; padding-left:0px">			
					<div class="col-sm-2 col-lg-5" style="vertical-align:middle; padding-left:0px; width: 45%">
						<?= $form->field($model, 'fecha')->widget(DatePicker::className(), [
						    'language' => 'es', 'dateFormat' => 'php: d-m-Y', 'clientOptions' => ['multidate' => false, 'autoclose' => true, 'changeMonth' => true, 'changeYear' => true]
						])->textInput(['placeholder' => 'Fecha Inicio de Periodo'])->label(false); ?>
					</div>
					
					<div class="col-sm-2 col-lg-5" style="vertical-align:middle; padding-left:0px; width: 45%">
						<?= $form->field($model, 'fechaFin')->widget(DatePicker::className(), [
						    'language' => 'es', 'dateFormat' => 'php: d-m-Y', 'clientOptions' => ['multidate' => false, 'autoclose' => true, 'changeMonth' => true, 'changeYear' => true]
						])->textInput(['placeholder' => 'Fecha Fin de Periodo'])->label(false); ?>
					</div>
					
					<div class="col-sm-1 col-lg-1">
			        	<?= Html::submitButton(Yii::t('app', 'Generar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			    	</div>
			    </div>
			    
			    <div class="col-sm-3 col-lg-7" style="vertical-align:middle; padding-left:0px">
			    	<?php if($proximoPeriodo){ ?>
					  		<div class="col-sm-2 col-lg-12" style="vertical-align:middle; padding-left:0px">
					  			<br><?= "Tu próximo ciclo menstrual será aproximadamente el día: <strong>".$proximoPeriodo."</strong>" ?>
					    	</div>
				    <?php } ?>
				</div>
			</div>
		    
		    <div class="col-sm-3 col-lg-3">
	    		<div id="datepicker"></div>
	    	</div>
	    	
	    	<div class="col-sm-3 col-lg-1"></div>
	    </div>

    <?php ActiveForm::end(); ?>
    
</div>


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
