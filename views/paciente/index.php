<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pacientes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paciente-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if(!Yii::$app->user->identity->isAdmin){
            Html::a(Yii::t('app', 'Crear Paciente'), ['nuevo/paciente'], ['class' => 'btn btn-success']);
        }
        ?>
    </p>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'doctor_id',
                'user_id',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}'
                ],
            ],
        ]);
    ?>
<?php Pjax::end(); ?></div>
