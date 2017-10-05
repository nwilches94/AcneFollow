<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Paciente;
use dektrium\user\models\Profile;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */

$this->title = Yii::t('app', 'Actualizar Periodo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pacientes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="formula-index">
    <h1><?= Html::encode($this->title) ?></h1><br>

	<?= $this->render('_formUpdate', [
	    'model' => $model
	]) ?>
</div>

