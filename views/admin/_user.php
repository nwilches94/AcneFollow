<?php

use yii\jui\DatePicker;
use app\models\Profile;

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\User $user
 */
 	
 	if(Yii::$app->user->identity->isAdmin)
		$this->title = Yii::t('user', 'Crear Doctor');
	else
		$this->title = Yii::t('user', 'Crear Paciente');
	
	if($user->id)
 		$name=Profile::find()->where(['user_id' => $user->id])->one()->name;
	else
		$name="";
?>

<?= $form->field($user, 'name')->textInput(['maxlength' => 255, 'value' => $name, 'placeholder' => 'Nombres']) ?>

<?php 	if(!Yii::$app->user->identity->isAdmin)
		{ ?>
			<?= $form->field($user, 'cedula')->textInput(['maxlength' => 255, 'placeholder' => 'Cedula']) ?>
			<?= $form->field($user, 'sexo')->dropDownList(['Hombre' => 'Hombre', 'Mujer' => 'Mujer'], ['prompt'=>'Seleccione el Sexo'])->label('Sexo'); ?>
			<?= $form->field($user, 'peso')->textInput(['maxlength' => 255, 'placeholder' => 'Kg']) ?>
			<?= $form->field($user, 'telefono')->textInput(['maxlength' => 255, 'placeholder' => 'Teléfono']) ?>
			<?= $form->field($user, 'fecha')->widget(DatePicker::className(), ['language' => 'es', 'dateFormat' => 'php: d-m-Y', 'clientOptions' => ['changeMonth' => true,  'yearRange' => '-70:+0', 'changeYear' => true]])->textInput(['placeholder' => 'Clic para seleccionar la Fecha de Nacimiento'])->label('Fecha de Nacimiento') ?>
<?php 	} ?>

<?= $form->field($user, 'email')->textInput(['maxlength' => 255, 'placeholder' => 'Email']) ?>

<?php if(Yii::$app->user->identity->isAdmin){ ?>
	<?= $form->field($user, 'password')->passwordInput(['placeholder' => 'Contraseña']) ?>-->
<?php } ?>
