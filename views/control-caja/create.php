<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ControlCaja */

$this->title = 'Crear Control de Caja';
$this->params['breadcrumbs'][] = ['label' => 'Control Cajas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="control-caja-create">

    <h1><?= Html::encode($this->title) ?></h1><br>

    <?= $this->render('_form', [
        'model' => $model, 'listaPaciente' => $listaPaciente
    ]) ?>

</div>
