<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="paciente-form">

    <?php $form = ActiveForm::begin(); ?>
	
		<?= $form->field($profile, 'user_id')->hiddenInput(['value' => $profile['user_id']])->label(false); ?>
	    <?= $form->field($profile, 'name')->textInput(['value' => $profile['name']]) ?>
		<?= $form->field($profile, 'sexo')->dropDownList(['Hombre' => 'Hombre', 'Mujer' => 'Mujer'], ['prompt'=>'Seleccione...'])->label('Sexo'); ?>
		<?= $form->field($profile, 'peso')->textInput(['value' => $profile['peso']]) ?>
		<?= $form->field($profile, 'telefono')->textInput(['value' => $profile['telefono']]) ?>
		
	    <div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    <?php ActiveForm::end(); ?>

</div>
