<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use app\models\Paciente;

/* @var $this yii\web\View */
/* @var $model app\models\Examen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="examen-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'fieldConfig' => ['horizontalCssClasses' => ['wrapper' => 'col-sm-9'],],]); ?>

	    <?php 	if(\Yii::$app->user->can('medico'))
					echo $form->field($model, 'paciente_id')->dropDownList($listaPaciente, ['prompt'=>'Seleccione...'])->label('Pacientes');
				else
				{
					$paciente=Paciente::find()->where(['user_id' => Yii::$app->user->id])->one();
					echo $form->field($model, 'paciente_id')->hiddenInput(['value' => $paciente['id']])->label(false);
				}
	    ?>
	    
	    <?= $form->field($model, 'fecha')->widget(DatePicker::className(), ['language' => 'es', 'dateFormat' => 'php: d-m-Y', 'clientOptions' => ['changeMonth' => true, 'changeYear' => true]])->textInput(['placeholder' => 'Clic para seleccionar la Fecha'])->label('Fecha') ?>
		
		<?= $form->field($model, 'tipo')->dropDownList(['TGO' => 'TGO', 'TGP' => 'TGP', 'Colesterol' => 'Colesterol', 'Triglicéridos' => 'Triglicéridos', 'Otro' => 'Otro'], ['prompt'=>'Seleccione el Tipo de Examen'])->label('Tipo de Examen'); ?>
		
		<div class="form-group">
			<div class="col-lg-offset-3 col-lg-9">
			    <?= \nemmo\attachments\components\AttachmentsInput::widget([
			            'id' => 'fileIinput', // Optional
			            'model' => $model,
			            'options' => [ // Options of the Kartik's FileInput widget
			                'multiple' => true, // If you want to allow multiple upload, default to false
			            ],
			            'pluginOptions' => [ // Plugin options of the Kartik's FileInput widget 
			            	'allowedFileExtensions'=>['jpg', 'jpeg', 'jpe', 'gif', 'png', 'doc', 'docx', 'pdf'],
			                'maxFileCount' => 10 // Client max files
			            ]
			        ])
			    ?>
			</div>
		</div>  
		
		<?= $form->field($model, 'notas')->textarea(['rows' => 4]) ?>
		 
	
	    <div class="form-group">
			<div class="col-lg-offset-3 col-lg-9">
	        	<?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-success']) ?>
	    		<?= Html::a(Yii::t('app', 'Regresar'), ['index'], ['class' => 'btn btn-primary']) ?>
			</div>
		</div>

    <?php ActiveForm::end(); ?>

</div>
