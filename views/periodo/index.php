<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */

$this->title = Yii::t('app', 'Seguimiento de Periodo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pacientes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="p-create">

    <h1><?= Html::encode($this->title) ?></h1><br>

    <?= $this->render('_form', [
        'model' => $model, 'proximoPeriodo' => $proximoPeriodo
    ]) ?>
    
    <br>
    
    <?php Pjax::begin(); ?>
	    <?= GridView::widget([
	            'dataProvider' => $dataProvider,
	            'columns' => [
	                [
				        'attribute' => 'fecha',
				        'format' => 'text',
				        'label' => 'Año',
				        'value' => function ($data) {
							return Yii::$app->formatter->asDate($data->fecha, 'php: Y');
					     }
				    ],
				    [
				        'attribute' => 'fecha',
				        'format' => 'text',
				        'label' => 'Mes',
				        'value' => function ($data) {
							return Yii::$app->formatter->asDate($data->fecha, 'php: m');
					     }
				    ],
				    [
				        'attribute' => 'fecha',
				        'format' => 'text',
				        'label' => 'Día',
				        'value' => function ($data) {
							return Yii::$app->formatter->asDate($data->fecha, 'php: d');
					     }
				    ],
	            ],
	        ]);
	    ?>
	<?php Pjax::end(); ?>

</div>
