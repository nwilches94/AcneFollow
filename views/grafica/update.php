<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use app\models\Examen;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */
/* @var $form yii\widgets\ActiveForm */
?>


<h1><?= Html::encode('Actualizar Estadística') ?></h1>

<div class="alert alert-info">
    <?= Yii::t('user', 'Una vez generada la estadística se va mostrar en la vista del Paciente') ?>.
</div>

<div class="grafica-form">
	
    <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'action' => '/grafica/update?id='.$_GET['id'].'&grafica='.$_GET['grafica'], 'fieldConfig' => ['horizontalCssClasses' => ['wrapper' => 'small col-xs-9 col-ms-9 col-md-9 col-lg-9'],],]); ?>
		
		<div class="form-group">
			<?= $form->field($model, 'fecha')->widget(DatePicker::className(), ['language' => 'es', 'dateFormat' => 'php: d-m-Y', 'clientOptions' => ['changeMonth' => true, 'changeYear' => true]])->textInput(['placeholder' => 'Clic para seleccionar la Fecha'])->label('Fecha') ?>
			<?= $form->field($model, 'tipo')->dropDownList(['TGO' => 'TGO', 'TGP' => 'TGP', 'Colesterol' => 'Colesterol', 'Triglicéridos' => 'Triglicéridos'], ['prompt'=>'Seleccione el Tipo de Examen'])->label('Tipo de Examen'); ?>
			<?= $form->field($model, 'valorExamen')->textInput(['placeholder' => 'Parametro 1'])->label('Valor del Examen'); ?>
			<?= $form->field($model, 'valorReferencia')->textInput(['placeholder' => 'Parametro 2'])->label('Valor de Referencia'); ?>
		</div>
		
	    <div class="form-group">
			<div class="small col-xs-offset-3 col-ms-offset-3 col-md-offset-3 col-lg-offset-3 col-xs-9 col-ms-9 col-md-9 col-lg-9">
				<?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-success']) ?>
			</div>
		</div>

    <?php ActiveForm::end(); ?>

</div>