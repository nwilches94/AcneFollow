<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\Paciente;
use app\models\Examen;
use dektrium\user\models\profile;
use yii\bootstrap\Modal;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ExamenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

if(\Yii::$app->user->can('paciente'))
	$this->title = Yii::t('app', 'Exámenes');
else
	$this->title = Yii::t('app', 'Histórico de Exámenes');

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="examen-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	<br>
    <p>
    	<?php	if(\Yii::$app->user->can('paciente'))
        			echo Html::a(Yii::t('app', 'Cargar Examen'), ['create'], ['class' => 'btn btn-success']);
				else
					echo Html::a(Yii::t('app', 'Regresar'), ['paciente/view?id='.$_GET['id']], ['class' => 'btn btn-success']);
		?>
    </p>
  
	<?= GridView::widget([
	        'dataProvider' => $dataProvider,
	        'responsive' => true,
	        'columns' => [
            	['class' => 'yii\grid\SerialColumn'],
				[
			        'attribute' => 'fecha',
			        'format' => 'text',
			        'label' => 'Fecha',
			        'value' => function ($data) {
			        	return \Yii::$app->formatter->asDate($data->fecha, 'php: d-m-Y');
				     }
			    ],
			    'tipo',
	            'notas:ntext',
	            [
					'class' => 'yii\grid\ActionColumn',
			        'template' => '{view}{update}{delete}',
			        "visible" => \Yii::$app->user->can('paciente')
				],    						
				[
					'class' => 'yii\grid\ActionColumn',
			        'template' => '{view}',
			        'buttons' => [
			        	'view' => function($url, $model){
			        		if($model->tipo == 'Otro')
								return '';
							else
				            	return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['imagen', 'id' => $model->id, 'paciente_id' => $_GET['id']]);
				        }
				    ],
			        "visible" => \Yii::$app->user->can('medico')
				],
	        ],
	    ]); 
	?>

</div>
