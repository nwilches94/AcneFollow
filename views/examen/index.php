<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Paciente;
use dektrium\user\models\profile;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ExamenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Examenes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="examen-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Cargar Examen'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	<?php Pjax::begin(); ?>    
		<?= GridView::widget([
		        'dataProvider' => $dataProvider,
		        'filterModel' => $searchModel,
		        'columns' => [
	            	['class' => 'yii\grid\SerialColumn'],
					[
				        'attribute' => 'fecha',
				        'format' => 'text',
				        'label' => 'Fecha',
				        'value' => function ($data) {
							return Yii::$app->formatter->asDate($data->fecha, 'php: M, Y');
					     }
				    ],
		            'notas:ntext',
		            ['class' => 'yii\grid\ActionColumn'],
		        ],
		    ]); 
		?>
	<?php Pjax::end(); ?>
</div>
