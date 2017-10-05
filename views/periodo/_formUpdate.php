<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use app\models\Periodo;

/* @var $this yii\web\View */
/* @var $model app\models\ControlCaja */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
	#periodo-fecha{
		width: 50%; 	
	}
	
	#periodo-fechafin{
		width: 50%; 	
	}
</style>

<div class="periodo-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'fieldConfig' => ['horizontalCssClasses' => ['wrapper' => 'col-sm-9'],],]); ?>
	
			<?= $form->field($model, 'fecha')->widget(DatePicker::className(), [
			    'language' => 'es', 'dateFormat' => 'php: d-m-Y', 'clientOptions' => ['multidate' => false, 'autoclose' => true, 'changeMonth' => true, 'changeYear' => true]
			])->textInput(['placeholder' => 'Fecha de Inicio de Periodo'])->label('Fecha de Inicio de Periodo'); ?>
	
			<?= $form->field($model, 'fechaFin')->widget(DatePicker::className(), [
			    'language' => 'es', 'dateFormat' => 'php: d-m-Y', 'clientOptions' => ['multidate' => false, 'autoclose' => true, 'changeMonth' => true, 'changeYear' => true]
			])->textInput(['placeholder' => 'Fecha de Fin de Periodo'])->label('Fecha de Fin de Periodo'); ?>
	
			<div class="form-group">
				<div class="col-lg-offset-3 col-lg-9">
		        	<?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-success']) ?>
		    	</div>
			</div>
		
    <?php ActiveForm::end(); ?>

</div>
