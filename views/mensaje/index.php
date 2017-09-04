<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Button;

use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Paciente;
use app\models\Mensaje;
use dektrium\user\models\profile;

$this->title = Yii::t('app', 'Buzón de Mensajes');
$this->params['breadcrumbs'][] = $this->title;
?>

<h3><?= Html::encode($this->title) ?> <span class="badge"><?= $count ?> Nuevos</span></h3><br>

<div>
	<?php Pjax::begin(); ?>    
		<?= GridView::widget([
		        'dataProvider' => $dataProvider,
		        'columns' => [
	            	['class' => 'yii\grid\SerialColumn'],
	            	[
				        'attribute' => 'paciente_id',
				        'format' => 'text',
				        'label' => Mensaje::getLabel(),
				        'value' => function ($data) {
							if(\Yii::$app->user->can('paciente')){
								$paciente=Paciente::find()->where(['user_id' => Yii::$app->user->id])->one();
								$profile=Profile::find()->where(['user_id' => $paciente['doctor_id']])->one();
							}
							else{
								$paciente=Paciente::find()->where(['id' => $data->paciente_id])->one();
								$profile=Profile::find()->where(['user_id' => $paciente['user_id']])->one();
							}
							return $profile['name'];
					     }
				    ],
				    [
				        'attribute' => 'mensaje',
				        'format' => 'raw',
				        'label' => 'Mensaje',
				        'value'=> 'mensaje',
				        'headerOptions' => ['width' => '40%'],
				        'value' => function ($data) {
							return "<span style='".Mensaje::nuevoMensaje($data->id)."'>".substr($data->mensaje, 0, 50)."</span>";
						}
				    ],
					[
				        'attribute' => 'fecha',
				        'format' => 'text',
				        'label' => 'Fecha',
				        'headerOptions' => ['width' => '10%'],
				        'value' => function ($data) {
							return Yii::$app->formatter->asDate($data->fecha, 'php: d-m-Y');
					     }
				    ],
				    [
						'class' => 'yii\grid\ActionColumn',
				        'template' => '{view}',
				        'buttons' => [
			                'view' => function ($url,$model,$key) {
			               		return Html::a('Ver Historial de Mensajes', '/mensaje/leido?id='.$model->doctor_id."&paciente_id=".$model->paciente_id);
			                },
				        ],
					],
					[
	                    'class' => 'yii\grid\ActionColumn',
	                    'template' => '{delete}',
	                    "visible" => \Yii::$app->user->can('medico')
	                ],
		        ],
		    ]); 
		?>
	<?php Pjax::end(); ?>
	
</div>

<br>

<div class="mensaje-index">

    <h3><?= Html::encode('Enviar Mensaje') ?></h3><br>

    <?= $this->render('_form', [
        'model' => $model, 'listaPaciente' => $listaPaciente
    ]) ?>

</div>