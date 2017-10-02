<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use app\models\Paciente;
use dektrium\user\models\Profile;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="formula-form">
	
    <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'fieldConfig' => ['horizontalCssClasses' => ['wrapper' => 'col-sm-9'],],]); ?>
		
		<div class="form-group">
			<?php 	$paciente=Paciente::find()->where(['user_id' => Yii::$app->user->id])->one();
					$profile=Profile::find()->where(['user_id' => $paciente['doctor_id']])->one();
					echo $form->field($model, 'paciente_id')->hiddenInput(['value' => $_GET['id']])->label(false);
					echo $form->field($model, 'doctor_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false);
	    	?>
			<?= $form->field($model, 'fecha')->widget(DatePicker::className(), ['language' => 'es', 'dateFormat' => 'php: d-m-Y', 'clientOptions' => ['changeMonth' => true, 'changeYear' => true]])->textInput(['placeholder' => 'Clic para seleccionar la Fecha'])->label('Fecha') ?>
	    	<?= $form->field($model, 'peso')->textInput(['value' => $model['peso'], 'placeholder' => 'Peso']); ?>
	    	<?= $form->field($model, 'dosis')->dropDownList(['120' => '120', '135' => '135', '150' => '150', '200' => '200'], ['prompt'=>'Seleccione la dosis']); ?>
	    	<?= $form->field($model, 'capsula')->textInput(['value' => $model['capsula'], 'placeholder' => 'mg']) ?>
		    <?= $form->field($model, 'cajas')->textInput(['value' => $model['cajas'], 'placeholder' => '#']) ?> 
	    </div>
	    
	    <div class="form-group">
			<div class="col-lg-offset-3 col-sm-12 col-lg-9">
	        	<?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-success']) ?>
	    	</div>
		</div>

    <?php ActiveForm::end(); ?>

</div>

<div id="peso" style="display:none"></div>

<script>
	window.onload=function()
	{
		var idPaciente= $('#formula-paciente_id').val();
		var server= '<?= $_SERVER['HTTP_HOST'] ?>';
		var http = 'http://';
		
		if(idPaciente)
		{
			$("#peso").load(http+server+'/formula/peso?id='+idPaciente,
			function(response, status, xhr)
			{
				if(status != "error")
		    		$('#formula-peso').prop('value', response);
			});
		}
	};
</script>
