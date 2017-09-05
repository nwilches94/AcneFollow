<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use app\models\Paciente;

/* @var $this yii\web\View */
/* @var $model app\models\Foto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="foto-form">

    <?php $form = ActiveForm::begin(); ?>
    
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
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', [
			'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
			'onclick' => "$('#file-input').fileinput('upload');"
		]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
