<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\grid\GridView;
use yii\widgets\Pjax;
use dektrium\user\models\Profile;
use dektrium\user\models\User;

$this->title = Yii::t('app', 'Pacientes');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('@vendor/dektrium/yii2-user/views/_alert', ['module' => Yii::$app->getModule('user'),]) ?>

<div class="paciente-index">

    <h1><?= Html::encode($this->title) ?></h1><br>

    <?php $form = ActiveForm::begin(['method' => 'get', 'action' => Url::toRoute('paciente/index')]); ?>
	
		<div class="form-group">
			<div class="col-lg-offset-0 col-lg-4" style="padding-left:0px">
				<?= $form->field($model, 'buscar')->textInput(['placeholder' => "Búsqueda por: ID / Cédula / Nombres"])->label(false); ?>
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
			           echo Html::a(Yii::t('app', 'Crear Paciente'), ['paciente/create'], ['class' => 'btn btn-success']);
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
						    'value' => 'id'
		                ],
						[
		                    'label' => 'Cédula',
						    'value' => function ($model) {
								$profile=Profile::find()->where(['user_id' => $model->user_id])->one();
								return $profile['cedula'];
						     }
		                ],
						[
		                    'label' => 'Nombres',
						    'value' => function ($model) {
								$profile=Profile::find()->where(['user_id' => $model->user_id])->one();
								return $profile['name'];
						     }
		                ],
		                [
		                    'label' => 'Teléfono',
						    'value' => function ($model) {
								$profile=Profile::find()->where(['user_id' => $model->user_id])->one();
								return $profile['telefono'];
						     }
		                ],
		                [
		                    'label' => 'Email',
						    'value' => function ($model) {
								$user=User::find()->where(['id' => $model->user_id])->one();
								return $user['email'];
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
