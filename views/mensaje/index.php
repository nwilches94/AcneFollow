<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Button;

use yii\widgets\Pjax;
use kartik\grid\GridView;
use app\models\Paciente;
use app\models\Mensaje;
use dektrium\user\models\profile;

$this->title = Yii::t('app', 'Buzón de Mensajes ');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('@vendor/dektrium/yii2-user/views/_alert', ['module' => Yii::$app->getModule('user'),]) ?>

<h3><?= Html::encode($this->title) ?> <span class="badge"><?= $count ?> Nuevos</span></h3><br>

<?php if(\Yii::$app->user->can('medico')){ ?>						
	<?php $form = ActiveForm::begin(['method' => 'get', 'action' => Url::toRoute('mensaje/index')]); ?>
		
		<div class="form-group">
			<div class="col-lg-offset-0 col-lg-4" style="padding-left:0px">
				<?= $form->field($model, 'buscar')->textInput(['placeholder' => "Búsqueda por: ID / Cédula / Paciente"])->label(false); ?>
			</div>
		</div>	
		
		<div class="form-group">
			<div class="col-lg-offset-0 col-lg-1">
				<?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
			</div>
		</div>
		
	<?php ActiveForm::end(); ?>
	
	<br>
<?php } ?>
    
<?php if($dataProvider->query){ ?> 
	<?php Pjax::begin(); ?>    
		<?= GridView::widget([
		        'dataProvider' => $dataProvider,
		        'responsive' => true,
		        'striped'=>true,
	    		'hover'=>true,
	    		'panel'=>['type' => 'primary', 'heading' => 'Listado de Mensajes'],
		        'columns' => [
	            	[
				        'attribute' => 'id',
				        'format' => 'text',
				        'label' => '#',
				        'value' => function ($data) {
							if(\Yii::$app->user->can('paciente')){
								$paciente=Paciente::find()->where(['user_id' => Yii::$app->user->id])->one();
								$profile=Profile::find()->where(['user_id' => $paciente['doctor_id']])->one();
							}
							else{
								$paciente=Paciente::find()->where(['id' => $data->paciente_id])->one();
								$profile=Profile::find()->where(['user_id' => $paciente['user_id']])->one();
							}
							return $profile['user_id'];
					     },
					     'visible' => \Yii::$app->user->can('medico')
				    ],
	            	[
				        'attribute' => 'cedula',
				        'format' => 'text',
				        'label' => 'Cédula',
				        'value' => function ($data) {
							$paciente=Paciente::find()->where(['id' => $data->paciente_id])->one();
							$profile=Profile::find()->where(['user_id' => $paciente['user_id']])->one();
							return $profile['cedula'];
					     },
					     'visible' => \Yii::$app->user->can('medico')
				    ],
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
				        	if(Mensaje::nuevoMensaje($data->id))
								return "<span style='".Mensaje::nuevoMensaje($data->id)."'>".substr($data->mensaje, 0, 50)."</span>";
						}
				    ],
					[
				        'attribute' => 'fecha',
				        'format' => 'text',
				        'label' => 'Fecha y Hora',
				        'headerOptions' => ['width' => '15%'],
				        'value' => function ($data) {
				        	if($data->fecha)
								return Yii::$app->formatter->asDate($data->fecha, 'php: d-m-Y h:i:s ').$data->ampm;
							else
								return Yii::$app->formatter->asDate(date('d-m-Y h:i:s A'), 'php: d-m-Y h:i:s A');
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
<?php } ?>

<br>

<div class="mensaje-index">

    <h3><?= Html::encode('Enviar Mensaje') ?></h3><br>

    <?= $this->render('_form', [
        'model' => $model, 'listaPaciente' => $listaPaciente
    ]) ?>

</div>
