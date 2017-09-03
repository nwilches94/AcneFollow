<?php

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
?>

<?= $form->field($user, 'name')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'email')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'sexo')->dropDownList(['Hombre' => 'Hombre', 'Mujer' => 'Mujer'], ['prompt'=>'Seleccione...'])->label('Sexo'); ?>
<?= $form->field($user, 'peso')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'telefono')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'password')->passwordInput() ?>
