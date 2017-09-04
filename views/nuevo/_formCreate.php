<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use app\models\Paciente;
use dektrium\user\models\Profile;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="formula-form">
	
	<div class="alert alert-info">
        <?= Yii::t('user', 'Credentials will be sent to the user by email') ?>.
        <?= Yii::t('user', 'A password will be generated automatically if not provided') ?>.
    </div>
                
    <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'fieldConfig' => ['horizontalCssClasses' => ['wrapper' => 'col-sm-9'],],]); ?>
		
		<div class="form-group">
			<?= $this->render('@vendor/dektrium/yii2-user/views/admin/_user', ['form' => $form, 'user' => $user]) ?>
	    </div>
	    
	    <div class="form-group">
			<div class="col-lg-offset-3 col-lg-9">
				<?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-success']) ?>
	    		<?= Html::a(Yii::t('app', 'Regresar'), ['paciente/index'], ['class' => 'btn btn-primary']) ?>
			</div>
		</div>

    <?php ActiveForm::end(); ?>

</div>
