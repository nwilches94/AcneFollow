<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Examen */

$this->title = Yii::t('app', 'Cargar Fotos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fotos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="foto-create">
	
    <h1><?= Html::encode($this->title) ?></h1><br>
    
    <?= Html::a(Yii::t('app', 'Ver Galería'), ['foto/galeria?id='.Yii::$app->user->id], ['class' => 'btn btn-primary']) ?>
    
    <br><br>

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>
    
</div>
