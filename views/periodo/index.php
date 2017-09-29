<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */

$this->title = Yii::t('app', 'Seguimiento de Periodo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pacientes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="p-create">

    <h1><?= Html::encode($this->title) ?></h1><br>

    <?= $this->render('_form', [
        'model' => $model, 'proximoPeriodo' => $proximoPeriodo, 'dataProvider' => $dataProvider
    ]) ?>
    
</div>

<br>
