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
			<?= $form->field($model, 'fecha')->widget(DatePicker::className(), ['language' => 'es', 'dateFormat' => 'php: d-m-Y'])->label('Fecha') ?>
			<?php 	if(true && \Yii::$app->user->can('medico'))
					{
						if($listaPaciente)
							echo $form->field($model, 'paciente_id')->dropDownList($listaPaciente, ['prompt'=>'Seleccione...'])->label('Seleccione el Paciente');
						else
						{
							echo 	'<div class="form-group field-formula-dosis required">
										<label class="control-label col-sm-3" for="formula-dosis">Seleccione el Paciente</label>
										<div class="col-sm-9">
											<p style="color:#FF0000; padding-top:1%; padding-bottom:0px">Debe crear un Paciente</p>
										</div>
									</div>';
						}
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
			<div class="col-lg-offset-3 col-lg-9">
	        	<?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-success']) ?>
	    		<?= Html::a(Yii::t('app', 'Regresar'), ['index'], ['class' => 'btn btn-primary']) ?>
			</div>
		</div>

    <?php ActiveForm::end(); ?>

</div>
