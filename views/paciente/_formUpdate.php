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

	<div class="alert alert-info">
        <?= Yii::t('user', 'Credentials will be sent to the user by email') ?>.
        <?= Yii::t('user', 'A password will be generated automatically if not provided') ?>.
    </div>
    
    <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'fieldConfig' => ['horizontalCssClasses' => ['wrapper' => 'col-sm-9'],],]); ?>
		
		<div class="form-group">
			<?= $form->field($profile, 'name')->textInput(['value' => $profile['name']])->label('Nombres'); ?>
			<?php 	if(!Yii::$app->user->identity->isAdmin)
					{ ?>
						<?= $form->field($profile, 'cedula')->textInput(['value' => $profile['cedula']])->label('Cedula'); ?>
						<?= $form->field($profile, 'sexo')->dropDownList(['Hombre' => 'Hombre', 'Mujer' => 'Mujer'], ['prompt'=>'Seleccione...'])->label('Sexo'); ?>
						<?= $form->field($profile, 'peso')->textInput(['value' => $profile['peso']]) ?>
						<?= $form->field($profile, 'telefono')->textInput(['value' => $profile['telefono']]) ?>
						<?= $form->field($profile, 'fecha')->widget(DatePicker::className(), ['language' => 'es', 'dateFormat' => 'php: d-m-Y'])->label('Fecha de Nacimiento') ?>	
			<?php 	} ?>
		</div>
		 
	    <div class="form-group">
			<div class="col-lg-offset-3 col-lg-9">
	        	<?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-success']) ?>
	    		<?= Html::a(Yii::t('app', 'Regresar'), ['index'], ['class' => 'btn btn-primary']) ?>
			</div>
		</div>

	<?php ActiveForm::end(); ?>
		
</div>
