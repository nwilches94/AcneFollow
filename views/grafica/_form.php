<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use app\models\Examen;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */
/* @var $form yii\widgets\ActiveForm */
?>

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
	     
    <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'action' => '/grafica/index?id='.$_GET['id'].'&paciente_id='.$_GET['paciente_id'], 'fieldConfig' => ['horizontalCssClasses' => ['wrapper' => 'col-sm-9'],],]); ?>
		
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

<?php if($dataProvider) { ?>
	
	<div class="garfica-create">
		
		<br>
		<h1><?= Html::encode('Histórico de Estadísticas') ?></h1>
		
	    <?php Pjax::begin(); ?>
		    <?= GridView::widget([
		            'dataProvider' => $dataProvider,
		            'responsive' => true,
		            'columns' => [
					    [
					        'attribute' => 'tipo',
					        'format' => 'text',
					        'label' => 'Tipo de Examen',
					        'value' => 'tipo'
					    ],
					    [
					        'attribute' => 'fecha',
					        'format' => 'text',
					        'label' => 'Fecha',
					        'value' => function ($data) {
					        	return Examen::changeDateEspanol(\Yii::$app->formatter->asDate($data->fecha, 'php: F Y'));
						     }
					    ],
					    [
					        'attribute' => 'valorExamen',
					        'format' => 'text',
					        'label' => 'Valor del Examen',
					        'value' => 'valorExamen'
					    ],
					    [
					        'attribute' => 'valorReferencia',
					        'format' => 'text',
					        'label' => 'Valor de Referencia',
					        'value' => 'valorReferencia'
					    ],
					    [
							'class' => 'yii\grid\ActionColumn',
					        'template' => '{view}{delete}',
					        'buttons' => [
					        	'view' => function($url, $model){
					        		return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/grafica/update', 'id' => $_GET['id'], 'paciente_id' => $_GET['paciente_id'], 'grafica' => $model->id]);
						        },
					        	'delete' => function($url, $model){
					        		return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/grafica/delete', 'id' => $_GET['id'], 'paciente_id' => $_GET['paciente_id'], 'grafica' => $model->id], 
					        		['title' => 'Eliminar', 'aria-label' => 'Eliminar', 'data-pjax' => '0', 'data-confirm' => '¿Está seguro de eliminar este elemento?', 'data-method' => 'post']);
						        }
						    ],
						],
		            ],
		        ]);
		    ?>
		<?php Pjax::end(); ?>
		
	</div>
	
<?php } ?>
