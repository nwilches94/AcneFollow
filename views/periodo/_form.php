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
		
		<div class="form-group">
			
			<div class="col-lg-offset-0 col-lg-4" style="vertical-align:middle; padding-left:0px">
				<?= $form->field($model, 'fecha')->widget(DatePicker::className(), [
				    'language' => 'es', 'dateFormat' => 'php: d-m-Y', 'clientOptions' => ['changeMonth' => true,  'changeYear' => true]
				])->label('Seleccione la fecha') ?>
			</div>
			
			<div class="col-lg-offset-0 col-lg-2">
	        	<?= Html::submitButton(Yii::t('app', 'Generar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    	</div>
	  		
	  		<?php if($proximoPeriodo){ ?>
		  		<div class="col-lg-offset-0 col-lg-4">
		    		<?= "Tu próximo ciclo menstrual será aproximadamente el día:"; ?>
		    	</div>
		    	<div class="col-lg-offset-0 col-lg-0">
		    		<?= $proximoPeriodo ?>
		    	</div>
		    <?php } ?>
	    </div>

    <?php ActiveForm::end(); ?>

</div>
