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
<div class="paciente-update">

    <h1><?= Html::encode('Actualizar Paciente') ?></h1><br>

    <?= $this->render('_form', [
        'model' => $model, 'profile' => $profile
    ]) ?>

</div>