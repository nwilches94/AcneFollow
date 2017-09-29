<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Examen */

$this->title = Yii::t('app', 'Cargar Examen');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Exámenes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="examen-create">
	
    <h1><?= Html::encode($this->title) ?></h1><br>

    <?= $this->render('_form', [
        'model' => $model, 'listaPaciente' => $listaPaciente
    ]) ?>

</div>
