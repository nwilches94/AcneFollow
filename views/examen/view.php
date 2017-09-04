<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Paciente;
use dektrium\user\models\profile;

/* @var $this yii\web\View */
/* @var $model app\models\Examen */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Examens'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="examen-view">

    <h1><?= Html::encode('Ver Examen') ?></h1><br>

    <p>
        <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Eliminar'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'created_at',
            [
		        'attribute' => 'created_at',
		        'format' => 'datetime',
		        'label' => 'Fecha de Creación',
		    ],
            //'updated_at',
            [
		        'attribute' => 'paciente_id',
		        'format' => 'text',
		        'label' => 'Paciente',
		        'value' => function ($data) {
					$paciente=Paciente::find()->where(['id' => $data->paciente_id])->one();
					$profile=Profile::find()->where(['user_id' => $paciente['user_id']])->one();
					return $profile['name'];
			     }
		    ],
            [
		        'attribute' => 'fecha',
		        'format' => 'text',
		        'label' => 'fecha',
		        'value' => function ($data) {
					return Yii::$app->formatter->asDate($data->fecha, 'php: M, Y');
			     }
		    ],
            'notas:ntext',
        ],
    ]) ?>

    <?= \nemmo\attachments\components\AttachmentsTable::widget(['model' => $model]) ?>
</div>
