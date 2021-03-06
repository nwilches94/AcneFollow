<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Examen */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Examen',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Examens'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="examen-update">

    <h1><?= Html::encode('Actualizar Examen') ?></h1><br>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
