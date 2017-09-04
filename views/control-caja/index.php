<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Paciente;
use dektrium\user\models\Profile;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Control de Cajas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="control-caja-index">

    <h1><?= Html::encode($this->title) ?></h1><br>
	
	<?php if(\Yii::$app->user->can('medico')){ ?>
		<p>
			<?= Html::a('Crear Control de Caja', ['create'], ['class' => 'btn btn-success']) ?>
	 	</p>
	<?php } ?>
	
	<br>
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
		        'attribute' => 'fecha',
		        'format' => 'text',
		        'label' => 'Fecha',
		        'value' => function ($data) {
					return Yii::$app->formatter->asDate($data->fecha, 'php: d-m-Y');
			     }
		    ],
            [
                'label' => 'Paciente',
			    'value' => function ($data) {
			    	$paciente=Paciente::find()->where(['id' => $data->paciente_id])->one();
					$profile=Profile::find()->where(['user_id' => $paciente['user_id']])->one();
					return $profile['name'];
			     },
			     "visible" => \Yii::$app->user->can('medico')
            ],
            'cajaTomada',
            'dosisAcumulada',
            'dosisRestante',
            'dosisCaja',
            [
				'class' => 'yii\grid\ActionColumn',
		        'template' => '{update}{delete}',
		        "visible" => \Yii::$app->user->can('medico')
			],
        ],
    ]); ?>
</div>
