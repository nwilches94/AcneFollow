<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use app\models\Paciente;

/* @var $this yii\web\View */
/* @var $model app\models\Examen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="examen-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 	if(true && \Yii::$app->user->can('medico'))
				echo $form->field($model, 'paciente_id')->dropDownList($listaPaciente, ['prompt'=>'Seleccione...'])->label('Pacientes');
			else
			{
				$paciente=Paciente::find()->where(['user_id' => Yii::$app->user->id])->one();
				echo $form->field($model, 'paciente_id')->hiddenInput(['value' => $paciente['id']])->label(false);
			}
    ?>
    
	<?= $form->field($model, 'fecha')->widget(DatePicker::className(), [
	    'language' => 'es', 'dateFormat' => 'php: M, Y',
	]) ?>

    <?= $form->field($model, 'notas')->textarea(['rows' => 4]) ?>

    <?= \nemmo\attachments\components\AttachmentsInput::widget([
            'id' => 'file-input', // Optional
            'model' => $model,
            'options' => [ // Options of the Kartik's FileInput widget
                'multiple' => true, // If you want to allow multiple upload, default to false
            ],
            'pluginOptions' => [ // Plugin options of the Kartik's FileInput widget 
                'maxFileCount' => 10 // Client max files
            ]
        ])
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>