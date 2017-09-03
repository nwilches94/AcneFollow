<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Examen */

$this->title = Yii::t('app', 'Cargar Fotos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fotos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="foto-create">
	
    <h1><?= Html::encode($this->title) ?></h1><br>
    
    <?php Pjax::begin(); ?>    
		<?= GridView::widget([
		        'dataProvider' => $dataProvider,
		        'columns' => [
	            	['class' => 'yii\grid\SerialColumn'],
	            	[
				        'attribute' => 'name',
				        'format' => 'text',
				        'label' => 'Nombre',
				    ],
				    [
				        'attribute' => 'mime',
				        'format' => 'text',
				        'label' => 'Tipo',
				    ],
		            ['class' => 'yii\grid\ActionColumn'],
		        ],
		    ]); 
		?>
	<?php Pjax::end(); ?></div>

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>
    
</div>
