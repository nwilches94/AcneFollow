<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Paciente;
use dektrium\user\models\Profile;

/* @var $this yii\web\View */
/* @var $model app\models\Mensaje */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mensaje-index">
	
	<?php $form = ActiveForm::begin(); ?>
		
		<?php 	if(\Yii::$app->user->can('medico'))
				{
					if($listaPaciente)
						echo $form->field($model, 'paciente_id')->dropDownList($listaPaciente, ['prompt'=>'Seleccione...'])->label('Seleccione el Paciente');
					else
					{
						echo 	'<div class="form-group field-formula-dosis required">
									<label class="control-label col-sm-2" style="padding-left:0px">Seleccione el Paciente</label>
									<div class="col-sm-10">
										<p style="color:#FF0000; padding-top:0%; padding-bottom:0px">Debe crear un Paciente</p>
									</div>
								</div>';
					}
					echo $form->field($model, 'doctor_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false);
					echo $form->field($model, 'origen')->hiddenInput(['value' => 'medico'])->label(false);
				}
				else
				{
					$paciente=Paciente::find()->where(['user_id' => Yii::$app->user->id])->one();
					$profile=Profile::find()->where(['user_id' => $paciente['doctor_id']])->one();
					echo $form->field($model, 'paciente_id')->hiddenInput(['value' => $paciente['id']])->label(false);
					echo $form->field($model, 'doctor_id')->hiddenInput(['value' => $paciente['doctor_id']])->label(false);
					echo $form->field($model, 'origen')->hiddenInput(['value' => 'paciente'])->label(false);
					echo '<label class="control-label" for="mensaje-mensaje">Medico: </label> '.$profile['name']."<br><br>";
				}
	    ?>
	    
		<?= $form->field($model, 'mensaje')->textarea(['rows' => 10])->label('Mensaje') ?>
		
	    <div class="form-group">
	        <?= Html::submitButton('Enviar Mensaje', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	        <?php if(isset($_GET['id'])) { ?>
	        		<?= Html::a(Yii::t('app', 'Regresar'), ['index'], ['class' => 'btn btn-primary']) ?>
	    	<?php } ?>
	    </div>

    <?php ActiveForm::end(); ?>

</div>
