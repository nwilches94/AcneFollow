<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Button;

use yii\widgets\DetailView;
use app\models\Paciente;
use dektrium\user\models\profile;

$this->title = Yii::t('app', 'Mensaje');
$this->params['breadcrumbs'][] = $this->title;
?>

<h3><?= Html::encode($this->title) ?></h3><br>

<?= DetailView::widget([
    'model' => $model,
    'template' => '<tr></th><td{contentOptions}>{value}</td></tr>',
    'attributes' => [
        [
	        'attribute' => 'mensaje',
	        'format' => 'text',
	        'value'=> 'mensaje',
	        'headerOptions' => ['width' => '100%'],
	        'value' => function ($data) {
				return Html::encode($data->mensaje);
		     }
	    ],
    ],
]) ?>

<?= Html::a(Yii::t('app', 'Regresar'), ['index'], ['class' => 'btn btn-primary']) ?>



