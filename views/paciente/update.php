<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Paciente',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pacientes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">

			    <h1><?= Html::encode('Actualizar Paciente') ?></h1><br>
			
			    <?= $this->render('_formUpdate', [
			        'model' => $model, 'profile' => $profile
			    ]) ?>

			</div>
        </div>
    </div>
</div>	
