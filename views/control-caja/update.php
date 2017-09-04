<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ControlCaja */

$this->title = 'Actualizar Control de Caja';
$this->params['breadcrumbs'][] = ['label' => 'Control Cajas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="control-caja-update">

    <h1><?= Html::encode($this->title) ?></h1><br>

    <?= $this->render('_form', [
        'model' => $model, 'listaPaciente' => $listaPaciente
    ]) ?>

</div>
