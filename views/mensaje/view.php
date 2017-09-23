<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Button;

use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Paciente;
use dektrium\user\models\profile;

$this->title = Yii::t('app', 'Historial de Mensajes');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('@vendor/dektrium/yii2-user/views/_alert', ['module' => Yii::$app->getModule('user'),]) ?>

<h3><?= Html::encode('Historial de Mensajes') ?></h3><br>
    
<?php Pjax::begin(); ?>    
	<?= GridView::widget([
	        'dataProvider' => $dataProvider,
	        'columns' => [
	        	[
			        'attribute' => 'origen',
			        'format' => 'raw',
			        'headerOptions' => ['width' => '10%'],
			        'value' => function ($data) {
			        	
						if(\Yii::$app->user->can('medico')){
							if($data->origen == 'medico')
								return 'Yo';
							else {
								$paciente=Paciente::find()->where(['id' => $data->paciente_id])->one();
								$profile=Profile::find()->where(['user_id' => $paciente['user_id']])->one();
								return '<span style="font-weight:bold; color:#777777">'.$profile['name'].'</span>';
							}
						}
						else
						{
							if($data->origen == 'paciente')
								return 'Yo';
							else {
								$profile=Profile::find()->where(['user_id' => $data->doctor_id])->one();
								return '<span style="font-weight:bold; color:#777777">'.$profile['name'].'</span>';
							}
						}
				     }
			    ],
				[
			        'attribute' => 'mensaje',
			        'format' => 'text',
			        'value'=> 'mensaje',
			        'value' => function ($data) {
						return Html::encode($data->mensaje);
				     }
			    ],
			    [
			        'attribute' => 'fecha',
			        'format' => 'text',
			        'label' => 'Fecha y Hora',
			        'headerOptions' => ['width' => '20%'],
			        'value' => function ($data) {
						return Yii::$app->formatter->asDate($data->fecha, 'php: d-m-Y h:i:s ').$data->ampm;
				     }
			    ],
	        ],
	    ]); 
	?>
<?php Pjax::end(); ?>

<br>

<div class="mensaje-index">

    <h3><?= Html::encode('Enviar Mensaje') ?></h3><br>

    <?= $this->render('_form', [
        'model' => $model, 'listaPaciente' => $listaPaciente
    ]) ?>

</div>
