<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use app\models\Paciente;
use dektrium\user\models\Profile;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="formula-form">

    <?php $form = ActiveForm::begin(); ?>
		
		<div class="form-group">
			<?= $form->field($model, 'fecha')->widget(DatePicker::className(), ['language' => 'es', 'dateFormat' => 'php: d-m-Y'])->label('Fecha') ?>
			<?php 	if(true && \Yii::$app->user->can('medico'))
					{
						echo $form->field($model, 'paciente_id')->dropDownList($listaPaciente, ['prompt'=>'Seleccione...'])->label('Seleccione el Paciente');
						echo $form->field($model, 'doctor_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false);
					}
					else
					{
						$paciente=Paciente::find()->where(['user_id' => Yii::$app->user->id])->one();
						$profile=Profile::find()->where(['user_id' => $paciente['doctor_id']])->one();
						echo $form->field($model, 'paciente_id')->hiddenInput(['value' => $paciente['id']])->label(false);
					}
	    	?>
		    <?= $form->field($model, 'dosis')->textInput(['value' => $model['dosis']])->label('Dosis (mg)') ?>
		    <?= $form->field($model, 'capsula')->textInput(['value' => $model['capsula']])->label('Cápsula (mg)') ?>
		    <?= $form->field($model, 'cajas')->textInput(['value' => $model['cajas']]) ?> 
	    </div>
	    
	    <div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    	<?= Html::a(Yii::t('app', 'Regresar'), ['index'], ['class' => 'btn btn-primary']) ?>
	    </div>

    <?php ActiveForm::end(); ?>

</div>
