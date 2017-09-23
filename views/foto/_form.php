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
    	
    	<?= $form->field($model, 'fecha')->widget(DatePicker::className(), ['language' => 'es', 'dateFormat' => 'php: d-m-Y', 'clientOptions' => ['changeMonth' => true,  'yearRange' => '-70:+0', 'changeYear' => true]])->textInput(['placeholder' => 'Clic para seleccionar la Fecha'])->label('Fecha') ?>
    	
	    <?= \nemmo\attachments\components\AttachmentsInput::widget([
	            'id' => 'file-input', // Optional
	            'model' => $model,
	            'options' => [ // Options of the Kartik's FileInput widget
	                'multiple' => true, // If you want to allow multiple upload, default to false
	            ],
	            'pluginOptions' => [ // Plugin options of the Kartik's FileInput widget 
	            	'allowedFileExtensions'=>['jpg','gif','png'],
	                'maxFileCount' => 10 // Client max files
	            ]
	        ])
	    ?>
	    
	    <?= $form->field($model, 'notas')->textarea(['rows' => 4]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Cargar la Foto' : 'Actualizar la Foto', [
			'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
			'onclick' => "$('#file-input').fileinput('upload');"
		]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
