<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="paciente-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'fieldConfig' => ['horizontalCssClasses' => ['wrapper' => 'col-sm-9'],],]); ?>
		
		<div class="form-group">
			<?= $form->field($profile, 'user_id')->hiddenInput(['value' => $profile['user_id']])->label(false); ?>
		    <?= $form->field($profile, 'name')->textInput(['value' => $profile['name']]) ?>
			<?= $form->field($profile, 'sexo')->dropDownList(['Hombre' => 'Hombre', 'Mujer' => 'Mujer'], ['prompt'=>'Seleccione...'])->label('Sexo'); ?>
			<?= $form->field($profile, 'peso')->textInput(['value' => $profile['peso']]) ?>
			<?= $form->field($profile, 'telefono')->textInput(['value' => $profile['telefono']]) ?>
			<?= $form->field($profile, 'fecha')->widget(DatePicker::className(), ['language' => 'es', 'dateFormat' => 'php: d-m-Y'])->label('Fecha de Nacimiento') ?>
		</div>
		 
	    <div class="form-group">
			<div class="col-lg-offset-3 col-lg-9">
	        	<?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-success']) ?>
	    		<?= Html::a(Yii::t('app', 'Regresar'), ['index'], ['class' => 'btn btn-primary']) ?>
			</div>
		</div>

    <?php ActiveForm::end(); ?>

</div>
