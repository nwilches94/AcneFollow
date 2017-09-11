<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\grid\GridView;
use yii\widgets\Pjax;
use dektrium\user\models\profile;

$this->title = Yii::t('app', 'Pacientes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paciente-index">

    <h1><?= Html::encode($this->title) ?></h1><br>


    <?php $form = ActiveForm::begin(['method' => 'get', 'action' => Url::toRoute('paciente/index')]); ?>
	
		<div class="form-group">
			<div class="col-lg-offset-0 col-lg-4" style="padding-left:0px">
				<?= $form->field($model, 'buscar')->textInput(['placeholder' => "Agregue el ID o Nombre del Paciente"])->label(false); ?>
			</div>
		</div>	
		
		<div class="form-group">
			<div class="col-lg-offset-0 col-lg-1">
				<?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-lg-offset-0 col-lg-4">
		        <?php
			        if(!Yii::$app->user->identity->isAdmin){
			           echo Html::a(Yii::t('app', 'Crear Paciente'), ['nuevo/paciente'], ['class' => 'btn btn-success']);
			        }
		        ?>
    		</div>
		</div>
		
    <?php ActiveForm::end(); ?>
    
    <br>
    
    <?php if($dataProvider){ ?>
		<?php Pjax::begin(); ?>
		    <?= GridView::widget([
		            'dataProvider' => $dataProvider,
		            'columns' => [
		            	[
		                    'label' => 'Paciente ID',
						    'value' => 'user_id'
		                ],
						[
		                    'label' => 'Cedula',
						    'value' => function ($model) {
								$user=Profile::find()->where(['user_id' => $model->user_id])->one();
								return $user['cedula'];
						     }
		                ],
						[
		                    'label' => 'Nombre del Paciente',
						    'value' => function ($model) {
								$user=Profile::find()->where(['user_id' => $model->user_id])->one();
								return $user['name'];
						     }
		                ],
		                [
		                    'label' => 'Teléfono',
						    'value' => function ($model) {
								$user=Profile::find()->where(['user_id' => $model->user_id])->one();
								return $user['telefono'];
						     }
		                ],
		                [
		                    'class' => 'yii\grid\ActionColumn',
		                    'template' => '{view}{update}{delete}'
		                ],
		            ],
		        ]);
		    ?>
		<?php Pjax::end(); ?>
	<?php } ?>
</div>
