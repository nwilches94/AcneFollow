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
    
<style>
	.ui-datepicker-calendar {
    	display: none;
	}​
</style>

<?php $this->registerJsFile('@web/js/datePicker.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>

<div class="grafica-form">
	
    <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'action' => '/grafica/update?id='.$_GET['id'].'&paciente_id='.$_GET['paciente_id'].'&grafica='.$_GET['grafica'], 'fieldConfig' => ['horizontalCssClasses' => ['wrapper' => 'col-sm-9'],],]); ?>
		
		<div class="form-group">
			<?= $form->field($model, 'fecha')->widget(DatePicker::className()) ?>
			<?= $form->field($model, 'tipo')->dropDownList(['TGO' => 'TGO', 'TGP' => 'TGP', 'Colesterol' => 'Colesterol', 'Triglicéridos' => 'Triglicéridos'], ['prompt'=>'Seleccione el Tipo de Examen'])->label('Tipo de Examen'); ?>
			<?= $form->field($model, 'valorExamen')->textInput(['placeholder' => 'Parametro 1'])->label('Valor del Examen'); ?>
			<?= $form->field($model, 'valorReferencia')->textInput(['placeholder' => 'Parametro 2'])->label('Valor de Referencia'); ?>
		</div>
		
	    <div class="form-group">
			<div class="col-lg-offset-3 col-lg-9">
				<?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-success']) ?>
			</div>
		</div>

    <?php ActiveForm::end(); ?>

</div>